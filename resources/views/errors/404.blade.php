@extends('admin.layouts.app')

@section('title', 'Sayfa Bulunamadı')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <h1 class="display-1">404</h1>
        <h2>Sayfa Bulunamadı</h2>
        <p class="lead">Aradığınız sayfa bulunamadı veya taşınmış olabilir.</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Geri Dön</a>
    </div>
</div>
@endsection 