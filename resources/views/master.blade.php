<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Trading Dojo @yield('title')</title>
		<meta name="Description" content="Trading Dojo is a bulletin board that helps Warframe players trade in a faster and more convenient way.">
		<link rel="icon" type="image/x-icon" href="/favicon.ico">
		{!! HTML::style('css/general.min.css') !!}
	</head>
	<body>
		<div class="container dojo-offset-100">
			@yield('content')
		</div>
		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<p class="text-muted">This site is fan-made and not affiliated with Digital Extremes in any way. Warframe, its content and materials are trademarks and copyrights of Digital Extremes Ltd. The <a href="mailto:dojo.trade.wf@gmail.com">author of this website</a> assumes no responsibility for its contents.</p>
					</div>
				</div>
			</div>
		</footer>
		{!! HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js') !!}
		{!! HTML::script('js/general.min.js') !!}
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-61692414-1', 'auto');
			ga('send', 'pageview');
		</script>
	</body>
</html>