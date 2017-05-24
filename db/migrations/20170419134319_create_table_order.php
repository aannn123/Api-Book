<?php

use Phinx\Migration\AbstractMigration;

class CreateTableOrder extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
       $product = $this->table('tbl_order');
        $product->addColumn('book_id', 'integer')
                ->addColumn('quantity', 'integer')
                // ->addColumn('update_at', 'timestamp')
                ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                ->addForeignKey('book_id', 'book', 'id', ['delete'=>'CASCADE', 'update'=>'NO_ACTION'])
                ->create();            
    }
}
