<x-main>

    <!-- Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Pengguna
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola dan pantau informasi seluruh pengguna PT Sarana Media Cemerlang
            </p>
        </div>

        <a href="{{ route('superadmin.tambahPengguna') }}"
           class="bg-blue-600 text-white px-5 py-2.5 rounded-xl shadow hover:bg-blue-700 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-user-plus"></i>
            Tambah Pengguna
        </a>
    </div>


    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

        <div class="grid grid-cols-3 gap-4">

            <!-- Divisi -->
            <div>
                <label class="text-sm text-gray-600">Divisi</label>
                <select class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">
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

            <!-- Search -->
            <div>
                <label class="text-sm text-gray-600">Nama</label>
                <form action="{{ route('superadmin.daftarPengguna') }}" method="GET">
                    <div class="relative mt-1">
                        <input type="text" name="search"
                               placeholder="Masukkan kata kunci..."
                               class="w-full border rounded-xl pl-10 pr-4 py-2 focus:ring focus:ring-blue-200">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </form>
                {{-- <div class="relative mt-1">
                    <input type="text"
                           placeholder="Masukkan kata kunci..."
                           class="w-full border rounded-xl pl-10 pr-4 py-2 focus:ring focus:ring-blue-200">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
                </div> --}}
            </div>

            <!-- Reset -->
            <div class="flex items-end">
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm">
                    Reset Filter
                </button>
            </div>

        </div>

    </div>


    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Divisi</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100/70">

                @forelse ( $users as $user )
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $user->nama_lengkap }}</td>
                        <td class="px-6 py-4">{{ $user->divisi }}</td>
                        <td class="px-6 py-4">
                            @if ($user->status === 'aktif')
                                <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">
                                    {{ $user->status }}
                                </span>
                            @else
                                <span class="bg-red-100 text-red-600 text-xs px-3 py-1 rounded-full">
                                    {{ $user->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center space-x-3">
                            <a href="{{ route('superadmin.editPengguna', $user->id) }}"
                                class="text-blue-500 hover:text-blue-700">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="{{ route('superadmin.lihatPengguna', $user->id) }}"
                                class="text-gray-500 hover:text-gray-700">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data pengguna</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <!-- Footer -->
        <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
            <p class="text-xs text-gray-500">
                Menampilkan 1 – 3 dari 124 Pengguna
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
