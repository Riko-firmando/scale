<?php

namespace App\Controllers;

use App\Models\userModel;
use App\Models\tokenModel;
use CodeIgniter\Router\Exceptions\RedirectException;

class Auth extends BaseController
{
	protected $userModel;
	protected $tokenModel;
	public function __construct()
	{
		session();

		// helper('my');
		// echo is_logged_in();
		// parent::__construct();
		// $this->load->library('form_validation');


		$this->userModel = new userModel();
		$this->tokenModel = new tokenModel();
	}
	public function is_logged_in()
	{
		if (isset($_SESSION['email'])) {
			if ($_SESSION['role_id'] == 1) {
				header('location:admin');
				die;
			} else {
				header('location:User');
				die;
			}
		}
	}
	public function index()
	{
		// return $this->is_logged_in();

		if (isset($_SESSION['email'])) {
			if ($_SESSION['role_id'] == 1) {
				header('location:admin');
				die;
			} else {
				header('location:User');
				die;
			}
		}

		$data = [
			'title' => 'Login',
			'validation' => \config\Services::validation()
		];

		return view("Auth/Login", $data);
	}
	public function Login()
	{
		if (!$this->validate([
			'email' => [
				'rules' => 'required|trim|valid_email',
				'errors' => []
			],
			'password' => [
				'rules' => 'required|trim',
				'errors' => []
			]
		])) {
			return Redirect()->to('/Auth/')->withInput();
		} else {

			$email = $_POST['email'];
			$password = $_POST['password'];

			$user = $this->userModel->where(['email' => $email])->first();

			if ($user) {

				if ($user['is_active'] == 1) {

					if (password_verify($password, $user['password'])) {
						if ($user['role_id'] == 1) {
							$_SESSION['email'] = $user['email'];
							$_SESSION['role_id'] = $user['role_id'];

							return redirect()->to('/Admin')->withInput();
						} else {
							$_SESSION['email'] = $user['email'];
							$_SESSION['role_id'] = $user['role_id'];

							return redirect()->to('/User')->withInput();
						}
					} else {
						session()->setflashdata('message1', 'wrong password');
						return redirect()->to('/Auth')->withInput();
					}
				} else {
					session()->setflashdata('message1', 'your account has not been activated');
					return redirect()->to('/Auth')->withInput();
				}
			} else {
				session()->setflashdata('message1', 'your account has not been registered');
				return redirect()->to('/Auth');
			}
		}
	}
	// private function _Login()
	// {
	// 	$email = $_POST['email'];
	// 	$password = $_POST['password'];



	// 	$user = $this->userModel->where(['email' => $email])->first();

	// 	// dd($user['is_active']);

	// 	if ($user) {
	// 		if ($user['is_active'] == 1) {

	// 			if (password_verify($password, $user['password'])) {
	// 				echo 'selamat datang';
	// 			} else {
	// 				// echo 'salah3';
	// 				session()->setflashdata('message', 'data has been input');
	// 				return redirect()->to('/Auth/');
	// 				// 	session()->setflashdata('message', 'wrong password');
	// 			}
	// 		} else {
	// 			echo 'salah2';
	// 			// 	session()->setflashdata('message', 'your account has not been activated');
	// 			// 	return redirect()->to('/Auth/');
	// 		}
	// 	} else {
	// 		echo 'salah1';
	// 		// session()->setflashdata('message', 'your account has not been registered');
	// 		// redirect('Auth');
	// 	}
	// }
	public function Registration()
	{
		if (isset($_SESSION['email'])) {
			if ($_SESSION['role_id'] == 1) {
				header('location:admin');
				die;
			} else {
				header('location:User');
				die;
			}
		}
		$data = [
			'title' => 'Registration',
			'validation' => \config\Services::validation()
		];
		return view('Auth/Registration', $data);
	}
	public function Save()
	{
		// dd($this->userModel->findAll());
		if (!$this->validate([
			'name' => [
				'rules' => 'required|trim',
				'errors' => [
					'required' => 'name should be required'
				]
			],
			'email' => [
				'rules' => 'required|trim|is_unique[user.email]|valid_email',
				'errors' => [
					'required' => 'email should be required',
				]
			],
			'password1' => [
				'rules' => 'required|trim|min_length[3]|matches[password2]',
				'errors' => [
					'required' => 'password should be required',
				]
			],
			'password2' => [
				'rules' => 'required|trim|matches[password1]',
			],
		])) {
			return redirect()->to('/Auth/Registration')->withInput();
		} else {
			$token = base64_encode(random_bytes(32));
			$email = $_POST['email'];
			$this->userModel->Save([
				'name' => htmlspecialchars($_POST['name'], true),
				'email' => htmlspecialchars($email, true),
				'image' => 'default.jpg',
				'password' => password_hash($_POST['password1'], PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 0,
			]);

			$this->tokenModel->Save([
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			]);

			$this->_sendEmail($token, 'verify');

			session()->setflashdata('message', 'data have been input, please verification!');
			return redirect()->to('/Auth');
		}
	}
	private function _sendEmail($token, $type)
	{
		$email = $_POST['email'];

		$mail = \config\Services::email();
		$mail->setFrom('Rikofrmndo27@gmail.com', 'Riko Firmando');
		$mail->setTo($email);

		if ($type = 'verify') {
			$mail->setSubject('verification email');
			$mail->setMessage('click this link to verification : <a href="' . base_url('/auth/verify?email=') . $email . '&token=' . urlEncode($token) .  '"> activation </a>');
		}
		if ($type = 'forgotPassword') {
			$mail->setSubject('Reset password');
			$mail->setMessage('click this link to Reset your password : <a href="' . base_url('/auth/resetPassword?email=') . $email . '&token=' . urlEncode($token) .  '"> Reset password </a>');
		}

		if (!$mail->send()) {
			return false;
		} else {
			return true;
		}
	}

	public function verify()
	{
		$email = $_GET['email'];
		$token = $_GET['token'];

		$dataToken = $this->tokenModel->where(['email' => $email])->first();
		$userData = $this->userModel->Where(['email' => $email])->first();


		if ($email = $dataToken['email']) {
			if ($token = $dataToken['token']) {
				if (time() - $dataToken['date_created']  <= (60 * 60 * 24)) {
					$this->userModel->save([
						'id' => $userData['id'],
						'is_active' => 1
					]);

					$this->tokenModel->delete([$dataToken['id']]);

					session()->setflashdata('message', 'Account have been active, please Login');
					return redirect()->to('/Auth');
				} else {
					$this->userModel->delete($userData['id']);
					$this->tokenModel->delete($dataToken['id']);

					session()->setflashdata('message1', 'account activation is too long');
					return redirect()->to('/Auth');
				}
			} else {
				session()->setflashdata('message1', 'wrong token!!');
				return redirect()->to('/Auth');
			}
		} else {
			session()->setflashdata('message1', 'wrong email!!');
			return redirect()->to('/Auth');
		}
	}
	public function forgotPassword()
	{
		$data = [
			'title' => 'forgot password',
			'validation' => \config\Services::validation()
		];

		return view('/auth/forgotPassword', $data);
	}

	public function getEmail()
	{
		if (!$this->validate([
			'email' => [
				'rules' => 'required|trim|valid_email',
				'errors' => [
					'required' => 'email should be required',
				]
			],
		])) {
			return redirect()->to('/Auth/forgotPassword')->withInput();
		} else {
			$email = $_POST['email'];
			$token = base64_encode(random_bytes(32));

			$this->tokenModel->save([
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			]);

			$this->_sendEmail($token, 'forgotPassword');
			session()->setflashdata('message', 'please check your email to reset ur password');
			return redirect()->to('/auth/forgotPassword');
		}
	}

	public function resetPassword()
	{
		$email = $_GET['email'];
		$token = $_GET['token'];

		$dataToken = $this->tokenModel->where(['email' => $email])->first();
		$userData = $this->userModel->where(['email' => $email])->first();

		// dd($dataToken);

		if (isset($dataToken)) {
			if ($dataToken['token'] == $token) {
				if (time() - $dataToken['date_created'] <= (60 * 60 * 24)) {
					$_SESSION['reset_email'] = $email;
					return $this->changePassword();
				} else {
					$this->userModel->delete($userData['id']);
					$this->userToken->delete($dataToken['id']);

					session()->setflashdata('message1', 'times up');
					return redirect()->to('/auth/forgotPassword');
				}
			} else {
				session()->setflashdata('message1', 'wrong token');
				return redirect()->to('/auth/forgotPassword');
			}
		} else {
			session()->setflashdata('message1', 'wrong email');
			return redirect()->to('/auth/forgotPassword');
		}
	}

	public function changePassword()
	{
		if (!isset($_SESSION['reset_email'])) {
			return redirect()->to('/Auth');
		}
		$data = [
			'title' => 'Reset Password',
			'validation' => \Config\Services::validation()
		];

		return view('/Auth/changePassword', $data);
	}

	public function savePassword()
	{
		if (!$this->validate([
			'password1' => [
				'rules' => 'required|trim|min_length[3]|matches[password2]',
				'errors' => [
					'required' => 'password should be required',
				]
			],
			'password2' => [
				'rules' => 'required|trim|matches[password1]',
			]
		])) {
			return redirect()->to('/auth/changePassword')->withInput();
		} else {
			$dataToken = $this->tokenModel->Where(['email' => $_SESSION['reset_email']])->first();
			$userData = $this->userModel->where(['email' => $_SESSION['reset_email']])->first();

			$this->userModel->save([
				'id' => $userData['id'],
				'password' => password_hash($_POST['password1'], PASSWORD_DEFAULT)
			]);

			$this->tokenModel->delete($dataToken['id']);
			unset($_SESSION['reset_email']);

			session()->setflashdata('message', 'your password have been reset, please Login');
			return redirect()->to('/auth');
		}
	}

	public function Logout()
	{
		if (!isset($_SESSION['email'])) {
			return redirect()->to('/Auth');
		} else {
			// die;
			unset($_SESSION['email']);
			unset($_SESSION['role_id']);

			SESSION()->setflashdata('message', 'you have been Logout');
			return redirect()->to('/Auth');
		}
	}
}
