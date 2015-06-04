@extends('master')

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<h3>Sending a new message to {{ $user->name }}</h3>
		{!! Form::open(['route' => 'messages.send.store']) !!}
			<!-- Subject Form Input -->
			<div class="form-group">
				{!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}
				{!! Form::text('subject', null, ['class' => 'form-control']) !!}
			</div>

			<!-- Message Form Input -->
			<div class="form-group">
				{!! Form::label('message', 'Message', ['class' => 'control-label']) !!}
				{!! Form::textarea('message', null, ['class' => 'form-control']) !!}
			</div>

			<input type="hidden" name="recipient" value="{!!$user->id!!}">

			<!-- Submit Form Input -->
			<div class="form-group">
				{!! Form::submit('Send', ['class' => 'btn btn-primary form-control']) !!}
			</div>
		{!! Form::close() !!}
	</div>
@stop