@extends('admin.layouts.auth')

@section('title', 'Yeni Şifre Belirleme')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header text-center mb-4">
            <i class="fas fa-key auth-logo"></i>
            <h4 class="auth-title">Yeni Şifre Belirleme</h4>
            <p class="auth-subtitle">Yeni şifrenizi belirleyin</p>
        </div>

        <form method="POST" action="{{ route('admin.password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ $request->email }}">

            <div class="mb-4">
                <label for="password" class="form-label">Yeni Şifre</label>
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
                <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" 
                           id="password_confirmation" name="password_confirmation" required>
                    <button type="button" class="input-group-text toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-save me-2"></i>Şifreyi Güncelle
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