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
			'cdn_path' => $this->_getCDNPath(NULL)
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
			'cdn_path' => $this->_getCDNPath('840/'.$name.'_840')));
	}

	private function _getCDNPath($name) {
		if($name === NULL) {
			$name = 'humhum_560'; // humhum is the smallest image filesize wise.
		}

		// check if cached
		if (Cache::has('dropbox_status_code')) {
			$status_code = Cache::get('dropbox_status_code');
		} else {
			// we don't have a cached status_code so grab one and store it for a few hours
			$request = Requests::get('https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/'.$name.'.jpg');
			$status_code = $request->status_code;
			Cache::put('dropbox_status_code', $status_code, 60);
		}

		// if dropbox has blocked us because of bandwidth limits, use local files
		if($status_code === 509 || $status_code  === 404) {
			$cdn_path = 'assets/imgs/art/';
		} else {
			$cdn_path = 'https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/';
		}

		return $cdn_path;
	}
}