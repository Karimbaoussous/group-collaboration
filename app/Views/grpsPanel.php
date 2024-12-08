<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Collaboration Platform</title>
    <style>
        /* Previous Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        h2 {
            color: #333;
            margin-top: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            flex: 1;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            display: inline-block;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .search-bar {
            width: 100%;
            padding: 10px;
            margin: 20px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .search-form {
            display: flex;
            justify-content: center;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin: 0 5px;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #45a049;
        }
        .pagination a.active {
            background-color: #45a049;
        }

        /* Footer Styles */
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 20px;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to the Group Collaboration Platform</h1>
</header>

<div class="container">

    <!-- Search Form -->
    <h2>Search Groups</h2>
    <form method="get" action="<?= site_url('panel'); ?>" class="search-form">
        <input type="text" name="search" class="search-bar" placeholder="Search for groups..." value="<?= isset($searchQuery) ? esc($searchQuery) : ''; ?>">
        <button type="submit" class="btn">Search</button>
    </form>

    <!-- Available Groups -->
    <h2>Available Groups</h2>
    <table>
        <thead>
            <tr>
                <th>Group Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= esc($group['title']) ?></td>
                    <td><?= esc($group['description']) ?></td>
                    <td><img src="<?= esc($group['image']) ?>" alt="Group Image" style="width: 50px; height: 50px;"></td>
                    <td><?= esc($group['isPublic'] ? 'Public' : 'Private') ?></td>
                    <td>
                        <?php
                        $isMember = false;
                        if (isset($userId)) {
                            // Check if the user is already a member
                            $isMember = (new \App\Models\JoinGroupModel())->where('user', $userId)->where('grp', $group['id'])->first();
                        }
                        ?>
                        <?php if (!$isMember): ?>
                            <a href="<?= site_url('join-group/' . $group['id']); ?>" class="btn">Join Group</a>
                        <?php else: ?>
                            <span>Joined</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <!-- First and Previous Buttons -->
        <?php if ($currentPage > 1): ?>
            <a href="<?= site_url('panel?page=1&search=' . esc($searchQuery)) ?>">First</a>
            <a href="<?= site_url('panel?page=' . ($currentPage - 1) . '&search=' . esc($searchQuery)) ?>">Prev</a>
        <?php endif; ?>

        <!-- Page Number Links -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= site_url('panel?page=' . $i . '&search=' . esc($searchQuery)) ?>" class="<?= ($i == $currentPage) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <!-- Next and Last Buttons -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="<?= site_url('panel?page=' . ($currentPage + 1) . '&search=' . esc($searchQuery)) ?>">Next</a>
            <a href="<?= site_url('panel?page=' . $totalPages . '&search=' . esc($searchQuery)) ?>">Last</a>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Group Collaboration Platform | <a href="<?= site_url('privacyPolicy'); ?>">Privacy Policy</a> | <a href="<?= site_url('termsOfService'); ?>">Terms of Service</a></p>
</footer>

</body>
</html>
