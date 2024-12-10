

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>

    <link rel="stylesheet" href="<?php echo base_url('css/global.css'); ?>">

    <style>

        body, head, html{

            width: 100%;
            height: 100%;
            color: var(--white);
            background: var(--black);

        }

        body{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        form{

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: var(--gap-w)

        }

        form .title{

            font-size: x-large;
            font-weight: bold;

        }


        form label{
            font-weight: bold;
        }

        form *{
        
            border-radius: var(--padding-w);
        
        }

        form input, form button{
            padding: var(--padding-w);

        }

        form input{
            border: 1px var(--gray) solid;
        }

        form button{

            background-color: var(--blue);
            color: var(--black);
            border: 0;
            cursor: pointer;

        }


        form .sub {

            width: 100%;

            display: grid;
            gap: var(--gap-w);

        }

        
        form .sub, form .redirect, form button{
            margin-top: var(--margin-w); 
        }


        form .redirect{
            cursor: pointer;
        }

    </style>


</head>
<body>

    <?= validation_list_errors(); ?> <!-- show form error-->

    <form action="/forgot/change" method="POST" name="changePasswordForm"
        onsubmit="return checkPassword()"
    >

        <?= csrf_field() ?> <!-- helps protect against some common attacks -->

        <?= 
            view("Global/IconBtn", 
                array(
                    "src"=> base_url(relativePath: "icons/forgotPassword/password.png"),
                    "style" => "
                        padding: var(--padding-w);
                        border-radius: var(--padding-w);
                        border: 1px var(--black-200) solid;
                        margin-bottom: var(--margin-w);
                    ",
                   
                )
            )
        ?>

        <div class="title">Set new password</div>

        <div class="text">Must be at least 8 character long.</div>

        <div class="sub">

            <label for="newPassword"> Password </label>

            <input type="password" name="newPassword" required>
           
            <label for="CNewPassword"> Confirm Password </label>

            <input type="password" name="CNewPassword" required>
          
            <button>Reset password</button>

        </div>
       

        <?= 
            view("Global/IconBtn", 
                array(
                    "src"=> base_url("icons/leftArrowWhite.png"),
                    "text" => "Back to log in",
                    "style" => "display: flex; gap: var(--gap-w);",
                    "size" => "3dvh",
                    "class" => "redirect" ,
                    "redirect" => "login"
                )
            )
        ?>

    </form>


    <?= 
        view("Global/progressBar", array(
            "max" => 3,
            "currently" => 3,
            "color0" => "var(--gray)",
            "color1" => "var(--blue)"
        ));
    ?>

  
    <script src="<?= base_url("js/ChangePasswordView.js")?>"></script>

    
</body>
</html>