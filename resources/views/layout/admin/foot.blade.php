<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; {{ env('APP_NAME') }} {{ Carbon\Carbon::now()->format('Y') }}</span>
        </div>
    </div>
</footer>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script>
    $('#logout').click(() => {
        Swal.fire({
            title: "Apa Kamu Yakin?",
            html: "Yakin Keluar Dari Aplikasi?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/logout";
            }
        });
    })
</script>
