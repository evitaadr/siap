<x-main>

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Pengajuan Perizinan
            </h1>
        </div>

        <a href="{{ route('karyawan.tambahPerizinan') }}"
            class="bg-blue-600 text-white px-5 py-2.5 rounded-xl shadow hover:bg-blue-700 flex items-center gap-2 text-sm">
                <i class="fa-solid fa-plus"></i>
                Tambah Pengajuan
        </a>
    </div>


    <!-- Sub Title -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-700">
            Riwayat Pengajuan Saya
        </h2>
    </div>


    <!-- Card Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <table class="w-full text-sm text-left">

            <!-- Head -->
            <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Jenis Izin</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="divide-y divide-gray-100">
                @forelse ( $perizinan as $p )
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ ($perizinan->currentPage() - 1) * $perizinan->perPage() + $loop->iteration }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->translatedFormat('d M Y') }}
                            @if ($p->tanggal_selesai && $p->tanggal_selesai != $p->tanggal_mulai)
                                - {{ \Carbon\Carbon::parse($p->tanggal_selesai)->translatedFormat('d M Y') }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">
                                {{ $p->jenis_perizinan }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($p->status === 'pending')
                                <span class="flex items-center gap-2 text-orange-500 font-medium">
                                    <i class="fa-solid fa-ellipsis"></i>
                                    Pending
                                </span>
                            @elseif ($p->status === 'disetujui')
                                <span class="flex items-center gap-2 text-green-600 font-medium">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Disetujui
                                </span>
                            @else
                                <span class="flex items-center gap-2 text-red-500 font-medium">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                    </tr>

                @empty

                @endforelse

                {{-- <!-- Row 1 -->
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-700">
                        12 Okt - 14 Okt 2023
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">
                            Cuti Tahunan
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-2 text-orange-500 font-medium">
                            <i class="fa-solid fa-ellipsis"></i>
                            Pending
                        </span>
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-700">
                        05 Okt 2023
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-orange-100 text-orange-500 text-xs px-3 py-1 rounded-full">
                            Sakit
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-2 text-green-600 font-medium">
                            <i class="fa-solid fa-circle-check"></i>
                            Disetujui
                        </span>
                    </td>
                </tr>

                <!-- Row 3 -->
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-700">
                        20 Sep 2023
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">
                            Cuti Tahunan
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-2 text-red-500 font-medium">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Ditolak
                        </span>
                    </td>
                </tr> --}}

            </tbody>

        </table>

    </div>

</x-main>
