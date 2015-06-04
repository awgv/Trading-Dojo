// Various popovers' initialization.
// ========================================================================
// Popover for the discription:
var popoverAccountBenefitsContents  = '<p>Account is just a convenience to players who sell a lot of items at the same time, so you might not need it at all. With an account you\'re be able to:</p>';
	popoverAccountBenefitsContents += '<ul class="dojo-popover-ul">';
		popoverAccountBenefitsContents += '<li>see all your offers in one place;</li>';
		popoverAccountBenefitsContents += '<li>change their price and commentary;</li>';
		popoverAccountBenefitsContents += '<li>renew all or some of your offers instead of creating them over and over again.</li>';
	popoverAccountBenefitsContents += '</ul>';


$('.js-popover-account-creation').popover({
	html      : true,
	placement : 'top',
	trigger   : 'hover',
	content   : popoverAccountBenefitsContents
}).click( function (event) {
	event.preventDefault();
});


$('.js-popover-account-offers-status').popover({
	placement : 'top',
	trigger   : 'hover',
	content   : 'All offers are automatically removed from tables after 3 days of publishing. Offers that were published by guest users are deleted; offers that were published by registered accounts are expired instead—this lets such users to renew their expired offers without having to fill in the publishing form over and over again.'
}).click( function (event) {
	event.preventDefault();
});


$('.js-popover-missing-item').popover({
	placement : 'top',
	trigger   : 'focus',
	html      : true,
	content   : 'Can\'t find an item? Add it to the "raw" sheet of this <a href="https://docs.google.com/spreadsheets/d/15K2ZRFk34HqUNRJFJ5H6Gc-axgetOagBpCXD1wYY75w/edit?usp=sharing">Google spreadsheet</a>, and we\'ll update our database with your changes very soon. Alternatively, you can always <a href="mailto:dojo.trade.wf@gmail.com">send us</a> a message.'
});



// Popover for recent offers:
var popoverRecentOffersContents  = '<div class="btn-group" role="group" aria-label="...">';
		popoverRecentOffersContents += '<a class="btn btn-default navbar-btn" href="/offers/recent/pc" role="button">PC</a>';
		popoverRecentOffersContents += '<a class="btn btn-default navbar-btn" href="/offers/recent/ps4" role="button">PS4</a>';
		popoverRecentOffersContents += '<a class="btn btn-default navbar-btn" href="/offers/recent/xbox-one" role="button">Xbox One</a>';
	popoverRecentOffersContents += '</div>';

$('.js-popover-recent-offers').popover({
	container : 'body',
	placement : 'bottom',
	trigger   : 'focus',
	html      : true,
	content   : popoverRecentOffersContents
}).click( function (event) {
	event.preventDefault();
});



// Popover for new messages:
$('.js-popover-new-messages').popover({
	container : 'body',
	placement : 'top',
	trigger   : 'manual',
	content   : 'Inbox messages await the Operator.'
}).popover('show');



// Popover for user's online status:
var popoverUserOnlineStatusContents  = '<p>If you\'d like Trading Dojo to show that you\'re playing and can trade:</p>';
	popoverUserOnlineStatusContents += '<ol class="dojo-popover-ol">';
		popoverUserOnlineStatusContents += '<li>launch the game and log in;</li>';
		popoverUserOnlineStatusContents += '<li>flip this switch on Trading Dojo;</li>';
		popoverUserOnlineStatusContents += '<li>flip the switch back when you\'re done playing.</li>';
	popoverUserOnlineStatusContents += '</ol>';
	popoverUserOnlineStatusContents += '<p><mark>Please note that your online status will automatically turn offline in 8 hours after going online, and you\'ll need to switch it on again.</mark></p>';
	popoverUserOnlineStatusContents += '<p>Unfortunately, there\'s no better way to show your online status.</p>';

$('.bootstrap-switch').popover({
	container : 'body',
	placement : 'bottom',
	trigger   : 'hover',
	html      : true,
	content   : popoverUserOnlineStatusContents
});



// Popover for profile urls that describes ign's color:
$('.js-popover-user-online-status-color').popover({
	container : 'body',
	placement : 'top',
	trigger   : 'hover',
	content   : 'Green color means they\'re currently in the game; blue means we don\'t know.'
});