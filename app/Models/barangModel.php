<?php

namespace App\Models;

use CodeIgniter\Model;

class barangModel extends Model
{
    protected $table      = 'barang';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'gambar', 'harga_modal', 'harga_jual', 's35', 's36', 's37', 's38', 's39', 's40', 'berat', 'tipe'];

    public function getBarang($id)
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
