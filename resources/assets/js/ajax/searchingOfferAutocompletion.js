// Autocompletion for searching.
// ========================================================================
var offerAutocompleteCached = {
	input                 : $('#offer_item_name'),
	platform              : $('#offer_item_platform'),
	resultsContainer      : $('.offer-item-name-search-results'),
	loading               : '<div class="loading"></div>',
	countingSearchResults : []
};


/**
 * Hides the autocomplete dropdown.
 * @return {void}
 */
function hideOfferAutocomplete () {
	// Hiding the dropdown when it's input is out of focus:
	if ( offerAutocompleteCached.resultsContainer.children().length > 0  ) {
		offerAutocompleteCached.resultsContainer.html('');
		offerAutocompleteCached.resultsContainer.css('visibility', 'hidden');
	}
}

// Actually hide the dropdown when its input is out of focus:
$('html').click( function () {
	if ( $('.offer-item-name-search-results li:hover').length === 0 ) {
		hideOfferAutocomplete();
	}
});



/**
 * Gets offers from the database and outputs them to the view.
 * @return {object} A JSON-object containing items that were found.
 */
function getOffer () {
	var searchInput = offerAutocompleteCached.input.val();

	if ( $.trim(searchInput) !== '' ) {
		offerAutocompleteCached.resultsContainer.html(offerAutocompleteCached.loading);
		offerAutocompleteCached.resultsContainer.css('visibility', 'visible');

		$.ajax({
			url     : '/item/find',
			data    : {name: searchInput},
			success : function (items) {
				if ( items.length === 0 ) {
					offerAutocompleteCached.resultsContainer.html('<p class="nowrap">Nothing found, which means we don\'t have it in our database yet. We do our best to fill it as much as possible to open more trading opportunities, so please try again later, we might have it by the time.</p>');
				} else {
					offerAutocompleteCached.resultsContainer.html('');
					offerAutocompleteCached.countingSearchResults.length = 0;

					$.each(items, function (key, item) {
						offerAutocompleteCached.countingSearchResults.push(key);
						if ( item.type === 'mod') {
							$('<li data-platform="' + offerAutocompleteCached.platform.val() + '" data-slug="' + item.slug + '">' + item.name + ' (mod)</li>').appendTo(offerAutocompleteCached.resultsContainer);
						} else {
							$('<li data-platform="' + offerAutocompleteCached.platform.val() + '" data-slug="' + item.slug + '">' + item.name + '</li>').appendTo(offerAutocompleteCached.resultsContainer);
						}


						$('.offer-item-name-search-results li').hover( function () {
							if ( $('.offer-item-name-search-results li').hasClass('js-offer-item-name-search-result-hover') ) {
								$('.offer-item-name-search-results li').removeClass('js-offer-item-name-search-result-hover');
							}
						}).click( function () {
							window.location = '/' + $(this).attr('data-platform') + '/' +  $(this).attr('data-slug');
						});
					}); // $.each ends.
				} // Else ends.
			},
			error   : function () {
				offerAutocompleteCached.resultsContainer.html('<p class="nowrap">It seems that our database is busy right now. Please try again later.</p>');
			}
		}); // Ajax call ends.
	}
} // getOffer ends.


/**
 * Implements keyboard naviation for autocompletion results.
 * By default, delays sending a search query while it's being typed.
 */
var offerAutocompleteKeyUpCached = {
	resultsItem   : null,
	resultsLength : null,
	delay         : null
};

offerAutocompleteCached.input.keyup( function (event) {
	switch (event.keyCode) {
		case 40:
			offerAutocompleteKeyUpCached.resultsItem = $('.offer-item-name-search-results li');
			offerAutocompleteKeyUpCached.resultsLength = offerAutocompleteCached.countingSearchResults.length;

			for (var i = 0; i < offerAutocompleteKeyUpCached.resultsLength; i++) {
				if ( offerAutocompleteCached.countingSearchResults[i] === 'js-offer-item-name-search-result-hover' ) {
					if ( i === offerAutocompleteKeyUpCached.resultsLength - 1 ) {
						offerAutocompleteCached.countingSearchResults[i] = i;
						offerAutocompleteKeyUpCached.resultsItem.eq(i).removeClass('js-offer-item-name-search-result-hover');
						offerAutocompleteCached.countingSearchResults[0] = 'js-offer-item-name-search-result-hover';
						offerAutocompleteKeyUpCached.resultsItem.eq(0).addClass('js-offer-item-name-search-result-hover');
						break;
					} else {
						offerAutocompleteCached.countingSearchResults[i] = i;
						offerAutocompleteKeyUpCached.resultsItem.eq(i).removeClass('js-offer-item-name-search-result-hover');
						offerAutocompleteCached.countingSearchResults[i + 1] = 'js-offer-item-name-search-result-hover';
						offerAutocompleteKeyUpCached.resultsItem.eq(i + 1).addClass('js-offer-item-name-search-result-hover');
						break;
					}
				} else {
					if ( i === offerAutocompleteKeyUpCached.resultsLength - 1 ) {
						offerAutocompleteCached.countingSearchResults[0] = 'js-offer-item-name-search-result-hover';
						offerAutocompleteKeyUpCached.resultsItem.eq(0).addClass('js-offer-item-name-search-result-hover');
						break;
					} else {
						continue;
					}
				}
			}
			break;
		case 38:
			offerAutocompleteKeyUpCached.resultsItem = $('.offer-item-name-search-results li');
			offerAutocompleteKeyUpCached.resultsLength = offerAutocompleteCached.countingSearchResults.length;

			for (var j = 0; j < offerAutocompleteKeyUpCached.resultsLength; j++) {
				if ( offerAutocompleteCached.countingSearchResults[j] === 'js-offer-item-name-search-result-hover' ) {
					if ( j === 0 ) {
						offerAutocompleteCached.countingSearchResults[j] = j;
						offerAutocompleteKeyUpCached.resultsItem.eq(j).removeClass('js-offer-item-name-search-result-hover');
						offerAutocompleteCached.countingSearchResults[offerAutocompleteKeyUpCached.resultsLength - 1] = 'js-offer-item-name-search-result-hover';
						offerAutocompleteKeyUpCached.resultsItem.eq(offerAutocompleteKeyUpCached.resultsLength - 1).addClass('js-offer-item-name-search-result-hover');
						break;
					} else {
						offerAutocompleteCached.countingSearchResults[j] = j;
						offerAutocompleteKeyUpCached.resultsItem.eq(j).removeClass('js-offer-item-name-search-result-hover');
						offerAutocompleteCached.countingSearchResults[j - 1] = 'js-offer-item-name-search-result-hover';
						offerAutocompleteKeyUpCached.resultsItem.eq(j - 1).addClass('js-offer-item-name-search-result-hover');
						break;
					}
				} else {
					if ( j === offerAutocompleteKeyUpCached.resultsLength - 1 ) {
						offerAutocompleteCached.countingSearchResults[offerAutocompleteKeyUpCached.resultsLength - 1] = 'js-offer-item-name-search-result-hover';
						offerAutocompleteKeyUpCached.resultsItem.eq(offerAutocompleteKeyUpCached.resultsLength - 1).addClass('js-offer-item-name-search-result-hover');
						break;
					} else {
						continue;
					}
				}
			}
			break;
		case 13:
			if ( $('.offer-item-name-search-results li').hasClass('js-offer-item-name-search-result-hover') ) {
				window.location = '/' + $('.offer-item-name-search-results li.js-offer-item-name-search-result-hover').attr('data-platform') + '/' +  $('.offer-item-name-search-results li.js-offer-item-name-search-result-hover').attr('data-slug');
			}
			break;
		default:
			if ( offerAutocompleteKeyUpCached.delay ) {
				clearTimeout(offerAutocompleteKeyUpCached.delay);
			}

			offerAutocompleteKeyUpCached.delay = setTimeout(getOffer, 500);
	}
}); // .keyup() ends.