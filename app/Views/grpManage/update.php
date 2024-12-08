<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Group</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            margin-top: 5px;
        }
        .form-group input[type="file"] {
            padding: 5px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: block;
            width: 100%;
            text-align: center;
            font-size: 16px;
            cursor:pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
        .back-button {
            background-color: #ccc;
            color: black;
            text-align: center;
            padding: 10px 20px;
            margin-top: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #bbb;
        }
        #image{
            cursor:pointer;
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
        <h1>Update Group</h1>
        <form action="<?= site_url('grpManage/updateSave/' . $group['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="title">Group Title</label>
                <input type="text" name="title" id="title" value="<?= esc($group['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Group Description</label>
                <textarea name="description" id="description" required><?= esc($group['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="isPublic">Is Public</label>
                <select name="isPublic" id="isPublic" required>
                    <option value="1" <?= $group['isPublic'] == 1 ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= $group['isPublic'] == 0 ? 'selected' : '' ?>>No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Group Image</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <button type="submit" class="button">Update Group</button>
            <a href="<?= site_url('grpManage') ?>" class="back-button">Back to Group List</a>
        </form>
    </div>
</body>
</html>
