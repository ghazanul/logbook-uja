@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')


    <body>


        <div class=" mx-[16px] mt-[90px] md:mt-[0px]  md:mx-[60px] md:pt-[213px] ">


            <form action="{{ route('user.editPassword', ['season' => $season, 'user' => $user]) }}" method="POST">
                @method('PUT')
                @csrf
                <button
                    class="bg-[#047857] text-white text-[18px] font-semibold text-left px-[12px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">
                    Edit Password {{ $user->name }}
                </button>


    

                <div class="mb-2">
                    <label for="password" class="block text-[18px]  font-semibold text-[#0F172A] mb-1">Password Baru</label>

                    <div class="relative w-[362px] md:w-[378px]">

                        <input type="password" id="password" name="password"
                            class="border-2 border-[#A3A1A1] rounded-lg px-[12px] py-[20px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        <img onclick="togglePasswordVisibility()" id="hidePassword"
                            src="{{ asset('images/view.png') }}" alt="" width="25" height="25"
                            class="absolute top-1/2 right-3 transform -translate-y-1/2">
                        <img onclick="togglePasswordVisibility()" id="showPassword"
                            src="{{ asset('images/hide.png') }}" alt="" width="25" height="25"
                            class="hidden absolute top-1/2 right-3 transform -translate-y-1/2">
                        @error('password')
                            <small class="text-red-500 block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="mb-[15px] ">
                    <label for="password_confirmation"
                        class="block text-[18px] font-semibold text-[#0F172A] mb-1">Konfirmasi Password</label>

                    <div class="relative w-[362px] md:w-[378px]">

                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="border-2 border-[#A3A1A1] rounded-lg px-[12px] py-[20px] w-[362px] md:w-[378px] h-[62px] focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        <img onclick="togglePasswordVisibilityConfirm()" id="hidePasswordConfirm"
                            src="{{ asset('images/view.png') }}" alt="" width="25" height="25"
                            class="absolute top-1/2 right-3 transform -translate-y-1/2">
                        <img onclick="togglePasswordVisibilityConfirm()" id="showPasswordConfirm"
                            src="{{ asset('images/hide.png') }}" alt="" width="25" height="25"
                            class="hidden absolute top-1/2 right-3 transform -translate-y-1/2">
                        @error('password_confirmation')
                            <small class="text-red-500 block">{{ $message }}</small>
                        @enderror
                    </div>
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
    


    <script>
       const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const hide = document.getElementById('hide');
        const show = document.getElementById('show');

        const togglePasswordVisibility = () => {
            const type = password.type === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // passwordConfirmation.setAttribute('type', type);
            hide.style.display = type === 'password' ? 'block' : 'none';
            show.style.display = type === 'password' ? 'none' : 'block';
        }

        const hidePasswordConfirm = document.getElementById('hidePasswordConfirm');
        const showPasswordConfirm = document.getElementById('showPasswordConfirm');

        const togglePasswordVisibilityConfirm = () => {
            const type = passwordConfirmation.type === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            hidePasswordConfirm.style.display = type === 'password' ? 'block' : 'none';
            showPasswordConfirm.style.display = type === 'password' ? 'none' : 'block';
        }
    </script>

@endsection
