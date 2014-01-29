@extends('layouts.master-admin')
@section('content')
<h1>All Posts</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Thumbnail</td>
			<td>Date Posted</td>
		</tr>
	</thead>
	<tbody>
	@foreach($posts as $post)
		<tr>
			<td>{{ $post->id }}</td>
			<td>{{ $post->name }}</td>
			<td><a href="/admin/{{ $post->id }}/edit"><img width="140" height="140" src="{{ $cdn_path . $post->filename}}_560.jpg"></a></td>
			<td>{{ $post->created_at }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
@stop