<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
         $data[] = [
            'username'  =>  'admin',
            'email'  =>  'admin123@gmail.com',
            'password'  =>  password_hash('superadmin', PASSWORD_DEFAULT),
            'name'      =>  'Admin',
            'status'    =>  '0',
        ];

        $data[] = [
            'username'  =>  'kasir',
            'email'  =>  'kasir123@gmail.com',
            'password'  =>  password_hash('kasir', PASSWORD_DEFAULT),
            'name'      =>  'Kasir',
        ];

        $this->insert('users', $data);

    }
}
