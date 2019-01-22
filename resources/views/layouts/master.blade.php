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
        <link rel="shortcut icon" href="/images/favi/rubix.png">
        <link rel="manifest" href="{{url('/manifest.json')}}">
        <link href="/css/loaderone.css" type="text/css" rel="stylesheet">

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
        <script>
            if ('serviceWorker' in navigator ) {
              window.addEventListener('load', function() {
                  navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
                      // Registration was successful
                      console.log('ServiceWorker registration successful with scope: ', registration.scope);
                  }, function(err) {
                      // registration failed :(
                      console.log('ServiceWorker registration failed: ', err);
                  });
              });
          }
          </script>
	</head>
	<body>
	    <div id="root">
	        <router-view>
                    <h1 style="color:white; position:absolute;  top: 30%; left: 40%; font-style:italic; font-weight:bolder; font:larger;">Rubix</h1>
                    <div class="spinner">
                            <div class="blob top"></div>
                            <div class="blob bottom"></div>
                            <div class="blob left"></div>
                            <div class="blob move-blob"></div>
                          </div>
            </router-view>
	    </div>
        <script src="/js/app.js"></script>

	</body>
</html>
