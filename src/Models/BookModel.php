<?php 

 namespace App\Models;

 class BookModel extends BaseModel
 {
 	protected $table = 'book';
    protected $column = '*';

 	public function getAll()
        {
            $qb = $this->db->createQueryBuilder();
                $qb->select('*')
                                 ->from($this->table)
                                 ->where('status = 1');
                $query = $qb->execute();
                return $query->fetchAll();
        }

    public function getAllSold()
        {
            $qb = $this->db->createQueryBuilder();

                $qb->select('*')
                                 ->from($this->table)
                                 ->where('status = 2');
                $query = $qb->execute();
                return $query->fetchAll();
        }

       public function upload($id)
        {
            $qb = $this->db->createQueryBuilder();

                $qb->update($this->table)
                                 ->set('status', '2')
                                 ->where('id = ' . $id)
                                 ->execute();
        }

 }