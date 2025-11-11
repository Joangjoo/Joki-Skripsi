<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Pengambilan Keputusan Biji Kopi - SAW' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        });
    </script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside id="sidebar"
            class="fixed md:static inset-y-0 left-0 w-64 bg-amber-800 text-white flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40">
            <div class="p-4 text-2xl font-bold border-b border-amber-700 flex items-center justify-between">
                ☕ {{ env('APP_NAME') }}
                <button id="sidebarToggle" class="md:hidden text-white focus:outline-none">
                    ✖
                </button>
            </div>
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('coffee.index') }}"
                    class="block px-3 py-2 rounded-md hover:bg-amber-700 transition {{ request()->routeIs('coffee.*') ? 'bg-amber-700' : '' }}">
                    Alternatif
                </a>
                <a href="{{ route('criteria.index') }}"
                    class="block px-3 py-2 rounded-md hover:bg-amber-700 transition {{ request()->routeIs('criteria.*') ? 'bg-amber-700' : '' }}">
                    Kriteria
                </a>
                <a href="{{ route('evaluation.index') }}"
                    class="block px-3 py-2 rounded-md hover:bg-amber-700 transition {{ request()->routeIs('evaluation.*') ? 'bg-amber-700' : '' }}">
                    Penilaian
                </a>
                <a href="{{ route('saw.result') }}"
                    class="block px-3 py-2 rounded-md hover:bg-amber-700 transition {{ request()->routeIs('saw.*') ? 'bg-amber-700' : '' }}">
                    Hasil SAW
                </a>
            </nav>
        </aside>

        {{-- Overlay untuk mobile --}}
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden z-30"></div>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col w-full">
            {{-- Header --}}
            <header class="bg-white shadow-md p-4 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center space-x-3">
                    <button id="sidebarToggle"
                        class="md:hidden text-amber-800 focus:outline-none border border-amber-800 rounded-md px-2 py-1">
                        ☰
                    </button>
                    <h1 class="text-2xl font-bold text-gray-800">
                        {{-- {{ $pageTitle ?? 'Dashboard' }} --}}
                    </h1>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-6 overflow-y-auto">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Overlay + toggle sidebar (versi mobile)
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggles = document.querySelectorAll('#sidebarToggle');
            const overlay = document.getElementById('overlay');

            toggles.forEach(btn => {
                btn.addEventListener('click', () => {
                    const isHidden = sidebar.classList.contains('-translate-x-full');
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden', isHidden);
                });
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        });
    </script>
</body>

</html>
