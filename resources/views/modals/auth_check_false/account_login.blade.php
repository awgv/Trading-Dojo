{{-- Modal; sign in. --}}
<div class="modal fade" id="accountSignIn" tabindex="-1" role="dialog" aria-labelledby="accountSignIn" aria-hidden="true">
	<div class="modal-dialog modal-smaller">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Sign in</h4>
			</div>
			<div class="modal-body js-modal-account-sign-in">
				<div class="continer-fluid">
					{!! Form::open([
						'url'    => '/account/login',
						'class'  => 'account_sign_in_form',
						'files'  => false,
						'method' => 'post'
					]) !!}
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('account_sign_in_email', 'Your e-mail:') !!}
									{!! Form::email('account_sign_in_email', null, [
										'id'        => 'account_sign_in_email',
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
									{!! Form::label('account_sign_in_password', 'Password:') !!}
									{!! Form::password('account_sign_in_password', [
										'id'             => 'account_sign_in_password',
										'class'          => 'form-control',
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
								<a tabindex="0" role="button" href="/password/email">Forgot your password?</a>
							</div>
						</div>
						<button type="submit" class="invisible">Submit</button>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="modal-footer js-modal-footer-account-sign-in">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary account_sign_in_form_submit">Sign in</button>
			</div>
		</div>
	</div>
</div>