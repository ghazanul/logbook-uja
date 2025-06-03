<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{{ csrf_token() }}}">
    <title>App Name - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @yield('styles')

    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.min.css
" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

</head>



<body>
    <header class=" bg-white  w-full  fixed items-center justify-between px-[60px] py-[55px] z-50  hidden md:flex">
        <!-- Logo & Nama -->
        <div class="flex items-center space-x-[5px] w-[297px]">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo 1" class="h-[58px] w-auto">

            <span class="text-lg font-bold text-gray-900">Usaha Jeumala Amal</span>
        </div>

        <!-- Menu Tengah -->
        <nav class="flex space-x-[54px] ">
            @php
                $season = request()->segment(1); // Ambil 's1' dari URL seperti /s1/home
            @endphp

            <a href="/{{ $season }}/home"
                class="{{ request()->is($season . '/home*') ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">
                Home
            </a>
            @if (auth()->user()->role == 'admin')
                <a href="/{{ $season }}/pilihan-tugas"
                    class="{{ request()->is($season . '/pilihan-tugas*') || request()->is($season . '/task*') || request()->is($season . '/list-kegiatan*') || request()->is($season . '/list-TugasTelur*') || request()->is($season . '/list-TugasPakan*') || request()->is($season . '/list-TugasUpdateKeadaanBebek*') || request()->is($season . '/list-TugasKebersihanKandang*') || request()->is($season . '/list-TugasAir*') ? 'text-[#047857]' : 'text-[#0F172A]' }} 
                        text-[20px] font-semibold hover:text-[#047857]">
                    Task
                </a>
            @endif
            <a href="/{{ $season }}/view-data"
                class="{{ request()->is($season . '/view-data') || request()->is($season . '/view-data-kandang*') ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">View
                Data</a>
            @if (auth()->user()->role == 'admin')
                {{-- <a href="/download-data"
                class="{{ request()->is('download-data')|| request()->is('download-data*')  ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">Download Data</a> --}}

                <a href="/{{ $season }}/user"
                    class="{{ request()->is($season . '/user*') || request()->is($season . '/user/create') || request()->is($season . '/user/*/edit') ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">User</a>
            @endif
            <a href="/{{ $season }}/laporan"
                class="{{ request()->is($season . '/laporan*') ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">Laporan</a>

            <a href="/{{ $season }}/season"
                class="{{ request()->is($season . '/season*') ? 'text-[#047857]' : 'text-[#0F172A]' }}  text-[20px] font-semibold hover:text-[#047857]">Season</a>

            {{-- {{ $seasonSelected }} --}}
            <select name="season" id="season">
                @foreach ($seasons as $season)
                    <option value="{{ $season->name }}" {{ $season->name == $seasonSelected ? 'selected' : '' }}>
                        Season - {{ $season->name }}</option>
                @endforeach
            </select>


        </nav>

        <!-- Logout Button -->
        <div class="w-[297px] ">
            <button id="logout-btn"
                class="bg-[#047857] ms-auto block hover:bg-emerald-800 text-white font-semibold text-[20px] w-[107px] h-[41px] shadow-md/50 rounded-[10px]">
                Logout
            </button>
        </div>
        </div>
    </header>


    {{-- Mobile --}}
    <header class="fixed top-0 left-0 w-full h-[70px] bg-white z-50 md:hidden">

        <div class="flex items-center justify-between mx-[16px] ">
            <div class=" flex items-center space-x-[5px] w-full">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo 1" class=" w-[86px] ">

                <span class="text-[20px] font-bold text-gray-900">Usaha Jeumala Amal</span>
            </div>

            <div onclick="toggleMenuNav()" class="relative w-[35px] h-[35px]  cursor-pointer">
                <img src="{{ asset('images/menu.png') }}" alt="Menu" id="menuIcon"
                    class="absolute w-[35px] transition-opacity duration-300">
                <img src="{{ asset('images/exit.png') }}" alt="Exit" id="exitIcon"
                    class="absolute  w-[35px] opacity-0 transition-opacity duration-300">
            </div>

        </div>
    </header>

    <nav class="flex-col hidden space-y-[21px] items-center h-[89%] absolute top-[68px] w-full bg-white z-10"
        id="menu">
        @php
            $season = request()->segment(1); // Ambil 's1' dari URL seperti /s1/home
        @endphp
        <div class="flex flex-col items-center space-y-[21px] justify-baseline h-full">
            <a href="/{{ $season }}/home"
                class="{{ request()->is($season . '/home*') ? 'text-[#047857]' : 'text-[#0F172A]' }}  text-[20px] font-semibold hover:text-[#047857]">Home</a>
            @if (auth()->user()->role == 'admin')
                <a href="/{{ $season }}/pilihan-tugas"
                    class="{{ request()->is($season . '/pilihan-tugas*') || request()->is($season . '/task*') || request()->is($season . '/list-kegiatan*') || request()->is($season . '/list-TugasTelur*') || request()->is($season . '/list-TugasPakan*') || request()->is($season . '/list-TugasUpdateKeadaanBebek*') || request()->is($season . '/list-TugasKebersihanKandang*') || request()->is($season . '/list-TugasAir*') ? 'text-[#047857]' : 'text-[#0F172A]' }} 
                        text-[20px] font-semibold hover:text-[#047857]">
                    Task
                </a>
            @endif
            <a href="/{{ $season }}/view-data"
                class="{{ request()->is($season . '/view-data') || request()->is($season . '/view-data-kandang*') ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">View
                Data</a>
            @if (auth()->user()->role == 'admin')
                <a href="/{{ $season }}/laporan"
                    class="{{ request()->is($season . '/laporan*') ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">
                    Laporan
                </a>
            @endif
            @if (auth()->user()->role == 'admin')
                <a href="/{{ $season }}/user"
                    class="{{ request()->is($season . '/user*') || request()->is($season . '/user/create') || request()->is($season . '/user/*/edit') ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">User</a>
            @endif
            @if (auth()->user()->role == 'admin')
                <a href="/{{ $season }}/season"
                    class="{{ request()->is('season') || request()->is('season*') ? 'text-[#047857]' : 'text-[#0F172A]' }} text-[20px] font-semibold hover:text-[#047857]">Season</a>
            @endif
            {{-- {{ $seasonSelected }} --}}
            <select name="season" id="season">
                @foreach ($seasons as $season)
                    <option value="{{ $season->name }}" {{ $season->name == $seasonSelected ? 'selected' : '' }}>
                        Season - {{ $season->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="">
            <button id="logout-btn-mobile"
                class="bg-[#047857] block hover:bg-emerald-800 text-white font-semibold text-[20px] w-[306px] h-[41px] shadow-md/50 rounded-[10px]">
                Logout
            </button>
        </div>
    </nav>











    @yield('content')

</body>



<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js
"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js"></script>

<script>
    let isOpen = false;
    const menu = document.getElementById("menu");
    const menuIcon = document.getElementById("menuIcon");
    const exitIcon = document.getElementById("exitIcon");

    const toggleMenuNav = () => {
        isOpen = !isOpen;
        if (isOpen) {
            menu.classList.add("flex");
            menu.classList.remove("hidden");
            menuIcon.classList.add("opacity-0");
            exitIcon.classList.remove("opacity-0");
        } else {
            menu.classList.remove("flex");
            menu.classList.add("hidden");
            menuIcon.classList.remove("opacity-0");
            exitIcon.classList.add("opacity-0");
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        const logoutButton = document.getElementById("logout-btn");
        const logoutButtonMobile = document.getElementById("logout-btn-mobile");



        const pathSegments = window.location.pathname.split('/');
        const season = pathSegments[1]; // "s1"
        if (logoutButton) {
            logoutButton.addEventListener("click", function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Logout',
                    text: "Apakah kamu yakin ingin keluar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#047857',
                    cancelButtonColor: '#A3A1A1',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke halaman login atau logout
                        fetch(`/${season}/logout`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        window.location.href = "/"; // Ganti sesuai kebutuhanmu
                    }
                });
            });
            logoutButtonMobile.addEventListener("click", function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Logout',
                    text: "Apakah kamu yakin ingin keluar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#047857',
                    cancelButtonColor: '#A3A1A1',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke halaman login atau logout
                        fetch(`/${season}/logout`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        window.location.href = "/"; // Ganti sesuai kebutuhanmu
                    }
                });
            });
        } else {
            console.error("Logout button not found.");
        }
    });

    document.getElementById("season").addEventListener("change", function() {
        const selectedSeason = this.value;
        window.location.href = `/${selectedSeason}/home`;
    })
</script>

@yield('scripts')



</html>
