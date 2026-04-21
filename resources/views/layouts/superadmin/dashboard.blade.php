<x-main>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Beranda Admin
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Selamat datang kembali, admin. Berikut adalah aktivitas di perusahaan PT Sarana Media Cemerlang
        </p>
    </div>

    <!-- Statistik Card -->
    <div class="grid grid-cols-3 gap-6 mb-8">

        <!-- Total Karyawan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    Total Karyawan
                </p>
                <p class="text-3xl font-bold text-gray-800 mt-2">140</p>
            </div>
            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                <i class="fa-solid fa-users text-lg"></i>
            </div>
        </div>

        <!-- Permintaan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    Permintaan Izin/Cuti
                </p>
                <p class="text-3xl font-bold text-gray-800 mt-2">8</p>
                <p class="text-xs text-gray-400 mt-1">Menunggu persetujuan</p>
            </div>
            <div class="bg-orange-100 text-orange-500 p-3 rounded-xl">
                <i class="fa-solid fa-calendar-days text-lg"></i>
            </div>
        </div>

        <!-- Kehadiran -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    Jumlah Kehadiran
                </p>
                <p class="text-3xl font-bold text-gray-800 mt-2">136</p>
                <p class="text-xs text-gray-400 mt-1">Karyawan hadir hari ini</p>
            </div>
            <div class="bg-purple-100 text-purple-500 p-3 rounded-xl">
                <i class="fa-solid fa-check text-lg"></i>
            </div>
        </div>

    </div>

    <!-- Tabel Menunggu Persetujuan -->
    <div class="bg-white rounded-2xl shadow-sm">

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100/70">
            <h2 class="font-semibold text-gray-700">
                Menunggu Persetujuan
            </h2>
            <a href="#" class="text-blue-600 text-sm hover:underline">
                Lihat Semua
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Nama Lengkap</th>
                        <th class="px-6 py-3">Jenis Permintaan</th>
                        <th class="px-6 py-3">Tanggal / Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">Santika</p>
                            <p class="text-xs text-gray-400">CRO</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">
                                Cuti
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p>24 Okt – 26 Okt</p>
                            <p class="text-xs text-gray-400">Cuti</p>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">Aldo</p>
                            <p class="text-xs text-gray-400">NOC</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-purple-100 text-purple-600 text-xs px-3 py-1 rounded-full">
                                Izin
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p>2 Jan – 3 Jan</p>
                            <p class="text-xs text-gray-400">Izin</p>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">Jessica</p>
                            <p class="text-xs text-gray-400">Admin</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-cyan-100 text-cyan-600 text-xs px-3 py-1 rounded-full">
                                Sakit
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p>25 Okt</p>
                            <p class="text-xs text-gray-400">Sakit</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card Presensi -->
    <div class="bg-white rounded-2xl shadow-sm p-10 text-center mt-10">

        <!-- Tanggal -->
        <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 px-4 py-2 rounded-full text-sm mb-6">
            <i class="fa-solid fa-calendar"></i>
            <span id="tanggalHari"></span>
        </div>

        <!-- Jam -->
        <h1 id="jam"
            class="text-6xl font-extrabold text-gray-900 tracking-wide mb-4">
            00:00:00
        </h1>

        <!-- Lokasi -->
        <p class="text-gray-500 mb-8">
            <i class="fa-solid fa-location-dot text-blue-500 mr-1"></i>
            Kantor Pusat PT Sarana Media Cemerlang
        </p>

        <div class="flex justify-center gap-6">

        <!-- PRESENSI MASUK -->
        <div class="flex flex-col items-center">
            <form id="formMasuk" action="{{ route('superadmin.absenMasuk') }}" method="POST">
                @csrf

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <button type="submit" id="btnMasuk"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-md hover:bg-blue-700 flex items-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Presensi Masuk
                </button>
            </form>

            <!--  STATUS MASUK -->
            <p id="statusMasuk" class="text-sm text-gray-500 mt-2"></p>
        </div>


        <!-- PRESENSI KELUAR -->
        <div class="flex flex-col items-center">
            <form id="formKeluar" action="{{ route('superadmin.absenPulang') }}" method="POST">
                @csrf

                <input type="hidden" name="latitude" id="latitude2">
                <input type="hidden" name="longitude" id="longitude2">

                <button type="submit" id="btnKeluar"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-md hover:bg-blue-700 flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Presensi Pulang
                </button>
            </form>

            <!--  STATUS KELUAR -->
            <p id="statusKeluar" class="text-sm text-gray-500 mt-2"></p>
        </div>

    </div>
    </div>

    @push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ===== UPDATE JAM =====
function updateJam() {
    const now = new Date();
    document.getElementById('jam').innerText = now.toLocaleTimeString('id-ID');
    document.getElementById('tanggalHari').innerText = now.toLocaleDateString('id-ID', {
        weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
    });
}
setInterval(updateJam, 1000);
updateJam();


// ===== CEK & MINTA LOKASI =====
function ambilLokasi(latId, lngId) {
    return new Promise((resolve, reject) => {

        // Cek apakah browser support geolocation
        if (!navigator.geolocation) {
            Swal.fire({
                icon: 'error',
                title: 'Browser Tidak Support',
                text: 'Browser kamu tidak mendukung fitur lokasi (GPS).',
            });
            return reject('unsupported');
        }

        // Tampilkan loading saat mengambil lokasi
        Swal.fire({
            title: 'Mengambil Lokasi...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading()
        });

        navigator.geolocation.getCurrentPosition(
            //  SUKSES
            function(position) {
                document.getElementById(latId).value = position.coords.latitude;
                document.getElementById(lngId).value  = position.coords.longitude;
                Swal.close();
                resolve(position);
            },

            // ❌ GAGAL / DITOLAK
            function(error) {
                let title   = 'Gagal Mendapatkan Lokasi';
                let text    = '';
                let footer  = '';

                if (error.code === error.PERMISSION_DENIED) {
                    title  = 'Izin Lokasi Ditolak ❌';
                    text   = 'Kamu harus mengizinkan akses lokasi agar bisa melakukan presensi.';
                    footer = `<b>Cara aktifkan:</b><br>
                              🔒 Klik ikon gembok/info di address bar browser<br>
                              → Pilih <b>Izinkan Lokasi</b> → Refresh halaman`;
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    text = 'Lokasi tidak tersedia. Pastikan GPS perangkat kamu aktif.';
                } else if (error.code === error.TIMEOUT) {
                    text = 'Waktu habis saat mengambil lokasi. Coba lagi.';
                }

                Swal.fire({
                    icon: 'warning',
                    title,
                    text,
                    footer,
                    confirmButtonText: 'Coba Lagi',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                }).then(result => {
                    if (result.isConfirmed) {
                        // Jika user klik "Coba Lagi", panggil ulang
                        ambilLokasi(latId, lngId).then(() => {
                            document.getElementById(latId).closest('form').submit();
                        }).catch(() => {});
                    }
                });

                reject(error);
            },

            // OPTIONS
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    });
}


// ===== HANDLE SUBMIT MASUK =====
document.getElementById('formMasuk').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;

    ambilLokasi('latitude', 'longitude')
        .then(() => {
            // Validasi ganda: pastikan value tidak kosong
            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;

            if (!lat || !lng) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lokasi Belum Didapat',
                    text: 'Data koordinat masih kosong. Silakan coba lagi.',
                });
                return;
            }

            form.submit();
        })
        .catch(() => {
            // Error sudah di-handle di dalam ambilLokasi()
        });
});

// ===== HANDLE SUBMIT KELUAR =====
document.getElementById('formKeluar').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;

    ambilLokasi('latitude2', 'longitude2')
        .then(() => {
            const lat = document.getElementById('latitude2').value;
            const lng = document.getElementById('longitude2').value;

            if (!lat || !lng) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lokasi Belum Didapat',
                    text: 'Data koordinat masih kosong. Silakan coba lagi.',
                });
                return;
            }

            form.submit();
        })
        .catch(() => {});
});
</script>
@endpush

</x-main>
