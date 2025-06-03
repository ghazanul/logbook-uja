@extends('layouts.app')

@section('title', 'Halaman Depan')

@section('content')


    <body>
        <div class=" flex justify-between  mx-[16px] md:mx-[60px] pt-[200px] md:pt-[300px] md:flex-row flex-col">
            <!-- Teks -->
            <div class=" leading-7 md:leading-[86px] ">
                <h1 class="text-[25px] md:text-[80px]  text[#0F172A] font-bold">
                    Selamat Datang<br>
                    Di Logbook Peternakan<br>
                    Bebek UJA
                </h1>
                <p class="text[#0F172A] font-regular text-[15px] md:text-[21px] leading-5 md:leading-[30px]">
                    Aplikasi Logbook Ini Membantu Mencatat Semua<br>
                    Aktivitas Penting Di Peternakan Bebek UJA
                </p>
            </div>

            <!-- Gambar bebek-->
            <div>
                @if (auth()->user()->role == 'admin')
                    <a href="/task">
                    @else
                        <a href="/view-data">
                @endif
                <div class="w-[297px] md:hidden">
                    <button
                        class="bg-[#047857] block hover:bg-emerald-800 text-white font-semibold text-[18px] w-[123px] h-[40px] shadow-md/50 rounded-r-[10px]">
                        Get Started
                    </button>
                </div>
                </a>
                <div class="">
                    <img src="{{ asset('images/bebek.png') }}" alt=""
                        class="ms-auto w-[247px]  md:w-[677px] md:h-[353px] object-contain">
                </div>
            </div>
        </div>
    </body>
    </div>
@endsection
