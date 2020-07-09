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
        <link rel="shortcut icon" href="/images/rubix.png">
        <link rel="manifest" href="{{url('/manifest.json')}}">
        <link href="/css/loaderone.css" type="text/css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

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
                <div class="d-flex justify-content-center align-items-center" style="min-height:100vh">
                    <div class="spinner-grow" role="status">
                            <span class="sr-only">Loading...</span>
                    </div>
                    <h1><span class="text-info">Ru</span>bix</h1>
                    <div class="spinner-grow text-info" role="status">
                            <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </router-view>
	    </div>
        <script src="/js/app.js"></script>

	</body>
</html>
