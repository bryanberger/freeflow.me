<?php

class BaseController extends Controller
{

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if (!is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

	protected function getCDNPath($name)
	{
		return 'https://freeflow.me/assets/imgs/art/';

		if ($name === NULL) {
			$name = 'humhum_560'; // humhum is the smallest image filesize wise.
		}

		// check if cached
		if (Cache::has('dropbox_status_code')) {
			$status_code = Cache::get('dropbox_status_code');
		} else {
			// we don't have a cached status_code so grab one and store it for a few hours
			$request = Requests::get('https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/' . $name . '.jpg');
			$status_code = $request->status_code;
			Cache::put('dropbox_status_code', $status_code, 60);
		}

		// if dropbox has blocked us because of bandwidth limits, use local files
		if ($status_code === 509 || $status_code  === 404) {
			$cdn_path = 'https://freeflow.me/assets/imgs/art/';
		} else {
			$cdn_path = 'https://dl.dropboxusercontent.com/u/584602/freeflow.me/imgs/art/';
		}

		return $cdn_path;
	}
}
