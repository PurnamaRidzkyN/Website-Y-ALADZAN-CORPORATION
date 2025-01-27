<!DOCTYPE html>
<html lang="en" class="h-full bg-[#2D3748]">
<link rel="icon" href="{{ asset('icon.png') }}" type="image/png">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Vite CSS and JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Font for Inter -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Login</title>
</head>

<body class="h-full bg-[#2D3748]">

    <div class="min-h-full flex flex-col">
        <section class="bg-[#2D3748]">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-[#F7FAFC]">
                    <img class="w-14 h-14 mr-3  " src="{{ asset('icon.png') }}" alt="logo">
                    Y-ALADZAN
                </a>
                <div class="w-full bg-[#1A2634] rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-[#F7FAFC] md:text-2xl">
                            Kirim password baru
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="{{ route('resetPassword') }}" method="POST">
                            @csrf
                            <div>
                                <label for="identifier"
                                    class="block mb-2 text-sm font-medium text-[#F7FAFC]">Email</label>
                                <input type="text" name="email" id="email" value="{{ old('email') }}"
                                    class="bg-[#1A2634] border border-[#A0AEC0] text-[#F7FAFC] rounded-lg focus:ring-[#00B5D8] focus:border-[#00B5D8] block w-full p-2.5"
                                    placeholder="email" required="">
                                @error('identifier')
                                    <div class="text-[#FF6347] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <a href="{{ route('login') }}"
                                    class="text-sm font-medium text-[#F7FAFC] hover:text-[#00B5D8]">Kembali ke halaman
                                    Login</a>
                            </div>
                            <button type="submit"
                                class="w-full text-[#F7FAFC] bg-[#3182CE] hover:bg-[#00B5D8] focus:ring-4 focus:outline-none focus:ring-[#00B5D8] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Kirim password baru
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
