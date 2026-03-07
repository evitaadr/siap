<x-main>

    <div class="max-w-3xl mx-auto">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm p-8">

            <!-- Title -->
            <div class="mb-8 text-center">
                <h1 class="text-xl font-semibold text-gray-800">
                    Tambah Pengajuan
                </h1>
                <div class="w-20 h-1 bg-gray-200 mx-auto mt-3 rounded-full"></div>
            </div>

        <form action="{{ route('karyawan.simpanPerizinan') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6">

                @csrf

                <!-- Jenis Izin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Izin/Cuti
                    </label>
                    <select id="jenis_perizinan" name="jenis_perizinan"
                        class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200">
                        <option value="">Pilih jenis izin/cuti</option>
                        @foreach ($jenisPerizinan as $jenis)
                            <option value="{{ $jenis }}">{{ ucfirst($jenis) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal_mulai"
                            class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Selesai
                        </label>
                        <input type="date" name="tanggal_selesai"
                            class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200">
                    </div>

                </div>

                <!-- Keterangan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan
                    </label>
                    <textarea rows="4" name="keterangan"
                        placeholder="Berikan deskripsi atau alasan pengajuan..."
                        class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200"></textarea>
                </div>

                <!-- Upload -->

                <div id="uploadWrapper" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload bukti surat sakit
                    </label>

                    <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-blue-600 font-medium">
                                Upload file
                                <span class="text-gray-500 font-normal">atau seret dan lepas</span>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                PNG, JPG, PDF up to 5MB
                            </p>
                        </div>
                        <input type="file" name="bukti_file" id="bukti_file" class="hidden" />
                    </label>
                </div>

                <!-- Sisa Cuti -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Sisa Token Cuti
                    </label>
                    <div class="bg-gray-100 rounded-xl px-4 py-3 text-gray-700 flex items-center gap-2">
                        <i class="fa-solid fa-box-open text-gray-400"></i>
                        <span class="font-medium">{{ $userTokenCuti }} Hari</span>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t">

                    <a href="{{ route('karyawan.daftarPerizinan') }}"
                        class="px-5 py-2 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100">
                        Batal
                    </a>

                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-xl shadow hover:bg-blue-700">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

    @push('js')
        <script>
        document.addEventListener('DOMContentLoaded', function () {

            const selectJenis = document.getElementById('jenis_perizinan');
            const uploadWrapper = document.getElementById('uploadWrapper');
            const uploadInput = document.getElementById('upload_file');

            selectJenis.addEventListener('change', function () {

                if (this.value.toLowerCase() === 'sakit') {
                    uploadWrapper.classList.remove('hidden');
                    uploadInput.required = true;
                } else {
                    uploadWrapper.classList.add('hidden');
                    uploadInput.required = false;
                    uploadInput.value = '';
                }

            });

        });
        </script>
    @endpush

</x-main>
