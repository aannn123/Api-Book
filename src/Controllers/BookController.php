<?php 

namespace App\Controllers;
use App\Models\BookModel;

class BookController extends BaseController
{
	public function index($request, $response)
	{
		$book = new BookModel($this->db);

		$getBook = $book->getAll();
		// var_dump($getBook);
		// die();
		$countBook = count($getBook);

		if ($getBook) {
			$page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');

			$get = $book->paginate($page, $getBook, 5);

			if ($get) {
				$data = $this->responseDetail(200, 'Data Available', $get, $this->paginate($countBook, 5, $page, ceil($countBook/5)));
			} else {
				$data = $this->responseDetail(404, 'Error', 'Data Not Found');
			}
		} else {
			$data = $this->responseDetail(204, 'Success', 'No Content');
		}
		
		return $data;
		
	}

	public function bookSold($request, $response)
	{
		$book = new BookModel($this->db);

		$getBookSold = $book->getAllSold();
		
		$countBookSold = count($getBookSold);

		if ($getBookSold) {
			$page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');

			$get = $book->paginate($page, $getBookSold, 5);

			if ($get) {
				$data = $this->responseDetail(200, 'Data Available', $get, $this->paginate($countBookSold, 5, $page, ceil($countBookSold/ 5)));
			} else {
				$data = $this->responseDetail(404, 'Error', 'Data Not Found');
			}
		} else {
			$data = $this->responseDetail(204, 'Success', 'No Content');
		}
		
		return $data;
		
	}	

	public function addBook($request, $response)
	{


		$this->validator->rule('required', ['title', 'short_desc', 'price', 'image', 'category_id']);
		$this->validator->rule('integer', 'id');
		$this->validator->rule('numeric', ['price', 'category_id']);

		if ($this->validator->validate()) {
			$book = new BookModel($this->db);
			$add = $book->createData($request->getParsedBody());


			// $data['data'] = $request->getParams();
			$data['status_code'] = 201;
        	$data['status_message'] = "Create data sukses";
        	$data['data'] = $request->getParsedBody();
		} else {

			$data['status_code'] = 400;
        	$data['status_message'] = "Error";
        	$data['data'] = $this->validator->errors();
        	
		}

       		return $response->withHeader('Content-type', 'application/json') 
       		->withJson($data, $data['status_code']);
	}

	public function updateBook($request, $response, $args)
	{
		$book = new BookModel($this->db);
		$findBook = $book->find('id', $args['id']);

		if ($findBook) {
			
		$this->validator->rule('required', ['title', 'short_desc', 'price', 'image', 'category_id']);
		$this->validator->rule('integer', 'id');

		if ($this->validator->validate()) {
			$book->updateData($request->getParams(), $args['id']);

			$data['status_code'] = 201;
        	$data['status_message'] = "Update data sukses";
        	$data['data'] = $request->getParams();


		} else {
			$data['status_code'] = 400;
        	$data['status_message'] = "Error";
        	$data['data'] = $this->validator->errors();

		}

  	} else {
  		$data['status_code'] = 404;
        $data['status_message'] = "Data Not Found";
  	}
  		return $response->withHeader('Content-type', 'application/json') 
       		->withJson($data, $data['status_code']);
   }

   public function delete($request, $response, $args)
   {
   		$book = new BookModel($this->db);
		$findBook = $book->find('id', $args['id']);

   		if ($findBook) {
   			$book->hardDelete($args['id']);

   			$data = $this->responseDetail(200, 'Success', 'Delete Data Succes');

   		} else {

   			$data = $this->responseDetail(200, 'Error', 'Page Not Found');

   		}

   		return $data;
   } 

	public function findBook($request, $response, $args)
	{
		$book = new BookModel($this->db);
		$findBook = $book->find('id', $args['id']);
		if ($findBook) {
			$data['status'] = 200;
			$data['message'] = 'Data Available';
			$data['data'] = $findBook;
		} else {
			$data['status'] = 404;
			$data['message'] = 'Data Not Found';
		}
		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}

	public function uploadBook($request, $response, $args)
   {
   		$book = new BookModel($this->db);
		$findBook = $book->find('id', $args['id']);
		$id = $args['id'];

   		if ($findBook) {
   			$book->upload($args['id']);

   			$data['status_code'] = 200;
        	$data['status_message'] = "Upload Book Succes";
        	$data['id'] = $id;
   		} else {
   			$data['status_code'] = 404;
        	$data['status_message'] = "Book Not Found";
   		}

   		return $response->withHeader('Content-type', 'application/json') 
       		->withJson($data, $data['status_code']);
   } 

   public function buyBook($request, $response, $args)
   {
   		$book = new BookModel($this->db);
		$findBook = $book->find('id', $args['id']);

		$token = $request->getHeader('Authorization')[0];

		$userToken = new \App\Models\Users\UserToken($this->db);
		$findToken = $userToken->find('token', $token);
		// var_dump($findToken);
		// die();

   		if ($findBook) {
		$data['book_id'] = $args['id'];
		$order = new \App\Models\OrderModel($this->db);

		$this->validator->rule('required', 'quantity');
		$this->validator->rule('numeric', 'quantity');
		$this->validator->rule('integer', ['id']);


		if ($this->validator->validate()) {
			$order->setQuantity($request->getParsedBody(), $args['id']);
			$data = $request->getParsedBody();
			
			$data = $this->responseDetail(201, 'Please fill quantity', $data, $findBook);

		} else {
			$data['status_code'] = 400;
        	$data['status_message'] = "Error";
        	$data['data'] = $this->validator->errors();

			$data = $this->responseDetail(400, 'Errors', $this->validator->errors());


		}
			return $data;
			// $invoice = new \App\Models\InvoiceModel($this->db);
			// $invoice->createInvoice($request->getParsedBody(), $args['id'], $findToken['user_id']);
			// $total = $request->getParsedBody();
			$buy = $book->find('id', $args['id']);
			$order = $request->getParsedBody();

			$data = $this->responseDetail(201, 'Book Succes Purchased', $buy, $order);
			
   			
   		} else {
			$data = $this->responseDetail(404, 'Error', 'Book Not Found');
   		}

   		return $data;

       	}

}















