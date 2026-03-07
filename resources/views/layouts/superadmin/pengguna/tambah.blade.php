<x-main>

    <div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Data Pengguna
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Tambahkan pengguna baru ke dalam sistem
        </p>
    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-2xl shadow-sm p-8 w-full">

        <form action="{{ route('superadmin.simpanPengguna') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label class="text-sm text-gray-600">Nama Lengkap</label>
                <input type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">
                @error('nama_lengkap')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Pengguna -->
            <div>
                <label class="text-sm text-gray-600">Nama Pengguna</label>
                <input type="text"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan nama pengguna"
                    class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Divisi -->
            <div>
                <label class="text-sm text-gray-600">Divisi</label>
                <select name="divisi"
                    class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">
                    <option value="">Pilih Divisi</option>
                    <option value="HRGA">HRGA</option>
                    <option value="FINANCE">FINANCE</option>
                    <option value="CRO&LEGAL">CRO & LEGAL</option>
                    <option value="MARKETING">MARKETING</option>
                    <option value="TEKNISI">TEKNISI</option>
                    <option value="NOC">NOC</option>
                    <option value="LOGISTIC&PROJECT">LOGISTIC & PROJECT</option>
                </select>
                @error('divisi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

                <!-- Role -->
                <div>
                    <label class="text-sm text-gray-600">Role</label>
                    <select name="roles[]"
                        class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-blue-200">
                        <option value="">Pilih Role</option>
                        @foreach ( $roles as $role )
                            <option value="{{ $role->id }}">{{ $role->nama == 'admin' ? 'Kepala Divisi' : ucfirst($role->nama) }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 pt-6 border-t border-gray-100/70">

                <a href="{{ route('superadmin.daftarPengguna') }}"
                    class="bg-gray-100 px-5 py-2 rounded-xl hover:bg-gray-200">
                    Batal
                </a>

                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700">
                    Simpan
                </button>

            </div>

        </form>

    </div>
    </div>
</x-main>
