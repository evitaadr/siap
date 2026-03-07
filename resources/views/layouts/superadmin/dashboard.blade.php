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
                            <p class="text-xs text-gray-400">Cuti Tahunan</p>
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

        <!-- Tombol -->
        <div class="flex justify-center gap-6">

            <form action="{{ route('superadmin.absenMasuk') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-md hover:bg-blue-700 flex items-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Presensi Masuk
                </button>
            </form>

            <form action="{{ route('superadmin.absenPulang') }}" method="POST">
                @csrf
                <button type="submit"
                    class="border border-gray-300 px-6 py-3 rounded-xl hover:bg-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Presensi Pulang
                </button>
            </form>
        </div>

    </div>

    @push('js')
    <script>
        function updateJam() {
            const now = new Date();

            const jam = now.toLocaleTimeString('id-ID');
            const tanggal = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            document.getElementById('jam').innerText = jam;
            document.getElementById('tanggalHari').innerText = tanggal;
        }

        setInterval(updateJam, 1000);
        updateJam();
    </script>
    @endpush

</x-main>
