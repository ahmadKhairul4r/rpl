<?php

namespace App\Controllers;

class MasterUserController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM master_user");
        $get = $query->getResultArray();
        $data = [
            'data' => $get
        ];
        return $this->render('MasterUser/master_user', $data);
    }

    public function indexAdd()
    {
        return $this->render('MasterUser/add_user');
    }

    public function add()
    {
        $data = $this->request->getVar();

        $rowid = $data['rowid'];
        $group_cd = $data['group_cd'];
        $descs = $data['descs'];
        $status = $data['status'];

        if ($rowid == 0) {
            $db = \Config\Database::connect();
            $query = $db->query("INSERT INTO master_user (group_cd, descs, status) VALUES ('$group_cd', '$descs', '$status')");

            if ($query) {
                $response = [
                    'status' => 'success',
                    'message' => 'User added successfully'
                ];
                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'User added failed'
                ];
                return $this->response->setJSON($response);
            }
        } else {
            $db = \Config\Database::connect();
            $query = $db->query("UPDATE master_user SET group_cd = '$group_cd', descs = '$descs', status = '$status' WHERE rowid = '$rowid'");

            if ($query) {
                $response = [
                    'status' => 'success',
                    'message' => 'User updated successfully'
                ];
                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'User updated failed'
                ];
            }
        }
    }

    public function getTable()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM master_user");
        $get = $query->getResultArray();
        
        $data = [
            'data' => $get
        ];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $data = $this->request->getVar();
        $rowid = $data['rowid'];

        $db = \Config\Database::connect();
        
        $query = $db->query("DELETE FROM master_user WHERE rowid = '$rowid'");

        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'User deleted successfully'
            ];
            return $this->response->setJSON($response);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'User deleted failed'
            ];
            return $this->response->setJSON($response);
        }

        return redirect()->to('/master-user');
    }

}
