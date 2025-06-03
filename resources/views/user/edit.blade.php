@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')


    <body>


        <div class=" mx-[16px] mt-[90px] md:mt-[0px]  md:mx-[60px] md:pt-[213px] ">


            <form action="{{ route('user.update', ['season' => $season, 'user' => $user]) }}" method="POST">
                @method('PUT')
                @csrf
                <button
                    class="bg-[#047857] text-white text-[18px] font-semibold text-left px-[12px]  h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">
                    Edit User {{ $user->name }}
                </button>


                <div class="mb-2">
                    <label for="name" class="block text-[18px] font-semibold text-[#0F172A] mb-1">Nama</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}"
                        class="border-2 border-[#A3A1A1] rounded-lg w-[362px] md:w-[378px] h-[62px] px-[12px] py-[20px] focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    @error('name')
                        <small class="text-red-500 block">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="username" class="block text-[18px] font-semibold text-[#0F172A] mb-1">Username</label>
                    <input type="text" id="username" name="username" value="{{ $user->username }}"
                        class="border-2 border-[#A3A1A1] rounded-lg px-[12px] py-[20px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    @error('username')
                        <small class="text-red-500 block">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-2">

                    <label for="role" class="block text-[18px] font-semibold text-[#0F172A] mb-1">Role</label>
                    <select name="role" id="role"
                        class="border-2 border-[#A3A1A1] rounded-lg w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-2 focus:ring-emerald-600"
                        id="">
                        <option value="">Role</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa</option>
                    </select>
                    @error('role')
                        <small class="text-red-500 block">{{ $message }}</small>
                    @enderror
                </div>
               
                <div class="w-[362px] md:w-[378px]">
                    <button type="submit"
                        class="bg-[#047857] ms-auto block text-white text-[18px] font-semibold text-center  w-[123px] md:w-[147px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-[10px]">Ubah</button>
                </div>
            </form>
        </div>
        </div>
    </body>


@endsection

@section('scripts')

@endsection
