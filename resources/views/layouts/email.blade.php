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
      width:160px;
      text-align: center;
      border-bottom:1px solid #dedede;
    }
    .logo img {
      max-width: 160px;
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
      <a href="{{ url('/') }}"><img src="{{ url('/storage/images/logo_email.png') }}" height="90" /></a>
    </div>
    <div style="padding: 15px;">
      @yield('content')
    </div>
  </div>
</div>

</body>
</html>
