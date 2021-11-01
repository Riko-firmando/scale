<?php

namespace App\Controllers;

use App\libraries\Veritrans;
// use App\libraries\Veritrans as LibrariesVeritrans;
// use App\libraries\Midtrans as LibrariesMidtrans;
// use App\libraries\Veritrans;
use App\Models\midtransModel;
use App\Models\orderModel;

// if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends BaseController
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	protected $Veritrans;
	protected $midtransModel;
	protected $orderModel;
	public function __construct()
	{
		// parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-ywNgepZjx4o6n9viOGGmjO74', 'production' => false);
		$this->Veritrans = new  Veritrans();
		$this->Veritrans->config($params);
		helper('url');
		$this->midtransModel = new midtransModel();
		$this->orderModel = new orderModel();
	}

	public function index()
	{
		$db = \Config\Database::connect();
		// $json_result = file_get_contents('php://input');
		// $result = json_decode($json_result, true);
		// $order_id = $result['order_id'];
		$result['status_code'] = 202;
		$order_id = 1774956869;

		if ($result['status_code'] == 200) {
			$db->query('UPDATE midtrans SET status_code =' . $result['status_code'] . ' WHERE order_id=' . $order_id);
		} else if ($result['status_code'] == 202) {
			$this->midtransModel->where('order_id', $order_id)->delete();
			$this->orderModel->where('order_id', $order_id)->delete();
		}
		return redirect()->to(base_url('User/profile'));
		// if ($result) {
		// 	$notif = $this->veritrans->status($result->order_id);
		// }

		// error_log(print_r($result, TRUE));

		//notification handler sample

		/*
		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		if ($transaction == 'capture') {
		  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
		  if ($type == 'credit_card'){
		    if($fraud == 'challenge'){
		      // TODO set payment status in merchant's database to 'Challenge by FDS'
		      // TODO merchant should decide whether this transaction is authorized or not in MAP
		      echo "Transaction order_id: " . $order_id ." is challenged by FDS";
		      } 
		      else {
		      // TODO set payment status in merchant's database to 'Success'
		      echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
		      }
		    }
		  }
		else if ($transaction == 'settlement'){
		  // TODO set payment status in merchant's database to 'Settlement'
		  echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
		  } 
		  else if($transaction == 'pending'){
		  // TODO set payment status in merchant's database to 'Pending'
		  echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
		  } 
		  else if ($transaction == 'deny') {
		  // TODO set payment status in merchant's database to 'Denied'
		  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
		}*/
	}
}
