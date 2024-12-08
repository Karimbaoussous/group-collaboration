<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            vertical-align: middle; /* Ensures content is centered vertically */
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #45a049;
        }

        /* Ensuring action buttons stretch to fill row height */
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
            align-items: stretch; /* Makes sure buttons stretch to match row height */
        }

        /* Ensuring image cell is properly aligned and doesn't break layout */
        td img {
            width: 100px;
            height: 100px;
            object-fit: cover; /* Prevent image from stretching and distorting */
        }

        /* Removing the bottom border from action buttons' cell to fix line issue */
        td:last-child {
            border-bottom: none; /* Removes the border below the action buttons */
        }

        /* Make the table responsive */
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            .container {
                width: 95%;
            }

            .button {
                font-size: 12px;
                padding: 8px 16px;
            }

            td img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Group Management</h1>
        <a href="<?= site_url('grpManage/create') ?>" class="button">Create New Group</a>
        
        <table>
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Description</th>
                    <th>Public</th>
                    <th>Image</th> <!-- Add Image Column -->
                    <th align="center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): ?>
                    <tr>
                        <td><?= esc($group['title']) ?></td>
                        <td><?= esc($group['description']) ?></td>
                        <td><?= $group['isPublic'] ? 'Yes' : 'No' ?></td>
                        
                        <!-- Display Image -->
                        <td>
                            <?php if (!empty($group['image'])): ?>
                                <img src="<?= site_url('grpManage/image/' . $group['id']) ?>" alt="Group Image">
                            <?php else: ?>
                                <img src="/assets/img/default-image.jpg" alt="No Image">
                            <?php endif; ?>
                        </td>

                        <td class="action-buttons">
                            <a href="<?= site_url('grpManage/update/' . $group['id']) ?>" class="button">Edit</a>
                            <a href="<?= site_url('grpManage/delete/' . $group['id']) ?>" class="button" onclick="return confirm('Are you sure you want to delete this group?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
