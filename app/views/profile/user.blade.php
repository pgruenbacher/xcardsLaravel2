@extends('layout.main')

@section('content')
	<p>{{e($user->user)}} ({{e($user->email)}})</p>
	
@stop
