<?php

namespace App\Models;

use CodeIgniter\Model;

class orderModel extends Model
{
    protected $table      = 'order_produk';
    // protected $useTimestamps = true;
    protected $allowedFields = ['order_id', 'user_id', 'barang_id', 'size', 'jumlah'];

    public function getAddress($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
