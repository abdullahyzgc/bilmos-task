@extends('admin.layouts.app')

@section('title', 'Giriş/Çıkış Kayıtları')

@section('content')
<div class="container-fluid py-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0 p-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Yeni Giriş/Çıkış Kaydı</h5>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="collapse" 
                            data-bs-target="#newRecordForm" aria-expanded="false">
                        <i class="fas fa-plus me-2"></i>Yeni Kayıt
                    </button>
                </div>
                <div class="@if($errors->any()) show @endif collapse" id="newRecordForm" >
                    <div class="card-body">
                        <form action="{{ route('admin.attendance.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="filter-label">Personel</label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" 
                                            name="user_id" required>
                                        <option value="">Personel Seçin</option>
                                        @foreach(\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}" 
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} {{ $user->surname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="filter-label">Giriş Zamanı</label>
                                    <input type="datetime-local" 
                                           class="form-control @error('check_in') is-invalid @enderror" 
                                           name="check_in" value="{{ old('check_in') }}" required>
                                    @error('check_in')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="filter-label">Çıkış Zamanı</label>
                                    <input type="datetime-local" 
                                           class="form-control @error('check_out') is-invalid @enderror" 
                                           name="check_out" value="{{ old('check_out') }}">
                                    @error('check_out')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="filter-label">Geç Kalma Nedeni</label>
                                    <textarea class="form-control @error('late_reason') is-invalid @enderror" 
                                              name="late_reason" rows="2">{{ old('late_reason') }}</textarea>
                                    @error('late_reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="filter-label">Erken Çıkış Nedeni</label>
                                    <textarea class="form-control @error('early_leave_reason') is-invalid @enderror" 
                                              name="early_leave_reason" rows="2">{{ old('early_leave_reason') }}</textarea>
                                    @error('early_leave_reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Kaydet
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Kayıtlar</h5>
                </div>
                <div class="card-body">
                    <div class="filters">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="filter-label">Başlangıç Tarihi</label>
                                <input type="date" id="min" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Bitiş Tarihi</label>
                                <input type="date" id="max" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Personel</label>
                                <select id="user_filter" class="form-select">
                                    <option value="">Tümü</option>
                                    @foreach(\App\Models\User::all() as $user)
                                        <option value="{{ $user->name }} {{ $user->surname }}">
                                            {{ $user->name }} {{ $user->surname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Durum</label>
                                <select id="status_filter" class="form-select">
                                    <option value="">Tümü</option>
                                    <option value="Geç Giriş">Geç Giriş</option>
                                    <option value="Erken Çıkış">Erken Çıkış</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <table id="attendance-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Personel</th>
                                <th>Giriş Zamanı</th>
                                <th>Çıkış Zamanı</th>
                                <th>Durum</th>
                                <th>Açıklama</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceLogs as $log)
                            <tr>
                                <td>{{ $log->user->name }} {{ $log->user->surname }}</td>
                                <td data-sort="{{ $log->check_in }}">
                                    {{ $log->check_in->format('d.m.Y H:i') }}
                                </td>
                                <td data-sort="{{ $log->check_out }}">
                                    {{ $log->check_out ? $log->check_out->format('d.m.Y H:i') : '-' }}
                                </td>
                                <td>
                                    @if($log->is_late)
                                        <span class="badge bg-warning">Geç Giriş</span>
                                    @endif
                                    @if($log->is_early_leave)
                                        <span class="badge bg-warning">Erken Çıkış</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log->late_reason)
                                        <small class="d-block text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Geç Kalma: {{ $log->late_reason }}
                                        </small>
                                    @endif
                                    @if($log->early_leave_reason)
                                        <small class="d-block text-muted">
                                            <i class="fas fa-sign-out-alt me-1"></i>
                                            Erken Çıkış: {{ $log->early_leave_reason }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.attendance.edit', $log->id) }}" 
                                       class="btn btn-action btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.attendance.destroy', $log->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action btn-delete" 
                                                onclick="return confirm('Emin misiniz?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Custom date range filter
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var min = $('#min').val();
        var max = $('#max').val();
        var date = new Date(data[1]); // Giriş zamanı kolonunu kullan

        if (
            (min === '' && max === '') ||
            (min === '' && date <= new Date(max)) ||
            (new Date(min) <= date && max === '') ||
            (new Date(min) <= date && date <= new Date(max))
        ) {
            return true;
        }
        return false;
    });

    // DataTable initialization
    var table = $('#attendance-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json'
        },
        order: [[1, 'desc']], // Giriş zamanına göre sırala
        dom: '<"d-flex justify-content-between align-items-center mb-3"lB>rtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel fa-lg"></i>',
                className: 'dt-button excel-button',
                titleAttr: 'Excel\'e Aktar'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf fa-lg"></i>',
                className: 'dt-button pdf-button',
                titleAttr: 'PDF\'e Aktar'
            }
        ],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tümü"]]
    });

    // Filters
    $('#min, #max').on('change', function() {
        table.draw();
    });

    $('#user_filter').on('change', function() {
        table.column(0).search(this.value).draw();
    });

    $('#status_filter').on('change', function() {
        table.column(3).search(this.value).draw();
    });

    // Form collapse animation
    $('#newRecordForm').on('show.bs.collapse', function () {
        $(this).addClass('show');
    }).on('hide.bs.collapse', function () {
        $(this).removeClass('show');
    });
});
</script>
@endpush 