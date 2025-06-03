@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')

    <body>
        <div
            class=" mx-[16px] md:mx-[200px]  mt-[90px] md:mt-[0px] grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 md:pt-[213px] gap-y-[20px] gap-x-[20px] md:gap-y-[30px] Md:gap-x-[30px]">

            {{-- @foreach ($kandang as $item)
                <a href="/list-kegiatan/{{ $item->id }}">
                    <div class=" auto flex flex-col items-center ">
                        <img src="images/Kandang.png" alt="" class="w-[289px] h-[183px] mb-[10px]">
                        <span class="text-[#0F172A] text-center font-medium text-[20px]"> {{ $item->name }}</span>
                    </div>
                </a>
            @endforeach --}}

            @foreach ($kandang as $item)
                <div class="relative group cursor-pointer ">
                    <input type="checkbox" class="kandang-checkbox hidden absolute top-2 left-2 w-5 h-5"
                        value="{{ $item->id }}">

                    <div class="kandang-item auto flex flex-col items-center" data-id="{{ $item->id }}">
                        <img src={{ asset('images/kandang.png') }} alt=""
                            class="kandang-img w-[289px]  lg:mb-[10px] object-contain">
                        <span
                            class="text-[#0F172A] text-center font-medium text-[18px] md:text-[20px]">{{ $item->name }}</span>
                    </div>
                </div>
            @endforeach



            <div class="fixed bottom-10 right-[16px] md:bottom-10 md:right-10 flex flex-col items-end gap-4 z-0 ">
                <!-- Tombol Toggle Menu -->
                <button id="toggleMenu"
                    class="bg-[#047857] hover:bg-emerald-800 text-white font-semibold text-[20px] w-[60px] h-[60px] rounded-[10px] shadow-md/50 flex items-center justify-center">
                    <img src="{{ asset('images/arrowUp.png') }}" alt="menu" class="w-[20px] h-[20px]">
                </button>

                <!-- Container tombol-tombol lainnya -->
                <div id="actionButtons" class="hidden flex 
                flex-col items-end gap-4">
                    <!-- Batal Hapus -->
                    <button id="batalHapus"
                        class="hidden bg-[#A3A1A1] hover:bg-gray-600 text-white font-semibold text-[20px] w-[60px] h-[60px] rounded-[10px] shadow-md/50 flex items-center justify-center">
                        <img src="{{ asset('images/closePutih.png') }}" alt="close" class="w-[20px] h-[20px]">
                    </button>

                    <!-- Hapus Kandang -->
                    <button id="hapusKandang"
                        class="bg-[#047857] hover:bg-emerald-800 text-white font-semibold text-[20px] w-[60px] h-[60px] rounded-[10px] shadow-md/50 flex items-center justify-center">
                        <img src="{{ asset('images/deletePutih.png') }}" alt="delete" class="w-[30px] h-[30px]">
                    </button>

                    <!-- Tambah Kandang -->
                    <button id="tambahKandang"
                        class="bg-[#047857] hover:bg-emerald-800 text-white font-semibold text-[20px] w-[60px] h-[60px] rounded-[10px] shadow-md/50 flex items-center justify-center">
                        <img src="{{ asset('images/more.png') }}" alt="more" class="w-[30px] h-[30px]">
                    </button>

                    <button id="toggleMenuBuka"
                        class="bg-[#047857] hover:bg-emerald-800 text-white font-semibold text-[20px] w-[60px] h-[60px] rounded-[10px] shadow-md/50 flex items-center justify-center">
                        <img src="{{ asset('images/arrowDown.png') }}" alt="menu" class="w-[20px] h-[20px]">
                    </button>
                </div>
            </div>
        </div>



    </body>




@endsection

@section('scripts')

    <script>
        const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
        const token = metaElements.length > 0 ? metaElements[0].content : "";
        const pathSegments = window.location.pathname.split('/');
        // hasil: ["", "s1", "task"]
        const season = pathSegments[1]; // "s1"

        document.getElementById('tambahKandang').addEventListener('click', function() {
            const swalbutton = Swal.mixin({
                customClass: {
                    confirmButton: 'bg-[#047857] hover:bg-emerald-800 text-white font-semibold text-[16px] px-4 py-2 rounded-[8px] mr-2',
                    cancelButton: 'bg-gray-400 hover:bg-gray-600 text-white font-semibold text-[16px] px-4 py-2 rounded-[8px]'
                },
                buttonsStyling: false
            });

            swalbutton.fire({
                // title: "Tambah Kandang & Jumlah Bebek",
                html: `
                    <h1 class=" text-2xl font-bold">Tambah Kandang &</h1>
                    <h1 class="mb-2 text-2xl font-bold">Jumlah Bebek</h1>
                    <input id="kandang-input" class=" capitalize" placeholder="Nama Kandang" >
                    <input id="bebek-input" class="" placeholder="Jumlah Bebek" type="number" min="0">
                    <style>
                        #kandang-input {
                            border: 2px solid #A3A1A1;
                            width: 100%;
                            height: 62px;
                            border-radius: 5px;
                            padding: 10px;
                            margin-bottom: 10px;
                            
                        }
                        #kandang-input:focus {
                            outline: none;
                            border-color: #047857;

                        }
                            #bebek-input {
                            border: 2px solid #A3A1A1;
                            width: 100%;
                            height: 62px;
                            border-radius: 5px;
                            padding: 10px;
                            margin-bottom: 10px;
                        }
                        #bebek-input:focus {
                            outline: none;
                            border-color: #047857;

                        }

                    
                    </style>
                    `,
                showCancelButton: true,
                confirmButtonText: "Tambah",
                showLoaderOnConfirm: true,
                didOpen: () => {
                    const kandangInput = document.getElementById('kandang-input');

                    kandangInput.focus();

                    kandangInput.addEventListener('input', () => {
                        const words = kandangInput.value.toLowerCase().split(' ');
                        kandangInput.value = words
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ');
                    });
                },

                preConfirm: async () => {
                    const kandangName = document.getElementById('kandang-input').value.trim();
                    const jumlahBebek = document.getElementById('bebek-input').value.trim();

                    if (!kandangName || !jumlahBebek || isNaN(jumlahBebek) || jumlahBebek < 0) {
                        Swal.showValidationMessage(`Isi nama kandang dan jumlah bebek dengan benar`);
                        return false;
                    }

                    try {
                        const response = await fetch(`/${season}/task`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                name: kandangName,
                                jumlah_bebek: jumlahBebek,
                                season: season
                            })
                        });

                        const res = await response.json();
                        if (!response.ok || res.status === 'failed') {
                            throw new Error(res.message || 'Gagal menyimpan');
                        }

                        return response;
                    } catch (error) {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        });

        //hapuss kandang
        let hapusMode = false;

        const hapusBtn = document.getElementById('hapusKandang');
        const batalBtn = document.getElementById('batalHapus');

        hapusBtn.addEventListener('click', async function() {
            const checkboxes = document.querySelectorAll('.kandang-checkbox');

            if (!hapusMode) {
                checkboxes.forEach(cb => cb.classList.remove('hidden'));
                hapusMode = true;

                // Mengubah teks menjadi icon
                hapusBtn.innerHTML =
                    `<img src="{{ asset('images/deletePutih.png') }}" alt="delete" class="w-[30px] h-[30px]">`;

                batalBtn.classList.remove('hidden'); // tampilkan tombol batal
                return;
            }

            const checked = document.querySelectorAll('.kandang-checkbox:checked');
            const ids = Array.from(checked).map(cb => cb.value);
            // Mengambil teks nama kandang yang bersebelahan dengan checkbox yang dipilih
            const names = Array.from(checked).map(cb => cb.nextElementSibling.textContent);

            if (ids.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada kandang yang dipilih',
                    text: 'Silakan pilih kandang yang ingin dihapus.',
                    customClass: {
                        confirmButton: 'bg-[#047857] hover:bg-emerald-800 text-white font-semibold text-[16px] px-4 py-2 rounded-[8px]'
                    },
                    buttonsStyling: false
                });

                return;
            }

            const confirm = await Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `${names.join(', ')}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'bg-[#047857] hover:bg-emerald-800 text-white font-semibold text-[16px] px-4 py-2 rounded-[8px] mr-2',
                    cancelButton: 'bg-gray-400 hover:bg-gray-600 text-white font-semibold text-[16px] px-4 py-2 rounded-[8px]'
                },
                buttonsStyling: false
            });

            if (confirm.isConfirmed) {
                try {
                    const response = await fetch(`/${season}/hapus-kandang`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            ids: ids
                        })
                    });

                    const result = await response.json();
                    if (result.success) {
                        Swal.fire('Berhasil!', 'Kandang telah dihapus.', 'success')
                            .then(() => window.location.reload());
                    } else {
                        Swal.fire('Gagal!', result.message || 'Terjadi kesalahan.', 'error');
                    }
                } catch (err) {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menghapus.', 'error');
                    console.error(err);
                }
            }
        });

        // Kode untuk tombol batal hapus
        batalBtn.addEventListener('click', function() {
            // Menyembunyikan checkbox
            const checkboxes = document.querySelectorAll('.kandang-checkbox');
            checkboxes.forEach(cb => cb.classList.add('hidden'));

            // Mengubah status hapusMode menjadi false
            hapusMode = false;

            // Mengubah tombol kembali ke keadaan semula
            hapusBtn.innerHTML =
                `<div class="flex items-center justify-center h-full">
                <img src="{{ asset('images/deletePutih.png') }}" alt="delete" class="w-[30px] h-[30px]">
            </div>`;

            // Menyembunyikan tombol batal
            batalBtn.classList.add('hidden');
        });

        // Nonaktifkan link ke detail kandang saat dalam mode hapus
        document.addEventListener('click', function(e) {
            if (hapusMode && e.target.closest('a[href^="/list-kegiatan/"]')) {
                e.preventDefault(); // cegah navigasi ke halaman lain
            }
        });

        //Kode ini memberikan kemampuan bagi pengguna untuk memilih atau membatalkan pilihan kandang hanya ketika mode hapus aktif
        // Menangani klik pada setiap elemen kandang (kandang-item)
        document.querySelectorAll('.kandang-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation(); // Mencegah event bubbling agar tidak konflik dengan event luar

                const checkbox = this.parentElement.querySelector('.kandang-checkbox');

                if (hapusMode) {
                    // Jika sedang dalam mode hapus, toggle status checkbox saat item diklik
                    checkbox.checked = !checkbox.checked;
                } else {
                    // Jika tidak dalam mode hapus, redirect ke halaman detail kandang
                    const id = this.dataset.id;
                    window.location.href = `list-kegiatan/${id}`;
                }
            });
        });
        //teggle menu arrow up
        const toggleMenu = document.getElementById('toggleMenu');
        const toggleMenuBuka = document.getElementById('toggleMenuBuka');
        const toggleIcon = toggleMenu.querySelector('img');
        const actionButtons = document.getElementById('actionButtons');

        let menuOpen = false;

        toggleMenu.addEventListener('click', () => {
            menuOpen = true;
            actionButtons.classList.toggle('hidden');
            toggleMenu.classList.toggle('hidden');
            toggleIcon.src = menuOpen ?
                "{{ asset('images/arrowDown.png') }}" :
                "{{ asset('images/arrowUp.png') }}";

            // Jika menu ditutup, reset ke keadaan awal
            if (!menuOpen) {
                const checkboxes = document.querySelectorAll('.kandang-checkbox');
                checkboxes.forEach(cb => {
                    cb.classList.add('hidden');
                    cb.checked = false;
                });

                hapusMode = false;
                batalBtn.classList.add('hidden');
                hapusBtn.innerHTML = `
                <img src="{{ asset('images/deletePutih.png') }}" alt="delete" class="w-[30px] h-[30px]">
            `;
            }
        });
        toggleMenuBuka.addEventListener('click', () => {
            menuOpen = false;
            actionButtons.classList.toggle('hidden');
            toggleMenu.classList.toggle('hidden');
            toggleIcon.src = menuOpen ?
                "{{ asset('images/arrowDown.png') }}" :
                "{{ asset('images/arrowUp.png') }}";
        })
    </script>

@endsection
