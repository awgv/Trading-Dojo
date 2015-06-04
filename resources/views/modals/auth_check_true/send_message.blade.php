{{-- Modal; send a message. --}}
<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="sendingMessage" aria-hidden="true">
	<div class="modal-dialog modal-smaller">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">New message</h4>
			</div>
			<div class="modal-body js-modal-send">
				<div class="continer-fluid">
					{!! Form::open([
						'class'       => 'send_message_form',
						'files'       => false,
						'method'      => 'post',
						'route'       => 'messages.send.store'
					]) !!}
						<div class="row">
							<div class="col-md-12">
								<fieldset disabled>
									<div class="form-group">
										{!! Form::label('recepient', 'Recepient:') !!}
										{!! Form::text('recepient', $user->name, [
											'id'          => 'recepient',
											'class'       => 'form-control',
											'required'    => 'required',
											'pattern'     => '^[a-zA-Z0-9-_.]+$',
											'maxlength'   => '255',
											'data-id'     => $user->id
										]) !!}
										<div class="help-block with-errors"></div>
									</div>
								</fieldset>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('subject', 'Subject:') !!}
									{!! Form::text('subject', null, [
										'required'  => 'required',
										'class'     => 'form-control',
										'required'  => 'required',
										'maxlength' => '255'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('message', 'Message (up to 500 characters):') !!}
									{!! Form::textarea('message', null, [
										'required'  => 'required',
										'rows'      => '10',
										'id'        => 'message',
										'class'     => 'form-control',
										'maxlength' => '500'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<button type="submit" class="invisible">Submit</button>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="modal-footer js-modal-footer-send">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary send_message_form_submit">Send</button>
			</div>
		</div>
	</div>
</div>