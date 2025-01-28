@extends('admin.layouts.auth')

@section('title', 'Şifre Sıfırlama')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header text-center mb-4">
            <i class="fas fa-lock-open auth-logo"></i>
            <h4 class="auth-title">Şifre Sıfırlama</h4>
            <p class="auth-subtitle">E-posta adresinizi girin</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success alert-modern mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}" class="auth-form">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">E-posta Adresi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-paper-plane me-2"></i>Sıfırlama Bağlantısı Gönder
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('admin.login') }}" class="back-link">
                    <i class="fas fa-arrow-left me-2"></i>Giriş Sayfasına Dön
                </a>
            </div>
        </form>
    </div>
</div>
@endsection 