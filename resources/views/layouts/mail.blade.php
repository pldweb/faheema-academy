<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; }
        .header { background-color: #f0bc74; color: white; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; color: #333; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #f21124; color: white !important; text-decoration: none; border-radius: 5px; margin-top: 10px;}
        .background { background-color: #f1f1f1 !important; padding: 20px 0;}
    </style>
</head>
<body class="background">
    @yield('content')
</body>
</html>
