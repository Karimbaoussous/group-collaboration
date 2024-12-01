

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn</title>


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url('css/global.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/signInView.css'); ?>">

</head>
<body>


    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>


    <?= validation_list_errors(); ?> <!-- show form error-->

    <form name="signUpForm" method="POST" action="/signUp/validation"
        class="form" onsubmit="return checkPassword()" 
    >
        
        <?= csrf_field() ?> <!-- helps protect against some common attacks -->

        <h3>Sign up</h3>

        
        <div class="row">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
        </div>

        <div class="row">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>

        <div class="row">
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>

        <div class="row">
            <label for="cPassword">Confirm Password:</label>
            <input type="password" name="cPassword" required>
        </div>
    
        <button>Sign up</button>

        <div class="social">
            
            <?= view("Global/GoogleBtnGlass", array(
                    "href"=>'googleLogin/',
                    "tittle"=> 'Google'
                ));
            ?>
        
            <?= view("Global/GoogleBtnGlass", array(
                    "href"=>'login/',
                    "tittle"=> 'Login'
                ));
            ?>
                
        </div>


    </form>


    <script >
       
        function checkPassword(){

            let p1 =  document.signUpForm.password.value;
            let p2 = document.signUpForm.cPassword.value;

            const IS_VALID = p1 === p2;
            // console.log(IS_VALID, p1, p2)
            if(!IS_VALID) alert("incorrect password")
            
            return IS_VALID;

        } 

    </script>


</body>
</html>
