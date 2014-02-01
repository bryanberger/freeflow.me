<?php

class ViewController extends \BaseController {
	
	public function showIndex()
	{	
		$posts = Post::orderBy('created_at', 'DESC')->get();
		$count = count($posts);
		$args = array(
			'posts' => $posts,
			'count' => $count,
			'cdn_path' => 'https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/'
		);

    	return View::make('index', $args);
	}

	public function showDetail($name)
	{
		$post = Post::where('filename', $name)->first();

		$prev = Post::orderBy('id', 'DESC')
			->where('id', '<', $post->id)
			->first();

		$next = Post::orderBy('id', 'ASC')
			->where('id', '>', $post->id)
			->first();

		return View::make('detail', array(
			'post' => $post,
			'prev' => $prev,
			'next' => $next,
			'cdn_path' => 'https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/'));
	}
}