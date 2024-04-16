<?php

class PostsTableSeeder extends Seeder {

    protected $content = 'post content';

    public function run()
    {
        DB::table('posts')->delete();

        $user_id = User::first()->id;

        DB::table('posts')->insert( array(
            array(
                'user_id'    => $user_id,
                'title'      => 'Lorem ipsum dolor sit amet',
                'slug'       => 'lorem-ipsum-dolor-sit-amet',
                'content'    => $this->content,
                'meta_title' => 'meta_title1',
                'meta_description' => 'meta_description1',
                'meta_keywords' => 'meta_keywords1',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'user_id'    => $user_id,
                'title'      => 'Vivendo suscipiantur vim te vix',
                'slug'       => 'vivendo-suscipiantur-vim-te-vix',
                'content'    => $this->content,
                'meta_title' => 'meta_title2',
                'meta_description' => 'meta_description2',
                'meta_keywords' => 'meta_keywords2',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'user_id'    => $user_id,
                'title'      => 'In iisque similique reprimique eum',
                'slug'       => 'in-iisque-similique-reprimique-eum',
                'content'    => $this->content,
                'meta_title' => 'meta_title3',
                'meta_description' => 'meta_description3',
                'meta_keywords' => 'meta_keywords3',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ))
        );
    }

}
