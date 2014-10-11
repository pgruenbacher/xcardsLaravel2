@extends('layout.main')
@section('header')
<!-- Datatables -->
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.4/js/TableTools.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.css">
<style>
	div.address-book_paginate{
		display: inline-block;
		padding-left: 0px;
		margin: 21px 0px;
		border-radius: 4px;
	}
	a.first{
		margin-left: 0px;
		border-bottom-left-radius: 4px;
		border-top-left-radius: 4px;
	}
	a.last{
		border-bottom-right-radius: 6px;
		border-top-right-radius: 6px;
	}
	a.paginate_button{
		position: relative;
		float: left;
		padding: 10px 15px;
		line-height: 1.42857;
		text-decoration: none;
		color: #FFF;
		background-color: #18BC9C;
		border: 1px solid transparent;
		margin-left: -1px;
	}
	a.paginate_button:hover {
		color: #FFF;
		background-color: #0F7864;
		border-color: transparent;
		cursor:hand;
	}
	a.paginate_active {
		position: relative;
		float: left;
		padding: 10px 15px;
		line-height: 1.42857;
		text-decoration: none;
		z-index: 2;
		color: #FFF;
		background-color: #0F7864;
		border-color: transparent;
		cursor: default;
		border: 1px solid transparent;
		margin-left: -1px;
	}
	a.paginate_button_active:hover{
		z-index: 2;
		color: #FFF;
		background-color: #0F7864;
		border-color: transparent;
		cursor: default;
	}
	a.paginate_button_disabled,a.paginate_button_disabled:hover {
		color: #ECF0F1;
		background-color: #3BE6C4;
		border-color: transparent;
		cursor: not-allowed;
	}
</style>

@stop