<?php

namespace App\Models;

use CodeIgniter\Model;

class JoinGroupModel extends Model
{
    protected $table = 'joinGroup'; // Table for user-group memberships
    protected $primaryKey = ['grp', 'user']; // Composite primary key (grp, user)
    protected $useAutoIncrement = false; // No auto-increment for this table

    protected $allowedFields = ['grp', 'user', 'date'];

    // Method to add a user to a group
    public function joinGroup($groupId, $userId)
    {
        $data = [
            'grp'  => $groupId,
            'user' => $userId,
            'date' => date('Y-m-d H:i:s'), // Add current timestamp
        ];

        return $this->insert($data); // Insert the user-group relationship
    }
}
