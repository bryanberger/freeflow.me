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

	<link rel="shortcut icon" href="https://freeflow.me/favicon.ico">

	<script>
		(function(b, o, i, l, e, r) {
			b.GoogleAnalyticsObject = l;
			b[l] || (b[l] =
				function() {
					(b[l].q = b[l].q || []).push(arguments)
				});
			b[l].l = +new Date;
			e = o.createElement(i);
			r = o.getElementsByTagName(i)[0];
			e.src = '//www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e, r)
		}(window, document, 'script', 'ga'));
		ga('create', 'UA-640481-18');
		ga('send', 'pageview');
	</script>

	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	{{ HTML::style('assets/css/styles.min.css'); }}
	<!--[if lt IE 9]>
			<script src="https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
			<script src="https://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
		<![endif]-->
</head>

<body>
	<!--[if lt IE 8]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
	<main role="main" class="container">

		<header>
			<h1>
				<a class="logo" href="/@if(isset($meta->pageNumUri)){{ $meta->pageNumUri }}@endif">
					{{HTML::image('assets/imgs/logo.svg', 'One Art Piece Daily for a full year. A project from Bryan Berger')}}</a>One flow daily. A project from <a href="https://bryanberger.com">Bryan Berger</a></h1>
			<ul class="social">
				<li><a href="https://twitter.com/bryanberger">{{HTML::image('assets/imgs/twitter.png')}}</a></li>
				<li><a href="https://facebook.com/bryanbergerdesign">{{HTML::image('assets/imgs/facebook.png')}}</a></li>
				<li><a href="https://behance.net/bryanberger">{{HTML::image('assets/imgs/behance.png')}}</a></li>

				<li class="cart">
					<a class="cart-link" href="/buy/cart">
						<span class="cart-text sprite icnCart"></span>
						@if ($cart_count == 0)
						<span class="cart-quantity" style="display:none;">{{ $cart_count }}</span>
						@else
						<span class="cart-quantity">{{ $cart_count }}</span>
						@endif
					</a>
				</li>
			</ul>
		</header>

		<!-- will be used to show any messages -->
		@if (Session::has('message'))
		<div class="alert alert-error">{{ Session::get('message') }}</div>
		@endif

		@yield('content')

		<section class="signup">
			<!-- Begin MailChimp Signup Form -->
			<form action="//bryanberger.us8.list-manage.com/subscribe/post?u=44edf3fa66250f750de0d061c&amp;id=fcae190381" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<h3>Subscribe for <i>free</i> stuff.</h3>
				<div class="mc-field-group">
					<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email Address">
					<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="subscribe">
				</div>
				<div id="mce-responses" class="clear">
					<div class="response" id="mce-error-response" style="display:none"></div>
					<div class="response" id="mce-success-response" style="display:none"></div>
				</div> <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				<div style="position: absolute; left: -5000px;"><input type="text" name="b_44edf3fa66250f750de0d061c_fcae190381" tabindex="-1" value=""></div>

			</form>
			<!--End mc_embed_signup-->
		</section>
	</main>

	<footer>
		<span>&copy;</span>
		<script type="text/javascript">
			document.write(new Date().getFullYear());
		</script>
		<a href="https://bryanberger.com">Bryan Berger</a>, All Rights Reserved. Verify at bryan@bryanberger.com
	</footer>

	<!-- custom js -->
	{{ HTML::script('assets/js/freeflow.me.min.js'); }}
</body>

</html>
