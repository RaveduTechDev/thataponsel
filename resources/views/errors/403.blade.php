@extends('errors::minimal')

@section('title', __('Akses Ditolak'))
@section('code', '403')
@section('message', __('Anda tidak memiliki izin untuk mengakses sumber daya ini.'))
@section('image', asset('static/img/error.gif'))
