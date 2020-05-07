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
            <td width="100%" style="font-size:22px;display: block;margin-bottom:30px;">Un nouveau projet a été posté, celui-ci est en relation avec vos compétences !</td>
        </tr>
        <tr>
            <td width="100%" style="font-size:22px;display: block;margin-bottom:30px;">" {{ $projet->title }} "</td>
        </tr>
        <tr>
            <td width="100%" style="font-size:22px;display: block;margin-bottom:30px;"></td>
        </tr>

        <tr style="text-align:center">
            <td width="100%"><a href="http://127.0.0.1:8000/projet/{{$projet->id}}" style="padding:15px;width:150px;text-align:center;border-radius:3px;color:white;font-weight: bold;text-decoration:none;background-color:#00a8ff;font-size:20px;">Accéder au projet</a></td>
        </tr>
    </table>
</body>
</html>
