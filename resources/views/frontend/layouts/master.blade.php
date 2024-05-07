<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	@include('frontend.layouts.head')
</head>
<body class="js">
    <link rel="icon" type="image/png" href="/images/trial3.png">
	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->

	@include('frontend.layouts.notification')
	<!-- Header -->
	@include('frontend.layouts.header')
	<!--/ End Header -->
	@yield('main-content')

	@include('frontend.layouts.footer')
    <script>
        // JavaScript code to change the favicon
        window.addEventListener('load', () => {
          const favicon = document.getElementById('favicon');
          favicon.href = '/images/new-favicon.png'; // Change this to the new favicon URL
        });
        </script>
</body>
</html>
