<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forget Password</title>
</head>
<body>
  <h1>Hello: {{ $mailData['user']->name }}</h1>

  <p>Click below to change your Password</p>

  <a href="{{route('resetpassword',$mailData['token'] )}}">Click here</a>
</body>
</html>
