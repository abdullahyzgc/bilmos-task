@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-title">Dashboard</h1>
        <div class="header-actions">
            <span class="current-date text-muted">{{ now()->format('d F Y, l') }}</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="stat-card bg-gradient-primary text-white">
                <div class="stat-card-inner">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-title">Toplam Personel</h5>
                        <h2 class="stat-value mb-0">{{ $stats['total_users'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg-gradient-success text-white">
                <div class="stat-card-inner">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-title">Bugün Giriş Yapanlar</h5>
                        <h2 class="stat-value mb-0">{{ $stats['today_attendance'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg-gradient-warning text-white">
                <div class="stat-card-inner">
                    <div class="stat-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-title">Geç Gelenler</h5>
                        <h2 class="stat-value mb-0">{{ $stats['late_entries'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg-gradient-danger text-white">
                <div class="stat-card-inner">
                    <div class="stat-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-title">Erken Çıkanlar</h5>
                        <h2 class="stat-value mb-0">{{ $stats['early_leaves'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Hızlı Erişim</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('admin.attendance.index') }}" class="quick-action-card">
                                <div class="quick-action-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h5>Giriş/Çıkış Kayıtları</h5>
                                    <p class="text-muted mb-0">Personel giriş çıkışlarını yönetin</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 