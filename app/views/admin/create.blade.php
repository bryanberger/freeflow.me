@extends('layouts.admin.master')
@section('content')
<h1>Create a Post</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => 'admin', 'class' => 'form-horizontal', 'role' => 'form')) }}
	<div class="form-group">
		{{ Form::label('name', 'Name', array('class' => 'col-sm-1 control-label')) }}
		<div class="col-sm-4">
			{{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Name')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('filename', 'File Name', array('class' => 'col-sm-1 control-label')) }}
		<div class="col-sm-4">
			{{ Form::text('filename', Input::old('filename'), array('class' => 'form-control', 'placeholder' => 'Filename')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('tags', 'Tags', array('class' => 'col-sm-1 control-label')) }}
		<div class="col-sm-4">
			{{ Form::text('tags', Input::old('tags'), array('class' => 'form-control', 'placeholder' => 'tag1, tag2, tag3')) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-1 col-sm-4">
			<div class="checkbox">
				{{ Form::label('hasWallpaper', 'Has Wallpaper?') }}
				{{ Form::checkbox('hasWallpaper', '1') }}
			</div>
			<div class="checkbox">
				{{ Form::label('hasBuyOptions', 'For Sale?') }}
				{{ Form::checkbox('hasBuyOptions', '1') }}
			</div>
		</div>
	</div>

	<div class="form-group">
	    <div class="col-sm-offset-1 col-sm-4">
	    	{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
	    </div>
  	</div>	
{{ Form::close() }}
@stop