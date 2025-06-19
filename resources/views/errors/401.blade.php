@extends('errors::minimal')

@section('title', __('Akses Ditolak'))
@section('code', '401')
@section('message', __('Anda tidak memiliki izin untuk mengakses halaman ini.'))
@section('image', asset('static/img/error.gif'))
