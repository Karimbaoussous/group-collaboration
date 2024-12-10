



<!DOCTYPE html>
<html lang="en">
<head>

    <title>Forgot Password</title>

    <link rel="stylesheet" href="<?php echo base_url('css/global.css'); ?>">

    <style>

        body, head, html{
            width: 100%;
            height: 100%;
       
        }

        body{

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--black);
            color: var(--white);

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


    <?= validation_list_errors() ?> <!-- show form error-->

    <form method="POST" action="/forgot/validation" class="form">

        <?= csrf_field() ?> <!-- helps protect against some common attacks -->

        <?= 
            view("Global/IconBtn", 
                array(
                    "src"=> base_url(relativePath: "icons/forgotPassword/fingerprint.png"),
                    "style" => "
                        padding: var(--padding-w);
                        border-radius: var(--padding-w);
                        border: 1px var(--black-200) solid;
                        margin-bottom: var(--margin-w);
                    ",
                   
                )
            )
        ?>

        <div class="title">Forgot password?</div>

        <div class="text">No worries, we'll send you reset instructions.</div>

        <div class="sub">

            <label for="email">Email</label> 
            <input 
                type="text" name='email' placeholder="Email"
            >

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
            "currently" => 1,
            "color0" => "var(--gray)",
            "color1" => "var(--blue)"
        ));
    ?>

   

   
</body>
</html>

