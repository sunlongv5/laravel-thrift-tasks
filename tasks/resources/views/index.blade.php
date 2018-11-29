<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRM客户管理后台 | 首页</title>
  <script>document.domain="{{ Config::get('website.domain') }}";</script>

  @include('index.css')
</head>

<body class="">
  <div id="wrapper">
    <!-- layouts.navigation -->
    
    @include('layouts.navigation')
    
    <div id="page-wrapper" class="gray-bg">
        <div class="row">
        </div>
    </div>
  </div>
  
  @include('index.js')
</body>

