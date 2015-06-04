@extends('master')

@section('content')
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-8">
										<a class="btn btn-default" href="/messages" role="button">Your messages</a>
										<a class="btn btn-default" href="/" role="button">Return to home page</a>
									</div>
									<div class="col-md-4 text-right">
										<a class="btn btn-default js-popover-recent-offers" href="" role="button">Recent offers</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h3>{{ $thread->subject }}</h3>
					</div>
				</div>
			@foreach($thread->messages as $message)
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									@if ( $message->user->name === $user->name )
										<div class="col-md-10">
											<p>{!! $message->body !!}</p>
										</div>
										<div class="col-md-2">
											<span class="glyphicon glyphicon-menu-right dojo-glyphicon-messages-size" aria-hidden="true"></span>
										</div>
									@else
										<div class="col-md-2">
											<span class="glyphicon glyphicon-menu-left dojo-glyphicon-messages-size" aria-hidden="true"></span>
										</div>
										<div class="col-md-10">
											<p>{!! $message->body !!}</p>
										</div>
									@endif

								</div>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-md-12">
										@if ( $message->user->name === $user->name )
											You sent this message {{ $message->created_at->diffForHumans() }}
										@else
											<strong><a href="/user/{{ $message->user->name }}" class="alert-link">{{ $message->user->name }}</a></strong> sent this message {{ $message->created_at->diffForHumans() }}
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h4>Send a new message</h4>
						{!! Form::open([
							'route' => ['messages.update', $thread->id],
							'method' => 'PUT'
						]) !!}
								<!-- Message Form Input -->
								<div class="form-group">
									{!! Form::textarea('message', null, [
										'required'  => 'required',
										'rows'      => '10',
										'id'        => 'message',
										'class'     => 'form-control',
										'maxlength' => '500'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
						
								<div class="row">
									<div class="col-md-3 col-md-offset-9 text-right">
										<!-- Submit Form Input -->
										<div class="form-group">
											{!! Form::submit('Send', ['class' => 'btn btn-primary form-control']) !!}
										</div>
									</div>
								</div>
						{!! Form::close() !!}
					</div>
				</div>
@stop