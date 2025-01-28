@extends('admin.layouts.app')

@section('title', 'Personel Detay')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="fas fa-user me-2"></i>Personel Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle-large mx-auto mb-3 bg-primary">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h5 class="mb-1">{{ $user->name }} {{ $user->surname }}</h5>
                        <p class="text-muted mb-0">Personel #{{ $user->id }}</p>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted"><i class="fas fa-envelope me-2"></i>E-posta</span>
                                <span>{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted"><i class="fas fa-phone me-2"></i>Telefon</span>
                                <span>{{ $user->phone }}</span>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted"><i class="fas fa-calendar me-2"></i>Kayıt Tarihi</span>
                                <span>{{ $user->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Geri
                        </a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Düzenle
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="fas fa-clock me-2"></i>Giriş/Çıkış Kayıtları
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tarih</th>
                                    <th>Giriş</th>
                                    <th>Çıkış</th>
                                    <th>Durum</th>
                                    <th>Açıklama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->attendanceLogs as $log)
                                <tr>
                                    <td>{{ $log->check_in->format('d.m.Y') }}</td>
                                    <td>
                                        <span class="text-{{ $log->is_late ? 'danger' : 'success' }}">
                                            <i class="fas fa-sign-in-alt me-1"></i>
                                            {{ $log->check_in->format('H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($log->check_out)
                                            <span class="text-{{ $log->is_early_leave ? 'danger' : 'success' }}">
                                                <i class="fas fa-sign-out-alt me-1"></i>
                                                {{ $log->check_out->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->is_late)
                                            <span class="badge bg-danger">Geç Giriş</span>
                                        @endif
                                        @if($log->is_early_leave)
                                            <span class="badge bg-warning">Erken Çıkış</span>
                                        @endif
                                        @if(!$log->is_late && !$log->is_early_leave)
                                            <span class="badge bg-success">Normal</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->late_reason)
                                            <small class="text-danger d-block">
                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                {{ $log->late_reason }}
                                            </small>
                                        @endif
                                        @if($log->early_leave_reason)
                                            <small class="text-warning d-block">
                                                <i class="fas fa-info-circle me-1"></i>
                                                {{ $log->early_leave_reason }}
                                            </small>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    font-weight: bold;
}

.list-group-item {
    border-left: 0;
    border-right: 0;
}

.table td {
    vertical-align: middle;
}
</style>
@endsection 