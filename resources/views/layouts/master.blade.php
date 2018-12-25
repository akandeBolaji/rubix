<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <!-- Tell the browser to be responsive to screen width -->
	    <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
	    <meta name="author" content="">
	    <title>Rubix</title>
	    <meta name="csrf-token" content="{{ csrf_token() }}" />
    	<link rel="shortcut icon" href="/images/favi/pb.png">

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <link href="/css/style.css" rel="stylesheet">
            <link href="framework7/css/framework7.css" rel="stylesheet">
            <link href="framework7-icons" rel="stylesheet">
		    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

           {{-- checks for service worker support.if you have the push manager package then use this line
        if ('serviceWorker' in navigator && 'PushManager' in window) instead of
        if ('serviceWorker' in navigator ) --}}
	</head>
	<body>
	    <div id="root">
	        <router-view></router-view>
	    </div>
        <script src="/js/app.js"></script>

	</body>
</html>
