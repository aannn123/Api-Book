<?php

namespace App\Controllers;

class HomeController extends BaseController
{
        public function index($request, $response)
        {

        $data['status'] = 200;
        $data['message'] = "Request index";

        $data['data'] = "Welcome To Book Market Place, Please Login";

       return $response->withHeader('Content-type', 'application/json')
            ->withJson($data, $data['status']);

        }
}
