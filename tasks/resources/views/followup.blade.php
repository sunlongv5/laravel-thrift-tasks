<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRM客户管理后台 | {{$title}}</title>
  <script>document.domain="{{ Config::get('website.domain') }}";</script>

  @include('details.css')
  @include('followup.js')
</head>

<body class="body-small" style="min-width:1024px;">
  <div id="wrapper">
    <!-- layouts.navigation -->
    
    @include('layouts.navigation')

    @include('followup.content')
  </div>
</body>

