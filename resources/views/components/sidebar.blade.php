<aside class="w-64 min-h-screen bg-gray-100 flex flex-col justify-between shadow-md">

    <!-- Top Section -->
    <div>
        <!-- Profile -->
        <div class="p-6 flex items-center gap-3">
            <div class="bg-blue-500 text-white p-3 rounded-xl">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ auth()->user()->nama_lengkap }}</p>
                <p class="text-sm text-gray-500">{{ auth()->user()->roles->first()->nama }}</p>
            </div>
        </div>

        <!-- Menu -->
        <nav class="mt-4 space-y-2 px-4">

            @hasRole('superadmin')
                <a href="{{ route('superadmin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('superadmin.daftarPengguna') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('superadmin.daftarPengguna') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Data Pengguna</span>
                </a>

                <a href="{{ route('superadmin.riwayat_presensi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('superadmin.riwayat_presensi') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Riwayat Presensi</span>
                </a>

                <a href="{{ route('superadmin.verifikasi_perizinan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('superadmin.verifikasi_perizinan') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span>Verifikasi Perizinan</span>
                </a>
            @endhasRole

            @hasRole('admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('admin.presensi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('admin.presensi') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Presensi</span>
                </a>

                <a href="{{ route('admin.daftarPerizinan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('admin.daftarPerizinan') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span>Perizinan</span>
                </a>

                <a href="{{ route('admin.daftarVerifikasiPerizinan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('admin.daftarVerifikasiPerizinan') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span>Verifikasi Perizinan</span>
                </a>
            @endhasRole

            @hasRole('karyawan')
                <a href="{{ route('karyawan.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('karyawan.dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('karyawan.presensi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('karyawan.presensi') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Presensi</span>
                </a>

                <a href="{{ route('karyawan.daftarPerizinan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->routeIs('karyawan.daftarPerizinan') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100' }}">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span>Perizinan</span>
                </a>
            @endhasRole

        </nav>
    </div>

    <!-- Bottom Section -->
    <div class="p-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-2 px-4 py-3 text-red-500 hover:bg-red-100 rounded-xl">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</aside>
