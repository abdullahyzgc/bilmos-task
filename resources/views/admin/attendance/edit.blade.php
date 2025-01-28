@extends('admin.layouts.app')

@section('title', 'Giriş/Çıkış Kaydı Düzenle')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="m-0 p-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Giriş/Çıkış Kaydı Düzenle</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Personel</label>
                        <input type="text" class="form-control" 
                               value="{{ $attendance->user->name }} {{ $attendance->user->surname }}" 
                               disabled>
                    </div>

                    <div class="mb-3">
                        <label for="check_in" class="form-label">Giriş Zamanı</label>
                        <input type="datetime-local" 
                               class="form-control @error('check_in') is-invalid @enderror" 
                               name="check_in" 
                               value="{{ old('check_in', $attendance->check_in->format('Y-m-d\TH:i')) }}" 
                               required>
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="check_out" class="form-label">Çıkış Zamanı</label>
                        <input type="datetime-local" 
                               class="form-control @error('check_out') is-invalid @enderror" 
                               name="check_out" 
                               value="{{ old('check_out', $attendance->check_out ? $attendance->check_out->format('Y-m-d\TH:i') : '') }}">
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="late_reason" class="form-label">Geç Kalma Nedeni</label>
                        <textarea class="form-control @error('late_reason') is-invalid @enderror" 
                                  name="late_reason" 
                                  rows="2">{{ old('late_reason', $attendance->late_reason) }}</textarea>
                        @error('late_reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="early_leave_reason" class="form-label">Erken Çıkış Nedeni</label>
                        <textarea class="form-control @error('early_leave_reason') is-invalid @enderror" 
                                  name="early_leave_reason" 
                                  rows="2">{{ old('early_leave_reason', $attendance->early_leave_reason) }}</textarea>
                        @error('early_leave_reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Güncelle</button>
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">İptal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 