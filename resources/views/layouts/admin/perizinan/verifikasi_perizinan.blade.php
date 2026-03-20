<x-main>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Verifikasi Perizinan
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Persetujuan Tahap 2 - Manajemen perizinan dan cuti karyawan PT Sarana Media Cemerlang
        </p>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center flex-wrap gap-4">

            <div class="flex gap-4 flex-wrap">

                <input type="date"
                    class="border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">

                <div class="relative">
                    <input type="text"
                        placeholder="Cari Nama"
                        class="border rounded-xl pl-10 pr-4 py-2 focus:ring focus:ring-blue-200">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
                </div>

            </div>

        </div>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <!-- Tabs -->
        <div class="px-6 py-4 border-b flex gap-8">

            <button onclick="showTab('pending')" id="tabPending"
                class="border-b-2 border-blue-600 pb-2 text-blue-600 font-medium transition">
                Menunggu Persetujuan
                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full ml-2">
                    {{ $perizinanPending->count() }}
                </span>
            </button>

            <button onclick="showTab('history')" id="tabHistory"
                class="text-gray-500 hover:text-blue-600 pb-2 transition">
                Riwayat Persetujuan
            </button>

        </div>

        <!-- ================= PENDING TABLE ================= -->
        <div id="pendingTable">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Jenis Izin</th>
                        <th class="px-6 py-4">Pengajuan</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100/70">

                    @forelse ($perizinanPending as $pp)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            {{ ($perizinanPending->currentPage() - 1) * $perizinanPending->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $pp->user->nama_lengkap }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="bg-orange-100 text-orange-600 text-xs px-3 py-1 rounded-full">
                                {{ $pp->jenis_perizinan }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($pp->tanggal_mulai)->translatedFormat('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-gray-600 truncate max-w-xs">
                            {{ $pp->keterangan ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            <button onclick="openModal({{ $pp->id }})"
                                class="text-blue-500 hover:text-blue-700">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                            Tidak ada data pending
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- ================= HISTORY TABLE ================= -->
        <div id="historyTable" class="hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Jenis Izin</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Disetujui Oleh</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

          <tbody class="divide-y divide-gray-100/70">

            @forelse ($perizinanRiwayat as $pr)
            <tr class="hover:bg-gray-50">

                <td class="px-6 py-4">
                    {{ ($perizinanRiwayat->currentPage() - 1) * $perizinanRiwayat->perPage() + $loop->iteration }}
                </td>

                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ $pr->user->nama_lengkap }}
                </td>

                <td class="px-6 py-4">
                    <span class="bg-orange-100 text-orange-600 text-xs px-3 py-1 rounded-full">
                        {{ $pr->jenis_perizinan }}
                    </span>
                </td>

                <td class="px-6 py-4">
                    {{ \Carbon\Carbon::parse($pr->tanggal_mulai)->translatedFormat('d M Y') }}
                </td>

               <td class="px-6 py-4">

                @if ($pr->verifikasi && $pr->verifikasi->status_admin == 'pending')

                <span class="flex items-center gap-2 text-orange-500 font-medium">
                    <i class="fa-solid fa-hourglass-half"></i>
                    Menunggu Kepala Divisi
                </span>

                @elseif ($pr->verifikasi && $pr->verifikasi->status_admin == 'disetujui' && $pr->verifikasi->status_superadmin == 'pending')

                <span class="flex items-center gap-2 text-yellow-500 font-medium">
                    <i class="fa-solid fa-clock"></i>
                    Menunggu HRD
                </span>

                @elseif ($pr->verifikasi && $pr->verifikasi->status_superadmin == 'disetujui')

                <span class="flex items-center gap-2 text-green-600 font-medium">
                    <i class="fa-solid fa-circle-check"></i>
                    Disetujui
                </span>

                @elseif ($pr->verifikasi && ($pr->verifikasi->status_admin == 'ditolak' || $pr->verifikasi->status_superadmin == 'ditolak'))

                <span class="flex items-center gap-2 text-red-500 font-medium">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Ditolak
                </span>
                @endif

                </td>

                <td class="px-6 py-4 text-gray-600">
                     {{ $pr->verifikasi->admin->nama_lengkap ?? '-' }}
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                    Tidak ada riwayat persetujuan
                </td>
            </tr>
            @endforelse

    </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
            <p class="text-xs text-gray-500">
                Menampilkan 1–3 dari 128 data
            </p>

            <div class="flex items-center gap-2">
                <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-600">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button class="w-8 h-8 rounded-lg bg-blue-600 text-white text-sm">1</button>
                <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-600 text-sm">2</button>
                <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-600 text-sm">3</button>
                <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-600">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>

        <!-- MODAL DETAIL VERIFIKASI -->
       @foreach ($perizinanPending as $item)

        <div id="modal-{{ $item->id }}"
            class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">

            <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl flex flex-col max-h-[90vh]">

                <!-- Header -->
                <div class="flex justify-between items-center px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Detail Verifikasi Perizinan
                    </h2>
                    <button onclick="closeModal({{ $item->id }})"
                        class="text-gray-400 hover:text-gray-600 text-xl">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-6 overflow-y-auto">

                    <div class="grid grid-cols-2 gap-6 text-sm">

                        <div>
                            <p class="text-gray-400 text-xs">Nama Lengkap</p>
                            <p class="font-medium text-gray-800">
                                {{ $item->user->nama_lengkap }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Divisi</p>
                            <p class="font-medium text-gray-800">
                                {{ $item->user->divisi }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Jenis Izin</p>
                            <span class="bg-orange-100 text-orange-600 text-xs px-3 py-1 rounded-full">
                                {{ $item->jenis_perizinan }}
                            </span>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Tanggal Mulai</p>
                            <p class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-xs">Tanggal Selesai</p>
                            <p class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                            </p>
                        </div>

                    </div>

                    <div>
                        <p class="text-gray-400 text-xs mb-2">Keterangan</p>
                        <div class="bg-gray-50 border rounded-xl px-4 py-3 text-sm">
                            {{ $item->keterangan ?? '-' }}
                        </div>
                    </div>

                    {{-- TAMPILKAN FILE HANYA JIKA SAKIT --}}
                    @if($item->jenis_perizinan === 'Sakit' && $item->bukti_file)
                    <div>
                        <p class="text-gray-400 text-xs mb-2">Bukti Surat Sakit</p>

                        <img src="{{ Storage::url('perizinan_files/'.$item->bukti_file) }}"
                             alt="Bukti Surat Sakit"
                            class="rounded-xl border max-h-80 object-contain">

                        <a href="{{ Storage::url('perizinan_files/'.$item->bukti_file) }}"
                            target="_blank"
                            class="text-blue-600 text-sm mt-2 inline-block">
                            Lihat File
                        </a>
                    </div>
                    @endif

                </div>

                <!-- Footer -->
                @hasRole('admin')
                    <div class="flex justify-end items-center gap-4 px-6 py-4 border-t">

                        <!-- BUTTON TOLAK -->
                        <button onclick="showRejectForm({{ $item->id }})"
                            class="px-5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
                            Tolak
                        </button>

                        <!-- BUTTON TERIMA -->
                        <form action="{{ route('admin.updateVerifikasiPerizinan', $item->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="disetujui">
                            <button type="submit"
                                class="px-5 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">
                                Terima
                            </button>
                        </form>

                    </div>

                    <!-- FORM CATATAN PENOLAKAN -->
                    <div id="reject-form-{{ $item->id }}" class="hidden px-6 pb-6">

                        <form action="{{ route('admin.updateVerifikasiPerizinan', $item->id) }}" method="POST">
                            @csrf

                            <input type="hidden" name="status" value="ditolak">

                            <label class="text-sm text-gray-500">Alasan Penolakan</label>

                            <textarea name="catatan"
                                required
                                class="w-full border rounded-xl p-3 mt-2 focus:ring focus:ring-red-200"
                                placeholder="Tulis alasan kenapa perizinan ini ditolak..."></textarea>

                            <div class="flex justify-end mt-4 gap-3">

                                <button type="button"
                                    onclick="hideRejectForm({{ $item->id }})"
                                    class="px-4 py-2 rounded-lg bg-gray-100">
                                    Batal
                                </button>

                                <button type="submit"
                                    class="px-5 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700">
                                    Konfirmasi Tolak
                                </button>

                            </div>

                        </form>

                    </div>
                    @endhasRole

            </div>
        </div>

        @endforeach

    </div>
</div>

    </div>

    @push('js')
    <script>
        function showTab(tab) {

            const pending = document.getElementById('pendingTable');
            const history = document.getElementById('historyTable');

            const tabPending = document.getElementById('tabPending');
            const tabHistory = document.getElementById('tabHistory');

            if (tab === 'pending') {
                pending.classList.remove('hidden');
                history.classList.add('hidden');

                tabPending.classList.add('border-b-2','border-blue-600','text-blue-600','font-medium');
                tabHistory.classList.remove('border-b-2','border-blue-600','text-blue-600','font-medium');
                tabHistory.classList.add('text-gray-500');
            } else {
                history.classList.remove('hidden');
                pending.classList.add('hidden');

                tabHistory.classList.add('border-b-2','border-blue-600','text-blue-600','font-medium');
                tabPending.classList.remove('border-b-2','border-blue-600','text-blue-600','font-medium');
                tabPending.classList.add('text-gray-500');
            }
        }

        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
            document.getElementById('modal-' + id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
        }

        function showRejectForm(id) {
            document.getElementById('reject-form-' + id).classList.remove('hidden');
        }

        function hideRejectForm(id) {
            document.getElementById('reject-form-' + id).classList.add('hidden');
        }
    </script>
    @endpush

</x-main>
