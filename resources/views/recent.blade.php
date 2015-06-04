@extends('master')

@section('title')
	– Recent offers
@stop

@section('content')
	@if ( $offers[0] )
		<div class="row dojo-offset-30">
			<div class="col-md-6 col-md-offset-3 text-center">
				<h3>Recent offers for {{ $offers[0]->platform }}:</h3>
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
							@if ( Auth::check() )
								<div class="col-md-6">
									<a data-toggle="modal" data-target="#publishSignedOffer" class="btn btn-primary" role="button">Publish an offer</a>
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
			<div class="col-md-12">
				<table class="table table-bordered table-hover table-striped dojo-table-offset">
					<thead>
						<tr>
							<th>Item</th>
							<th>
								Seller <a tabindex="0" role="button" class="js-popover-user-online-status-color"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>
							</th>
							<th>Price</th>
							<th>Published</th>
							<th>Commentary</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($offers as $offer)
							<tr>
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
									<td>
										@if ($offer->user_id !== null)
											{{-- Same here, doesn't work locally on XAMPP, for XAMPP it should be integer comparison --}}
											@if ( $offer->user->online_status === '0' )
												<a href="/user/{{ $offer->seller_ign }}" class="js-popover-user-online-status-color">
													{{ $offer->seller_ign }}
												</a>
											@else
												<strong>
													<a href="/user/{{ $offer->seller_ign }}" class="text-success js-popover-user-online-status-color">
														{{ $offer->seller_ign }}
													</a>
												</strong>
											@endif
										@else
											{{ $offer->seller_ign }}
										@endif
									</td>
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
	@else
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="jumbotron text-center">
					<h3>Nobody published anything today.</h3>
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
	@endif



	@if ( Auth::check() )
		@include('modals.auth_check_true.publish_offer')
	@endif
@stop