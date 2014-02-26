<?php

/* TODO
 *
 * Add tag filtering & date filtering
 *
 */

class SitemapController extends \BaseController {
	
	public function show() {
		// create new sitemap object
		$sitemap = App::make("sitemap");

		// set cache (key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean))
		// by default cache is disabled
		$sitemap->setCache('freeflow.sitemap', 1440); // 1 day

		// add item to the sitemap (url, date, priority, freq)
		$sitemap->add(URL::to('/'), date('c',time()), '1.0', 'daily');

		// get all posts from db
		$posts = DB::table('posts')->orderBy('created_at', 'desc')->get();

		// add every post to the sitemap
		foreach ($posts as $post) {
			$sitemap->add(URL::to('/').'/'.$post->filename, $post->updated_at, 0.5, 'monthly');
		}

		// show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
		return $sitemap->render('xml');
	}

}