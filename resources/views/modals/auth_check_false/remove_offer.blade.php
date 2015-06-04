{{-- Modal; remove an offer. --}}
<div class="modal fade" id="removeOffer" tabindex="-1" role="dialog" aria-labelledby="removingOffer" aria-hidden="true">
	<div class="modal-dialog modal-smaller">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Remove an offer</h4>
			</div>
			<div class="modal-body js-modal-remove">
				<div class="continer-fluid">
					{!! Form::open([
						'url'         => '/offer/remove',
						'class'       => 'remove_offer_form',
						'files'       => false,
						'method'      => 'post'
					]) !!}
						<div class="row">
							<div class="col-md-12">
								<div class="well">Thank you for keeping our database clean. Please enter the code that was privided to you upon publishing to remove your offer.</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('offer_code', 'Your code:') !!}
									{!! Form::text('offer_code', null, [
										'id'          => 'offer_code',
										'class'       => 'form-control',
										'required'    => 'required',
										'pattern'     => '^[a-zA-Z0-9-_]+$',
										'maxlength'   => '255'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<button type="submit" class="invisible">Submit</button>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="modal-footer js-modal-footer-remove">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-warning remove_offer_form_submit">Remove</button>
			</div>
		</div>
	</div>
</div>