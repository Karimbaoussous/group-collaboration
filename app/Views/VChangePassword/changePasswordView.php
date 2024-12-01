

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
</head>
<body>

    <?= validation_list_errors(); ?> <!-- show form error-->

    <form action="/forgot/change" method="POST" name="changePasswordForm">

        <?= csrf_field() ?> <!-- helps protect against some common attacks -->

        <label for="newPassword"> new Password </label>
        <input type="password" name="newPassword">
        <br>
        <label for="CNewPassword"> Confirm Password </label>
        <input type="password" name="CNewPassword">
        <br>
        <input type="submit">

    </form>

  
    <script>
       

        function checkPassword(){

            let p1 = document.changePasswordForm.newPassword.value;
            let p2 = document.changePasswordForm.CNewPassword.value;
            
            const IS_VALID = p1 === p2;
            // console.log(IS_VALID, p1, p2)
            if(!IS_VALID) alert("incorrect password")

            return IS_VALID;

        } 

    </script>

    
</body>
</html>