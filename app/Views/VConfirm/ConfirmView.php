
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="<?php echo base_url('css/global.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/ConfirmCSS.css'); ?>">

</head>
<body>

    <h2><?= esc(data: $title) ?></h2>


    <?= validation_list_errors(); ?> <!-- show form error-->

    <form method="POST" action="<?= esc(data: $action) ?>">

        <?= csrf_field() ?> <!-- helps protect against some common attacks -->

        <table>
            <tr><th colspan="5">check your email box</th></tr>
            <tr>
                <th>code:</th>
                <td><input type="number" name="number1"></td>
                <td><input type="number" name="number2"></td>
                <td><input type="number" name="number3"></td>
                <td><input type="number" name="number4"></td>
            </tr>
        
            <tr>
                <td colspan="2"><button type="submit">Confirm</button></td>
            </tr>
        </table>
    </form>

</body>
</html>
