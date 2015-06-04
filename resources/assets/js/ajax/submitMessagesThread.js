// A call that submits a new messages' thread.
// ========================================================================
// For new messages:
var sendMessageVariables = {
	modal        : '.js-modal-send',
	form         : $('.send_message_form'),
	url          : '/messages/send/store',
	actionButton : '.btn-primary',
	error        : 'Unauthorized.',
	modalFooter  : '.js-modal-footer-send',
	successText  : 'Sent! <a href="/messages">Here\'s a quick access</a> to your inbox, in case you want to see your message.',
	errorText    : 'Please sign in first.'
};

$('.send_message_form_submit').click( function () {
	sendMessageVariables.form.submit();
});

sendMessageVariables.form.validator().submit( function (event) {
	if ( !event.isDefaultPrevented() ) {
		sendMessageVariables.form.append('<input type="hidden" name="recipient[]" value="' + $('#recepient').attr('data-id') + '">');

		event.preventDefault();

		ajaxFormSubmit(sendMessageVariables.modal, sendMessageVariables.form, sendMessageVariables.url, sendMessageVariables.actionButton, sendMessageVariables.error, sendMessageVariables.modalFooter, sendMessageVariables.successText, false, sendMessageVariables.errorText, true);
	} // If ends.
}); // Validator ends.



// Hiding remove button until it's hovered:
$('.js-messages-remove').hover(function () {
	var row = $(this);

	row.find('a.btn').removeClass('invisible');
}, function () {
	var row = $(this);

	row.find('a.btn').addClass('invisible');
});