<?php

class HomeController extends Controller {
	
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

}