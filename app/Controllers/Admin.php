<?php

namespace App\Controllers;

use App\Models\barangModel;
use App\Models\userModel;
use App\Models\orderModel;
use App\Models\addressModel;
use App\Models\midtransModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\Router\Exceptions\RedirectException;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use CodeIgniter\Session\Session;


class Admin extends BaseController
{
    protected $userModel;
    protected $barangModel;
    protected $orderModel;
    protected $addressModel;
    protected $midtransModel;
    public function __construct()
    {
        session();

        // dd($_SESSION['role_id']);
        if (!isset($_SESSION['email'])) {
            header('location:Auth');
            die;
        } else if ($_SESSION['role_id'] == 2) {
            header('location:User');
            die;
        }

        $this->userModel = new userModel();
        $this->barangModel = new barangModel();
        $this->orderModel = new orderModel();
        $this->addressModel = new addressModel();
        $this->midtransModel = new midtransModel();
        // helper('my');
        // echo is_logged_in();
    }
    public function index()
    {

        $data = [
            'title' => 'Admin page',
            'barang' => $this->barangModel->findAll()
        ];
        return view('Admin/index', $data);

        // if (isset($_SESSION['email'])) {
        //     if ($_SESSION['role_id'] == 2) {
        //         return redirect()->to('/user');
        //     } else {
        //         $data = [
        //             'title' => 'Admin page',
        //             'barang' => $this->barangModel->findAll()
        //         ];
        //         return view('Admin/index', $data);
        //     }
        // } else {
        //     return redirect()->to('/Auth');
        // }
    }
    public function create()
    {
        $data = [
            'title' => 'Form Tambah'

        ];
        return view('Admin/create', $data);
    }
    public function save()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '*nama should be required',
                ]
            ],
            'harga_modal' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '*harga modal should be required',
                ]
            ],
            'harga_jual' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '*harga jual should be required',
                ]
            ],
            'berat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '*berat should be required',
                ]
            ],
        ])) {
            $msg = [
                'error' => [
                    'nama' => $validation->getError('nama'),
                    'harga_jual' => $validation->getError('harga_jual'),
                    'harga_modal' => $validation->getError('harga_modal'),
                    'berat' => $validation->getError('berat'),
                    // 'gambar' => $validation->getError('gambar'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $file = $_FILES['gambar']['tmp_name'];

            $filename = $_FILES['gambar']['name'];

            rename($file, 'image/' . $filename);

            $this->barangModel->save([
                'nama' => $_POST['nama'],
                'gambar' => $filename,
                'harga_modal' => $_POST['harga_modal'],
                'harga_jual' => $_POST['harga_jual'],
                's35' => $_POST['35'],
                's36' => $_POST['36'],
                's37' => $_POST['37'],
                's38' => $_POST['38'],
                's39' => $_POST['39'],
                's40' => $_POST['40'],
                'berat' => $_POST['berat'],
                'tipe' => $_POST['tipe']
            ]);
            $msg = [
                'sukses' => 'data berhasil disimpan'
            ];

            echo json_encode($msg);
        }
    }
    public function update($id)
    {
        $data = [
            'title' => 'Update page',
            'barang' => $this->barangModel->getBarang($id)
        ];

        return view('Admin/update', $data);
    }
    public function saveUpdate($id)
    {
        $barangLama = $this->barangModel->getBarang($id);
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'nama should be required',
                ]
            ],
            'harga_modal' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'harga modal should be required',
                ]
            ],
            'harga_jual' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'harga jual should be required',
                ]
            ],
            'berat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '*berat should be required',
                ]
            ],
        ])) {
            $msg = [
                'error' => [
                    'nama' => $validation->getError('nama'),
                    'harga_jual' => $validation->getError('harga_jual'),
                    'harga_modal' => $validation->getError('harga_modal'),
                    'berat' => $validation->getError('berat'),
                ]
            ];
            echo json_encode($msg);
        } else {
            if ($_FILES['gambar']['name']) {
                $file = $_FILES['gambar']['tmp_name'];
                $filename = $_FILES['gambar']['name'];

                rename($file, 'image/' . $filename);

                unlink('image/' . $barangLama['gambar']);
                $this->barangModel->save([
                    'nama' => $_POST['nama'],
                    'gambar' => $filename,
                    'harga_modal' => $_POST['harga_modal'],
                    'harga_jual' => $_POST['harga_jual'],
                    'berat' => $_POST['berat'],
                    's35' => $_POST['35'],
                    's36' => $_POST['36'],
                    's37' => $_POST['37'],
                    's38' => $_POST['38'],
                    's39' => $_POST['39'],
                    's40' => $_POST['40'],
                    'tipe' => $_POST['tipe']
                ]);
            } else {
                $this->barangModel->save([
                    'id' => $barangLama['id'],
                    'nama' => $_POST['nama'],
                    'gambar' => $barangLama['gambar'],
                    'harga_modal' => $_POST['harga_modal'],
                    'harga_jual' => $_POST['harga_jual'],
                    'berat' => $_POST['berat'],
                    's35' => $_POST['35'],
                    's36' => $_POST['36'],
                    's37' => $_POST['37'],
                    's38' => $_POST['38'],
                    's39' => $_POST['39'],
                    's40' => $_POST['40'],
                    'tipe' => $_POST['tipe']
                ]);
            }
            $msg = 'data berhasil diubah';

            echo json_encode($msg);
        }
    }
    public function delete($id)
    {
        $barang = $this->barangModel->getBarang($id);
        unlink('image/' . $barang['gambar']);
        $this->barangModel->delete($id);

        return redirect()->to(base_url('Admin/'));
    }
    public function listOrder()
    {
        $db = \Config\Database::connect();
        $user = $this->userModel->findAll();
        $order = $this->orderModel->findAll();
        $midtrans = $this->midtransModel->findAll();
        $barang = $this->barangModel->findAll();
        $address = $this->addressModel->findAll();


        $data = [
            'title' => 'order page',
            'user' => $user,
            'order' => $order,
            'midtrans' => $midtrans,
            'barang' => $barang,
            'address' => $address
        ];

        // $tes = $db->query('select * from order_produk inner join barang on order_produk.barang_id=barang.id where order_produk.order_id=999917204')->getresultArray();
        // dd($tes);
        return view('Admin/listOrder', $data);
    }
    public function listBarang()
    {
    }
}
