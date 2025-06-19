@extends('errors::minimal')

@section('title', __('Terlalu Banyak Permintaan'))
@section('code', '429')
@section('message', __('Anda telah mengirim terlalu banyak permintaan dalam waktu singkat. Silakan coba lagi nanti.'))
@section('image', asset('static/img/error.gif'))
