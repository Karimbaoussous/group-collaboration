<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\JoinGroupModel;
use App\Models\panelModel;

class GrpsPanel extends BaseController
{
    public function index()
    {
        // Get the current page number from the URL, defaulting to 1 if not provided
        $page = $this->request->getGet('page') ?? 1;
        
        // Define the number of groups to display per page
        $groupsPerPage = 3;

        // Calculate the offset based on the current page
        $offset = ($page - 1) * $groupsPerPage;

        // Get the search query from the URL (if any)
        $searchQuery = $this->request->getGet('search');

        // Load the GroupModel and JoinGroupModel
        $groupModel = new panelModel();
        $joinGroupModel = new JoinGroupModel();

        // Fetch groups based on search query and paginate results
        if ($searchQuery) {
            $data['groups'] = $groupModel->like('title', $searchQuery)
                                         ->orLike('description', $searchQuery)
                                         ->limit($groupsPerPage, $offset)
                                         ->findAll();
        } else {
            // No search query, just fetch paginated groups
            $data['groups'] = $groupModel->limit($groupsPerPage, $offset)
                                         ->findAll();
        }

        // Calculate the total number of groups for pagination (with search filter if needed)
        $totalGroups = $groupModel->countGroups($searchQuery);

        // Calculate the total number of pages
        $totalPages = ceil($totalGroups / $groupsPerPage);

        // Pass necessary data to the view
        $data['searchQuery'] = $searchQuery;
        $data['totalPages'] = $totalPages;
        $data['currentPage'] = $page;

        // Get the user ID from session to check group membership
        $data['userId'] = session()->get('userId');

        // Load the view
        return view('grpsPanel', $data);
    }

    public function joinGroup($groupId)
    {
        $userId = session()->get('userId');
        
        if (!$userId) {
            return redirect()->to('/login'); // Redirect to login page if user is not logged in
        }

        $joinGroupModel = new JoinGroupModel();
        $groupModel = new panelModel();

        // Check if the group exists
        $group = $groupModel->find($groupId);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Group not found');
        }

        // Check if the user is already a member
        $isMember = $joinGroupModel->where('user', $userId)->where('grp', $groupId)->first();
        if ($isMember) {
            return redirect()->to('/grpsPanel')->with('message', 'You are already a member of this group.');
        }

        // Add the user to the group
        $joinGroupModel->joinGroup($groupId, $userId);

        return redirect()->to('/grpsPanel')->with('message', 'You have successfully joined the group.');
    }

    public function privacyPolicy()
    {
        // Load the Privacy Policy page view
        return view('privacyPolicy');
    }

    public function termsOfService()
    {
        // Load the Terms of Service page view
        return view('termsOfService');
    }
}
