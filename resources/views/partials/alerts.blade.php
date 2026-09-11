@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4 rounded-4" style="background-color: #E8F8F0; color: #0E6245; border-left: 5px solid #10B981 !important;" role="alert">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-check-circle-fill fs-4 text-success"></i>
            <div>
                <strong class="d-block">¡Excelente!</strong>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4 rounded-4" style="background-color: #FDE8E8; color: #9B1C1F; border-left: 5px solid #EF4444 !important;" role="alert">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i>
            <div>
                <strong class="d-block">Atención</strong>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm p-3 mb-4 rounded-4 position-relative" style="background-color: #FDE8E8; color: #9B1C1F; border-left: 5px solid #EF4444 !important;" role="alert">
        <div class="d-flex align-items-start gap-3">
            <i class="bi bi-shield-exclamation fs-4 text-danger mt-1"></i>
            <div class="flex-grow-1">
                <strong class="d-block mb-1">Por favor verifica los siguientes campos:</strong>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close shadow-none position-absolute top-0 end-0 m-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

