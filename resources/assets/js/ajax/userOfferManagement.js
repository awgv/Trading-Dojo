// editableTableWidget's initialization. If you're looking for logic
// that changes price/commentary or renews/expires/removes offers—it's here.
// ========================================================================
$('.js-account-offers-table').editableTableWidget();


// A bit of validation:
$('td[data-editable="true"]').on('validate', function(evt, value) {
	var cell   = $(this);
	var	column = cell.index();

	if (column === 1) {
		if (value === '' || !$.isNumeric(value) || value < 1) {
			return false;
		}
	} else if (column === 3) {
		if (value.length > 250) {
			return false;
		} else {
			if (value === '') {
				return '';
			} else {
				return value.trim();
			}
		}
	}
});


/**
 * General AJAX-call for table's on change event.
 * @param  {object} data An object to send with a call.
 * @return {void}
 */
var editableTableWidgetAjaxCall = function (data) {
	$.ajax({
		url     : '/offer/update',
		data    : data,
		type    : 'POST',
		success : function (response) {
			$('#updateSignedOfferCall').modal('hide');
			setTimeout(function () {
				$('#updateSignedOfferDone').modal('show');
			}, 300);
		},
		error   : function () {
			$('#updateSignedOfferCall').modal('hide');
			setTimeout(function () {
				$('#updateSignedOfferError').modal('show');
			}, 300);
		}
	}); // Ajax ends.
};



$('td[data-editable="true"]').on('change', function(evt, value) {
	var cell   = $(this);
	var	column = cell.index();
	var id     = cell.attr('data-id');


	$('#updateSignedOfferCall').modal({
		keyboard : false,
		backdrop : 'static'
	});


	if (column === 1) {
		editableTableWidgetAjaxCall({
			sell_item_price : value,
			sell_item_id    : id
		});
	} else if (column === 3) {
		editableTableWidgetAjaxCall({
			sell_item_commentary : value,
			sell_item_id         : id
		});
	}
}); // On change ends.



// Hiding buttons until they're hovered:
$('tr').hover(function () {
	var row = $(this);

	row.find('td').eq(5).find('.js-account-offer-table-button').removeClass('invisible');
}, function () {
	var row = $(this);

	row.find('td').eq(5).find('.js-account-offer-table-button').addClass('invisible');
});



// AJAX call to remove an offer:
$('.js-account-offer-remove').click( function (event) {
	event.preventDefault();
	var that   = $(this);
	var cell   = that.parent();
	var row    = cell.parent();
	var id     = cell.attr('data-id');

	$.ajax({
		url     : '/offer/remove',
		data    : {
			sell_item_id : id
		},
		type    : 'POST',
		success : function (response) {
			$('#updateSignedOfferCall').modal('hide');
			if (response === 'Removed.') {
				setTimeout(function () {
					$('#removeSignedOfferSuccess').modal('show');
				}, 300);

				row.addClass('danger');
				row.fadeOut(200);
			} else {
				setTimeout(function () {
					$('#removeSignedOfferError').modal('show');
				}, 300);
			}
		},
		error   : function () {
			$('#updateSignedOfferCall').modal('hide');
			setTimeout(function () {
				$('#updateSignedOfferError').modal('show');
			}, 300);
		}
	}); // Ajax ends.
});



// AJAX call to expire an offer:
$('.js-account-offer-expire').click( function (event) {
	event.preventDefault();
	var that = $(this);
	var cell = that.parent();
	var row  = cell.parent();
	var id   = cell.attr('data-id');

	$.ajax({
		url     : '/offer/expire',
		data    : {
			sell_item_id : id
		},
		type    : 'POST',
		success : function (response) {
			$('#updateSignedOfferCall').modal('hide');
			if (response === 'Expired.') {
				window.location = '/';
			} else {
				setTimeout(function () {
					$('#renewSignedOfferError').modal('show');
				}, 300);
			}
		},
		error   : function () {
			$('#updateSignedOfferCall').modal('hide');
			setTimeout(function () {
				$('#updateSignedOfferError').modal('show');
			}, 300);
		}
	}); // Ajax ends.
});



// AJAX call to renew an offer:
$('.js-account-offer-renew').click( function (event) {
	event.preventDefault();
	var that = $(this);
	var cell = that.parent();
	var row  = cell.parent();
	var id   = cell.attr('data-id');

	$.ajax({
		url     : '/offer/renew',
		data    : {
			sell_item_id : id
		},
		type    : 'POST',
		success : function (response) {
			$('#updateSignedOfferCall').modal('hide');
			if (response === 'Renewed.') {
				window.location.reload();
			} else {
				setTimeout(function () {
					$('#renewSignedOfferError').modal('show');
				}, 300);
			}
		},
		error   : function () {
			$('#updateSignedOfferCall').modal('hide');
			setTimeout(function () {
				$('#updateSignedOfferError').modal('show');
			}, 300);
		}
	}); // Ajax ends.
});



// AJAX call to renew all offers:
$('.js-account-offer-renew-all').click( function (event) {
	event.preventDefault();

	$.ajax({
		url     : '/offer/renew/all',
		type    : 'GET',
		success : function (response) {
			$('#updateSignedOfferCall').modal('hide');
			if (response === 'Renewed.') {
				window.location = '/';
			} else {
				setTimeout(function () {
					$('#renewSignedOfferError').modal('show');
				}, 300);
			}
		},
		error   : function () {
			$('#updateSignedOfferCall').modal('hide');
			setTimeout(function () {
				$('#updateSignedOfferError').modal('show');
			}, 300);
		}
	}); // Ajax ends.
});
// Table ends.