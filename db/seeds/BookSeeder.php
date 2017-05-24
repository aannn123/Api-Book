<?php

use Phinx\Seed\AbstractSeed;

class BookSeeder extends AbstractSeed
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
        for ($i = 0; $i < 10 ; $i++) {
            $data[] = [
                'category_id'   =>  '2',
                'title'         =>  'Manga',
                'short_desc'    =>  'Manga Anime',
                'price'         =>  '50000',
                'image'         =>  'default-thumbnail.jpg',
                'status'         =>   '1',

            ];
        }

        $this->insert('book', $data);
    }
}
