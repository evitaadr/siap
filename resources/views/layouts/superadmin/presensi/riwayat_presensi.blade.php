<x-main>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Riwayat Presensi
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Manajemen riwayat kehadiran karyawan PT Sarana Media Cemerlang
        </p>
    </div>

    <!-- Filter & Export -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

        <div class="flex justify-between items-center flex-wrap gap-4">

            <div class="flex gap-4">

                <!-- Filter Tanggal -->
                <div class="relative">
                    <input type="date"
                        class="border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">
                </div>

                <!-- Filter Divisi -->
                <select class="border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">
                    <option>Semua Divisi</option>
                    <option>HRGA</option>
                    <option>Finance</option>
                    <option>CRO & Legal</option>
                    <option>Marketing</option>
                    <option>NOC</option>
                    <option>Teknisi</option>
                    <option>Logistic & Project</option>
                </select>

            </div>

            <!-- Export Button -->
            <button class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700 flex items-center gap-2">
                <i class="fa-solid fa-download"></i>
                Export
            </button>

        </div>

    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <!-- Tab -->
        <div class="px-6 py-4 border-b border-gray-100/70 flex items-center gap-2">
            <span class="text-blue-600 font-medium">
                Semua Rekaman
            </span>
            <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                5
            </span>
        </div>

        <!-- Table -->
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Divisi</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Masuk</th>
                    <th class="px-6 py-4">Pulang</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100/70">

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4 font-medium text-gray-800">Budi Santoso</td>
                    <td class="px-6 py-4">Teknisi</td>
                    <td class="px-6 py-4">12 Oct 2025</td>
                    <td class="px-6 py-4 font-semibold">08:00</td>
                    <td class="px-6 py-4">17:00</td>
                    <td class="px-6 py-4">
                        <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">
                            Hadir
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4 font-medium text-gray-800">Siti Aminah</td>
                    <td class="px-6 py-4">Marketing</td>
                    <td class="px-6 py-4">12 Oct 2025</td>
                    <td class="px-6 py-4 text-red-500 font-semibold">08:15</td>
                    <td class="px-6 py-4">17:05</td>
                    <td class="px-6 py-4">
                        <span class="bg-red-100 text-red-500 text-xs px-3 py-1 rounded-full">
                            Terlambat - 15 Menit
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">3</td>
                    <td class="px-6 py-4 font-medium text-gray-800">Andi Wijaya</td>
                    <td class="px-6 py-4">Finance</td>
                    <td class="px-6 py-4">12 Oct 2025</td>
                    <td class="px-6 py-4 text-gray-400">--:--</td>
                    <td class="px-6 py-4 text-gray-400">--:--</td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-200 text-gray-600 text-xs px-3 py-1 rounded-full">
                            Tidak Hadir
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">4</td>
                    <td class="px-6 py-4 font-medium text-gray-800">Dewi Lestari</td>
                    <td class="px-6 py-4">CRO & Legal</td>
                    <td class="px-6 py-4">12 Oct 2025</td>
                    <td class="px-6 py-4 font-semibold">07:55</td>
                    <td class="px-6 py-4">17:10</td>
                    <td class="px-6 py-4">
                        <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">
                            Hadir
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">5</td>
                    <td class="px-6 py-4 font-medium text-gray-800">Eko Prasetyo</td>
                    <td class="px-6 py-4">NOC</td>
                    <td class="px-6 py-4">12 Oct 2025</td>
                    <td class="px-6 py-4 text-red-500 font-semibold">08:05</td>
                    <td class="px-6 py-4">17:00</td>
                    <td class="px-6 py-4">
                        <span class="bg-red-100 text-red-500 text-xs px-3 py-1 rounded-full">
                            Terlambat - 5 Menit
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>

        <!-- Footer -->
        <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
            <p class="text-xs text-gray-500">
                Menampilkan 1–5 dari 1,248 data
            </p>

            <div class="flex items-center gap-2">

                <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-600">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>

                <button class="w-8 h-8 rounded-lg bg-blue-600 text-white text-sm">
                    1
                </button>

                <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-600 text-sm">
                    2
                </button>

                <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-600 text-sm">
                    3
                </button>

                <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-600">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>

            </div>
        </div>

    </div>

</x-main>
