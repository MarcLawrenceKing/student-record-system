{{-- Toasts for Success and Error --}}
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1055">

  {{-- Success Toast --}}
  @if(session('success'))
    <div id="successToast" class="toast text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        {{ session('success') }}
      </div>
    </div>
  @endif

  {{-- Error Toast --}}
  @if(session('error'))
    <div id="errorToast" class="toast text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-danger text-white">
        <strong class="me-auto">Error</strong>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        {{ session('error') }}
      </div>
    </div>
  @endif

</div>

{{-- Initialize Toasts --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const toastElList = [].slice.call(document.querySelectorAll('.toast'));
  toastElList.forEach(function(toastEl) {
    new bootstrap.Toast(toastEl, { delay: 5000 }).show();
  });
});
</script>
