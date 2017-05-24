<?php 

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;

class UserController extends BaseController
{
	public function register(Request $request, Response $response )
	{
		$this->validator->rule('required', ['username', 'name', 'email', 'password']);
		$this->validator->rule('email', 'email');
		$this->validator->rule('integer', 'id');

		if ($this->validator->validate()) {
			$user = new UserModel($this->db); 
			$registers = $user->register($request->getParsedBody());

		$findUserAfterRegister = $user->find('id', $registers);

		$data = $this->responseDetail(201, 'Register Success, Please Login', 
				$findUserAfterRegister);

		} else {

		$data = $this->responseDetail(400, 'Errors', $this->validator->errors());

		}

       	return $data;
	}

	public function login(Request $request, Response $response )
	{
		
		$user = new UserModel($this->db);
		$login = $user->find('username', $request->getParam('username'));
		if (empty($login)) {
			$data = $this->responseDetail(401, 'Error', 'Username is not Registered');
		} else {
			$check = password_verify($request->getParam('password'), $login['password']);
			if ($check) {
				$token = new UserToken($this->db);
				$token->setToken($login['id']);
				$getToken = $token->find('user_id', $login['id']);
				$key = [
					'key'	=> $getToken,
				];
				$data = $this->responseDetail(201, 'Login Success', $login, $key);
			} else {
				$data = $this->responseDetail(401, 'Error', 'Wrong Password');
			}
		}
		return $data;
	}

	public function logout(Request $request, Response $response )
	{
		$token = $request->getHeader('Authorization')[0];

		$userToken = new UserToken($this->db);
		$findUser = $userToken->find('token', $token);
		
		$userToken->delete('user_id',$findUser['user_id']);
		return $this->responseDetail(200, 'Success', 'Logout Success');
	}

}