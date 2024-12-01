



<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Glassmorphism login Form Tutorial in html css</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
 
    <link rel="stylesheet" href="<?php echo base_url(relativePath: 'css/LoginCSS.css'); ?>">

</head>
<body>

    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <?= validation_list_errors() ?> <!-- show form error-->

    <form method="POST" action="/login/validation" class="form" name="loginForm">

        <?= csrf_field() ?> <!-- helps protect against some common attacks -->

        <h3>Login</h3>

        <div class="row">
            <label for="email">Email</label>
            <input type="text" name='email' placeholder="Email" value="kzcode47k@gmail.com">
        </div>

        <div class="row">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" value="kzcode47k@gmail.com">
        </div>


        <div class="lastRow">
            <a href="/forgot/">Forgot password?</a>
        </div>

        <button>Log In</button>

        <div class="social">
            
            <?= view("Global/GoogleBtnGlass", array(
                    "href"=>'googleLogin/',
                    "tittle"=> 'Google'
                ));
            ?>
           
            <?= view("Global/GoogleBtnGlass", array(
                    "href"=>'signUp/',
                    "tittle"=> 'Sign up'
                ));
            ?>
                
        </div>

        
      
    </form>

   
</body>
</html>

