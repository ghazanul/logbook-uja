@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')

    <body>

        <div class=" flex flex-col items-center justify-center mt-[90px] md:mt-[0px] md:pt-[213px] ">

            <!-- Tombol Kandang 1 -->
            @isset($kandang)
                <button
                    class="bg-[#047857] text-white font-semibold text-center text-[20px] w-[215px] h-[54px] rounded-[10px] mb-[50px]">
                    {{ $kandang->name }}
                </button>
            @endisset

            @php
                $season = request()->segment(1); // Ambil 's1' dari URL seperti /s1/home
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 justify-center gap-[24px] mx-[16px]">
                <!-- Baris berisi 3 tugas -->
                <a href="/{{ $season }}/list-TugasPakan{{ isset($kandang) ? '/' . $kandang->id : '' }}">
                    <div class="flex gap-x-[30px]">
                        <!-- pakan -->
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('images/pakan.png') }}" alt="Kandang 2"
                                class="w-[289px]  lg:mb-[10px] object-contain">
                            <span class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]">Pakan</span>
                        </div>
                    </div>
                </a>

                <!-- Kebersihan Kandang -->
                <a href="/{{ $season }}/list-TugasKebersihanKandang{{ isset($kandang) ? '/' . $kandang->id : '' }}">
                    <div class="flex flex-col items-center">
                        <img src= "{{ asset('images/kebersihan.png') }}" alt="Kandang 3"
                            class="w-[289px]  lg:mb-[10px] object-contain">
                        <span class="text-[#0F172A] text-center font-medium leading-5 text-[18px] md:text-[20px]">Kebersihan
                            Kandang</span>
                    </div>
                </a>
                <!-- Minum -->
                <a href="/{{ $season }}/list-TugasAir{{ isset($kandang) ? '/' . $kandang->id : '' }}">
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('images/minum.png') }}" alt="Kandang 3"
                            class="w-[289px]  lg:mb-[10px] object-contain">
                        <span class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]">Air</span>
                    </div>
                </a>

                <a class="w-full md:hidden" href="/{{ $season }}/list-TugasTelur{{ isset($kandang) ? '/' . $kandang->id : '' }}">
                    <div class="flex gap-x-[30px]">
                        <!-- Telur -->
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('images/telur.png') }}" alt="Kandang 2"
                                class="w-[289px] lg:mb-[10px] object-contain">
                            <span class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]">Telur</span>
                        </div>
                    </div>
                </a>

                <!-- Update Keadaan Bebek -->
                <a class="w-full md:hidden"
                    href="/{{ $season }}/list-TugasUpdateKeadaanBebek{{ isset($kandang) ? '/' . $kandang->id : '' }}" class="">
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('images/updateBebek.png') }}" alt="Kandang 3"
                            class="w-[289px]  lg:mb-[10px] object-contain">
                        <span class="text-[#0F172A] text-center font-medium text-[18px] leading-5  md:text-[20px]">Update
                            Keadaan Bebek</span>
                    </div>
                </a>
            </div>

            <!-- Baris berisi 2 tugas -->

            <div class="md:flex justify-center gap-[24px] mx-[16px] mt-[30px] hidden">
                <a class="w-full" href="/{{ $season }}/list-TugasTelur{{ isset($kandang) ? '/' . $kandang->id : '' }}" class="md:hidden">
                    <div class="flex gap-x-[30px]">
                        <!-- Telur -->
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('images/telur.png') }}" alt="Kandang 2"
                                class="w-[289px] lg:mb-[10px] object-contain">
                            <span class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]">Telur</span>
                        </div>
                    </div>
                </a>

                <!-- Update Keadaan Bebek -->
                <a class="w-full" href="/{{ $season }}/list-TugasUpdateKeadaanBebek{{ isset($kandang) ? '/' . $kandang->id : '' }}"
                    class="md:hidden">
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('images/updateBebek.png') }}" alt="Kandang 3"
                            class="w-[289px]  lg:mb-[10px] object-contain">
                        <span class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]">Update Keadaan
                            Bebek</span>
                    </div>
                </a>
            </div>

        </div>




    </body>

@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                // showCloseButton: true,
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
@endsection
