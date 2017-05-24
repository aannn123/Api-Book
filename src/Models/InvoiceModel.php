<?php 

namespace App\Models;

class InvoiceModel extends BaseModel 
{
	protected $table = "tbl_invoice";
	protected $column = ['id', 'book_id', 'user_id', 'quantity', 'subtotal'];

	public function createInvoice(array $data, $id, $user_id)
	{
	
		$data = 
		[
			'book_id' => $id,
			'user_id' => $user_id,
			'quantity' => $data['quantity'],
		];

		$this->createData($data);
	}
}
