
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=isset($title)? $title: "Password reset"?></title>
    
    <link rel="stylesheet" href="<?php echo base_url('css/global.css'); ?>">

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


        .inputs{
            display: flex;
            gap: var(--gap-w);
            user-select: none;
            align-items: center;
            justify-content: center;
        }


        form input{

            border: 1px var(--gray) solid;
            width: 25px;
            height: 25px;
            text-align: center;

        }


        .inputs input:focus{

            border: 1px var(--blue-2) solid;
            outline: none;

        }

        form .redirect{
            cursor: pointer;
        }


    </style>



</head>
<body>

    <?= validation_list_errors(); ?> <!-- show form error-->

    <form method="POST" action="<?= esc(data: $action) ?>">

        <?= csrf_field() ?> <!-- helps protect against some common attacks -->

            
        <?= 
            view("Global/IconBtn", 
                array(
                    "src"=> base_url(relativePath: "icons/forgotPassword/mail.png"),
                    "style" => "
                        padding: var(--padding-w);
                        border-radius: var(--padding-w);
                        border: 1px var(--black-200) solid;
                        margin-bottom: var(--margin-w);
                    ",
                   
                )
            )
        ?>

        <div class="title"><?=isset($title)? $title: "Password reset"?></div>

        <div class="text">We sent a code to <strong><?=esc($email)?></strong>.</div>

        <div class="sub">

            <div class="inputs">
                <input type="text" name="number1">
                <input type="text" name="number2">
                <input type="text" name="number3">
                <input type="text" name="number4">
            </div>

            <button>Confirm</button>
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
        view("Global/progressBar", 
            isset($progressBarData)? $progressBarData: array(
                "max" => 3,
                "currently" => 2,
                "color0" => "var(--gray)",
                "color1" => "var(--blue)"
            )
        );
    ?>

    <script>

        const inputs = document.querySelectorAll(".inputs input");

        inputs.forEach((input, index) => {
            input.addEventListener("input", (event) => {
                // Allow only one digit
                input.value = input.value.replace(/[^0-9]/g, "").slice(0, 1);

                // Move to the next input if it's not the last one
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener("keydown", (event) => {
                // Allow backspace to move to the previous input
                if (event.key === "Backspace" && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

    </script>

</body>
</html>
