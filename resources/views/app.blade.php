<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ config('app.title') }}</title>
		<link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
		
		@yield('content')

		<script src="/js/app.js"></script>
    </body>
</html>
