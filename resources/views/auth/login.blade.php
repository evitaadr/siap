<x-app>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="bg-blue-500 text-white p-4 rounded-xl shadow-md">
                    <i class="fa-solid fa-building text-2xl"></i>
                </div>
            </div>

            <!-- Title -->
            <div class="text-center mb-6">
                <p class="text-gray-600 text-sm">PT Sarana Media Cemerlang</p>
                <h1 class="text-3xl font-bold text-gray-800">Selamat Datang</h1>
                <p class="text-gray-500 text-sm mt-2">Silahkan masuk ke akun anda</p>
            </div>

            <!-- Error Message -->
            @if (session('error'))
                <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Pengguna
                    </label>
                    <div class="relative">
                        <input type="text" name="username" value="{{ old('username') }}" required autofocus
                            placeholder="Masukkan Nama Pengguna"
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_hp') border-red-500 @enderror">
                        <span class="absolute right-3 top-3 text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                    </div>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input type="password" name="password" required
                            placeholder="Masukkan Kata Sandi"
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        <span class="absolute right-3 top-3 text-gray-400">
                            <i class="fa-solid fa-eye-slash"></i>
                        </span>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lupa Password -->
                <div class="text-right">
                    <a href="#"
                    class="text-sm text-blue-600 hover:underline">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-300 shadow-md">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</x-app>
