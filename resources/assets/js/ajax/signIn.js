// A call to sign user in.
// ========================================================================
var accountSignInFormVariables = {
	modal        : '.js-modal-account-sign-in',
	form         : $('.account_sign_in_form'),
	errorText    : 'The ID and password didn’t match. Please check the credentials you entered or try again with a different combination.'
};

$('.account_sign_in_form_submit').click( function () {
	accountSignInFormVariables.form.submit();
});

accountSignInFormVariables.form.validator().submit( function (event) {
	if ( !event.isDefaultPrevented() ) {
		event.preventDefault();

		var modalCached = $(accountSignInFormVariables.modal);
		var modalHeight = modalCached.css('height');

		accountSignInFormVariables.form.fadeOut(200, function () {
			$(accountSignInFormVariables.modal + ' .alert-danger').remove();
			modalCached
				.css('height', modalHeight)
				.animate({
					'height' : '57px' // The perfect height for ".loading" state.
				}, 200);
			$(accountSignInFormVariables.modal + ' > .continer-fluid').append('<div class="loading"></div>');
			$('.loading').fadeIn(200);

			$.ajax({
				url     : '/account/login',
				type    : 'POST',
				data    : accountSignInFormVariables.form.serialize(),
				success : function (response) {
					if (response === 'Exists.') {
						window.location = '/';
					} else {
						var successNewHeight;
						$('.loading').fadeOut(200);


						modalCached
							.append('<div class="alert alert-danger" role="alert">' + accountSignInFormVariables.errorText + '</div>')
							.removeAttr('style');
						$('.loading').remove();
						accountSignInFormVariables.form.css('display', 'block');
						successNewHeight = modalCached.css('height');
						accountSignInFormVariables.form.css('display', 'none');
						$(accountSignInFormVariables.modal + ' .alert-danger').css('display', 'none');


						modalCached.animate({
							'height' : successNewHeight
						}, 200);


						accountSignInFormVariables.form.fadeIn(200);
						$(accountSignInFormVariables.modal + ' .alert-danger').fadeIn(200);
					}
				},
				error   : function () {
					var errorNewHeight;
					$('.loading').fadeOut(200);


					if (response.status === 422) {
						for (var key in response.responseJSON) {
							modalCached.append('<div class="alert alert-danger" role="alert">' + response.responseJSON[key][0] + '</div>');
							break;
						}
						modalCached.removeAttr('style');
						$('.loading').remove();
						accountSignInFormVariables.form.css('display', 'block');
						errorNewHeight = modalCached.css('height');
						accountSignInFormVariables.form.css('display', 'none');
						$(accountSignInFormVariables.modal + ' .alert-danger').css('display', 'none');


						modalCached.animate({
							'height' : errorNewHeight
						}, 200);


						accountSignInFormVariables.form.fadeIn(200);
						$(accountSignInFormVariables.modal + ' .alert-danger').fadeIn(200);
					} else {
						modalCached
							.append('<div class="alert alert-danger" role="alert">It seems that our database is busy right now. Please try again later.</div>')
							.removeAttr('style');
						$('.loading').remove();
						accountSignInFormVariables.form.css('display', 'block');
						errorNewHeight = modalCached.css('height');
						accountSignInFormVariables.form.css('display', 'none');
						$(accountSignInFormVariables.modal + ' .alert-danger').css('display', 'none');


						modalCached.animate({
							'height' : errorNewHeight
						}, 200);


						accountSignInFormVariables.form.fadeIn(200);
						$(accountSignInFormVariables.modal + ' .alert-danger').fadeIn(200);
					}
				}
			});
		}); // FadeOut ends.
	} // If ends.
});