<?php

use Phinx\Migration\AbstractMigration;

class CreateTableTblInvoice extends AbstractMigration
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
        $total = $this->table('tbl_invoice');
        $total->addColumn('book_id', 'integer')
                ->addColumn('user_id', 'integer')
                ->addColumn('quantity', 'integer')
                ->addColumn('subtotal', 'integer', ['default' => 0])
                ->addForeignKey('book_id', 'book', 'id', ['delete'=>'CASCADE', 'update'=>'NO_ACTION'])
                ->addForeignKey('user_id', 'users', 'id', ['delete'=>'CASCADE', 'update'=>'NO_ACTION'])
                ->create();

    }
}