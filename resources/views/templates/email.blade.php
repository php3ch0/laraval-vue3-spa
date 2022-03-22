<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!-- NAME: 1 COLUMN - FULL WIDTH -->
    <!--[if gte mso 15]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700|Asap:400,500,700" rel="stylesheet">
    <style type="text/css">

            body {
                margin:0px;
                padding:0px;
            }

            h1 {
                font-family: 'Amatic SC', sans-serif !important;
                margin-bottom: 30px;
                color: #ff0000;
                font-size: 45px;
                font-style: normal;
                font-weight: bold;
                line-height: 100%;
                letter-spacing: -1px;
                text-align: center;
            }

            p {
                color: #425463;
                font-family: 'Asap', sans-serif !important;
                font-weight: 300 !important;
                font-size: 14px;
                line-height: 150%;
                text-align: center;
            }

            small {
                font-family: 'Asap', sans-serif !important;
                font-weight: 300 !important;
                color: #b9c2c7;
                font-size: 12px;
                line-height: 150%;
                text-align: center;
            }
      @yield('style')
     </style>
</head>
<body>

    <table width="100%" border="0" cellpadding="0">
        <tr>
            <td align="center">
                <a href="http://trade.printjunction.co.uk">
                    <img align="center" src="https://trade.printjunction.co.uk/storage/images/logo.jpg" style="width: 275px; height: auto; margin: 25px 0px 20px;" width="275">
                </a>
            </td>
        </tr>
        <tr>
            <td align="center">
                <div style="padding: 10px">
                    @yield('content')
                </div>

            </td>
        </tr>
        <tr>
            <td align="center" style="background-color: #425463; padding:20px;">
                <a href="http://print-junction.co.uk"><img alt="Powered by Print | Junction" src="https://xmas4schools.co.uk/storage/images/poweredby.png" width="225"></a>
                <p><small>© Print Junction Ltd.<br />
                Cobbs Wood House, Cobbs Wood Industrial Estate, Ashford, Kent, TN23 1EP</small></p>
            </td>
        </tr>
    </table>



</body>
</html>
