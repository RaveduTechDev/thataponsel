<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        @if (session('success'))
            Toast.fire({
                icon: "success",
                text: "{{ session('success') }}",
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: "error",
                text: "{{ session('error') }}",
            });
        @endif

        @if (session('warning'))
            Toast.fire({
                icon: "warning",
                text: "{{ session('warning') }}",
            });
        @endif

        @if (session('info'))
            Toast.fire({
                icon: "info",
                text: "{{ session('info') }}",
            });
        @endif
    });
</script>
