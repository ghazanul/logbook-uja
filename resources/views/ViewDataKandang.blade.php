@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')


    <body>


        <div class="mx-[16px] mt-[90px] md:mt-[0px] md:mx-[200px] md:pt-[213px]">
            <div class="flex flex-col items-center justify-center">
                <div
                    class="bg-[#047857] w-[142px] h-[70px] md:w-[215px] md:h-[70px] rounded-[10px] mb-[50px] shadow-md/50 text-white font-semibold text-center text-[18px] md:text-[20px] flex items-center justify-center flex-col">
                    <span>{{ $kandang->name }}</span>
                    <span class="text-[18px] font-semibold">{{ date('d-m-Y', strtotime($tanggal)) }}</span>
                </div>
            </div>

            @error('error')
                <script>
                    alert("{{ $message }}")
                </script>
            @enderror

            @if ($tugasPakan || $tugasAir || $tugasKebersihan || $TugasTelur || $tugasKeadaanBebek)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3  w-full mb-[50px] gap-x-[150px] gap-y-[30px]">


                    <div class="flex ">
                        <form action="{{ route('tugas.updatePakan', ['season' => $season, 'kandang' => $kandang]) }}" method="POST"
                            id="{{ $tugasPakan?->id }}" class="task-wrapper" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <button
                                class="bg-[#047857] text-white text-[18px] font-semibold text-left pl-[12px] w-[147px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">{{ $tugasPakan?->nama_tugas }}</button>

                            <div class="mb-[15px]">
                                <label class="block mb-[5px] text-[18px] font-semibold">Tanggal</label>
                                <input type="date" name="tanggal"
                                    value="{{ $tugasPakan?->tanggal ? date('Y-m-d', strtotime($tugasPakan?->tanggal)) : old('tanggal', '')  }}"
                                    class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                    >
                                @error('tanggal')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-[15px]">
                                <label class="block mb-[5px] text-[18px] font-semibold">Status Tugas</label>
                                <select name="status" value="{{ old('status', '') }}"
                                    class="border-2 border-[#A3A1A1] px-[12px] py-[10px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                                    <option value=""> Pilih Status</option>
                                    <option value="Sudah dikerjakan"
                                        {{ $tugasPakan?->Status == 'Sudah dikerjakan' ? 'selected' : '' }}>
                                        Sudah Dikerjakan</option>
                                    <option value="Belum dikerjakan"
                                        {{ $tugasPakan?->Status == 'Belum dikerjakan' ? 'selected' : '' }}>
                                        Belum Dikerjakan</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-[15px]">
                                <label class="block mb-[5px] text-[18px] font-semibold">Keterangan</label>
                                <textarea name="keterangan"
                                    class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[180px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">{{ $tugasPakan?->keterangan }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-[15px] relative upload-wrapper">
                                <label class="block mb-[5px] text-[18px] font-semibold"> Gambar Kegiatan</label>
                                <div
                                    class="flex items-center justify-center flex-col border-2 border-[#A3A1A1] border-dashed rounded-lg p-4 text-center w-full h-[500px] cursor-pointer hover:border-[#047857] task-image-wrapper">

                                    <img src="{{ asset('images/tugas/' . $tugasPakan?->gambar) }}"
                                        class="w-[350px] h-[500px] task-image  object-contain" alt="">

                                    <!-- Delete Icon -->
                                    <img src="{{ asset('images/delete.png') }}"
                                        class="delete-icon absolute top-2 right-2 w-[30px] h-[30px] cursor-pointer hidden mt-10"
                                        alt="Hapus Gambar">
                                </div>
                            </div>

                            <div class=" task-form flex justify-end gap-4 mt-4  mb-[50px]">

                                <!-- Tombol Save -->
                                <button type="submit"
                                    class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-save">
                                    Save
                                </button>

                                <!-- Tombol Batal (diperbarui) -->
                                <button type="button"
                                    class="bg-white hover:text-emerald-800 hover:border-emerald-800 border-[3px] border-[#047857] text-[#047857] text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-cancel">
                                    Batal
                                </button>

                                @auth
                                    @if (auth()->user()->role === 'admin')
                                        <!-- Tombol Edit -->
                                        <button type="button"
                                            class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md btn-edit">
                                            Edit
                                        </button>
                                    @endif
                                @endauth
                            </div>
                        </form>
                    </div>

                    @isset($tugasKebersihan)
                        <div class="flex ">
                            <form action="{{ route('tugas.updateKebersihan', ['season' => $season, 'kandang' => $kandang]) }}" method="POST"
                                id="{{ $tugasKebersihan?->id }}" class="task-wrapper" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <button
                                    class="bg-[#047857] text-white text-[18px] font-semibold text-left pl-[12px] w-[220px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">{{ $tugasKebersihan?->nama_tugas }}</button>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Tanggal</label>
                                    <input type="date" name="tanggal"
                                        value="{{ $tugasKebersihan?->tanggal ? date('Y-m-d', strtotime($tugasKebersihan?->tanggal)) : '' }}"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                        value="{{ old('tanggal', '') }}">
                                    @error('tanggal')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Status Tugas</label>
                                    <select name="status" value="{{ old('status', '') }}"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[10px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                                        <option value=""> Pilih Status</option>
                                        <option value="Sudah dikerjakan"
                                            {{ $tugasKebersihan?->Status == 'Sudah dikerjakan' ? 'selected' : '' }}>
                                            Sudah Dikerjakan</option>
                                        <option value="Belum dikerjakan"
                                            {{ $tugasKebersihan?->Status == 'Belum dikerjakan' ? 'selected' : '' }}>
                                            Belum Dikerjakan</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Keterangan</label>
                                    <textarea name="keterangan"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[180px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">{{ $tugasKebersihan?->keterangan }}</textarea>
                                    @error('keterangan')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px] relative upload-wrapper">
                                    <label class="block mb-[5px] text-[18px] font-semibold"> Gambar Kegiatan</label>
                                    <div
                                        class="flex items-center justify-center flex-col border-2 border-[#A3A1A1] border-dashed rounded-lg p-4 text-center w-full h-[500px] cursor-pointer hover:border-[#047857] task-image-wrapper">

                                        <img src="{{ asset('images/tugas/' . $tugasKebersihan?->gambar) }}"
                                            class="w-[350px] h-[500px] task-image  object-contain" alt="">

                                        <!-- Delete Icon -->
                                        <img src="{{ asset('images/delete.png') }}"
                                            class="delete-icon absolute top-2 right-2 w-[30px] h-[30px] cursor-pointer hidden mt-10"
                                            alt="Hapus Gambar">
                                    </div>
                                </div>



                                <div class=" task-form flex justify-end gap-4 mt-4  mb-[50px]">

                                    <!-- Tombol Save -->
                                    <button type="submit"
                                        class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-save">
                                        Save
                                    </button>

                                    <!-- Tombol Batal (diperbarui) -->
                                    <button type="button"
                                        class="bg-white hover:text-emerald-800 hover:border-emerald-800 border-[3px] border-[#047857] text-[#047857] text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-cancel">
                                        Batal
                                    </button>

                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            <!-- Tombol Edit -->
                                            <button type="button"
                                                class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md btn-edit">
                                                Edit
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                            </form>
                        </div>
                    @endisset

                    @isset($tugasAir)
                        <div class="flex ">
                            <form action="{{ route('tugas.updateAir', ['season' => $season, 'kandang' => $kandang]) }}" method="POST"
                                id="{{ $tugasAir?->id }}" class="task-wrapper" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <button
                                    class="bg-[#047857] text-white text-[18px] font-semibold text-left pl-[12px] w-[100px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">{{ $tugasAir?->nama_tugas }}</button>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Tanggal</label>
                                    <input type="date" name="tanggal"
                                        value="{{ $tugasAir?->tanggal ? date('Y-m-d', strtotime($tugasAir?->tanggal)) : '' }}"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                        value="{{ old('tanggal', '') }}">
                                    @error('tanggal')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Status Tugas</label>
                                    <select name="status" value="{{ old('status', '') }}"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[10px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                                        <option value=""> Pilih Status</option>
                                        <option value="Sudah dikerjakan"
                                            {{ $tugasAir?->Status == 'Sudah dikerjakan' ? 'selected' : '' }}>
                                            Sudah Dikerjakan</option>
                                        <option value="Belum dikerjakan"
                                            {{ $tugasAir?->Status == 'Belum dikerjakan' ? 'selected' : '' }}>
                                            Belum Dikerjakan</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Keterangan</label>
                                    <textarea name="keterangan"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[180px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">{{ $tugasAir?->keterangan }}</textarea>
                                    @error('keterangan')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px] relative upload-wrapper">
                                    <label class="block mb-[5px] text-[18px] font-semibold"> Gambar Kegiatan</label>
                                    <div
                                        class="flex items-center justify-center flex-col border-2 border-[#A3A1A1] border-dashed rounded-lg p-4 text-center w-full h-[500px] cursor-pointer hover:border-[#047857] task-image-wrapper">

                                        <img src="{{ asset('images/tugas/' . $tugasAir?->gambar) }}"
                                            class="w-[350px] h-[500px] task-image  object-contain" alt="">

                                        <!-- Delete Icon -->
                                        <img src="{{ asset('images/delete.png') }}"
                                            class="delete-icon absolute top-2 right-2 w-[30px] h-[30px] cursor-pointer hidden mt-10"
                                            alt="Hapus Gambar">
                                    </div>
                                </div>



                                <div class=" task-form flex justify-end gap-4 mt-4  mb-[50px]">

                                    <!-- Tombol Save -->
                                    <button type="submit"
                                        class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-save">
                                        Save
                                    </button>

                                    <!-- Tombol Batal (diperbarui) -->
                                    <button type="button"
                                        class="bg-white hover:text-emerald-800 hover:border-emerald-800 border-[3px] border-[#047857] text-[#047857] text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-cancel">
                                        Batal
                                    </button>

                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            <!-- Tombol Edit -->
                                            <button type="button"
                                                class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md btn-edit">
                                                Edit
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                            </form>
                        </div>
                    @endisset


                    @isset($TugasTelur)
                        <div class="flex ">
                            <form action="{{ route('tugas.updateTelur', ['season' => $season, 'kandang' => $kandang]) }}" method="POST"
                                id="{{ $TugasTelur?->id }}" class="task-wrapper" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <button
                                    class="bg-[#047857] text-white text-[18px] font-semibold text-left pl-[12px] w-[147px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">{{ $TugasTelur?->nama_tugas }}</button>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Tanggal</label>
                                    <input type="date" name="tanggal"
                                        value="{{ $TugasTelur?->tanggal ? date('Y-m-d', strtotime($TugasTelur?->tanggal)) : '' }}"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                        value="{{ old('tanggal', '') }}">
                                    @error('tanggal')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Total Telur Hari
                                        Ini</label>
                                    <input name="jumlah_telur" type="number"
                                        value="{{ $TugasTelur?->tugasTelur?->jumlah_telur }}"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                        value="{{ old('jumlah_telur', '') }}">
                                    @error('jumlah_telur')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Telur Rusak Hari
                                        Ini</label>
                                    <input name="jumlah_telur_rusak" type="number"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                        value="{{ $TugasTelur?->tugasTelur?->jumlah_telur_rusak }}" />
                                    @error('jumlah_telur_rusak')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px]">
                                    <label class="block mb-[5px] text-[18px] font-semibold">Keterangan</label>
                                    <textarea name="keterangan"
                                        class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[180px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">{{ $TugasTelur?->keterangan }}</textarea>
                                    @error('keterangan')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-[15px] relative upload-wrapper">
                                    <label class="block mb-[5px] text-[18px] font-semibold"> Gambar Kegiatan</label>
                                    <div
                                        class="flex items-center justify-center flex-col border-2 border-[#A3A1A1] border-dashed rounded-lg p-4 text-center w-full h-[500px] cursor-pointer hover:border-[#047857] task-image-wrapper">

                                        <img src="{{ asset('images/tugas/' . $TugasTelur?->gambar) }}"
                                            class="w-[350px] h-[500px] task-image  object-contain" alt="">

                                        <!-- Delete Icon -->
                                        <img src="{{ asset('images/delete.png') }}"
                                            class="delete-icon absolute top-2 right-2 w-[30px] h-[30px] cursor-pointer hidden mt-10"
                                            alt="Hapus Gambar">
                                    </div>
                                </div>
                                <div class=" task-form flex justify-end gap-4 mt-4  mb-[50px]">

                                    <!-- Tombol Save -->
                                    <button type="submit"
                                        class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-save">
                                        Save
                                    </button>

                                    <!-- Tombol Batal (diperbarui) -->
                                    <button type="button"
                                        class="bg-white hover:text-emerald-800 hover:border-emerald-800 border-[3px] border-[#047857] text-[#047857] text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-cancel">
                                        Batal
                                    </button>

                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            <!-- Tombol Edit -->
                                            <button type="button"
                                                class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md btn-edit">
                                                Edit
                                            </button>
                                        @endif
                                    @endauth
                                </div>

                            </form>
                        </div>
                    @endisset

                    @isset($tugasKeadaanBebek)
                        <div class="flex">
                            <form action="{{ route('tugas.updateKeadaanBebek', ['season' => $season, 'kandang' => $kandang]) }}"
                                id="{{ $tugasKeadaanBebek?->id }}" method="POST" class="task-wrapper"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="">
                                    <button
                                        class="bg-[#047857] text-white text-[18px] font-semibold text-left pl-[12px] w-[260px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">{{ $tugasKeadaanBebek?->nama_tugas }}</button>

                                    <div class="mb-[15px]">
                                        <label class="block mb-[5px] text-[18px] font-semibold">Tanggal</label>
                                        <input type="date" name="tanggal"
                                            value="{{ $tugasKeadaanBebek?->tanggal ? date('Y-m-d', strtotime($tugasKeadaanBebek?->tanggal)) : '' }}"
                                            class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                                        @error('tanggal')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-[15px]">
                                        <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Total Bebek</label>
                                        <input type="number" name="jumlah_total_bebek"
                                            value="{{ $tugasKeadaanBebek?->tugasKeadaanBebek?->jumlah_total_bebek }}"
                                            class=" text-center border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">

                                        @error('jumlah_total_bebek')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-[15px]">
                                        <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Sehat Hari
                                            Ini</label>
                                        <input type="number" name="jumlah_bebek_sehat"
                                            value="{{ $tugasKeadaanBebek?->tugasKeadaanBebek?->jumlah_bebek_sehat }}"
                                            class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">

                                        @error('jumlah_bebek_sakit')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-[15px]">
                                        <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Sakit Hari
                                            Ini</label>
                                        <input type="number" name="jumlah_bebek_sakit"
                                            value="{{ $tugasKeadaanBebek?->tugasKeadaanBebek?->jumlah_bebek_sakit }}"
                                            class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                                        @error('jumlah_bebek_sakit')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-[15px]">
                                        <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Mati Hari
                                            Ini</label>
                                        <input type="number" name="jumlah_bebek_mati"
                                            value="{{ $tugasKeadaanBebek?->tugasKeadaanBebek?->jumlah_bebek_mati }}"
                                            class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]"
                                            value="{{ old('jumlah_bebek_mati', '') }}">
                                        @error('jumlah_bebek_mati')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-[15px]">
                                        <label class="block mb-[5px] text-[18px] font-semibold">Keterangan</label>
                                        <textarea name="keterangan"
                                            class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-[362px] md:w-[378px] h-[180px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">{{ $tugasKeadaanBebek?->keterangan }} </textarea>
                                        @error('keterangan')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-[15px] relative upload-wrapper">
                                        <label class="block mb-[5px] text-[18px] font-semibold"> Gambar Kegiatan</label>
                                        <div
                                            class="flex items-center justify-center flex-col border-2 border-[#A3A1A1] border-dashed rounded-lg p-4 text-center w-full h-[500px] cursor-pointer hover:border-[#047857] task-image-wrapper">

                                            <img src="{{ asset('images/tugas/' . $tugasKeadaanBebek?->gambar) }}"
                                                class="w-[350px] h-[500px] task-image  object-contain" alt="">

                                            <!-- Delete Icon -->
                                            <img src="{{ asset('images/delete.png') }}"
                                                class="delete-icon absolute top-2 right-2 w-[30px] h-[30px] cursor-pointer hidden mt-10"
                                                alt="Hapus Gambar">
                                        </div>
                                    </div>



                                    <div class=" task-form flex justify-end gap-4 mt-4  mb-[50px]">

                                        <!-- Tombol Save -->
                                        <button type="submit"
                                            class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-save">
                                            Save
                                        </button>

                                        <!-- Tombol Batal (diperbarui) -->
                                        <button type="button"
                                            class="bg-white hover:text-emerald-800 hover:border-emerald-800 border-[3px] border-[#047857] text-[#047857] text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md hidden btn-cancel">
                                            Batal
                                        </button>

                                        @auth
                                            @if (auth()->user()->role === 'admin')
                                                <!-- Tombol Edit -->
                                                <button type="button"
                                                    class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md btn-edit">
                                                    Edit
                                                </button>
                                            @endif
                                        @endauth
                                    </div>

                                </div>
                            </form>
                        </div>
                    @endisset
            @endif

        </div>


    </body>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskWrappers = document.querySelectorAll('.task-wrapper');

            taskWrappers.forEach(wrapper => {
                const editBtn = wrapper.querySelector('.btn-edit');
                const saveBtn = wrapper.querySelector('.btn-save');
                const cancelBtn = wrapper.querySelector('.btn-cancel');
                const inputs = wrapper.querySelectorAll('input, select, textarea');
                const inputTanggal = wrapper.querySelector('input[name="tanggal"]');


                // if (!editBtn) return;
                // Lock all inputs by default
                inputs.forEach(input => {
                    input.setAttribute('readonly', true);
                    if (input.tagName === 'SELECT' || input.tagName === 'TEXTAREA') {
                        input.setAttribute('disabled', true);
                    }
                });

                editBtn.addEventListener('click', () => {
                    editBtn.classList.add('hidden');
                    saveBtn.classList.remove('hidden');
                    cancelBtn.classList.remove('hidden');

                    inputs.forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    });
                    inputTanggal.setAttribute('readonly', true);
                });

                cancelBtn.addEventListener('click', () => {
                    saveBtn.classList.add('hidden');
                    cancelBtn.classList.add('hidden');
                    editBtn.classList.remove('hidden');

                    inputs.forEach(input => {
                        input.setAttribute('readonly', true);
                        if (input.tagName === 'SELECT' || input.tagName === 'TEXTAREA') {
                            input.setAttribute('disabled', true);
                        }
                    });
                });
            });
        });

        // Tambahan untuk handle icon delete gambar
        const imageWrappers = document.querySelectorAll('.upload-wrapper');

        imageWrappers.forEach(wrapper => {
            const deleteIcon = wrapper.querySelector('.delete-icon');
            const image = wrapper.querySelector('.task-image');

            wrapper.closest('.task-wrapper').querySelector('.btn-edit').addEventListener('click', () => {
                deleteIcon.classList.remove('hidden');
            });

            wrapper.closest('.task-wrapper').querySelector('.btn-cancel').addEventListener('click', () => {
                deleteIcon.classList.add('hidden');
            });

            deleteIcon.addEventListener('click', async () => {
                image.src = ''; // Hapus tampilan gambar
                deleteIcon.classList.add('hidden');
                const form = deleteIcon.closest('form');
                const id = form.id;

                // Tambahkan hidden input agar backend tahu gambar dihapus
                let inputDelete = wrapper.querySelector('input[name="hapus_gambar[]"]');
                if (!inputDelete) {
                    inputDelete = document.createElement('input');
                    spanText = document.createElement('span');
                    // spanText.textContent = 'Pilih Gambar';
                    inputDelete.type = 'file';
                    inputDelete.name = 'gambar';
                    inputDelete.classList.add('border-2', 'border-[#A3A1A1]', 'px-[12px]', 'py-[20px]',
                        'rounded-[10px]', 'w-[362px]', 'md:w-[378px]', 'focus:outline-none',
                        'focus:ring-[2px]', 'focus:ring-[#047857]');
                    wrapper.querySelector('.task-image-wrapper').remove();
                    // wrapper.style.display = 'relative';
                    // inputDelete.style.position = 'absolute';
                    // inputDelete.style.top = '0';
                    // inputDelete.style.left = '0';
                    // inputDelete.style.width = '100%';
                    // inputDelete.style.height = '100%';
                    // inputDelete.style.opacity = '0';
                    // inputDelete.style.cursor = 'pointer';
                    // spanText.style.position = 'absolute';
                    // spanText.style.top = '50%';
                    // spanText.style.left = '50%';
                    // spanText.style.transform = 'translate(-50%, -50%)';
                    // spanText.style.color = 'gray';
                    // spanText.style.fontSize = '1.5rem';
                    // spanText.style.textShadow = '2px 2px 4px rgba(0, 0, 0, 0.5)';
                    wrapper.appendChild(spanText);

                    image.remove();
                    // inputDelete.value = wrapper.dataset.taskId;
                    wrapper.appendChild(inputDelete);
                }
            });
        });
    </script>



@endsection


{{-- @extends('layouts.app')

@section('title', 'Halaman belakang')

@section('content')

```
<body>


    <div class="mx-[200px] pt-[213px]">
        <div class="flex flex-col items-center justify-center">
            <div
                class="bg-[#047857] w-[215px] h-[70px] rounded-[10px] mb-[50px] shadow-md/50 text-white font-semibold text-center text-[20px] flex items-center justify-center flex-col">
                <span>{{ $kandang->name }}</span>
                <span class="text-[18px] font-semibold">{{ $tanggal }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3  w-full mb-[50px] gap-x-[150px] gap-y-[30px]">

            @foreach ($tugas as $item)
                + 
                <div class="">
                    <button
                        class="inline-block bg-[#047857] text-white text-[18px] font-semibold text-left px-4 py-3 shadow-md mb-6 rounded-r-[10px] whitespace-nowrap">{{ $item->nama_tugas }}</button>

                    <div class="mb-[15px]">
                        <label class="block mb-[5px] text-[18px] font-semibold">Tanggal</label>
                        <input type="date" value={{ $item->tanggal }}
                            class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-full h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                    </div>

                    @if ($item->nama_tugas === 'Air' || $item->nama_tugas === 'Pakan' || $item->nama_tugas === 'Kebersihan Kandang')
                        <div class="mb-[15px]">
                            <label class="block mb-[5px] text-[18px] font-semibold">Status Tugas</label>
                            <select
                                class="border-2 border-[#A3A1A1] px-[12px] py-[10px] rounded-[10px] w-full h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                                <option value=""> Pilih Status</option>
                                <option value="Sudah dikerjakan" {{ $item->status === 'Sudah dikerjakan' ? 'selected' : '' }}>Sudah Dikerjakan</option>
                                <option value="Belum dikerjakan" {{ $item->status === 'Belum dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                            </select>
                        </div>
                    @endif


                    <div class="mb-[15px]">
                        <label class="block mb-[5px] text-[18px] font-semibold">Keterangan</label>
                        <textarea
                            class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-full h-[180px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">{{ $item->keterangan }}</textarea>
                    </div>


                    @if ($item->nama_tugas === 'Update Keadaan Bebek')
                        <div class="mb-[15px]">
                            <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Total Bebek</label>
                            <input type="text" value="{{ $kandang->jumlah_ternak }}"
                                class=" border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-full h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                        </div>

                        <div class="mb-[15px]">
                            <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Sehat Hari Ini</label>
                            <input type="text" value="{{ $item->tugasKeadaanBebek->jumlah_bebek_sehat }}"
                                class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-full h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                        </div>

                        <div class="mb-[15px]">
                            <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Sakit Hari Ini</label>
                            <input type="text" value="{{ $item->tugasKeadaanBebek->jumlah_bebek_sakit }}"
                                class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-full h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                        </div>

                        <div class="mb-[15px]">
                            <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Bebek Mati Hari Ini</label>
                            <input type="text" value="{{ $item->tugasKeadaanBebek->jumlah_bebek_mati }}"
                                class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-full h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                        </div>
                    @elseif ($item->nama_tugas === 'Telur')
                        <div class="mb-[15px]">
                            <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Total Telur Hari Ini</label>
                            <input type="text"
                                class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-full h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                        </div>

                        <div class="mb-[15px]">
                            <label class="block mb-[5px] text-[18px] font-semibold">Jumlah Telur Rusak Hari Ini</label>
                            <input type="text"
                                class="border-2 border-[#A3A1A1] px-[12px] py-[20px] rounded-[10px] w-full h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">
                        </div>
                    @endif

                    <div class="mb-[15px] ">

                        <label class="block mb-[5px] text-[18px] font-semibold"> Gambar Kegiatan</label>
                        <div
                            class="flex items-center justify-center flex-col border-2 border-[#A3A1A1] border-dashed rounded-lg p-4 text-center w-full h-[500px] cursor-pointer hover:border-[#047857] task-image-wrapper">
                            <img src="{{ asset('storage/images/tugas/' . $item->gambar) }}" class="w-[400px] h-[500px]"
                                alt="">
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-4  mb-[50px]">

                        <button
                            class="bg-white hover:text-emerald-800 hover:border-emerald-800  border-[3px] border-[#047857]  text-[#047857] text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md">
                            Save
                        </button>
                        <button
                            class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] font-semibold px-6 py-2 w-[110px] h-[50px] rounded-[10px] shadow-md">
                            Edit
                        </button>
                    </div>


                </div>
            @endforeach
        </div>


</body>
```

@endsection --}}
