<x-main>

    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Detail Data Pengguna
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Informasi lengkap pengguna
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm p-8 space-y-6">

            <!-- Nama Lengkap -->
            <div>
                <label class="text-sm text-gray-500">Nama Lengkap</label>
                <div class="mt-1 bg-gray-100 rounded-xl px-4 py-3 text-gray-800">
                    {{ $user->nama_lengkap ?? '-' }}
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm text-gray-500">Email</label>
                <div class="mt-1 bg-gray-100 rounded-xl px-4 py-3 text-gray-800">
                    {{ $user->email ?? '-' }}
                </div>
            </div>

            <!-- Nama Pengguna -->
            <div>
                <label class="text-sm text-gray-500">Nama Pengguna</label>
                <div class="mt-1 bg-gray-100 rounded-xl px-4 py-3 text-gray-800">
                    {{ $user->username ?? '-' }}
                </div>
            </div>

            <!-- Divisi -->
            <div>
                <label class="text-sm text-gray-500">Divisi</label>
                <div class="mt-1 bg-gray-100 rounded-xl px-4 py-3 text-gray-800">
                    {{ $user->divisi ?? '-' }}
                </div>
            </div>

            <!-- Role -->
            <div>
                <label class="text-sm text-gray-500">Role</label>
                <div class="mt-1 bg-gray-100 rounded-xl px-4 py-3 text-gray-800">
                    {{ $user->roles->first()?->nama == 'admin' ? 'Kepala Divisi' : ucfirst($user->roles->first()?->nama ?? '-') }}
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="text-sm text-gray-500">Status</label>
                <div class="mt-2">
                    <span class="px-4 py-1 rounded-full text-sm
                        {{ $user->status == 'aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-500' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </div>
            </div>

        </div>

    </div>

</x-main>
