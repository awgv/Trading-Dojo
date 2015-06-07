var gulp        = require('gulp');
var elixir      = require('laravel-elixir');
var wrap        = require('gulp-wrap');

// Wrap JavaScript file with onDomReady via gulp-wrap:
elixir.extend('wrap', function(file) {
	gulp.task('wrap', function() {
		gulp.src('resources/assets/js/' + file)
			.pipe(wrap('$(document).ready(function(){<%= contents %>});'))
			.pipe(gulp.dest('resources/assets/js/wrap'));
	});

	return this.queueTask('wrap');
});



/**
 * There're two Elixir functions here, because you can't execute
 * tasks sequentially, for example, the last .scripts() in
 * mix.styles().scripts().wrap().scripts() will be executed right
 * after the first one, and .wrap() will become the last.
 *
 * It is possible to do it with Gulp, but I didn't have time to
 * set it up, and there's a chance that Elixir will be updated soon
 * to allow that.
 *
 * So just run "gulp --production", comment the first one, uncomment
 * the second, and run it again. Hopefully, it'll become easier soon.
 */
elixir(function(mix) {
	mix
		.styles([
			'bootstrap.min.css',
			'bootstrap-theme.min.css',
			'bootstrap-switch.min.css',
			'general.css'
		], 'public/css/general.min.css')
		// At first, combine all project-related files:
		.scripts([
			'ajax/CSRFsetup.js',
			'ajax/generalAjaxFunction.js',
			'ajax/publishingOfferAutocompletion.js',
			'ajax/publishOffer.js',
			'ajax/removeOffer.js',
			'ajax/searchingOfferAutocompletion.js',
			'ajax/createAccount.js',
			'ajax/signIn.js',
			'ajax/toggleOnlineStatus.js',
			'initializePopovers.js',
			'ajax/userOfferManagement.js',
			'ajax/submitMessagesThread.js',
			'ajax/updateMessagesCount.js'
		], 'resources/assets/js/wrapped/general.js')
		// All project-related files should be wrapped with something, in this case it's onDomReady:
		.wrap('wrapped/general.js');
});

/*elixir(function(mix) {
	mix
		.scripts([
			// Finally, combine everything for production:
			'dependencies/bootstrap.min.js',
			'dependencies/validator.min.js',
			'dependencies/mindmup-editabletable.js',
			'dependencies/bootstrap-switch.min.js',
			'wrapped/general.js',
		], 'public/js/general.min.js');
});*/