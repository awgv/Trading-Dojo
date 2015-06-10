/**
 * A general AJAX call function for form submitting.
 * @param  {string}   modal          Class of a ".modal-body" to use.
 * @param  {object}   form           jQuery selector of a form in use.
 * @param  {string}   url            An ajax URL.
 * @param  {string}   actionButton   Class of a button that should be removed on successful post.
 * @param  {string}   error          An error from a server.
 * @param  {string}   modalFooter    Class of a modal's footer.
 * @param  {string}   seccessText    Text to show on successful post.
 * @param  {bool}     appendResponse Append a server's response to a page or not.
 * @param  {string}   errorText      Text to show on unsuccessful post.
 * @param  {bool}     validateInput  Append validation error from a server or not.
 * @param  {function} callback       Something to run after successful posting.
 * @return {void}
 */
var ajaxFormSubmit = function (modal, form, url, actionButton, error, modalFooter, seccessText, appendResponse, errorText, validateInput, callback) {
	var modalCached = $(modal);
	var modalHeight = modalCached.css('height');

	form.fadeOut(200, function () {
		$(modal + ' .alert-danger').remove();
		modalCached
			.css('height', modalHeight)
			.animate({
				'height' : '57px' // The perfect height for ".loading" state.
			}, 200);
		$(modal + ' > .continer-fluid').append('<div class="loading"></div>');
		$('.loading').fadeIn(200);
		$.ajax({
			url     : url,
			type    : 'POST',
			data    : form.serialize(),
			success : function (response) {
				var successNewHeight;
				if (response !== error) {
					if ( form.hasClass('js-account-signed') || response === 'Registered.' ) {
						window.location.reload();
					} else {
						$('.loading').fadeOut(200);
						$(modalFooter + ' ' + actionButton).fadeOut(200);
						$(modalFooter + ' .btn-default').fadeOut(200, function () {
							$(this)
								.text('Close')
								.fadeIn(200);
						});


						$(modalFooter + ' ' + actionButton).remove();
						$('.loading').remove();
						modalCached.append('<div class="alert alert-success" role="alert">' + seccessText + '</div>');
						if (appendResponse === true) {
							modalCached.append('<div class="well"><h4>' + response + '</h4></div>');
						}
						modalCached.removeAttr('style');
						successNewHeight = modalCached.css('height');
						$(modal + ' .alert-success').css('display', 'none');
						$(modal + ' .well').css('display', 'none');


						modalCached.animate({
							'height' : successNewHeight
						}, 200);

						$(modal + ' .alert-success').fadeIn(200);
						if (appendResponse === true) {
							$(modal + ' .well').fadeIn(200);
						}
						if (typeof callback !== 'undefined') {
							callback();
						}
					}
				} else {
					$('.loading').fadeOut(200);


					modalCached
						.append('<div class="alert alert-danger" role="alert">' + errorText + '</div>')
						.removeAttr('style');
					$('.loading').remove();
					form.css('display', 'block');
					successNewHeight = modalCached.css('height');
					form.css('display', 'none');
					$(modal + ' .alert-danger').css('display', 'none');


					modalCached.animate({
						'height' : successNewHeight
					}, 200);


					form.fadeIn(200);
					$(modal + ' .alert-danger').fadeIn(200);
				}
			},
			error   : function (response) {
				var errorNewHeight;
				$('.loading').fadeOut(200);


				if (validateInput === true) {
					if (response.status === 422) {
						for (var key in response.responseJSON) {
							modalCached.append('<div class="alert alert-danger" role="alert">' + response.responseJSON[key][0] + '</div>');
							break;
						}
						modalCached.removeAttr('style');
						$('.loading').remove();
						form.css('display', 'block');
						errorNewHeight = modalCached.css('height');
						form.css('display', 'none');
						$(modal + ' .alert-danger').css('display', 'none');


						modalCached.animate({
							'height' : errorNewHeight
						}, 200);


						form.fadeIn(200);
						$(modal + ' .alert-danger').fadeIn(200);
					} else {
						modalCached
							.append('<div class="alert alert-danger" role="alert">It seems that our database is busy right now. Please try again later.</div>')
							.removeAttr('style');
						$('.loading').remove();
						form.css('display', 'block');
						errorNewHeight = modalCached.css('height');
						form.css('display', 'none');
						$(modal + ' .alert-danger').css('display', 'none');


						modalCached.animate({
							'height' : errorNewHeight
						}, 200);


						form.fadeIn(200);
						$(modal + ' .alert-danger').fadeIn(200);
					}
				} else {
					modalCached
						.append('<div class="alert alert-danger" role="alert">It seems that our database is busy right now. Please try again later.</div>')
						.removeAttr('style');
					$('.loading').remove();
					form.css('display', 'block');
					errorNewHeight = modalCached.css('height');
					form.css('display', 'none');
					$(modal + ' .alert-danger').css('display', 'none');


					modalCached.animate({
						'height' : errorNewHeight
					}, 200);


					form.fadeIn(200);
					$(modal + ' .alert-danger').fadeIn(200);
				}
			}
		}); // Ajax ends.
	}); // FadeOut ends.
};