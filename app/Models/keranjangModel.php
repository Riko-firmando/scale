<?php

namespace App\Models;

use CodeIgniter\Model;

class keranjangModel extends Model
{
    protected $table      = 'keranjang';
    // protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'barang_id', 'ukuran', 'jml_barang', 'total_hrg'];

    public function getKeranjang($id)
    {
        //query sql
        ///////////////////////////////////////////////////// 
        //  $users = $userModel->where('status', 'active') //
        // ->orderBy('last_login', 'asc')
        // ->findAll();

        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
