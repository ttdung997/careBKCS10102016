@extends('staff.layout.master')
@section('title')
    Xin chào {{ Auth::user()->name }}
@stop
