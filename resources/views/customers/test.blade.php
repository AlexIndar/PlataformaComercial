
@extends('layouts.customers.customer')

@section('title') Indar - Frontend Test @endsection

@section('assets')
<link rel="stylesheet" href="{{asset('assets/customers/css/styles.css')}}">
<link href="{{asset('assets/customers/css/app.fdbdb825e1a19ce899a31db1df1e79f7.css')}}" rel="stylesheet">
@endsection

@section('body')
<div id=app></div>
	<script type="text/javascript" src="{{asset('assets/customers/js/manifest.2ae2e69a05c33dfc65f8.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/customers/js/vendor.8aa87dd3c903ad781810.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/customers/js/app.32d416c89d5d4eaa3b32.js')}}"></script>
   
@endsection

<!-- <!DOCTYPE html>
<html>

<head>
	<meta charset=utf-8>
	<meta name=viewport content="width=device-width,initial-scale=1">
	<title>frontend_test</title>
	<link href="{{asset('assets/customers/css/app.fdbdb825e1a19ce899a31db1df1e79f7.css')}}" rel="stylesheet">
    

</head>

<body>
	
</body>

</html> -->