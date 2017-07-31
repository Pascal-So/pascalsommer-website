<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<meta name="description" content="My personal Blog about Photography">
	<meta name="keywords" content="Pascal Sommer,Photography,Photos">
	<meta name="author" content="Pascal Sommer">

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@SommerPascal">
	<meta name="twitter:creator" content="@SommerPascal">
	<meta name="twitter:title" content="@yield('title', 'Pascal Sommer Photography')">
	<meta name="twitter:description" content="My personal Photography Blog. Mostly landscapes, animals and people, sometimes even portrait photography.">
	<meta name="twitter:image" content="@yield('twitter_image', 'http://pascalsommer.ch/photography/img/PascalSommerLondon.jpg')">


	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

	<title>
		@yield('title', 'Pascal Sommer Photography')
	</title>
</head>
<body>

@yield('content')

</body>
</html>