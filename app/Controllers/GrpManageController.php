<?php

namespace App\Controllers;

use App\Models\GrpManageModel;
use CodeIgniter\Controller;

class GrpManageController extends Controller
{
    public function index()
    {
        $model = new GrpManageModel();
        $data['groups'] = $model->findAll(); // Fetch all groups
        return view('grpManage/index', $data);
    }

    public function create()
    {
        // Pass error message to the view if present
        return view('grpManage/create');
    }

    public function store()
    {
        $model = new GrpManageModel();

        // Validate image file size (2MB limit)
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && $image->getSize() > 2097152) { // 2MB = 2 * 1024 * 1024
            // Set an error message and return to the create page
            return redirect()->to('/grpManage/create')->with('error', 'The image file is too large. Maximum size is 2MB.');
        }

        // Prepare data
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'isPublic' => $this->request->getPost('isPublic') ? true : false,
        ];

        // Save image as BLOB if valid
        if ($image && $image->isValid()) {
            // Store image as BLOB in database
            $data['image'] = file_get_contents($image->getTempName()); // Convert the image to binary data
        }

        $model->save($data);
        return redirect()->to('/grpManage');
    }

    public function update($id)
    {
        $model = new GrpManageModel();
        $data['group'] = $model->find($id);
        return view('grpManage/update', $data);
    }

    public function updateSave($id)
    {
        $model = new GrpManageModel();

        // Validate image file size (2MB limit)
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && $image->getSize() > 2097152) {
            return redirect()->to('/grpManage/update/'.$id)->with('error', 'The image file is too large. Maximum size is 2MB.');
        }

        // Prepare data
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'isPublic' => $this->request->getPost('isPublic') ? true : false,
        ];

        // Update data
        if ($image && $image->isValid()) {
            $data['image'] = file_get_contents($image->getTempName()); // Convert the image to binary data
        }

        $model->update($id, $data);
        return redirect()->to('/grpManage');
    }

    public function delete($id)
    {
        $model = new GrpManageModel();
        $model->delete($id);
        return redirect()->to('/grpManage');
    }

    public function showImage($id)
    {
        $model = new GrpManageModel();
        $group = $model->find($id);

        if ($group && isset($group['image'])) {
            header('Content-Type: image/jpeg');
            echo $group['image']; // Output the binary image data
            exit;
        } else {
            return redirect()->to('/assets/img/default-image.jpg'); // Default fallback image if no image is available
        }
    }
}

