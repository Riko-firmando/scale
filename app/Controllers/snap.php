<?php

namespace App\Controllers;

// use App\libraries\Midtrans as LibrariesMidtrans;

// require '..\Libraries\Midtrans.php';

use App\libraries\Midtrans;
use App\Models\keranjangModel;
use App\Models\userModel;
use App\Models\addressModel;
use App\Models\barangModel;
use App\Models\midtransModel;
use App\Models\orderModel;


// if (!defined('BASEPATH')) exit('No direct script access allowed');



class Snap extends BaseController
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

	protected $midtrans;
	protected $keranjangModel;
	protected $userModel;
	protected $addressModel;
	protected $barangModel;
	protected $midtransModel;
	protected $orderModel;
	public function __construct()
	{
		// parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-ywNgepZjx4o6n9viOGGmjO74', 'production' => false);
		$this->midtrans = new Midtrans();
		$this->midtrans->config($params);
		helper('url');
		$this->keranjangModel = new keranjangModel();
		$this->userModel = new userModel();
		$this->addressModel = new addressModel();
		$this->barangModel = new barangModel();
		$this->midtransModel = new midtransModel();
		$this->orderModel = new orderModel();
	}

	public function index()
	{
		return view('checkout_snap');
	}

	public function token()
	{
		$email = $_SESSION['email'];
		$user = $this->userModel->where(['email' => $email])->first();
		$address = $this->addressModel->where(['user_id' => $user['id']])->first();
		// $keranjang = $this->keranjangModel->where(['user_id' => $user['id']])->findAll();
		// Required
		$transaction_details = array(
			'order_id' => rand(),
			'gross_amount' => $_POST['subtotal'], // no decimal allowed for creditcard
		);

		// $index = 1;
		// $pe = 0;
		// foreach ($keranjang as $k) {
		// 	$barang = $this->barangModel->where(['id' => $k['barang_id']])->first();

		// 	$produk[$pe] = [
		// 		'id' => 'a' . $index,
		// 		'price' => $k['total_hrg'],
		// 		'quantity' => $k['jml_barang'],
		// 		'name' => $barang['nama']
		// 	];
		// 	$index++;
		// 	$pe++;
		// }

		// dd($items);

		// Optional
		// $item1_details = array(
		// 	'id' => 'a1',
		// 	'price' => 18000,
		// 	'quantity' => 3,
		// 	'name' => "Apple"
		// );

		// // Optional
		// $item2_details = array(
		// 	'id' => 'a2',
		// 	'price' => 20000,
		// 	'quantity' => 2,
		// 	'name' => "Orange"
		// );

		// Optional
		$item_details = array();
		// dd($item_details);
		// Optional
		$billing_address = array(
			'first_name'    => "Andri",
			'last_name'     => "Litani",
			'address'       => "Mangga 20",
			'city'          => "Jakarta",
			'postal_code'   => "16602",
			'phone'         => "081122334455",
			'country_code'  => 'IDN'
		);
		// Optional
		$shipping_address = array(
			'address'       => $address['alamat'],
			'city'          => $address['kota'],
			'postal_code'   => $address['pos'],
			'phone'         => '+62' . $address['phone'],
			'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
			'first_name'   	=> $address['nama'],
			'last_name' 	=> '',
			'email'         => $user['email'],
			'phone'         => '+62' . $address['phone'],
			'billing_address'  => $billing_address,
			'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration'  => 120
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details'       => $item_details,
			'customer_details'   => $customer_details,
			'credit_card'        => $credit_card,
			'expiry'             => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function finish()
	{
		$user = $this->userModel->where(['email' => $_SESSION['email']])->first();
		// dd($user['id']);
		$result = json_decode($_POST['result_data'], true);
		if (isset($result['va_numbers'][0])) {
			$this->midtransModel->save([
				'order_id' => $result['order_id'],
				'user_id' => $user['id'],
				'gross_amount' => $result['gross_amount'],
				'payment_type' => $result['payment_type'],
				'payment_code' => '-',
				'transaction_time' => $result['transaction_time'],
				'bank' => $result['va_numbers'][0]['bank'],
				'va_number' => $result['va_numbers'][0]['va_number'],
				'status_code' => $result['status_code'],
				'pdf_url' => $result['pdf_url']
			]);
		} else if (isset($result['payment_code'])) {
			$this->midtransModel->save([
				'order_id' => $result['order_id'],
				'user_id' => $user['id'],
				'gross_amount' => $result['gross_amount'],
				'payment_type' => $result['payment_type'],
				'payment_code' => $result['payment_code'],
				'transaction_time' => $result['transaction_time'],
				'bank' => '-',
				'va_number' => '-',
				'status_code' => $result['status_code'],
				'pdf_url' => $result['pdf_url']
			]);
		} else {
			$this->midtransModel->save([
				'order_id' => $result['order_id'],
				'user_id' => $user['id'],
				'gross_amount' => $result['gross_amount'],
				'payment_type' => $result['payment_type'],
				'payment_code' => '-',
				'transaction_time' => $result['transaction_time'],
				'bank' => '-',
				'va_number' => '-',
				'status_code' => $result['status_code'],
				'pdf_url' => '-'
			]);
		}
		$keranjang = $this->keranjangModel->where(['user_id' => $user['id']])->findAll();
		foreach ($keranjang as $k) {
			$this->orderModel->save([
				'order_id' => $result['order_id'],
				'user_id' => $user['id'],
				'barang_id' => $k['barang_id'],
				'size' => $k['ukuran'],
				'jumlah' => $k['jml_barang']
			]);
		}

		$this->keranjangModel->where('user_id', $user['id'])->delete();
		return redirect()->to(base_url('User/profile'));
	}
}
