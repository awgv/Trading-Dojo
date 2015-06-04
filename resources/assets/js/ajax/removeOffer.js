// A call that removes an offer from the database.
// ========================================================================
var removeOfferFormVariables = {
	modal        : '.js-modal-remove',
	form         : $('.remove_offer_form'),
	url          : '/offer/remove',
	actionButton : '.btn-warning',
	error        : 'Doesn\'t exist.',
	modalFooter  : '.js-modal-footer-remove',
	successText  : 'Your offer was successfully removed. Please refresh the page to remove another offer.',
	errorText    : 'An offer with that code doesn\'t exist. You either deleted it already, or it was removed automatically after 3 days of publishing.'
};

$('.remove_offer_form_submit').click( function () {
	removeOfferFormVariables.form.submit();
});

removeOfferFormVariables.form.validator().submit( function (event) {
	if ( !event.isDefaultPrevented() ) {
		event.preventDefault();

		ajaxFormSubmit(removeOfferFormVariables.modal, removeOfferFormVariables.form, removeOfferFormVariables.url, removeOfferFormVariables.actionButton, removeOfferFormVariables.error, removeOfferFormVariables.modalFooter, removeOfferFormVariables.successText, false, removeOfferFormVariables.errorText, false);
	} // If ends.
}); // Validator ends.