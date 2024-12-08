<?php

namespace App\Models;

use CodeIgniter\Model;

class panelModel extends Model
{
    protected $table = 'grp';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'image', 'isPublic'];
    
    // Method to get groups with search and pagination
    public function getGroups($searchQuery = null, $limit = 10, $offset = 0)
    {
        if ($searchQuery) {
            return $this->like('title', $searchQuery)
                        ->orLike('description', $searchQuery)
                        ->limit($limit, $offset)
                        ->findAll();
        }
        return $this->limit($limit, $offset)->findAll();
    }

    // Method to count total groups with optional search filter
    public function countGroups($searchQuery = null)
    {
        if ($searchQuery) {
            return $this->like('title', $searchQuery)
                        ->orLike('description', $searchQuery)
                        ->countAllResults();
        }
        return $this->countAllResults();
    }
}
