<?php

/* TODO
 *
 * Add tag filtering & date filtering
 *
 */

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
		$max_days = '365';
		//$post = Post::where('filename', $name)->first();

		$posts = Post::all();
		$post_index = array_search($name, $posts->lists('filename'), true);

		// if fails to exist
		if($post_index === FALSE || $post_index === NULL)
			return Redirect::to('/');

		// determine post
		$post = $posts->get($post_index);
		$post->sequence_number = $post_index+1;
		
		// remove tags from the object since we exploded them ourselves
		$tags = explode(', ', $post->tags);
		unset($post->tags);

		// prev and next objects for simple pageination
		$prev = $posts->get($post_index-1);
		$next = $posts->get($post_index+1);

		return View::make('detail', array(
			'post' => $post,
			'prev' => $prev,
			'next' => $next,
			'tags' => $tags,
			'max_days' => $max_days,
			'cdn_path' => 'https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/'));
	}
}