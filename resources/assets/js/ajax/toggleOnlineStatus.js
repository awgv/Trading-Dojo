// A call to switch user's online status.
// ========================================================================
var userOnlineStatusCheckbox = $('input[name="js-user-online-status"]');

/**
 * General AJAX call for switching a status.
 * @param  {bool} state User's current status.
 * @return {void}
 */
var userOnlineStatusAjaxCall = function(state) {
	var route;
	var description = $('.js-user-online-description');

	if (state === true) {
		route = '/user/status/online';
	} else {
		route = '/user/status/offline';
	}


	$.ajax({
		url     : route,
		type    : 'GET',
		success : function (response) {
			if (response === 'Online.') {
				description.fadeOut(200, function () {
					description.text('You\'re playing and can trade.');
					description.fadeIn(200);
				});
			} else if (response === 'Offline.') {
				description.fadeOut(200, function () {
					description.text('You\'re not in the game and unavailable for trading.');
					description.fadeIn(200);
				});
			} else {
				description.fadeOut(200, function () {
					description.text('There\'s something wrong, please try again later.');
					description.fadeIn(200);
				});

				userOnlineStatusCheckbox.bootstrapSwitch('toggleIndeterminate');
			}
		},
		error   : function () {
			description.fadeOut(200, function () {
				description.text('There\'s something wrong, please try again later.');
				description.fadeIn(200);
			});

			userOnlineStatusCheckbox.bootstrapSwitch('toggleIndeterminate');
		}
	}); // Ajax ends.
};


if ( userOnlineStatusCheckbox.hasClass('js-user-online-status-1')) {
	userOnlineStatusCheckbox.bootstrapSwitch({
		state : true,
		onColor : 'success',
		offColor : 'danger',
		onText : 'ONLINE',
		offText : 'OFFLINE',
		size  : 'mini'
	}).on('switchChange.bootstrapSwitch', function(event, state) {
		userOnlineStatusAjaxCall(state);
	});
} else {
	userOnlineStatusCheckbox.bootstrapSwitch({
		state : false,
		onColor : 'success',
		offColor : 'danger',
		onText : 'ONLINE',
		offText : 'OFFLINE',
		size  : 'mini'
	}).on('switchChange.bootstrapSwitch', function(event, state) {
		userOnlineStatusAjaxCall(state);
	});
}