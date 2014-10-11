<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>X-press Card Address Request</title>
    <style type="text/css">

      body {
        padding     : 25px 0;
        font-family : Helvetica;
      }

    </style>
  </head>
  <body>
    <h1>Postcard Address Request</h1>
    <p>Hi</p>
    <p>{{Auth::User()->first}} would like you to share your address so a special postcard can be sent to you! Please click on the link below:</p>
    <p>{{URL::to('address-request-form')}}/{{$data['code']}}/*|EMAIL|*</p>
    <p>Best,</p>
    <p>The X-Press Cards Team</p>
    <a href="google.com"></a>
  </body>
</html>