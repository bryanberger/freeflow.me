<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Freeflow.me - admin</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="shortcut icon" href="http://freeflow.me/favicon.ico">
		{{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css'); }}
		{{ HTML::style('assets/css/admin.min.css'); }}
	</head>
	<body>	
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="{{ URL::to('admin') }}">Freeflow Admin Panel</a>
				</div>
				<div class="navbar-collapse collapse">
				  <ul class="nav navbar-nav">
					<li><a href="{{ URL::to('admin') }}">Home</a></li>
					<li><a href="{{ URL::to('admin/create') }}">Create a Post</a>
				  </ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>

		<div class="container">
			@yield('content');
		</div>
	</body>
</html>
