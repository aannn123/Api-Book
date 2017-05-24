<?php  

namespace App\Controllers;

use App\Models\CategoryModel;

class CategoryController extends BaseController
{
	public function index($request, $response)
	{
		$category = new CategoryModel($this->db);

		$getCategory = $category->getAll();
		// var_dump($getCategory);
		// die();
		$countCategory = count($getCategory);

		if ($getCategory) {
			$page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');

			$get = $category->paginate($page, $getCategory, 5);

			if ($get) {
				$data = $this->responseDetail(200, 'Data Available', $get, $this->paginate($countCategory, 5, $page, ceil($countCategory/5)));
			} else {
				$data = $this->responseDetail(404, 'Error', 'Data Not Found');
			}
		} else {
			$data = $this->responseDetail(204, 'Success', 'No Content');
		}
		
		return $data;
	}
		


	public function addCategory($request, $response)
	{
		$category = new CategoryModel($this->db);

		$this->validator->rule('required', 'name');
		$this->validator->rule('integer', 'id');

		if ($this->validator->validate()) {
			$category->createData($request->getParams());

			$data['status_code'] = 201;
        	$data['status_message'] = "Create data sukses";
        	$data['data'] = $request->getParams();

		} else {
			$data['status_code'] = 400;
        	$data['status_message'] = "Error";
        	$data['data'] = $this->validator->errors();
        	
		}

       		return $response->withHeader('Content-type', 'application/json') 
       		->withJson($data, $data['status_code']);
	}

	public function updateCategory($request, $response, $args)
	{
		$category = new CategoryModel($this->db);
		$findcategory = $category->find('id', $args['id']);

		if ($findcategory) {
			
		$this->validator->rule('required', 'name');
		$this->validator->rule('integer', 'id');

		if ($this->validator->validate()) {
			$category->updateData($request->getParams(), $args['id']);

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
   		$category = new CategoryModel($this->db);
		$findcategory = $category->find('id', $args['id']);

   		if ($findcategory) {
   			$category->hardDelete($args['id']);

   			$data['status_code'] = 200;
        	$data['status_message'] = "Delete Data Succes";
   		} else {
   			$data['status_code'] = 404;
        	$data['status_message'] = "Page Not Found";
   		}

   		return $response->withHeader('Content-type', 'application/json') 
       		->withJson($data, $data['status_code']);
   } 

}