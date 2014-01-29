@extends('layouts.master-admin')
@section('content')
	<h2>{{ $post->name }}</h2>
	<div><img src="{{ $cdn_path . $post->filename}}_560.jpg"></div>
@stop