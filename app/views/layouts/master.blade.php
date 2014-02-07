<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>{{ $meta->title }}</title>

		<meta name="description" content="One Art Piece Daily for a full year. I call these freeflows as they are simply freeflow thoughts brought to life. - Bryan Berger">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<meta property="og:title" content="{{ $meta->title }}" />
		<meta property="og:type" content="article" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:url" content="{{ Request::url() }}" />
		<meta property="og:image" content="{{ $meta->image_url }}" />
		<meta property="og:description" content="One Art Piece Daily for a full year. I call these freeflows as they are simply freeflow thoughts brought to life. - Bryan Berger" />
		<meta property="og:site_name" content="Freeflow.me - Daily artwork" />

		<link rel="shortcut icon" href="http://freeflow.me/favicon.ico">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		{{ HTML::style('assets/css/styles.min.css'); }}
		<!--[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
			<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
		<![endif]-->
	</head>
	<body>
		<!--[if lt IE 8]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<main role="main" class="container">
			<header>
				<a href="/"><h1>One Art Piece Daily for a full year. A project from Bryan Berger</h1></a>
				<ul class="social">
					<li><a href="http://twitter.com/bryanberger">{{HTML::image('assets/imgs/twitter.png')}}</a></li>
					<li><a href="http://facebook.com/bryanbergerdesign">{{HTML::image('assets/imgs/facebook.png')}}</a></li>
					<li><a href="http://behance.net/bryanberger">{{HTML::image('assets/imgs/behance.png')}}</a></li>
				</ul>
			</header>

			@yield('content')

		</main>

		<footer>
			<span>&copy;</span>
			<script type="text/javascript">
				document.write(new Date().getFullYear());
			</script>
			<a href="http://bryanberger.com">Bryan Berger</a>, <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/deed.en_US">Creative Commons BY-NC-ND 4.0</a>. Project inspired by @justinmaller
		</footer>

		<!-- Google Analytics -->
		<script>
			(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
			function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
			e=o.createElement(i);r=o.getElementsByTagName(i)[0];
			e.src='//www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
			ga('create','UA-640481-18');ga('send','pageview');
		</script>

		<!-- custom js -->
		{{ HTML::script('assets/js/freeflow.me.min.js'); }}
	</body>
</html>