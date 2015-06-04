// Autocompletion that finds an item in the database and outputs it
// to the publishing form; keyboard navigation is included.
// ========================================================================
var itemAutocompleteCached = {
	input                 : $('#sell_item_name'),
	resultsContainer      : $('.sell-item-name-search-results'),
	loading               : '<div class="loading"></div>',
	countingSearchResults : []
};


/**
 * Hides the autocomplete dropdown.
 * @return {void}
 */
function hideItemAutocomplete () {
	// Hiding the dropdown when it's input is out of focus:
	if ( itemAutocompleteCached.resultsContainer.children().length > 0  ) {
		itemAutocompleteCached.resultsContainer.html('');
		itemAutocompleteCached.resultsContainer.css('visibility', 'hidden');
	}
}

// Actually hide the dropdown when its input is out of focus:
$('.modal-content').click( function () {
	if ( $('.sell-item-name-search-results li:hover').length === 0 ) {
		hideItemAutocomplete();
	}
});



/**
 * Gets items from the database and outputs them to the view.
 * @return {object} A JSON-object containing items that were found.
 */
function getItem () {
	var searchInput = itemAutocompleteCached.input.val();

	if ( $.trim(searchInput) !== '' ) {
		itemAutocompleteCached.resultsContainer.html(itemAutocompleteCached.loading);
		itemAutocompleteCached.resultsContainer.css('visibility', 'visible');

		$.ajax({
			url     : '/item/find',
			data    : {name: searchInput},
			success : function (items) {
				if ( items.length === 0 ) {
					itemAutocompleteCached.resultsContainer.html('<p class="nowrap">Nothing found, which means we don\'t have it in our database yet. We do our best to fill it as much as possible to open more trading opportunities, so please try again later, we might have it by the time.</p>');
				} else {
					itemAutocompleteCached.resultsContainer.html('');
					itemAutocompleteCached.countingSearchResults.length = 0;

					$.each(items, function (key, item) {
						itemAutocompleteCached.countingSearchResults.push(key);
						if ( item.type === 'mod') {
							$('<li data-type="' + item.type + '" data-name="' + item.name + '">' + item.name + ' (mod)</li>').appendTo(itemAutocompleteCached.resultsContainer);
						} else {
							$('<li data-type="' + item.type + '" data-name="' + item.name + '">' + item.name + '</li>').appendTo(itemAutocompleteCached.resultsContainer);
						}


						$('.sell-item-name-search-results li').hover( function () {
							if ( $('.sell-item-name-search-results li').hasClass('js-sell-item-name-search-result-hover') ) {
								$('.sell-item-name-search-results li').removeClass('js-sell-item-name-search-result-hover');
							}
						}).click( function () {
							itemAutocompleteCached.input.val( $(this).attr('data-name') );
							if ( $(this).attr('data-type') === 'mod') {
								$('.sell_item_rank_fieldset[disabled]').removeAttr('disabled');
							} else {
								$('.sell_item_rank_fieldset').attr('disabled', 'disabled');
							}
							hideItemAutocomplete();
						});
					}); // $.each ends.
				} // Else ends.
			},
			error   : function () {
				itemAutocompleteCached.resultsContainer.html('<p class="nowrap">It seems that our database is busy right now. Please try again later.</p>');
			}
		}); // Ajax call ends.
	}
} // getItem ends.


/**
 * Implements keyboard naviation for autocompletion results.
 * By default, delays sending a search query while it's being typed.
 */
var itemAutocompleteKeyUpCached = {
	resultsItem   : null,
	resultsLength : null,
	delay         : null
};

itemAutocompleteCached.input.keyup( function (event) {
	switch (event.keyCode) {
		case 40:
			itemAutocompleteKeyUpCached.resultsItem = $('.sell-item-name-search-results li');
			itemAutocompleteKeyUpCached.resultsLength = itemAutocompleteCached.countingSearchResults.length;

			for (var i = 0; i < itemAutocompleteKeyUpCached.resultsLength; i++) {
				if ( itemAutocompleteCached.countingSearchResults[i] === 'js-sell-item-name-search-result-hover' ) {
					if ( i === itemAutocompleteKeyUpCached.resultsLength - 1 ) {
						itemAutocompleteCached.countingSearchResults[i] = i;
						itemAutocompleteKeyUpCached.resultsItem.eq(i).removeClass('js-sell-item-name-search-result-hover');
						itemAutocompleteCached.countingSearchResults[0] = 'js-sell-item-name-search-result-hover';
						itemAutocompleteKeyUpCached.resultsItem.eq(0).addClass('js-sell-item-name-search-result-hover');
						break;
					} else {
						itemAutocompleteCached.countingSearchResults[i] = i;
						itemAutocompleteKeyUpCached.resultsItem.eq(i).removeClass('js-sell-item-name-search-result-hover');
						itemAutocompleteCached.countingSearchResults[i + 1] = 'js-sell-item-name-search-result-hover';
						itemAutocompleteKeyUpCached.resultsItem.eq(i + 1).addClass('js-sell-item-name-search-result-hover');
						break;
					}
				} else {
					if ( i === itemAutocompleteKeyUpCached.resultsLength - 1 ) {
						itemAutocompleteCached.countingSearchResults[0] = 'js-sell-item-name-search-result-hover';
						itemAutocompleteKeyUpCached.resultsItem.eq(0).addClass('js-sell-item-name-search-result-hover');
						break;
					} else {
						continue;
					}
				}
			}
			break;
		case 38:
			itemAutocompleteKeyUpCached.resultsItem = $('.sell-item-name-search-results li');
			itemAutocompleteKeyUpCached.resultsLength = itemAutocompleteCached.countingSearchResults.length;

			for (var j = 0; j < itemAutocompleteKeyUpCached.resultsLength; j++) {
				if ( itemAutocompleteCached.countingSearchResults[j] === 'js-sell-item-name-search-result-hover' ) {
					if ( j === 0 ) {
						itemAutocompleteCached.countingSearchResults[j] = j;
						itemAutocompleteKeyUpCached.resultsItem.eq(j).removeClass('js-sell-item-name-search-result-hover');
						itemAutocompleteCached.countingSearchResults[itemAutocompleteKeyUpCached.resultsLength - 1] = 'js-sell-item-name-search-result-hover';
						itemAutocompleteKeyUpCached.resultsItem.eq(itemAutocompleteKeyUpCached.resultsLength - 1).addClass('js-sell-item-name-search-result-hover');
						break;
					} else {
						itemAutocompleteCached.countingSearchResults[j] = j;
						itemAutocompleteKeyUpCached.resultsItem.eq(j).removeClass('js-sell-item-name-search-result-hover');
						itemAutocompleteCached.countingSearchResults[j - 1] = 'js-sell-item-name-search-result-hover';
						itemAutocompleteKeyUpCached.resultsItem.eq(j - 1).addClass('js-sell-item-name-search-result-hover');
						break;
					}
				} else {
					if ( j === itemAutocompleteKeyUpCached.resultsLength - 1 ) {
						itemAutocompleteCached.countingSearchResults[itemAutocompleteKeyUpCached.resultsLength - 1] = 'js-sell-item-name-search-result-hover';
						itemAutocompleteKeyUpCached.resultsItem.eq(itemAutocompleteKeyUpCached.resultsLength - 1).addClass('js-sell-item-name-search-result-hover');
						break;
					} else {
						continue;
					}
				}
			}
			break;
		case 13:
			if ( $('.sell-item-name-search-results li').hasClass('js-sell-item-name-search-result-hover') ) {
				itemAutocompleteCached.input.val( $('.sell-item-name-search-results li.js-sell-item-name-search-result-hover').attr('data-name') );
				if ( $('.sell-item-name-search-results li.js-sell-item-name-search-result-hover').attr('data-type') === 'mod' ) {
					$('.sell_item_rank_fieldset[disabled]').removeAttr('disabled');
				} else {
					$('.sell_item_rank_fieldset').attr('disabled', 'disabled');
				}
				hideItemAutocomplete();
			}
			break;
		default:
			if ( itemAutocompleteKeyUpCached.delay ) {
				clearTimeout(itemAutocompleteKeyUpCached.delay);
			}

			itemAutocompleteKeyUpCached.delay = setTimeout(getItem, 500);
	}
}); // .keyup() ends.