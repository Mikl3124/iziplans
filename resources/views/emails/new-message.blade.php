<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body style="font-family: 'Roboto', sans-serif;color:#353b48;">
    <table with="100%" style="max-width:650px;display:block;margin:auto;">
        <tr>
          <td>

          </td>
        </tr>
        <tr style="text-align:center">
            <td width="100%">
                <img style="height:50px" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png" alt="logo iziplans">
            </td>
        </tr>
        <tr>
          <td width="100%" style="font-size:22px;display: block;margin-bottom:30px;">Bonjour {{ $user->firstname }}</td>
        </tr>
        <tr>
            <td width="100%" style="font-size:22px;display: block;margin-bottom:30px;">Vous avez reçu un nouveau message sur iziplans!</td>
        </tr>
        <tr>
            <td width="100%" style="font-size:22px;display: block;margin-bottom:30px;"></td>
        </tr>
        <tr>
            <td width="100%" style="font-size:22px;display: block;margin-bottom:30px;"></td>
        </tr>

        <tr style="text-align:center">
            <td width="100%"><a href="https://iziplans.com/" style="padding:15px;width:150px;text-align:center;border-radius:10px;color:white;font-weight: bold;text-decoration:none;background-color:#0072ff;font-size:20px;">Lire le message</a></td>
        </tr>
    </table>
</body>
</html>
