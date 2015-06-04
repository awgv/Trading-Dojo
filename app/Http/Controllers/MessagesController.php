<?php namespace Dojo\Http\Controllers;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Dojo\Http\Requests\StoreMessageRequest;
use Dojo\User;
use Request;

class MessagesController extends Controller
{

	/**
	 * Show all of the message threads to the user.
	 * 
	 * @return Response
	 */
	public function messages()
	{
		$user = Auth::user();

		if ($user)
		{
			$currentUserId = $user->id;

			// All threads, ignore deleted/archived participants
			//$threads = Thread::getAllLatest()->get();

			// All threads that user is participating in
			$threads = Thread::forUser($currentUserId)->latest('updated_at')->get();

			// All threads that user is participating in, with new messages
			// $threads = Thread::forUserWithNewMessages($currentUserId)->latest('updated_at')->get();

			return view('messenger.messages')
				->with('threads', $threads)
				->with('currentUserId', $currentUserId);
		}
		else
		{
			return redirect('/');
		}
	}


	/**
	 * Show a message thread.
	 * 
	 * @param $id
	 * @return Response
	 */
	public function show($id)
	{
		try
		{
			$thread = Thread::findOrFail($id);
		}
		catch (ModelNotFoundException $e)
		{
			Session::flash('error_message', 'This conversation doesn\'t exist anymore.');

			return redirect('messages');
		}

		// show current user in list if not a current participant
		// $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

		// Don't show the current user in list:
		$user = Auth::user();
		$users = User::whereNotIn('id', $thread->participantsUserIds($user->id))->get();

		$thread->markAsRead($user->id);


		return view('messenger.show')
			->with('thread', $thread)
			->with('users', $users)
			->with('user', $user);
	}


	/**
	 * Stores a new message thread.
	 * 
	 * @return String
	 */
	public function store(StoreMessageRequest $request)
	{
		if ( Auth::check() )
		{
			$input = Input::all();

			$thread = Thread::create(
				[
					'subject' => $input['subject'],
				]
			);

			// Message:
			Message::create(
				[
					'thread_id' => $thread->id,
					'user_id'   => Auth::user()->id,
					'body'      => $input['message'],
				]
			);

			// Sender:
			Participant::create(
				[
					'thread_id' => $thread->id,
					'user_id'   => Auth::user()->id,
					'last_read' => new Carbon
				]
			);

			// Recipients:
			if ( Input::has('recipient') ) {
				$thread->addParticipants($input['recipient']);
			}

			return 'Saved.';
		}
		else
		{
			return 'Unauthorized.';
		}
	}


	/**
	 * Adds a new message to the current thread.
	 * 
	 * @param $id
	 * @return Response
	 */
	public function update($id)
	{
		try
		{
			$thread = Thread::findOrFail($id);
		}
		catch (ModelNotFoundException $e)
		{
			Session::flash('error_message', 'This conversation doesn\'t exist anymore.');

			return redirect('messages');
		}

		$thread->activateAllParticipants();

		// Message:
		Message::create(
			[
				'thread_id' => $thread->id,
				'user_id'   => Auth::id(),
				'body'      => Input::get('message'),
			]
		);

		// Add replier as a participant:
		$participant = Participant::firstOrCreate(
			[
				'thread_id' => $thread->id,
				'user_id'   => Auth::user()->id
			]
		);
		$participant->last_read = new Carbon;
		$participant->save();


		return redirect('messages/' . $id);
	}


	/**
	 * Removes (soft-deletes) participant from the conversation.
	 * 
	 * @return Response
	 */
	public function remove($id)
	{
		$user = Auth::user();

		if ($user)
		{
			$participant = Participant::where('thread_id', $id)
				->where('user_id', $user->id)
				->first();

			if ($participant)
			{
				$participant->delete();


				$participants = Participant::where('thread_id', $id)
					->get();

				// If there's no more participants in the thread, remove it for good.
				// Couldn't make it work via relations from $thread, so maybe this needs a refactoring.
				if ( $participants->isEmpty() )
				{
					$participants = Participant::onlyTrashed()
						->where('thread_id', $id)
						->get();

					foreach ($participants as $participant) {
						$participant->forceDelete();
					}

					$messages = Message::where('thread_id', $id)
					->get();

					foreach ($messages as $message) {
						$message->delete();
					}

					Thread::find($id)->forceDelete();
				}


				return redirect('messages');
			}
			else
			{
				Session::flash('error_message', 'This conversation doesn\'t exist anymore.');

				return redirect('messages');
			}
		}
		else
		{
			return redirect('/');
		}
	}


	/**
	 * Checks for new messages, answers to an AJAX-call.
	 * 
	 * @return String|Object
	 */
	public function check()
	{
		$user = Auth::user();

		if ($user)
		{
			if ( $user->newMessagesCount() > Request::input('current_messages_count') )
			{
				return $user->newMessagesCount();
			}
			else
			{
				return 'There\'s no new messages.';
			}
		}
		else
		{
			return 'Doesn\'t exist.';
		}
	}

}