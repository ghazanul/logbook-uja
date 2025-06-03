@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')


    <body>


        <div class=" mx-[16px] mt-[90px] md:mt-[0px]  md:mx-[60px] md:pt-[213px] ">


            <div class="flex flex-col ">
                <button
                    class="bg-[#047857] text-white text-[18px] font-semibold text-left pl-[12px] w-[123px] md:w-[147px] h-[45px]  md:h-[54px] shadow-md mb-6 rounded-r-[10px]">List
                    Season</button>

                @php
                    $seasonSegment = request()->segment(1); // Ambil 's1' dari URL seperti /s1/home
                @endphp

                <div class="w-[50%]">
                    <a href="/{{ $seasonSegment }}/season/create"
                        class="bg-[#047857] ms-auto block  cursor-pointer hover:bg-emerald-800 text-center text-white text-[15px] font-semibold  w-[123px] md:w-[147px] py-2 shadow-md mb-6 rounded-[10px]">Tambah
                    </a>
                    <table class="w-full " cellpadding="5">
                        <thead class=" text-white text-[18px]">
                            <tr class="bg-[#047857]">
                                <th scope="col" class="px-6 py-3">
                                    Nama Season
                                </th>


                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($seasons as $season)
                                <tr class="border-b border-[#047857] p-5 ">
                                    <td class="text-center py-2">{{ $season->name }}</td>

                                    <td class="flex justify-center py-2">
                                        <a href="/{{ $seasonSegment }}/season/{{ $season->id }}/edit" title="edit">
                                            <img src="{{ asset('images/edit.png') }}" class="bg-[#047857] p-1 me-3 rounded "
                                                width="40" height="40" alt="edit">
                                        </a>

                                        <form onclick="hapusSeason({{ $season->id }})">
                                            <img src="{{ asset('images/deletePutih.png') }}" width="40" height="40"
                                                class="bg-[#047857] p-1 me-3 rounded cursor-pointer" title="Delete"
                                                alt="delete">

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                </div>

            </div>
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

        @if (request()->has('msg'))

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ request('msg') }}',
                showConfirmButton: true,
                // showCloseButton: true,
            })

            window.history.replaceState({}, '', window.location.href.split('?')[0]);
        @endif
        const pathSegments = window.location.pathname.split('/');
        const season = pathSegments[1]; // "s1"
        function hapusSeason(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'inline-block !ml-2 bg-[#047857] text-white ms-auto block  cursor-pointer hover:bg-emerald-800 text-center text-white text-[15px] font-semibold  w-[123px] md:w-[147px] py-2 shadow-md mb-6 rounded-[10px]',
                    cancelButton: 'border border-[#047857] text-[#047857] ms-auto block  cursor-pointer text-center text-[#047857] text-[15px] font-semibold  w-[123px] md:w-[147px] py-2 shadow-md mb-6 rounded-[10px]'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak, batalkan!',
                reverseButtons: true
            }).then(async (result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman login atau logout
                    const response = await fetch(`/${season}/season/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    const responseJson = await response.json()
                    window.location.href =
                        `/${season}/season?msg=${encodeURIComponent(responseJson.message)}`; // Ganti sesuai kebutuhanmu
                }
            })
        }
    </script>
@endsection
