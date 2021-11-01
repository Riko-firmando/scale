<?php

namespace App\Models;

use CodeIgniter\Model;

class tokenModel extends Model
{
    protected $table      = 'user_token';
    // protected $useTimestamps = true;
    protected $allowedFields = ['email', 'token', 'date_created'];

    public function getToken($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
