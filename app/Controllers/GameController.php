<?php
namespace App\Controllers;

class GameController{
	public function __invoke($request, $response){
		$this->getData($request->getParam("data"));
	}
	public function getData($data){
		print $data;
	}
}