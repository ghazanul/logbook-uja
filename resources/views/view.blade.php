@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')

    <body>
        <div class="mx-[16px] md:mx-[200px] mt-[90px] md:mt-[0px] grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 md:pt-[213px] gap-y-[20px] gap-x-[20px] md:gap-y-[30px] Md:gap-x-[30px]">

            @foreach ($kandang as $item)
                <a href="view-data-kandang/{{ $item->id }}">
                    <div class=" auto flex flex-col items-center ">
                        <img src={{ asset('images/kandang.png') }} alt="" class="w-[289px]  lg:mb-[10px] object-contain">
                        <span class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]"> {{ $item->name }}</span>
                    </div>
                </a>
            @endforeach

    </body>

@endsection
