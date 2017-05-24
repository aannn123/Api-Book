<?php 

namespace App\Models;

class OrderModel extends BaseModel
{
	protected $table = 'tbl_order';
	protected $column = ['id', 'quantity', 'subtotal'];

	public function setQuantity(array $data, $id)
	{
		$datas = 
		[
		"book_id" => $id,
		"quantity" => $data['quantity'],
		];

		$this->createData($datas);
	}
}
