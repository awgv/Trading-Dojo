{{-- Modal; create an account. --}}
<div class="modal fade" id="createAccount" tabindex="-1" role="dialog" aria-labelledby="createAccount" aria-hidden="true">
	<div class="modal-dialog modal-smaller">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Create an account</h4>
			</div>
			<div class="modal-body js-modal-create-account">
				<div class="continer-fluid">
					{!! Form::open([
						'url'         => '/account/register',
						'class'       => 'create_account_form',
						'files'       => false,
						'method'      => 'post'
					]) !!}
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('account_email', 'E-mail:') !!}
									{!! Form::email('account_email', null, [
										'id'          => 'account_email',
										'class'       => 'form-control',
										'placeholder' => 'To be able to restore your password and sign in here',
										'required'    => 'required',
										'maxlength'   => '255'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('account_ign', 'Your in-game name:') !!}
									{!! Form::text('account_ign', null, [
										'id'          => 'account_ign',
										'class'       => 'form-control',
										'placeholder' => 'For people to be able to contact you in-game',
										'required'    => 'required',
										'pattern'     => '^[a-zA-Z0-9-_.]+$',
										'maxlength'   => '255'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('account_password', 'Password:') !!}
									{!! Form::password('account_password', [
										'id'             => 'account_password',
										'class'          => 'form-control',
										'placeholder'    => 'We don\'t store passwords in our database',
										'required'       => 'required',
										'maxlength'      => '255',
										'data-minlength' => '6'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::password('account_password_confirmation', [
										'id'             => 'account_password_confirmation',
										'class'          => 'form-control',
										'placeholder'    => 'Password again, just to be sure that it\'s right',
										'required'       => 'required',
										'maxlength'      => '255',
										'data-minlength' => '6',
										'data-match'     => '#account_password'
									]) !!}
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<button type="submit" class="invisible">Submit</button>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="modal-footer js-modal-footer-create-account">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary create_account_form_submit">Create</button>
			</div>
		</div>
	</div>
</div>