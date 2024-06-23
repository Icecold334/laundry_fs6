<!-- Bootstrap core JavaScript-->
<script src="/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.6/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<!-- Core plugin JavaScript-->
<script src="/dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/dashboard/js/sb-admin-2.js"></script>
<script>
    $('input').attr('autocomplete', 'off');
    /* Fungsi formatRupiah */
    function rupiah(angka, prefix) {
        var number_string = angka.replace(/[^\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function mustNumeric(angka) {
        return angka.replace(/[^\d.]/g, '').toString()
    }
</script>
{{-- @if (Auth::user()->role == 1)
    <script>
        window.onload = function() {

            var channel = Echo.channel('alert-channel');
            channel.listen("AlertEvent", function(data) {
                var Toast = Swal.mixin({
                    toast: true,
                    position: "top-start",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    showCloseButton: true,
                    icon: "info",
                    html: data.alert
                });
            })
        }
    </script>
@endif --}}

<script>
    // let user = JSON.parse('{!! json_encode(Auth::user()) !!}')
    // window.onload = function() {

    //     var channel = Echo.channel('alert-channel');
    //     channel.listen("AlertEvent", function(data) {
    //         var icon
    //         if (data.color == "secondary") {
    //             icon = 'info'
    //         } else if (data.icon == 'danger') {
    //             icon = 'error'
    //         } else {
    //             icon = data.color
    //         }
    //         setTimeout(() => {
    //             if (data.user_id == user.id) {
    //                 $('#alert').prepend($(
    //                     `<a class="dropdown-item d-flex align-items-center" href="${data.link}"><div class="mr-3"><div class="icon-circle bg-${data.color}"><i class="${data.icon} text-white" aria-hidden="true"></i></div></div><div><div class="small text-gray-500">${data.time}</div><span class="font-weight-bold">${data.alert}</span></div></a>`
    //                 ))
    //                 $('#notif-table').prepend($(
    //                     `<tr><th class="align-middle" style="width: 10%">
    //                             <div class="icon-circle bg-secondary">
    //                                 <i class="${data.icon} text-white" aria-hidden="true"></i>
    //                             </div>
    //                         </th>
    //                         <th class="align-middle" style="width: ">
    //                             <span class="d-flex small text-gray-500">${data.time}</span>
    //                             <a href="${data.link}" class="text-black">${data.alert}</a>
    //                         </th>
    //                         <th class="align-middle" style="width: 5%">

    //                         </th></tr>`
    //                 ))
    //                 if ($('#alert a').length >= 3) {
    //                     $('#alert a').last().remove();
    //                 }
    //                 var Toast = Swal.mixin({
    //                     toast: true,
    //                     position: "top-start",
    //                     showConfirmButton: false,
    //                     timer: 3000,
    //                     timerProgressBar: true,
    //                     didOpen: (toast) => {
    //                         toast.onmouseenter = Swal.stopTimer;
    //                         toast.onmouseleave = Swal.resumeTimer;
    //                     }
    //                 });
    //                 Toast.fire({
    //                     showCloseButton: true,
    //                     icon: icon,
    //                     html: data.alert
    //                 });

    //             } else if (data.role.includes(user.role)) {
    //                 $('#alert').prepend($(
    //                     `<a class="dropdown-item d-flex align-items-center" href="${data.link}"><div class="mr-3"><div class="icon-circle bg-${data.color}"><i class="${data.icon} text-white" aria-hidden="true"></i></div></div><div><div class="small text-gray-500">${data.time}</div><span class="font-weight-bold">${data.alert}</span></div></a>`
    //                 ))
    //                 $('#notif-table').prepend($(
    //                     `<tr><th class="align-middle" style="width: 10%">
    //                             <div class="icon-circle bg-secondary">
    //                                 <i class="${data.icon} text-white" aria-hidden="true"></i>
    //                             </div>
    //                         </th>
    //                         <th class="align-middle" style="width: ">
    //                             <span class="d-flex small text-gray-500">${data.time}</span>
    //                             <a href="${data.link}" class="text-black">${data.alert}</a>
    //                         </th>
    //                         <th class="align-middle" style="width: 5%">

    //                         </th>
    //                         </tr>`
    //                 ))
    //                 if ($('#alert a').length >= 3) {
    //                     $('#alert a').last().remove();
    //                 }
    //                 var Toast = Swal.mixin({
    //                     toast: true,
    //                     position: "top-start",
    //                     showConfirmButton: false,
    //                     timer: 3000,
    //                     timerProgressBar: true,
    //                     didOpen: (toast) => {
    //                         toast.onmouseenter = Swal.stopTimer;
    //                         toast.onmouseleave = Swal.resumeTimer;
    //                     }
    //                 });
    //                 Toast.fire({
    //                     showCloseButton: true,
    //                     icon: icon,
    //                     html: data.alert,
    //                 });
    //             }
    //         }, 1000);


    //     })
    // }
</script>
@if (App\Models\Products::count() == 0 && (Auth::user()->role == 2 || Auth::user()->role == 3))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Layanan Kosong!',
            text: 'Hubungi pihak laundry untuk informasi lebih lanjut.',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Keluar"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '/logout';
            }
        });
    </script>
@endif
@if (App\Models\Products::count() == 0)
    @if (Auth::user()->role == 1 && !Request::is('products*'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Layanan Kosong!',
                text: 'Tambahkan layanan laundry anda!',
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Tambahkan Layanan",
                cancelButtonText: "Keluar"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '/products/create';
                } else {
                    location.href = '/logout';
                }
            });
        </script>
    @endif
@endif
@stack('scripts')
