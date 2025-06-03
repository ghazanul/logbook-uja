@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')

    <body>
        <div class=" mx-[16px] md:mx-[200px]  mt-[90px] md:mt-[0px] md:pt-[213px] ">



            <div class="flex w-full gap-y-[20px] gap-x-[20px] md:gap-y-[30px] Md:gap-x-[30px]  ">

                @php
                    $season = request()->segment(1); // Ambil 's1' dari URL seperti /s1/home
                @endphp
                <a href="/{{ $season }}/list-kegiatan">
                    <div class="kandang-item auto flex flex-col items-center" data-id="">
                        <img src={{ asset('images/sekaligus.png') }} alt=""
                            class=" w-[289px]  lg:mb-[10px] object-contain">
                        <span class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]">Isi Tugas
                            Sekaligus</span>
                    </div>
                </a>

                <a href="/{{ $season }}/task">
                    <div class="kandang-item auto flex flex-col items-center" data-id="">
                        <img src={{ asset('images/perkandang.png') }} alt=""
                            class="w-[289px]  lg:mb-[10px] object-contain">
                        <span class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]">Isi Tugas
                            Perkandang</span>
                    </div>
                </a>
            </div>




        </div>



    </body>




@endsection
