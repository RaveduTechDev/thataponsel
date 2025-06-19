@extends('errors::minimal')

@section('title', __('Layanan Tidak Tersedia'))
@section('code', '503')
@section('message', __('Layanan tidak tersedia saat ini. Silakan coba lagi nanti.'))
@section('image', asset('static/img/error.gif'))
