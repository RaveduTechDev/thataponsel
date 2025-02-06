@extends('layouts.app')

@section('content')
    <section class="row">
        <div class="card">
            <div class="card-header">
                <h3>Wellcome</h3>
            </div>

            <div class="card-body">
                <p>Hi, {{ Auth::user()->name }} 😇</p>
            </div>
        </div>
    </section>
@endsection
