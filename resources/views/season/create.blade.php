@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')


    <body>

        @php
            $seasonSegment = request()->segment(1); // Ambil 's1' dari URL seperti /s1/home
        @endphp


        <div class=" mx-[16px] mt-[90px] md:mt-[0px]  md:mx-[60px] md:pt-[213px] ">


            <form action="{{ route('season.store', ['season' => $season]) }}" method="POST">
                @csrf
                <button
                    class="bg-[#047857] text-white text-[18px] font-semibold text-left pl-[12px] w-[147px] md:w-[147px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">Tambah
                    Season</button>


                <div class="mb-2">
                    <label for="name" class="block text-[18px] font-semibold text-[#0F172A] mb-1">Nama Season</label>
                    <input type="text" id="name" name="name"
                        class="border-2 border-[#A3A1A1] rounded-lg px-[12px] py-[20px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    @error('name')
                        <small class="text-red-500 block">{{ $message }}</small>
                    @enderror
                </div>
                

                <div class="w-[362px] md:w-[378px]">
                    <button type="submit"
                        class="bg-[#047857] ms-auto block text-white text-[18px] font-semibold text-center  w-[123px] md:w-[147px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-[10px]">Tambah</button>
                </div>
            </form>
        </div>
        </div>
    </body>


@endsection

@section('scripts')
    <script>

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                // showCloseButton: true,
            })
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1500
            })
        @endif
    </script>
@endsection
