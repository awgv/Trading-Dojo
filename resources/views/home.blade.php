@extends('master')

@section('content')
	@if ( Auth::check() )
			<div class="row dojo-signed-offset">
				<div class="col-md-5 col-md-offset-3">
					<p>
						Signed in as <strong>{{ $user->name }}</strong>.
					</p>
				</div>
				<div class="col-md-1">
					<p class="text-right">
						<a href="/account/logout" role="button">Log out</a>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#publishSignedOffer">Publish an offer</button>
								</div>
								<div class="col-md-9 text-right">
									@if ( $user->newMessagesCount() > 0 )
										<a class="btn btn-info js-popover-new-messages js-messages-check" href="/messages" role="button">Your messages <span class="badge">{{ $user->newMessagesCount() }}</span></a>
									@else
										<a class="btn btn-default js-messages-check" href="/messages" role="button">Your messages</a>
									@endif
										<a class="btn btn-default js-popover-recent-offers" href="" role="button">Recent offers</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								@if ( $user->online_status == '0' )
									<div class="col-md-8">
										<span class="js-user-online-description">
											You're not in the game and unavailable for trading.
										</span>
									</div>
									<div class="col-md-4 text-right">
										<input type="checkbox" name="js-user-online-status" class="js-user-online-status-0" checked>
									</div>
								@else
									<div class="col-md-8">
										<span class="js-user-online-description">
											You're playing and can trade.
										</span>
									</div>
									<div class="col-md-4 text-right">
										<input type="checkbox" name="js-user-online-status" class="js-user-online-status-1" checked>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
	@else
			<div class="row dojo-sign-offset">
				<div class="col-md-3 col-md-offset-3">
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#accountSignIn">Sign in</button>
				</div>
				<div class="col-md-3 text-right">
					<button type="submit" class="btn btn-default" data-toggle="modal" data-target="#createAccount">Create an account</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					<div class="jumbotron">
						<h3>Trading Dojo is a bulletin board that helps Warframe players trade in a faster and more convenient way.</h3>
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#publishOffer">Publish an offer</button>
						<button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#removeOffer">Remove an offer</button>
					</div>
				</div>
			</div>
	@endif
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					<h3>Start by searching for an item or publishing an offer.</h3>
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
	@if ( Auth::check() )
			<div class="row dojo-offset-30">
				<div class="col-md-6 col-md-offset-3 text-center">
					<h3>Your offers sorted by time:</h3>
				</div>
			</div>
		@if ( Session::pull('justCreated') === 'true' )
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="alert alert-info alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<p>
							<strong>How to use:</strong> 1) click on an offer's price or commentary to edit them, then click anywhere else or hit Enter to save; 2) use buttons in "Action" column to manage offers.
						</p>
						<p>
							<button type="button" class="btn btn-info" data-dismiss="alert">Okay, got it!</button>
						</p>
					</div>
				</div>
			</div>
		@endif
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					{!! $offers->render() !!}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered table-hover table-striped dojo-table-offset js-account-offers-table">
						<thead>
							<tr>
								<th>Item</th>
								<th>Price</th>
								<th>Published</th>
								<th>Commentary</th>
								<th>
									Status <a tabindex="0" role="button" class="js-popover-account-offers-status"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>
								</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($offers as $offer)
								@if ( $offer->created_at->diffInSeconds(null) < 5 )
									<tr class="success">
								@else
									<tr>
								@endif
											<td>
												<a href="/{{ $offer->platform_slug }}/{{ $offer->item->slug }}">
													{{ $offer->item->name }}
													@if ($offer->item->type === 'mod')
														 (mod)
													@endif
												</a>
											</td>
											<td data-editable="true" data-id="{{ $offer->id }}">{{ $offer->price }}</td>
											<td>{{ $offer->created_at->diffForHumans() }}</td>
											<td data-editable="true" data-id="{{ $offer->id }}">{{ $offer->commentary }}</td>
										{{-- $offer->active === '1' doesn't work locally on my XAMPP, it should be an integer instead of a string comparison. --}}
										@if ($offer->active === '1')
											<td class="text-success">Published</td>
											<td data-id="{{ $offer->id }}">
												<a class="btn btn-warning btn-xs invisible js-account-offer-table-button js-account-offer-expire" role="button">Expire</a>
											</td>
										@else
											<td class="text-danger">Expired</td>
											<td data-id="{{ $offer->id }}">
												<a class="btn btn-danger btn-xs invisible js-account-offer-table-button js-account-offer-remove" role="button">Delete</a>
												<a class="btn btn-success btn-xs invisible js-account-offer-table-button js-account-offer-renew" role="button">Renew</a>
												<a class="btn btn-info btn-xs invisible js-account-offer-table-button js-account-offer-renew-all" role="button">Renew all</a>
											</td>
										@endif
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



			{{-- Including modals for all occasions. --}}
			@include('modals.auth_check_true.publish_offer')

			@include('modals.auth_check_true.update_offer_general_processing')
			@include('modals.auth_check_true.update_offer_general_success')
			@include('modals.auth_check_true.update_offer_general_error')

			@include('modals.auth_check_true.remove_offer_success')
			@include('modals.auth_check_true.remove_offer_error')

			@include('modals.auth_check_true.renew_offer_success')
			@include('modals.auth_check_true.renew_offer_error')
	@else
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					<p class="text-muted">
						<a tabindex="0" role="button" class="js-popover-account-creation">Hover mouse cursor here</a> to see the benefits of account creation.
					</p>
				</div>
			</div>
			<div class="row dojo-offset-30">
				<div class="col-md-6 col-md-offset-3 text-center">
					<h3>Recent offers:</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered table-hover table-striped dojo-table-offset">
						<thead>
							<tr>
								<th>Platform</th>
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
										<td>
											@if ($offer->user_id !== null)
												{{-- $offer->user->online_status === '0' doesn't work locally on my XAMPP, it should be an integer instead of a string comparison. --}}
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



			{{-- Including modals for all occasions. --}}
			@include('modals.auth_check_false.publish_offer')
			@include('modals.auth_check_false.remove_offer')

			@include('modals.auth_check_false.account_login')
			@include('modals.auth_check_false.account_create')
	@endif
@stop