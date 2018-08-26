<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>401 - Unathorized</title>
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link rel="stylesheet" href="../css/font-awesome.css">
        <style media="screen">
            body
            {
                background-color: #eee;
            }

            .container
            {
                width: 70%;
                margin: auto;
                background-color: #fff;
                padding: 30px;
            }

            .error
            {
                color: #C20903;
                border-bottom: 1px solid #C20903;
                font-family: sans-serif;
                font-size: 30px;
            }

            .message
            {
                margin-top: 30px;
                color: #C20903;
                font-size: 18px;
            }

            .link
            {
                padding: 2px 10px;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2 class="error">
                Unathorized Access
            </h2>

            <div class="message">
                You do not have permission to view this page.<br>
                Please go back and login or go to the home page.

                <br><br>

                <span class="login">
                    <a href="../login.php" class="link">
                        <i class="fa fa-user"></i>
                        Login
                    </a>
                </span>

                or

                <span>
                    <a href="../index.php" class="link">
                        <i class="fa fa-home"></i>
                        Home
                    </a>
                </span>

            </div>


        </div>
    </body>
</html>
