{{-- Modal; publish an offer. --}}
<div class="modal fade" id="publishOffer" tabindex="-1" role="dialog" aria-labelledby="publishingOffer" aria-hidden="true">
	<div class="modal-dialog modal-smaller">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">New offer</h4>
			</div>
			<div class="modal-body js-modal-create">
				<div class="continer-fluid">
					{!! Form::open([
						'url'         => '/offer/publish/guest',
						'class'       => 'sell_item_form',
						'files'       => false,
						'method'      => 'post'
					]) !!}
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-info" role="alert">The rank field will be enabled, if you're selling a mod.</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-7">
								<div class="form-group">
									{!! Form::label('user_ign', 'Your in-game name:') !!}
									{!! Form::text('sell_user_ign', null, [
										'id'          => 'user_ign',
										'class'       => 'form-control',
										'placeholder' => 'To contact you in-game',
										'required'    => 'required',
										'pattern'     => '^[a-zA-Z0-9-_.]+$',
										'maxlength'   => '255'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									{!! Form::label('sell_item_platform', 'Platform:') !!}
									{!! Form::select('sell_item_platform', [
										'PC'       => 'PC',
										'PS4'      => 'PS4',
										'Xbox One' => 'Xbox One'
									], 'PC', [
										'id'       => 'sell_item_platform',
										'class'    => 'form-control',
										'required' => 'required',
										'pattern'  => '(^[A-Za-z0-9 ]+$)+'
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9">
								<div class="form-group">
									{!! Form::label('sell_item_name', 'What are you selling?') !!}
									{!! Form::text('sell_item_name', null, [
										'id'          => 'sell_item_name',
										'class'       => 'form-control js-popover-missing-item',
										'placeholder' => 'Start typing to show results',
										'required'    => 'required',
										'pattern'     => '(^[A-Za-z0-9 \']+$)+',
										'maxlength'   => '255'
									]) !!}
									<div class="help-block with-errors"></div>
									<ul class="sell-item-name-search-results"></ul>
								</div>
							</div>
							<div class="col-md-3">
								<fieldset class="sell_item_rank_fieldset" disabled>
									<div class="form-group">
										{!! Form::label('sell_item_rank', 'Rank:') !!}
										{!! Form::selectRange('sell_item_rank', 0, 10, null, [
											'id'    => 'sell_item_rank',
											'class' => 'form-control',
											'type'  => 'number',
											'min'   => '0',
											'max'   => '11'
										]) !!}
									</div>
								</fieldset>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('sell_item_price', 'How much are you selling it for?') !!}
									<div class="input-group">
										{!! Form::number('sell_item_price', null, [
											'id'          => 'sell_item_price',
											'class'       => 'form-control',
											'placeholder' => 'Enter an amount',
											'required'    => 'required',
											'min'         => '1',
											'max'         => '1000'
										]) !!}
										<span class="input-group-addon">Platinum</span>
									</div>
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('sell_item_commentary', 'Optional commentary (up to 250 characters):') !!}
									<div class="input-group">
										{!! Form::textarea('sell_item_commentary', null, [
											'rows'        => '5',
											'id'          => 'sell_item_commentary',
											'class'       => 'form-control',
											'maxlength'   => '250'
										]) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('', 'Additionally, check this:') !!}
									{!! Recaptcha::render() !!}
								</div>
							</div>
						</div>
						{{-- Basic spam protection via hidden field (validation can be found in StoreOfferRequest): --}}
						{!! Honeypot::generate('wax_name', 'wax_time') !!}
					{!! Form::close() !!}
				</div>
			</div>
			<div class="modal-footer js-modal-footer-create">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary sell_item_form_submit">Publish</button>
			</div>
		</div>
	</div>
</div>