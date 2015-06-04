// A call that submits publishing form; validation included.
// ========================================================================
// For offers published by guest users:
var guestOfferFormVariables = {
	modal        : '.js-modal-create',
	form         : $('.sell_item_form'),
	url          : '/offer/publish/guest',
	actionButton : '.btn-primary',
	error        : 'Doesn\'t exist.',
	modalFooter  : '.js-modal-footer-create',
	successText  : 'You\'re live. <mark>Write down the code below</mark>—you\'ll need it to remove your offer after a successful trade; it\'s your communal responsibility to do so, please keep our tables clean. Your offer will automatically be removed in 3 days.<br><br>Please refresh the page to add another offer.',
	errorText    : 'The item you\'re trying to sell doesn\'t exist in our database. Please check the item\'s name, or come back later, we might have it by the time.'
};

$('.sell_item_form_submit').click( function () {
	guestOfferFormVariables.form.submit();
});

guestOfferFormVariables.form.validator().submit( function (event) {
	if ( !event.isDefaultPrevented() ) {
		// value="11" means NULL at back-end, since it doesn't allow for non-negative values:
		if ( $('.sell_item_rank_fieldset[disabled]').length > 0 ) {
			guestOfferFormVariables.form.append('<input type="hidden" name="sell_item_rank" value="11">');
		}

		event.preventDefault();

		ajaxFormSubmit(guestOfferFormVariables.modal, guestOfferFormVariables.form, guestOfferFormVariables.url, guestOfferFormVariables.actionButton, guestOfferFormVariables.error, guestOfferFormVariables.modalFooter, guestOfferFormVariables.successText, true, guestOfferFormVariables.errorText, true);
	} // If ends.
}); // Validator ends.



// For offers published by authenticated users:
var userOfferFormVariables = {
	modal        : '.js-modal-create',
	form         : $('.sell_item_form_authed'),
	url          : '/offer/publish/user',
	actionButton : '.btn-primary',
	error        : 'Doesn\'t exist.',
	modalFooter  : '.js-modal-footer-create',
	successText  : '',
	errorText    : 'The item you\'re trying to sell doesn\'t exist in our database. Please check the item\'s name, or come back later, we might have it by the time.'
};

$('.sell_item_form_submit_authed').click( function () {
	userOfferFormVariables.form.submit();
});

userOfferFormVariables.form.validator().submit( function (event) {
	if ( !event.isDefaultPrevented() ) {
		// value="11" means NULL at back-end, since it doesn't allow for non-negative values:
		if ( $('.sell_item_rank_fieldset[disabled]').length > 0 ) {
			userOfferFormVariables.form.append('<input type="hidden" name="sell_item_rank" value="11">');
		}

		userOfferFormVariables.form.append('<input type="hidden" name="sell_user_ign" value="' + $('#user_ign').val() + '">');


		event.preventDefault();

		ajaxFormSubmit(userOfferFormVariables.modal, userOfferFormVariables.form, userOfferFormVariables.url, userOfferFormVariables.actionButton, userOfferFormVariables.error, userOfferFormVariables.modalFooter, userOfferFormVariables.successText, true, userOfferFormVariables.errorText, true);
	} // If ends.
}); // Validator ends.