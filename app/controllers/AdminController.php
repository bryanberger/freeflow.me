<?php

/*
GET			/resource	index	resource.index
GET			/resource/create	create	resource.create
POST		/resource	store	resource.store
GET			/resource/{resource}	show	resource.show
GET			/resource/{resource}/edit	edit	resource.edit
PUT/PATCH	/resource/{resource}	update	resource.update
DELETE		/resource/{resource}	destroy	resource.destroy
*/

class AdminController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Post::orderBy('created_at', 'DESC')->get();
		$args = array(
			'posts' => $posts,
			'cdn_path' => $this->getCDNPath(NULL)
		);

    	return View::make('admin.index', $args);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * validate the inputs
	 * send back error messages if they exist
	 * authenticate against the database
	 * store the resource if all is good
	 *
	 * @return Response
	 */
	public function store()
	{
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'       	=> 'required|regex:/^[a-z0-9 ]+$/i',
			'filename'		=> 'required|alpha_num',
			'tags'		 	=> 'required|regex:/^[a-z,0-9 ]+$/i',
			'hasWallpaper'	=> 'digits:1',
			'hasBuyOptions'	=> 'digits:1',
			'hasPsd'		=> 'digits:1'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/create')
				->withErrors($validator)
				->withInput();
		} else {
			// store
			$post = new Post;
			$post->name			 = Input::get('name');
			$post->filename		 = strtolower(Input::get('filename'));
			$post->tags			 = Input::get('tags');
			$post->hasWallpaper  = Input::get('hasWallpaper', 0);
			$post->hasBuyOptions = Input::get('hasBuyOptions', 0);
			$post->hasPsd		 = Input::get('hasBuyOptions', 0);

			// extract color palette
			$image = ColorExtractor::loadJpeg(public_path() . '/assets/imgs/art/' . $post->filename . '_560.jpg');
			$post->palette = $image->extract(8);

			// save to DB
			$post->save();

			// clear cache
			Cache::flush();
			
			// redirect
			Session::flash('message', 'Successfully created ' . $post->name);
			return Redirect::to('admin');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// unneeded for this project
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$post = Post::find($id);
		$args = array(
			'post' => $post,
			'id' => $id,
			'cdn_path' => $this->getCDNPath(NULL)
		);
		return View::make('admin.edit', $args);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'       	=> 'required|regex:/^[a-z0-9 ]+$/i',
			'filename'		=> 'required|alpha_num',
			'tags'		 	=> 'required|regex:/^[a-z,0-9 ]+$/i',
			'hasWallpaper'	=> 'digits:1',
			'hasBuyOptions'	=> 'digits:1',
			'hasPsd'		=> 'digits:1'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/' . $id . '/edit')
				->withErrors($validator)
				->withInput();
		} else {
			// store
			$post = Post::find($id);
			$post->name			 = Input::get('name');
			$post->tags			 = Input::get('tags');
			$post->filename		 = strtolower(Input::get('filename'));
			$post->hasWallpaper  = Input::get('hasWallpaper', 0);
			$post->hasBuyOptions = Input::get('hasBuyOptions', 0);
			$post->hasPsd		 = Input::get('hasBuyOptions', 0);

			// extract color palette
			$image = ColorExtractor::loadJpeg(public_path() . '/assets/imgs/art/' . $post->filename . '_560.jpg');
			$post->palette = $image->extract(8);

			// save to DB
			$post->save();

			// clear cache
			Cache::flush();

			// redirect
			Session::flash('message', 'Successfully updated ' . $post->name);
			return Redirect::to('admin');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$post = Post::find($id);
		$post->delete();

		// redirect
		Session::flash('message', 'Successfully deleted ' . $post->name);
		return Redirect::to('admin');
	}

}