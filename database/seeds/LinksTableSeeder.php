<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('links')->insert([
            'links_name' => '学并思',
            'links_url' => 'http://bbs.xuebingsi.com',
            'links_explain' => '学并思PHP问答社区',
            'links_order' => 1,
        ]);
    }
}
