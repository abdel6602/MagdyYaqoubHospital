<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tester</title>
    <style>
        .seperator {
            margin-top: 40px;
        }

        form{
            border: 1px solid black;
        }
    </style>
</head>
<body>
<div class="seperator"></div>
<form action="http://localhost/magdyyaqoubhospital/Controllar/Authentication/AuthenticationController.php" method="GET">
    <input type="hidden" name="LOGIN" value="1">
    <button type="submit">Testing Login</button>
</form>

</body>
</html>