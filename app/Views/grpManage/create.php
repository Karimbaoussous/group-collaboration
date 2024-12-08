<!-- /app/Views/grpManage/create.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #333;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            margin-top: 10px;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
            <!-- Display Error Message -->
            <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message" style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 20px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
    <div class="container">
        <h1>Create New Group</h1>
        <form action="<?= site_url('grpManage/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="title">Group Title</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div class="form-group">
                <label for="description">Group Description</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="isPublic">Is Public</label>
                <select name="isPublic" id="isPublic" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Group Image</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <button type="submit" class="button">Create Group</button>
            <a href="<?= site_url('grpManage') ?>" class="back-button">Back to Group List</a>
        </form>
    </div>
</body>
</html>
