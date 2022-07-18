<!doctype html>
<html lang="en">
<head>
  <title>Email</title>
  <style >

    body, html {
      background-color: #FFFFFF;
    }
    .container {
      margin:0 auto;
      max-width: 800px;
      padding:15px;
      background-color: #FFFFFF;
    }
    .logo {
      margin:0 auto;
      width:250px;
      text-align: center;
    }
    .product {
      float:left;
      width:50%;
    }
    .title {
      margin-top:15px;
      padding:0 10px;
      height:90px;
      font-size: 1.2em;
      text-align: center;

    }
    .price {
      margin-top:15px;
      min-height:60px;
      font-size: 1.2em;
      font-weight: bold;
      color: red;
    }
    hr {
      color: #dedede;
      margin:15px;
    }
    .text-center {
      text-align: center;
    }
    a {
      border:none;
    }
    .btn {
      text-align: center;
      margin:0 auto;
      background-color: black;
      padding:8px 12px;

    }
    .btn a {
      font-size: 1.2em;
      display: block;
      color: white;
      text-decoration: none;
    }
  </style>

</head>
<body>

<div class="container">
  <div class="container" style="padding:15px;">
    <div class="logo" style="text-align: center">
      <a href="{{ url('/') }}"><img src="{{ url('/storage/images/logo.png') }}" width="250" alt="{{ getenv('APP_NAME') }}" style="margin:0 auto;" /></a>

    </div>
      <hr style="width:100%;margin:15px 0;">
    <div style="padding: 15px;">
      @yield('content')
    </div>
  </div>
</div>

</body>
</html>
