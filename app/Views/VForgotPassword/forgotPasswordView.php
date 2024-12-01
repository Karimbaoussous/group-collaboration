



<!DOCTYPE html>
<html lang="en">
<head>

     <!-- Design by foolishdeveloper.com -->
    <title>Forgot Password</title>
 
    <link rel="stylesheet" href="<?php echo base_url('css/login.css'); ?>">


</head>
<body>


    <?= validation_list_errors() ?> <!-- show form error-->

    <form method="POST" action="/forgot/validation" class="form">

        <?= csrf_field() ?> <!-- helps protect against some common attacks -->

        <label for="email">Email</label> 
        <input 
            type="text" name='email' placeholder="Email"
        >

        <br><br>

        <input type="submit" value="Send Code">
        
      
    </form>

   
</body>
</html>

