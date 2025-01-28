@extends('admin.layouts.app')

@section('title', 'Erişim Reddedildi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <h1 class="display-1">403</h1>
        <h2>Erişim Reddedildi</h2>
        <p class="lead">Bu sayfaya erişim yetkiniz bulunmamaktadır.</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Geri Dön</a>
    </div>
</div>
@endsection 