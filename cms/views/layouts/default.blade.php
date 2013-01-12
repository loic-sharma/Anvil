<!doctype html>
<html>

<head>
<title>Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<link rel="stylesheet" href="https://app.divshot.com/css/divshot-util.css">
<link rel="stylesheet" href="https://app.divshot.com/themes/slate/bootstrap.min.css">
<link rel="stylesheet" href="https://app.divshot.com/css/bootstrap-responsive.css">
<script src="https://app.divshot.com/js/jquery.min.js"></script>
</head>

	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="{{ $url->base() }}">{{ $page->title }}</a>
			
					<div class="navbar-content">
						<ul class="nav">
							<li class="active"><a href="#">Home</a></li>
							<li><a href="#">About</a></li>
							<li><a href="{{ $url->to('users/logout') }}">Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="#">Admin</a>
					<span class="divider">/</span>
				</li>
				<li class="active">Home</li>
			</ul>
			
			<div class="alert">
				<span>
					<b>Warning!</b>Alerts may warn users of impending danger.
				</span>
			</div>
		</div>
	</body>
</html>