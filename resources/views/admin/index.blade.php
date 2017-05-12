@extends('admin.layout.master')
@section('title')
    Xin chào {{ Authen::getCurrentUserName() }}
@stop
