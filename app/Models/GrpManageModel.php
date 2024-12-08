<?php

namespace App\Models;

use CodeIgniter\Model;

class GrpManageModel extends Model
{
    protected $table = 'grp'; // Table name
    protected $primaryKey = 'id'; // Primary key column

    // Specify the fields that are allowed for mass assignment
    protected $allowedFields = ['title', 'description', 'isPublic', 'image', 'creation'];

    // Disable timestamps since your table has "creation" instead of "created_at"
    protected $useTimestamps = false;

    // Ensure soft deletes are disabled as "deleted_at" is not in your table
    protected $useSoftDeletes = false;

    // Optional: You can enable custom timestamp handling manually if needed
    // Specify custom fields for creation and update times (if you later add these)
    // protected $createdField = 'creation';
    // protected $updatedField = 'updated_at';
}
