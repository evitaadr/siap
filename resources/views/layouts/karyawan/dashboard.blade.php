<x-main>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Beranda
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Selamat Datang
        </p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-3 gap-6 mb-8">

        <!-- Kehadiran -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kehadiran Bulan Ini</p>
                <p class="text-xl font-bold text-gray-800">20/22 Hari</p>
            </div>
        </div>

        <!-- Izin Pending -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="bg-orange-100 text-orange-500 p-3 rounded-xl">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Izin Pending</p>
                <p class="text-xl font-bold text-gray-800">1</p>
            </div>
        </div>

    </div>

    <!-- Card Presensi -->
    <div class="bg-white rounded-2xl shadow-sm p-10 text-center">

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

            <form action="{{ route('karyawan.absenMasuk') }}" method="POST">
                @csrf

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-md hover:bg-blue-700 flex items-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Presensi Masuk
                </button>
            </form>

            <form action="{{ route('karyawan.absenPulang') }}" method="POST">
                @csrf

                <input type="hidden" name="latitude" id="latitude2">
                <input type="hidden" name="longitude" id="longitude2">

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-md hover:bg-blue-700 flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Presensi Keluar
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

        navigator.geolocation.getCurrentPosition(function(position) {

            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;

        });

        setInterval(updateJam, 1000);
        updateJam();
    </script>
    @endpush

</x-main>
