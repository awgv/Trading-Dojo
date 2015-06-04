// A call that updates new messages every 30 seconds.
// ========================================================================
if ( $('.js-messages-check').length > 0 ) {
	var currentMessagesSelector      = $('.js-messages-check');
	var currentMessagesBadgeSelector = $('.badge');


	setInterval(function () {
		var currentMessagesCount    = currentMessagesBadgeSelector.text();

		$.ajax({
			url     : '/messages/check',
			type    : 'POST',
			data    : { current_messages_count : currentMessagesCount },
			success : function (response) {
				if ( response !== 'There\'s no new messages.' ) {
					if ( !currentMessagesSelector.hasClass('btn-info') ) {
						currentMessagesSelector.removeClass('btn-default').addClass('btn-info').addClass('js-popover-new-messages');
						currentMessagesSelector.html('Your messages <span class="badge">' + response + '</span>');

						// Popover for new messages:
						$('.js-popover-new-messages').popover({
							container : 'body',
							placement : 'top',
							trigger   : 'manual',
							content   : 'Inbox messages await the Operator.'
						}).popover('show');
					} else {
						currentMessagesBadgeSelector.text(response);
					}
				}
			},
			error   : function () {
				
			}
		}); // Ajax ends.
	}, 30000);
}