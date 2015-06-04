@extends('master')

@section('content')
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<a class="btn btn-default" href="/" role="button">Return to home page</a>
							</div>
							<div class="col-md-6 text-right">
								<a class="btn btn-default js-popover-recent-offers" href="" role="button">Recent offers</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@if (Session::has('message_removed'))
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{!! Session::pull('message_removed') !!}
				</div>
			</div>
		</div>
	@endif
	@if (Session::has('error_message'))
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{!! Session::pull('error_message') !!}
				</div>
			</div>
		</div>
	@endif
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				@if($threads->count() > 0)
					@foreach($threads as $thread)
						@if ( $thread->isUnread($currentUserId) )
							<div class="panel panel-info js-messages-remove">
						@else
							<div class="panel panel-default js-messages-remove">
						@endif
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<h4 class="media-heading">
												<a href="messages/{{ $thread->id }}">
													{{ $thread->subject }}
												</a>
											</h4>
											<span>
												{{ $thread->latestMessage->body }}
											</span>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-8">
											Conversation with <strong><a href="/user/{{ $thread->participantsString(Auth::id()) }}" class="alert-link">{{ $thread->participantsString(Auth::id()) }}</a></strong>
										</div>
										<div class="col-md-4 text-right">
											<a class="btn btn-danger invisible btn-xs" href="/messages/remove/{{ $thread->id }}" role="button">Remove</a>
										</div>
									</div>
								</div>
							</div>
					@endforeach
				@else
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12 text-center">
												<h4>No inbox messages await the Operator.</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				@endif
			</div>
		</div>
@stop