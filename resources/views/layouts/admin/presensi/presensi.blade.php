<x-main>

    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-gray-800">
            Presensi
        </h1>
    </div>

    <!-- Sub Title -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-700">
            Riwayat Presensi Saya
        </h2>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <table class="w-full text-sm text-left">

            <!-- Table Head -->
            <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Jam</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-100">

                @forelse ($presensi as $item)

                    {{-- ROW JAM MASUK --}}
                    @if($item->jam_masuk)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($item->jam_masuk)->format('H.i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-green-600 font-medium">
                                Masuk
                            </span>
                        </td>
                    </tr>
                    @endif

                    {{-- ROW JAM PULANG --}}
                    @if($item->jam_pulang)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                            </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($item->jam_pulang)->format('H.i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-red-500 font-medium">
                                Pulang
                            </span>
                        </td>
                    </tr>
                    @endif

                @empty
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">
                            Belum ada riwayat presensi
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</x-main>
