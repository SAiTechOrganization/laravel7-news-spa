<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel News - </title>

    <!-- Styles -->
    <!-- NOTE: change mix() to asset() -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <header-component></header-component>

    <!-- <router-view></router-view> -->
</div>
<!-- Scripts -->
<!-- NOTE: change mix() to asset() -->
<script src="{{ asset('/js/app.js') }}" defer></script>
</body>
</html>
