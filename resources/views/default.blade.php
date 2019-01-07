<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AAAS IT Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

	<!-- Font Awesome -->
	<link href="{{ asset('admin/css/font-awesome.min.css') }}" rel="stylesheet">

	<!-- Pace -->
	<link href="{{ asset('admin/css/pace.css') }}" rel="stylesheet">

	<!-- Color box -->
	<link href="{{ asset('admin/css/colorbox/colorbox.css') }}" rel="stylesheet">

	<!-- Morris -->
	<link href="{{ asset('admin/css/morris.css') }}" rel="stylesheet"/>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<!-- Perfect -->
	<link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/css/app-skin.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/css/bootstrap/zebra_datepicker.min.css">
  <link href="{{ asset('admin/css/master.css') }}" rel="stylesheet">
  <!-- Developed and Designed by : Nitish Dolakasharia, nitish.dola@gmail.com, +91-9706125041 -->

  	<style>
  		.fa-heartbeat {
  			color: #F50A0A;
  		}
	</style>
  </head>

  <body class="overflow-hidden">
	<!-- Overlay Div -->
	<div id="overlay" class="transparent"></div>

	<div id="wrapper" class="preload">
		<div id="top-nav" class="fixed skin-6">
			<a href="#" class="brand">
				<span class="text-toggle"> {{ config('app.name') }}: Admin</span>
			</a><!-- /brand -->
			<button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div><!-- /top-nav-->

		<aside class="fixed skin-6">
			@include('common.sidebar_nav')
		</aside>

		<div id="main-container">
			<div id="breadcrumb">
				<ul class="breadcrumb">
					 <li><i class="fa fa-home"></i><a href="{{ route('home') }}"> Home</a></li>
					 <li class="active">Dashboard</li>
				</ul>
			</div><!-- /breadcrumb-->

			<div class="padding-md">

        @if(Session::has('message'))
        <div class="row">
           <div class="col-lg-12">
                 <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                       <button type="button" class="close" data-dismiss="alert">×</button>
                       {!! Session::get('message') !!}
                 </div>
              </div>
        </div>
        @endif

        @if ($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
        @endif

				@yield('main_content')
			</div><!-- /.padding-md -->
		</div><!-- /main-container -->
		<!-- Footer
		================================================== -->
		<footer>
			<div class="row">
				<div class="col-sm-6">
					<span class="footer-brand">
						<strong class="text-danger"></strong>AAAS Float-Claims Payment System
					</span>
					<p class="no-margin">
						Made with <i class="fa fa-heartbeat" aria-hidden="true"></i> by <strong>Nitish D.</strong>
					</p>
				</div><!-- /.col -->
			</div><!-- /.row-->
		</footer>


	<a href="#" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>

	

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

	<!-- Jquery -->
	<script src="{{ asset('admin/js/jquery-1.10.2.min.js') }}"></script>

	<!-- Bootstrap -->
    <script src="{{ asset('admin/bootstrap/js/bootstrap.js') }}"></script>

	<!-- Flot -->
	

	<!-- Morris -->
	<script src="{{ asset('admin/js/rapheal.min.js') }}"></script>
	<!-- <script src="{{ asset('admin/js/morris.min.js') }}"></script> -->

	<!-- Colorbox -->
	<script src="{{ asset('admin/js/jquery.colorbox.min.js') }}"></script>

	<!-- Sparkline -->
	<script src="{{ asset('admin/js/jquery.sparkline.min.js') }}"></script>

	<!-- Pace -->
	<script src="{{ asset('admin/js/uncompressed/pace.js') }}"></script>

	<!-- Popup Overlay -->
	<script src="{{ asset('admin/js/jquery.popupoverlay.min.js') }}"></script>

	<!-- Slimscroll -->
	<script src="{{ asset('admin/js/jquery.slimscroll.min.js') }}"></script>

	<!-- Modernizr -->
	<script src="{{ asset('admin/js/modernizr.min.js') }}"></script>

	<!-- Cookie -->
	<script src="{{ asset('admin/js/jquery.cookie.min.js') }}"></script>
	
	<!-- Perfect -->

	

	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

	<script src="{{ asset('admin/js/app/app_dashboard.js') }}"></script>
	<script src="{{ asset('admin/js/app/app.js') }}"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.12/zebra_datepicker.min.js"></script>

	<script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>

	<script>
		$( document ).ready(function() {
		    $('.datepicker').Zebra_DatePicker({
		    	direction: 0
		    });

		    $('#dataTable').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"bPaginate": false
			});
		    
		});
	</script>
	@yield('pageJs')
  </body>

</html>
