@if (session('success'))
  <div class="alert alert-success d-flex align-items-start gap-2 py-2 px-3 mb-3" role="alert" style="font-size: 0.85rem;">
    <i class="bi bi-check-circle-fill mt-1"></i>
    <div>{{ session('success') }}</div>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger d-flex align-items-start gap-2 py-2 px-3 mb-3" role="alert" style="font-size: 0.85rem;">
    <i class="bi bi-exclamation-triangle-fill mt-1"></i>
    <div>{{ session('error') }}</div>
  </div>
@endif

@if ($errors->any())
  <div class="alert alert-danger d-flex align-items-start gap-2 py-2 px-3 mb-3" role="alert" style="font-size: 0.85rem;">
    <i class="bi bi-exclamation-triangle-fill mt-1"></i>
    <div>
      <strong class="d-block mb-1">Periksa kembali data Anda:</strong>
      <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
