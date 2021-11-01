<?php

namespace App\Controllers;

use App\Models\addresModel;
use App\Models\barangModel;
use App\Models\userModel;
use App\Models\keranjangModel;
use App\Models\addressModel;
use App\Models\midtransModel;
use CodeIgniter\Database\Query;
use CodeIgniter\Router\Exceptions\RedirectException;
use Kint\Parser\ToStringPlugin;

class User extends BaseController
{
    protected $userModel;
    protected $barangModel;
    protected $keranjangModel;
    protected $addressModel;
    protected $midtransModel;
    public function __construct()
    {
        session();
        if (!isset($_SESSION['email'])) {
            header('location:' . base_url('Auth'));
            die;
        } else if ($_SESSION['role_id'] == 1) {
            header('location:' . base_url('Admin'));
            die;
        }

        // helper('my');
        // echo is_logged_in();
        $this->userModel = new userModel();
        $this->barangModel = new barangModel();
        $this->keranjangModel = new keranjangModel();
        $this->addressModel = new addressModel();
        $this->midtransModel = new midtransModel();
    }
    public function index()
    {
        $db = \Config\Database::connect();
        if (isset($_GET['tipe'])) {
            $tipe = $_GET['tipe'];
            $data = [
                'title' => $tipe . ' page',
                'tipe' => $tipe,
                'barang' => $this->barangModel->where(['tipe' => $tipe])->orderBy('id', 'desc')->findAll()
            ];
        } else if (isset($_GET['key'])) {
            $key = $_GET['key'];
            $query = $db->query("select * from barang where nama like '%$key%' or tipe like '%$key%' Order By  id DESC");
            if ($query->getNumRows() == 0) {
                $data = [
                    'title' => 'Search page',
                    'tipe' => 'Search for ' . $key,
                ];

                // return view('User/resultNotFound', $data);
                // die;
            } else {
                $data = [
                    'title' => 'Search page',
                    'tipe' => 'Search for ' . $key,
                    'barang' => $query->getresultArray(),
                ];
            }
        } else {
            $data = [
                'title' => 'User page',
                'tipe' => 'All',
                'barang' => $this->barangModel->orderBy('id', 'desc')->findAll(),
            ];

            $tes = $this->barangModel->orderBy('id', 'desc')->findAll();

            // foreach ($tes as $k) {
            //     $total = 
            // }
        }

        return view('User/Home', $data);
    }
    public function profile()
    {
        $db = \Config\database::connect();
        $email = $_SESSION['email'];
        $user = $this->userModel->where(['email' => $email])->first();
        $address = $this->addressModel->where(['user_id' => $user['id']])->first();
        $midtrans = $this->midtransModel->where(['user_id' => $user['id']])->findAll();
        $bank_tf = $this->midtransModel->where(['user_id' => $user['id'], 'payment_type' => 'bank_transfer'])->findAll();
        // $onlinePay = $this->midtransModel->where(['user_id' => $user['id'],'payment_type' => 'gopay'&'qris'])->findAll();
        $cStore = $this->midtransModel->where(['user_id' => $user['id'], 'payment_type' => 'cstore'])->findAll();
        $onlinePay = $db->query("select * from midtrans where payment_type = 'gopay' or payment_type = 'qris'")->getResultArray();
        // var_dump($cStore) ;
        // die;
        // dd($user);
        $data = [
            'title' => 'Profile page',
            'user' => $user,
            'address' => $address,
            'midtrans' => $midtrans,
            'bank_tf' => $bank_tf,
            'cStore' => $cStore,
            'onlinePay' => $onlinePay
        ];

        return view('User/profile', $data);
    }
    public function viewProduk($id)
    {
        $db = \Config\database::connect();
        $query = $db->query('select * from barang where id = ' . $id)->getRowArray();

        $data = [
            'title' => 'view',
            'barang' => $query,
        ];

        return view('User/viewProduk', $data);
    }
    public function keranjang()
    {
        $db = \Config\Database::connect();
        $email = $_SESSION['email'];
        $user = $this->userModel->where(['email' => $email])->first();
        $query = $db->query("SELECT keranjang.id, barang.nama, barang.harga_jual, barang.gambar, keranjang.jml_barang, keranjang.ukuran, keranjang.total_hrg FROM keranjang INNER JOIN user ON keranjang.user_id = user.id JOIN barang ON keranjang.barang_id = barang.id WHERE keranjang.user_id =" . $user['id'] . ' Order By  id DESC')->getResultArray();
        // dd($query);
        // if ($query == null) {
        //     $data = [
        //         'title' => 'cart page'
        //     ];

        //     return view('User/empty_cart', $data);
        // } else {
        $data = [
            'title' => 'cart page',
            'keranjang' => $query
        ];

        return view('User/Keranjang', $data);
        // }
    }
    public function addCart()
    {

        $db = \Config\Database::connect();
        // dd($_COOKIE['id'], $_COOKIE['ukuran'], $_COOKIE['jml_barang'], $_COOKIE['total_hrg']);
        $email = $_SESSION['email'];
        $user = $this->userModel->where(['email' => $email])->first();

        // cek ada tidak data dikeranjang
        $barangID = $_COOKIE['id'];
        $ukuran = $_COOKIE['ukuran'];
        $dbquery = $db->query('SELECT * from keranjang where user_id =' . $user['id'] . ' AND barang_id = ' . $barangID . ' AND ukuran = ' . $ukuran)->getNumRows();
        $query = $this->keranjangModel->where(['barang_id' => $barangID, 'ukuran' => $ukuran])->findAll();
        $barang = $this->barangModel->where(['id' => $barangID])->first();

        // dd($dbquery);
        // dd($query[0]['jml_barang'] + $_COOKIE['jml_barang'], $barang[$_COOKIE['ukuran']] + 1);
        if ($dbquery == 0) {

            $this->keranjangModel->save([
                'user_id' => $user['id'],
                'barang_id' => $_COOKIE['id'],
                'ukuran'  => $_COOKIE['ukuran'],
                'jml_barang' => $_COOKIE['jml_barang'],
                'total_hrg' => $_COOKIE['total_hrg']
            ]);
            session()->setflashdata('success', 'produk berhasil masuk keranjang');
        } else {
            // pengecekan dilakukan pada    
            if ($query[0]['jml_barang'] + $_COOKIE['jml_barang'] <= $barang['s' . $ukuran]) {
                $this->keranjangModel->save([
                    'id' => $query[0]['id'],
                    'user_id' => $user['id'],
                    'barang_id' => $query[0]['barang_id'],
                    'ukuran' => $query[0]['ukuran'],
                    'jml_barang' => $query[0]['jml_barang'] + $_COOKIE['jml_barang'],
                    'total_hrg' => $query[0]['total_hrg'] + $_COOKIE['total_hrg']
                ]);
                session()->setflashdata('success', 'produk berhasil masuk keranjang');
            } else {

                session()->setflashdata('error', 'produk gagal masuk keranjang, melebihi stok!');
            }
        }
        return redirect()->to(base_url('User/keranjang'));
    }
    public function tambah()
    {
        // echo $_GET['id'];
        $id = $_GET['id'];
        $db = \Config\Database::connect();
        $data = $db->query("SELECT keranjang.user_id, keranjang.barang_id, keranjang.jml_barang, keranjang.ukuran, keranjang.total_hrg, barang.nama, barang.harga_jual, barang.gambar FROM keranjang INNER JOIN user ON keranjang.user_id = user.id JOIN barang ON keranjang.barang_id = barang.id Where keranjang.id =" . $id)->getRowArray();
        $barang = $this->barangModel->Where(['id' => $data['barang_id']])->first();
        // dd($data['jml_barang']);
        $hrgTotal = $data['total_hrg'] + $data['harga_jual'];

        if ($data['jml_barang'] + 1 <= $barang['s' . $data['ukuran']]) {
            $this->keranjangModel->save([
                'id' => $id,
                'user_id' => $data['user_id'],
                'barang_id' => $data['barang_id'],
                'ukuran' => $data['ukuran'],
                'jml_barang' => $data['jml_barang'] + 1,
                'total_hrg' => $hrgTotal
            ]);
            // session()->setflashdata('success', 'done !');
            $msg = [
                'success' => 'yes!'
            ];

            echo json_encode($msg);
        } else {
            // session()->setflashdata('error', 'out of stock !');
            $msg = [
                'error' => '<i class="fas fa-exclamation-circle" style="font-size: 20px"></i> out of stock!'
            ];

            echo json_encode($msg);
            die;
        }

        // return redirect()->to(base_url('User/keranjang'));
    }
    public function kurang($id)
    {
        $db = \Config\Database::connect();
        $data = $db->query("SELECT keranjang.user_id, keranjang.barang_id, keranjang.jml_barang, keranjang.ukuran, keranjang.total_hrg, barang.nama, barang.harga_jual, barang.gambar FROM keranjang INNER JOIN user ON keranjang.user_id = user.id JOIN barang ON keranjang.barang_id = barang.id Where keranjang.id =" . $id)->getRowArray();
        $barang = $this->barangModel->Where(['id' => $data['barang_id']])->first();
        $cek = $data['jml_barang'] - 1;
        // dd($cek);
        if ($cek == 0) {
            $this->keranjangModel->delete($id);
        } else {
            $hrgTotal = $data['total_hrg'] - $data['harga_jual'];
            $this->keranjangModel->save([
                'id' => $id,
                'user_id' => $data['user_id'],
                'barang_id' => $data['barang_id'],
                'ukuran' => $data['ukuran'],
                'jml_barang' => $data['jml_barang'] - 1,
                'total_hrg' => $hrgTotal
            ]);
        }
        return redirect()->to(base_url('User/keranjang'));
    }
    public function remove($id)
    {
        $this->keranjangModel->delete($id);
        return redirect()->to(base_url('User/keranjang'));
    }
    public function Address_v()
    {
        $db = \Config\Database::connect();
        $email = $_SESSION['email'];
        $user = $this->userModel->where(['email' => $email])->first();
        $query = $db->query('SELECT * FROM user_address where user_id =' . $user['id']);
        $row_address = $query->getNumRows();
        $Address = $query->getRowArray();
        $keranjang = $db->query("SELECT keranjang.id, barang.nama, barang.harga_jual, barang.gambar, keranjang.jml_barang, keranjang.ukuran, keranjang.total_hrg FROM keranjang INNER JOIN user ON keranjang.user_id = user.id JOIN barang ON keranjang.barang_id = barang.id WHERE keranjang.user_id =" . $user['id'] . ' Order By  id DESC')->getResultArray();
        // dd($address);
        if (isset($_GET['id'])) {
            $row_address = 0;
        }
        if ($row_address == 0) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "key: e6d6a3430225a2b7ba5bcc20d47404ba"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
                die;
            } else {
                $provinsi = json_decode($response, true);
            }

            // dd($query);
            if (isset($_GET['id'])) {
                $data = [
                    'title' => 'Address page',
                    'user' => $user,
                    'provinsi' => $provinsi,
                    'keranjang' => $keranjang,
                    'Address' => $Address
                ];
            } else {
                $data = [
                    'title' => 'Address page',
                    'user' => $user,
                    'provinsi' => $provinsi,
                    'keranjang' => $keranjang
                ];
            }
            return view('User/Address', $data);
        } else {
            return redirect()->to(base_url('User/checkout'));
        }
    }
    public function kota()
    {
        $id = $_GET['id'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e6d6a3430225a2b7ba5bcc20d47404ba"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            die;
        } else {
            // dd($response);
            // echo json_encode($response);
            $data = json_decode($response, true);
            // dd($data['rajaongkir']['results'][2]['postal_code']);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                echo "<option  data-kota='" . $data['rajaongkir']['results'][$i]['city_name'] . "' data-code='" . $data['rajaongkir']['results'][$i]['postal_code'] . "' value='" . $data['rajaongkir']['results'][$i]['city_id'] . "'>" . $data['rajaongkir']['results'][$i]['city_name'] . "</option>";
            }
        }
    }
    public function Address()
    {
        $validation = \Config\Services::validation();
        $email = $_SESSION['email'];
        $user  = $this->userModel->where(['email' => $email])->first();

        if (!$this->validate([
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'nama should be required',
                ]
            ],
            'alamat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'alamat should be required',
                ]
            ],
            'phone' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No hp should be required',
                ]
            ],
        ])) {
            $msg = [
                'error' => [
                    'nama' => $validation->getError('nama'),
                    'alamat' => $validation->getError('alamat'),
                    'phone' => $validation->getError('phone'),
                ]
            ];
            echo json_encode($msg);
        } else if ($_POST['provinsi'] == 'none') {
            $msg = [
                'error' => [
                    'provinsi' => 'select your provinsi',
                ]
            ];
            echo json_encode($msg);
        } else if (!isset($_POST['kota'])) {
            $msg = [
                'error' => [
                    'kota' => 'select your kota',
                ]
            ];
            echo json_encode($msg);
        } else if ($_POST['kota'] == '') {
            $msg = [
                'error' => [
                    'kota' => 'select your kota',
                ]
            ];
            echo json_encode($msg);
        } else {

            if (isset($_GET['id'])) {
                $data = [
                    'id' => $_GET['id'],
                    'user_id' => $user['id'],
                    'nama' => $_POST['nama'],
                    'alamat' => $_POST['alamat'],
                    'provinsi_id' => $_POST['provinsi'],
                    'provinsi' => $_GET['province'],
                    'kota_id' => $_POST['kota'],
                    'kota' => $_GET['city'],
                    'pos' => $_GET['pos'],
                    'phone' => $_POST['phone']
                ];
            } else {
                $data = [
                    'user_id' => $user['id'],
                    'nama' => $_POST['nama'],
                    'alamat' => $_POST['alamat'],
                    'provinsi_id' => $_POST['provinsi'],
                    'provinsi' => $_GET['province'],
                    'kota_id' => $_POST['kota'],
                    'kota' => $_GET['city'],
                    'pos' => $_GET['pos'],
                    'phone' => $_POST['phone']
                ];
            }

            $this->addressModel->save($data);

            $msg = [
                'sukses' => 'data berhasil disimpan',
            ];

            echo json_encode($msg);
        }
    }
    public function checkout()
    {
        $db = \Config\Database::connect();

        $email = $_SESSION['email'];
        $user = $this->userModel->where(['email' => $email])->first();
        $address = $this->addressModel->where(['user_id' => $user['id']])->first();
        $query = $db->query("SELECT keranjang.id, barang.nama, barang.harga_jual, barang.gambar, barang.berat, keranjang.jml_barang, keranjang.ukuran, keranjang.total_hrg FROM keranjang INNER JOIN user ON keranjang.user_id = user.id JOIN barang ON keranjang.barang_id = barang.id WHERE keranjang.user_id =" . $user['id'] . ' Order By  id DESC')->getResultArray();

        $berat = 0;
        foreach ($query as $q) :
            $berat += $q['berat'] * $q['jml_barang'];
        endforeach;

        //////// cost ///////////
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=350&destination=" . $address['kota_id'] . "&weight=" . $berat . "&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: e6d6a3430225a2b7ba5bcc20d47404ba"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            die;
        } else {
            $cost = json_decode($response, true);
        }

        $cost = $cost['rajaongkir']['results'][0]['costs'];
        // dd($cost);
        $data = [
            'title' => 'checkout page',
            'user' => $user,
            'address' => $address,
            'cost' => $cost,
            'keranjang' => $query,
            'berat' => $berat
        ];

        return view('User/checkout', $data);
    }
    public function tes()
    {
        $id = $_GET['id'];
        $db = \Config\Database::connect();
        $data = $db->query("SELECT keranjang.user_id, keranjang.barang_id, keranjang.jml_barang, keranjang.ukuran, keranjang.total_hrg, barang.nama, barang.harga_jual, barang.gambar FROM keranjang INNER JOIN user ON keranjang.user_id = user.id JOIN barang ON keranjang.barang_id = barang.id Where keranjang.id =" . $id)->getRowArray();
        $barang = $this->barangModel->Where(['id' => $data['barang_id']])->first();
        // dd($data['jml_barang']);
        $s1 = $data['jml_barang'] + 1;
        $ukuran = 's' . $data['ukuran'];

        $stok = $barang[$ukuran];

        // $s2 = $barang[$data['ukuran']];
        $hrgTotal = $data['total_hrg'] + $data['harga_jual'];
        $this->keranjangModel->save([
            'id' => $id,
            'user_id' => $data['user_id'],
            'barang_id' => $data['barang_id'],
            'ukuran' => $data['ukuran'],
            'jml_barang' => $data['jml_barang'] + 1,
            'total_hrg' => $hrgTotal
        ]);
        // session()->setflashdata('success', 'done !');
        $msg = [
            'success' => 'berhasil =' . $s1 . 'ukuran=' . $ukuran . 'stok=' . $stok
        ];

        echo json_encode($msg);
    }
}
