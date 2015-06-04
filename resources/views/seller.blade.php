@extends('master')

@section('title')
	– Offers of {{ $user->name }}
@stop

@section('content')
	<div class="row dojo-offset-30">
		<div class="col-md-6 col-md-offset-3 text-center">
			@if ( $user->online_status === '1')
				<h3>Offers of {{ $user->name }} (<strong><span class="text-success">online</span></strong>):</h3>
			@else
				<h3>Offers of {{ $user->name }}:</h3>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
							<div class="col-md-12">
								<p>Offers are sorted by hour (new offers are higher). Just copy seller's name and contact her in-game via this command in chat: <kbd>/w [seller's name] [message]</kbd></p>
							</div>
					</div>
					<div class="row">
						@if ( Auth::check() && Auth::user()->id === $user->id )
							<div class="col-md-12 text-right">
								<a href="/" class="btn btn-default" role="button">Return to home page</a>
							</div>
						@elseif ( Auth::check() )
							<div class="col-md-6">
								<a data-toggle="modal" data-target="#sendMessage" class="btn btn-default" role="button">Send a message</a>
							</div>
							<div class="col-md-6 text-right">
								<a href="/" class="btn btn-default" role="button">Return to home page</a>
							</div>
						@else
							<div class="col-md-12 text-right">
								<a href="/" class="btn btn-default" role="button">Return to home page</a>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-3">
			<div class="form-group">
				{!! Form::text('offer_item_name', null, [
					'id'          => 'offer_item_name',
					'class'       => 'form-control js-popover-missing-item',
					'placeholder' => 'What else do you want to buy?'
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
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-hover table-striped dojo-table-offset">
				<thead>
					<tr>
						<th>Platform</th>
						<th>Item</th>
						<th>Price</th>
						<th>Published</th>
						<th>Commentary</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($offers as $offer)
						<tr>
								<td>
									{{ $offer->platform }}
								</td>
							@if ( $offer->item->type === 'mod' )
								<td>
									<a href="/{{ $offer->platform_slug }}/{{ $offer->item->slug }}">
										{{ $offer->item->name }} 
										@if ( $offer->rank === '0' || $offer->rank === null )
											(unranked)
										@else
											(rank {{ $offer->rank }})
										@endif
									</a>
								</td>
							@else
								<td>
									<a href="/{{ $offer->platform_slug }}/{{ $offer->item->slug }}">
										{{ $offer->item->name }}
									</a>
								</td>
							@endif
								<td>{{ $offer->price }}</td>
								<td>{{ $offer->created_at->diffForHumans() }}</td>
								<td>{{ $offer->commentary }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			{!! $offers->render() !!}
		</div>
	</div>



	@if ( Auth::check() )
		@include('modals.auth_check_true.send_message')
	@endif
@stop