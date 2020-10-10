<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel News SPA</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <navbar></navbar>

    <router-view></router-view>
</div>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
