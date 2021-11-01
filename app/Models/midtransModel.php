<?php

namespace App\Models;

use CodeIgniter\Model;

class midtransModel extends Model
{
    protected $table      = 'midtrans';
    // protected $useTimestamps = true;
    protected $allowedFields = ['order_id', 'user_id', 'gross_amount', 'payment_type', 'payment_code', 'transaction_time', 'bank', 'va_number', 'status_code', 'pdf_url'];

    public function getAddress($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
