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
                    <th class="px-6 py-4">Aksi</th>
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

                        @if ($p->verifikasi && $p->verifikasi->status_admin == 'pending')

                        <span class="flex items-center gap-2 text-orange-500 font-medium">
                        <i class="fa-solid fa-hourglass-half"></i>
                        Menunggu Kepala Divisi
                        </span>

                        @elseif ($p->verifikasi && $p->verifikasi->status_admin == 'disetujui' && $p->verifikasi->status_superadmin == 'pending')

                        <span class="flex items-center gap-2 text-yellow-500 font-medium">
                        <i class="fa-solid fa-clock"></i>
                        Menunggu HRD
                        </span>

                        @elseif ($p->verifikasi && $p->verifikasi->status_superadmin == 'disetujui')

                        <span class="flex items-center gap-2 text-green-600 font-medium">
                        <i class="fa-solid fa-circle-check"></i>
                        Disetujui
                        </span>

                        @elseif ($p->verifikasi && ($p->verifikasi->status_admin == 'ditolak' || $p->verifikasi->status_superadmin == 'ditolak'))

                        <span class="flex items-center gap-2 text-red-500 font-medium">
                        <i class="fa-solid fa-circle-xmark"></i>
                        Ditolak
                        </span>

                        @endif

                        </td>

                        <td class="px-6 py-4">
                            <button onclick="openModal({{ $p->id }})" class="text-blue-500 hover:text-blue-700">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada pengajuan perizinan
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Modal Detail Perizinan --}}
    @foreach ( $perizinan as $item )
    <div id="modal-{{ $item->id }}"
        class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-xl flex flex-col max-h-[90vh]">

            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Detail Pengajuan Perizinan
                </h2>

                <button onclick="closeModal({{ $item->id }})"
                    class="text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-6 text-sm overflow-y-auto">
                <div>
                    <p class="text-gray-400 text-xs">Jenis Izin</p>
                    <p class="font-medium text-gray-800">
                        {{ $item->jenis_perizinan }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Tanggal</p>
                    <p class="font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                        @if ($item->tanggal_selesai && $item->tanggal_selesai != $item->tanggal_mulai)
                        - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs mb-2">Keterangan</p>
                    <div class="bg-gray-50 border rounded-xl px-4 py-3">
                        {{ $item->keterangan ?? '-' }}
                    </div>
                </div>

                {{-- Bukti File --}}
                @if($item->bukti_file)

                <div>
                    <p class="text-gray-400 text-xs mb-2">Bukti File</p>
                    <img src="{{ Storage::url('perizinan_files/'.$item->bukti_file) }}"
                    class="rounded-xl border max-h-72 object-contain mx-auto">
                    <a href="{{ Storage::url('perizinan_files/'.$item->bukti_file) }}"
                        target="_blank"
                        class="text-blue-600 text-sm mt-2 inline-block">
                        Lihat File
                    </a>
                </div>
                @endif

                  @if ($item->verifikasi->admin_verified_at != null)
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <p class="text-green-700 text-sm">
                            <span class="font-medium">Admin:</span>
                            {{ $item->verifikasi->status_admin === 'disetujui' ? 'Disetujui' : 'Ditolak' }} pada {{ \Carbon\Carbon::parse($item->verifikasi->admin_verified_at)->translatedFormat('d M Y H:i') }}
                        </p>
                    </div>
                    @endif

                    @if ($item->verifikasi->superadmin_verified_at != null)
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <p class="text-green-700 text-sm">
                            <span class="font-medium">HRD:</span>
                            {{ $item->verifikasi->status_superadmin === 'disetujui' ? 'Disetujui' : 'Ditolak' }} pada {{ \Carbon\Carbon::parse($item->verifikasi->superadmin_verified_at)->translatedFormat('d M Y H:i') }}
                        </p>
                    </div>
                    @endif

                    @if ($item->verifikasi->status_admin == 'ditolak')
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <p class="text-red-700 text-sm">
                            <span class="font-medium">Alasan Penolakan:</span>
                            {{ $item->verifikasi->catatan_admin ?? '-' }}
                        </p>
                    </div>
                    @endif

                    @if ($item->verifikasi->status_superadmin == 'ditolak')
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <p class="text-red-700 text-sm">
                            <span class="font-medium">Alasan Penolakan:</span>
                            {{ $item->verifikasi->catatan_superadmin ?? '-' }}
                        </p>
                    </div>
                    @endif

            </div>

        </div>

    </div>

    @endforeach

    @push('js')
    <script>

    function openModal(id){
        document.getElementById('modal-'+id).classList.remove('hidden');
        document.getElementById('modal-'+id).classList.add('flex');
    }

    function closeModal(id){
        document.getElementById('modal-'+id).classList.add('hidden');
    }

    </script>
    @endpush

</x-main>
