<?php

use Phinx\Seed\AbstractSeed;

class Categories extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data[] = ['name'  =>  'Martial Arts'];
        $data[] = ['name'  =>  'History'];
        $data[] = ['name'  =>  'Math'];
        $data[] = ['name'  =>  'Religi'];
        $data[] = ['name'  =>  'Comic'];
        $data[] = ['name'  =>  'Novel'];

        $this->insert('category', $data);

    }
}
