@extends('master')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="jumbotron text-center">
				<h3>There're no offers for this item.</h3>
				<a href="/" class="btn btn-default btn-lg" role="button">Return to home page</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3 text-center">
			<h3>Or you can search for something else.</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-3">
			<div class="form-group">
				{!! Form::text('offer_item_name', null, [
					'id'          => 'offer_item_name',
					'class'       => 'form-control js-popover-missing-item',
					'placeholder' => 'What do you want to buy?'
				]) !!}
				<ul class="offer-item-name-search-results"></ul>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				{!! Form::select('offer_item_platform', [
					'pc'       => 'on PC',
					'ps4'      => 'on PS4',
					'xbox-one' => 'on Xbox One'
				], 'PC', [
					'id'       => 'offer_item_platform',
					'class'    => 'form-control'
				]) !!}
			</div>
		</div>
	</div>
@stop