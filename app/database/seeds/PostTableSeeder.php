<?php

class PostTableSeeder extends Seeder {

	public function run()
	{
		DB::table('posts')->delete();

		Post::create(array(
			'name' => 'Heart',
			'filename' => 'heart',
			'tags' => 'vector',
			'hasBuyOptions' => true,
			'hasWallpaper' => true
		));

		Post::create(array(
			'name' => 'Storm Trooper',
			'filename' => 'stormtrooper',
			'tags' => 'fan art, star wars, storm trooper',
			'hasBuyOptions' => true,
			'hasWallpaper' => true
		));

		Post::create(array(
			'name' => 'Tricular',
			'filename' => 'tricular',
			'tags' => 'geometric, vector',
			'hasBuyOptions' => true,
			'hasWallpaper' => true
		));

		Post::create(array(
			'name' => 'Irn',
			'filename' => 'irn',
			'tags' => 'fan art, iron man, mask',
			'hasBuyOptions' => true,
			'hasWallpaper' => true
		));

		Post::create(array(
			'name' => 'Mask',
			'filename' => 'mask',
			'tags' => 'misc',
			'hasBuyOptions' => true,
			'hasWallpaper' => true
		));
	}
}