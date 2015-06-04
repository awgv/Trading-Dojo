// A call to create new account.
// ========================================================================
var createAccountFormVariables = {
	modal        : '.js-modal-create-account',
	form         : $('.create_account_form'),
	url          : '/account/register',
	actionButton : '.btn-primary',
	error        : null,
	modalFooter  : '.js-modal-footer-create-account',
	successText  : 'Your account was successfully created; <a href="#" class="js-login-after-creation">click here</a> to sign in.',
	errorText    : null
};

$('.create_account_form_submit').click( function () {
	createAccountFormVariables.form.submit();
});

createAccountFormVariables.form.validator().submit( function (event) {
	if ( !event.isDefaultPrevented() ) {
		event.preventDefault();

		ajaxFormSubmit(createAccountFormVariables.modal, createAccountFormVariables.form, createAccountFormVariables.url, createAccountFormVariables.actionButton, createAccountFormVariables.error, createAccountFormVariables.modalFooter, createAccountFormVariables.successText, false, createAccountFormVariables.errorText, true, function () {
			$('.js-login-after-creation').click( function (event) {
				event.preventDefault();
				$('#createAccount').modal('hide');
				$('#accountSignIn').modal('show');
			});
		});
	} // If ends.
});