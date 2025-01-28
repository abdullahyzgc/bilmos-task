@extends('admin.layouts.app')

@section('title', 'API Dokümantasyonu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="fas fa-book me-2"></i>API Dokümantasyonu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="endpoint-section mb-5">
                        <h4 class="border-bottom pb-2">
                            <i class="fas fa-key me-2"></i>Kimlik Doğrulama
                        </h4>
                        
                        <div class="endpoint-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2">POST</span>
                                <code class="fs-6">/api/v1/register</code>
                            </div>
                            <p class="text-muted mb-2">Yeni personel kaydı oluşturur</p>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">İstek Gövdesi:</h6>
                                <pre class="bg-light p-3 rounded"><code>{
    "name": "John",
    "surname": "Doe",
    "phone": "5551234567",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}</code></pre>
                            </div>
                        </div>

                        <div class="endpoint-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2">POST</span>
                                <code class="fs-6">/api/v1/login</code>
                            </div>
                            <p class="text-muted mb-2">Personel girişi yapar ve token döner</p>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">İstek Gövdesi:</h6>
                                <pre class="bg-light p-3 rounded"><code>{
    "email": "john@example.com",
    "password": "password123"
}</code></pre>
                            </div>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">Başarılı Yanıt:</h6>
                                <pre class="bg-light p-3 rounded"><code>{
    "status": "success",
    "message": "Giriş başarılı",
    "data": {
        "token": "1|abcdef123456...",
        "user": {
            "id": 1,
            "name": "John",
            "surname": "Doe",
            "email": "john@example.com"
        }
    }
}</code></pre>
                            </div>
                        </div>

                        <div class="endpoint-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2">POST</span>
                                <code class="fs-6">/api/v1/forgot-password</code>
                            </div>
                            <p class="text-muted mb-2">Şifre sıfırlama bağlantısı gönderir</p>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">İstek Gövdesi:</h6>
                                <pre class="bg-light p-3 rounded"><code>{
    "email": "john@example.com"
}</code></pre>
                            </div>
                        </div>

                        <div class="endpoint-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2">POST</span>
                                <code class="fs-6">/api/v1/reset-password</code>
                            </div>
                            <p class="text-muted mb-2">Şifre sıfırlama işlemini gerçekleştirir</p>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">İstek Gövdesi:</h6>
                                <pre class="bg-light p-3 rounded"><code>{
    "token": "reset-token",
    "email": "john@example.com",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}</code></pre>
                            </div>
                        </div>

                        <div class="endpoint-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2">POST</span>
                                <code class="fs-6">/api/v1/logout</code>
                            </div>
                            <p class="text-muted mb-2">Oturumu sonlandırır</p>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">Header:</h6>
                                <pre class="bg-light p-3 rounded"><code>Authorization: Bearer {token}</code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="endpoint-section mb-5">
                        <h4 class="border-bottom pb-2">
                            <i class="fas fa-clock me-2"></i>Giriş/Çıkış İşlemleri
                        </h4>
                        
                        <div class="endpoint-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2">POST</span>
                                <code class="fs-6">/api/v1/check-in</code>
                            </div>
                            <p class="text-muted mb-2">Giriş kaydı oluşturur</p>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">Header:</h6>
                                <pre class="bg-light p-3 rounded"><code>Authorization: Bearer {token}
Content-Type: application/json</code></pre>
                            </div>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">İstek Gövdesi:</h6>
                                <pre class="bg-light p-3 rounded"><code>{
    "late_reason": "Trafik yoğunluğu" // Opsiyonel, geç kalma durumunda
}</code></pre>
                            </div>
                        </div>

                        <div class="endpoint-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2">POST</span>
                                <code class="fs-6">/api/v1/check-out</code>
                            </div>
                            <p class="text-muted mb-2">Çıkış kaydı oluşturur</p>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">Header:</h6>
                                <pre class="bg-light p-3 rounded"><code>Authorization: Bearer {token}
Content-Type: application/json</code></pre>
                            </div>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">İstek Gövdesi:</h6>
                                <pre class="bg-light p-3 rounded"><code>{
    "early_leave_reason": "Doktor randevusu" // Opsiyonel, erken çıkış durumunda
}</code></pre>
                            </div>
                        </div>

                        <div class="endpoint-item">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2">GET</span>
                                <code class="fs-6">/api/v1/attendance-logs</code>
                            </div>
                            <p class="text-muted mb-2">Giriş/çıkış kayıtlarını listeler</p>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">Query Parametreleri:</h6>
                                <ul class="list-unstyled">
                                    <li><code>start_date</code> - Başlangıç tarihi (YYYY-MM-DD)</li>
                                    <li><code>end_date</code> - Bitiş tarihi (YYYY-MM-DD)</li>
                                </ul>
                            </div>
                            
                            <div class="mt-3">
                                <h6 class="fw-bold">Header:</h6>
                                <pre class="bg-light p-3 rounded"><code>Authorization: Bearer {token}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.endpoint-item {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
}

.endpoint-item:last-child {
    margin-bottom: 0;
}

pre {
    margin: 0;
}

code {
    color: #e83e8c;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5em 0.8em;
}
</style>
@endsection