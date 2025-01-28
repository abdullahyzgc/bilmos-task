@extends('admin.layouts.auth')

@section('title', 'Giriş')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header text-center mb-4">
            <i class="fas fa-shield-alt auth-logo"></i>
            <h4 class="auth-title">Admin Panel</h4>
            <p class="auth-subtitle">Yönetici Girişi</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}" class="auth-form">
            @csrf
            <div class="mb-3">
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

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="password" class="form-label mb-0">Şifre</label>
                    <a href="{{ route('admin.password.request') }}" class="forgot-link">
                        Şifremi Unuttum
                    </a>
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required>
                    <button type="button" class="input-group-text toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Beni Hatırla</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.toggle-password').click(function() {
        const input = $(this).prev('input');
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
</script>
@endpush 