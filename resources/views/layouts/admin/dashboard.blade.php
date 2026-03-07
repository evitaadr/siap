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

        <!-- Permintaan Cuti -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="bg-red-100 text-red-500 p-3 rounded-xl">
                <i class="fa-solid fa-calendar-plus"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Permintaan Cuti</p>
                <p class="text-xl font-bold text-gray-800">8</p>
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

            <form action="{{ route('admin.absenMasuk') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-md hover:bg-blue-700 flex items-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Presensi Masuk
                </button>
            </form>

            <form action="{{ route('admin.absenPulang') }}" method="POST">
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

{{-- <x-main>

    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">
            Beranda
        </h1>
        <p class="text-gray-500 mt-1">
            Selamat Datang
        </p>
    </div>

    <!-- Statistik -->
    <div class="grid md:grid-cols-3 gap-6 mb-10">

        <!-- Kehadiran -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 flex items-center gap-4">
            <div class="bg-blue-100 text-blue-600 p-4 rounded-xl text-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kehadiran Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800">20/22 Hari</p>
            </div>
        </div>

        <!-- Izin Pending -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 flex items-center gap-4">
            <div class="bg-orange-100 text-orange-500 p-4 rounded-xl text-xl">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Izin Pending</p>
                <p class="text-2xl font-bold text-gray-800">1</p>
            </div>
        </div>

        <!-- Permintaan Cuti -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 flex items-center gap-4">
            <div class="bg-red-100 text-red-500 p-4 rounded-xl text-xl">
                <i class="fa-solid fa-calendar-plus"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Permintaan Cuti</p>
                <p class="text-2xl font-bold text-gray-800">8</p>
            </div>
        </div>

    </div>

    <!-- Card Presensi -->
    <div class="bg-white rounded-3xl shadow-md p-12 text-center relative overflow-hidden">

        <!-- Decorative background -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50 rounded-full -translate-y-10 translate-x-10"></div>

        <!-- Tanggal -->
        <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-600 px-5 py-2 rounded-full text-sm mb-6">
            <i class="fa-solid fa-calendar-days"></i>
            <span id="tanggalHari"></span>
        </div>

        <!-- Jam -->
        <h1 id="jam"
            class="text-7xl font-extrabold text-gray-900 tracking-widest mb-6">
            00:00:00
        </h1>

        <!-- Lokasi -->
        <p class="text-gray-500 mb-10 text-sm">
            <i class="fa-solid fa-location-dot text-blue-500 mr-1"></i>
            Kantor Pusat PT Sarana Media Cemerlang
        </p>

        <!-- Tombol -->
        <div class="flex flex-col md:flex-row justify-center gap-6">

            <button
                class="bg-blue-600 text-white px-8 py-4 rounded-xl shadow-lg hover:bg-blue-700 hover:scale-105 transition duration-200 flex items-center justify-center gap-3 text-sm font-medium">
                <i class="fa-solid fa-right-to-bracket"></i>
                Presensi Masuk
            </button>

            <button
                class="border border-gray-300 px-8 py-4 rounded-xl hover:bg-gray-100 hover:scale-105 transition duration-200 flex items-center justify-center gap-3 text-sm font-medium">
                <i class="fa-solid fa-right-from-bracket"></i>
                Presensi Keluar
            </button>

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

</x-main> --}}
