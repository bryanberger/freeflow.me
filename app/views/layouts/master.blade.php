<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Freeflow.me - 1 flow daily</title>
		<meta name="description" content="1 piece of art daily by Designer &amp; Developer Bryan Berger">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<meta property="og:title" content="Freeflow.me - 1 flow daily. A Project by Bryan Berger" />
		<meta property="og:type" content="article" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:url" content="http://freeflow.me" />
		<meta property="og:image" content="https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/stormtrooper_560.jpg" />
		<meta property="og:description" content="1 flow daily. I will be creating 1 piece a day for as long as possible! I call these freeflows as they are simply freeflow thoughts brought to life." />
		<meta property="og:site_name" content="Freeflow.me - 1 flow daily" />

		<!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->
		<link rel="shortcut icon" href="http://freeflow.me/favicon.ico">
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
				<h1>1 flow daily. A project by Bryan Berger</h1>
				<ul class="social">
					<li><a href="http://twitter.com/bryanberger">{{HTML::image('assets/imgs/twitter.png')}}</a></li>
					<li><a href="http://facebook.com/bryanbergerdesign">{{HTML::image('assets/imgs/facebook.png')}}</a></li>
					<li><a href="http://behance.net/bryanberger">{{HTML::image('assets/imgs/behance.png')}}</a></li>
				</ul>
			</header>

			@yield('content')

		</main>

		<footer>
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
	</body>
</html>