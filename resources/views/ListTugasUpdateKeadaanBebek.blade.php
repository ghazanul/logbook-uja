@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')


    <body>
        <div class=" mx-[16px] mt-[90px] md:mt-[0px]  md:mx-[60px] md:pt-[213px]">
            @isset($kandang)
                <div class="flex flex-col items-center justify-center">
                    <div
                        class="bg-[#047857] flex items-center justify-center text-white font-semibold text-center text-[18px] md:text-[20px] w-[142px] h-[45px] md:w-[215px] shadow-md/50 md:h-[54px] rounded-[10px] mb-[50px]">
                        {{ $kandang->name }}
                    </div>
                </div>
            @endisset
            <div class="flex">
                @isset($kandang)
                    <form action="{{ route('tugas.storeUpdateKeadaanBebek', ['season' => $season, 'kandang' => $kandang]) }}" method="POST"
                        enctype="multipart/form-data">
                    @endisset
                    <form action="{{ route('tugas.storeUpdateKeadaanBebeks', ['season' => $season]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="">
                            <button
                                class="bg-[#047857] text-white text-[18px] font-semibold text-left pl-[12px] w-[260px] h-[45px] md:h-[54px] shadow-md mb-6 rounded-r-[10px]">Update
                                Keadaan Bebek</button>
                            @isset($kandangs)
                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold" id="pilih-kandang">Pilih
                                        Kandang</label>
                                    <div class="grid grid-cols-2">
                                        @foreach ($kandangs as $kandang)
                                            <div>
                                                <input type="checkbox" name="kandang[]"
                                                    id="pilih-kandang-checkbox-{{ $kandang->id }}" value="{{ $kandang->id }}">
                                                <label
                                                    for="pilih-kandang-checkbox-{{ $kandang->id }}">{{ $kandang->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="text-[#047857] border p-2 rounded mt-2"
                                        onclick="pilihSemuaKandang()">Pilih Semua</button>
                                    <button type="button" class="ml-2 border p-2 rounded"
                                        onclick="batalPilihSemuaKandang()">Batal</button>
                                </div>
                            @endisset
                            <div class="mb-[15px]">
                                <label class="block mb-[5px] text-[18px] font-semibold">Tanggal</label>
                                <input type="date" name="tanggal"
                                    class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                    value="{{ old('tanggal', '') }}">
                                @error('tanggal')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            @if (!isset($kandangs))
                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Total Bebek</label>
                                    <input type="number" name="jumlah_total_bebek"
                                        class=" text-center border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                        value="{{ old('jumlah_total_bebek', $kandang->jumlah_ternak) }}" readonly>
                                    @error('jumlah_total_bebek')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-[15px]">
                                <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Sehat Hari Ini</label>
                                <input type="number" name="jumlah_bebek_sehat"
                                    class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                    value="{{ old('jumlah_bebek_sehat', '') }}">
                                @error('jumlah_bebek_sakit')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-[15px]">
                                <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Sakit Hari Ini</label>
                                <input type="number" name="jumlah_bebek_sakit"
                                    class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                    value="{{ old('jumlah_bebek_sakit', '') }}">
                                @error('jumlah_bebek_sakit')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-[15px]">
                                <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Mati Hari Ini</label>
                                <input type="number" name="jumlah_bebek_mati"
                                    class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                    value="{{ old('jumlah_bebek_mati', '') }}">
                                @error('jumlah_bebek_mati')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-[15px]">
                                <label class="block mb-[5px] text-[18px] font-semibold">Keterangan</label>
                                <textarea name="keterangan"
                                    class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[180px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">{{ old('keterangan', '') }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-[15px] ">
                                <label class="block mb-[5px] text-[18px] font-semibold"> Upload Kegiatan</label>
                                <input
                                    class="px-4 py-2 border-2 border-[#A3A1A1] rounded-lg w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-2 focus:ring-emerald-600 justify-center items-center"
                                    type="file" id="File-upload" accept="image/*" name="gambar" class="border">
                                @error('gambar')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end gap-4 mt-4  mb-[50px]">
                                <button type="submit"
                                    class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md">
                                    Save
                                </button>
                            </div>

                        </div>
                    </form>
            </div>
        </div>
    </body>


@endsection

@section('scripts')
    <script>
        function pilihSemuaKandang() {

            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        }

        function batalPilihSemuaKandang() {

            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
        }
    </script>
@endsection
