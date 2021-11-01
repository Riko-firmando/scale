<?php

namespace App\Models;

use CodeIgniter\Model;

class addressModel extends Model
{
    protected $table      = 'user_address';
    // protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'nama', 'alamat', 'provinsi_id', 'provinsi', 'kota_id', 'kota', 'pos', 'phone'];

    public function getAddress($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
