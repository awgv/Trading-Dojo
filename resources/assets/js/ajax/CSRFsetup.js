// Add CSRF token to every AJAX call.
// ========================================================================
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	}
});