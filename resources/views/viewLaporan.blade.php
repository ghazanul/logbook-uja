@extends('layouts.app')

@section('title', 'Halaman belakang')


@section('content')

    <body>
        <div id="app" class=" mx-[16px] md:mx-[200px]  mt-[90px] md:mt-[0px] md:pt-[213px] ">



            <div class=" w-full ">
                <label
                    class="bg-[#047857] flex items-center justify-center text-white font-semibold text-center text-[18px] md:text-[20px] w-full h-[45px] md:w-[215px] shadow-md/50 md:h-[54px] rounded-[10px] mb-[50px] mx-auto"
                    id="pilih-kandang">Pilih Kandang</label>

                @php
                    $season = request()->segment(1); // Ambil 's1' dari URL seperti /s1/home
                @endphp

                <form action="/{{ $season }}/tugas/export">
                    <div class="flex flex-col md:flex-row mb-16 items-center justify-center gap-[20px] mx-auto">
                        <div class="flex flex-col md:flex-row gap-[20px] items-center">
                            <div class=" gap-[20px] text-[18px] grid grid-cols-3 md:grid-cols-5">
                                @foreach ($kandangs as $kandang)
                                    <div>
                                        <input type="checkbox" name="kandang[]"
                                            id="pilih-kandang-checkbox-{{ $kandang->id }}" value="{{ $kandang->id }}">
                                        <label for="pilih-kandang-checkbox-{{ $kandang->id }}">{{ $kandang->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div>
                                <button type="button"
                                    class="bg-[#047857] h-[50px] w-[50px]  p-2 rounded cursor-pointer hover:bg-emerald-800"
                                    onclick="pilihSemuaKandang()"><img src="{{ asset('images/all.png') }}" alt=""
                                        class="w-[35px] h-[35px]"></button>
                                <button type="button"
                                    class="ml-2  bg-[#047857]  p-2 rounded h-[50px] cursor-pointer hover:bg-emerald-800 w-[50px]"
                                    onclick="batalPilihSemuaKandang()"><img src="{{ asset('images/closePutih.png') }}"
                                        alt="" class="w-[20px] h-[20px] mx-auto"></button>
                            </div>
                        </div>
                        <button type="button" id="lihat-semua-data" @click="lihatSemuaData()"
                            class="bg-[#047857] hover:bg-emerald-800 text-white text-[18px] px-6 py-2 w-[200px] h-[50px] rounded-[10px] shadow-md">
                            Lihat Semua Data
                            </button=>

                    </div>

                    <div class="flex  justify-center max-w-[1200px] mx-auto mb-[50px]">


                        <div class="flex  flex-col pl-5 md:flex-row gap-5 w-[50%]">

                            <input name="dates" id="dates"
                                class="border-2 border-[#A3A1A1] px-[12px] text-center py-[20px] rounded-[10px] w-full md:w-[320px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">

                            <!-- Tombol lihat pertanggal -->
                            <button @click="laporanPertanggal()" type="button"
                                class="flex items-center gap-2 bg-[#047857]  hover:bg-emerald-800 w-full md:w-[362px]  justify-center text-white px-4 py-2 h-[62px] rounded-md shadow-md">

                                Laporan Data per Tanggal
                            </button>
                        </div>
                    </div>


                    <!-- Tombol Download -->
                    <button type="submit" v-if="tampilDownloadFilterData || tampilDownloadFilterTanggal"
                        class="flex items-center ms-auto mb-5 gap-2 bg-[#047857]  hover:bg-emerald-800 w-[362px] md:w-[200px]  justify-center text-white px-4 py-2 h-[62px] rounded-md shadow-md">
                        <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24">
                            <path d="M12 16l4-5h-3V4h-2v7H8l4 5zm-9 4v2h18v-2H3z" />
                        </svg>
                        @{{ tampilDownloadFilterData ? 'Download Laporan Data' : 'Download Laporan Per Tanggal' }}
                    </button>
                </form>

            </div>

            <div class="overflow-x-auto ">
                <table class="table-fixed w-full border-collapse mb-10">
                    <thead>
                        <tr class="bg-[#047857] text-white">
                            <th class="px-4 py-2 border w-[200px]">Nama Kandang</th>
                            <th class="px-4 py-2 border w-[200px]">Tanggal</th>
                            <th class="px-4 py-2 border w-[200px]">Nama Tugas</th>
                            <th class="px-4 py-2 border w-[200px]">Status</th>
                            <th class="px-4 py-2 border w-[200px]">Jumlah Ternak</th>
                            <th class="px-4 py-2 border w-[200px]">Keterangan</th>
                            <th class="px-4 py-2 border w-[200px]">Jumlah Telur</th>
                            <th class="px-4 py-2 border w-[200px]">Jumlah Telur Rusak</th>
                            <th class="px-4 py-2 border w-[200px]">Jumlah Bebek</th>
                            <th class="px-4 py-2 border w-[200px]">Jumlah Bebek Sehat</th>
                            <th class="px-4 py-2 border w-[200px]">Jumlah Bebek Sakit</th>
                            <th class="px-4 py-2 border w-[200px]">Jumlah Bebek Mati</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in tugas">
                            <td class="px-4 py-2 border">
                                @{{ item.kandang.name }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.tanggal }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.nama_tugas }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.Status }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.kandang.jumlah_ternak }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.keterangan }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.tugas_telur?.jumlah_telur ? item.tugas_telur?.jumlah_telur : "-" }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.tugas_telur?.jumlah_telur_rusak ? item.tugas_telur?.jumlah_telur_rusak : "-" }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.tugas_keadaan_bebek?.jumlah_total_bebek ? item.tugas_keadaan_bebek?.jumlah_total_bebek : "-" }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.tugas_keadaan_bebek?.jumlah_bebek_sehat ? item.tugas_keadaan_bebek?.jumlah_bebek_sehat : "-" }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.tugas_keadaan_bebek?.jumlah_bebek_sakit ? item.tugas_keadaan_bebek?.jumlah_bebek_sakit : "-" }}
                            </td>
                            <td class="px-4 py-2 border">
                                @{{ item.tugas_keadaan_bebek?.jumlah_bebek_mati ? item.tugas_keadaan_bebek?.jumlah_bebek_mati : "-" }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- <div class="overflow-x-auto">
                <table class="table-fixed w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border w-[50px]" rowspan="2">No</th>
                            <th class="px-4 py-2 border w-[200px]" rowspan="2">Nama Kandang</th>
                            <th class="px-4 py-2 border w-[400px]" colspan="3">Pakan</th>
                            <th class="px-4 py-2 border w-[400px]" colspan="3">Air</th>
                            <th class="px-4 py-2 border w-[400px]" colspan="3">Kebersihan</th>
                            <th class="px-4 py-2 border w-[500px]" colspan="4">Telur</th>
                            <th class="px-4 py-2 border w-[700px]" colspan="6">Update Keadaan Bebek</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">status</th>
                            <th class="px-4 py-2 border">keterangan</th>

                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">sttus</th>
                            <th class="px-4 py-2 border">keterangan</th>

                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">status</th>
                            <th class="px-4 py-2 border">keterangan</th>

                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Jumlah Total Telur Hari Ini</th>
                            <th class="px-4 py-2 border">Jumlah Total Telur Rusak</th>
                            <th class="px-4 py-2 border">keterangan</th>

                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Jumlah Total Bebek</th>
                            <th class="px-4 py-2 border">Jumlah Bebek Sehat</th>
                            <th class="px-4 py-2 border">Jumlah Bebek Sakit</th>
                            <th class="px-4 py-2 border">Jumlah Bebek Mati</th>
                            <th class="px-4 py-2 border">keterangan</th>

                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="(tugasPerKandang, index) in kandangs" :key="index">
                            <td class="px-4 py-2 border">@{{ index + 1 }}</td>

                            <td class="px-4 py-2 border w-[200px]">@{{ tugasPerKandang[0]?.kandang?.name || '-' }}</td>

                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Pakan')?.tanggal || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Pakan')?.nama_tugas || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Pakan')?.keterangan || '-' }}</td>

                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Air')?.tanggal || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Air')?.nama_tugas || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Air')?.keterangan || '-' }}</td>

                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Kebersihan Kandang')?.tanggal || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Kebersihan Kandang')?.nama_tugas || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Kebersihan Kandang')?.keterangan || '-' }}</td>

                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Telur')?.tanggal || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Telur')?.tugas_telur.jumlah_telur || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Telur')?.tugas_telur.jumlah_telur_rusak || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Telur')?.keterangan || '-' }}</td>

                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Update Keadaan Bebek')?.tanggal || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Update Keadaan Bebek')?.tugas_keadaan_bebek.jumlah_total_bebek || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Update Keadaan Bebek')?.tugas_keadaan_bebek.jumlah_bebek_sehat || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Update Keadaan Bebek')?.tugas_keadaan_bebek.jumlah_bebek_sakit || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Update Keadaan Bebek')?.tugas_keadaan_bebek.jumlah_bebek_mati || '-' }}</td>
                            <td class="px-4 py-2 border">@{{ getTugas(tugasPerKandang, 'Update Keadaan Bebek')?.keterangan || '-' }}</td>
                        </tr>


                    </tbody>
                </table>
            </div> --}}
        </div>


    </body>
@endsection


@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <script>
        const {
            createApp,
            ref
        } = Vue

        createApp({
            setup() {
                const message = ref('Hello vue!')
                const tugas = ref([])
                const tampilDownloadFilterData = ref(false)
                const tampilDownloadFilterTanggal = ref(false)
                const currentURL = window.location.href;
                console.log('Current URL:', currentURL);

                return {
                    message,
                    tugas
                }
            },
            // mounted() {
            //     document.querySelector('input[name="dates"]').value = '';
            // },
            methods: {
                getTugas(data, nama) {

                    const list = Array.isArray(data) ? data : Object.values(data);
                    return list.find(item => item.nama_tugas === nama) || {};
                },
                async lihatSemuaData() {
                    const pathSegments = window.location.pathname.split('/');
                    const season = pathSegments[1];
                    document.querySelector('input[name="dates"]').value = '';
                    this.tampilDownloadFilterData = true
                    const checkedKandang = [];
                    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                    checkboxes.forEach((checkbox) => {
                        checkedKandang.push(checkbox.value);
                    });
                    const response = await fetch(`/${season}/laporan-json`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            kandang: checkedKandang
                        })
                    });
                    const data = await response.json();
                    this.tugas = data;
                    console.log(data);
                },
                async laporanPertanggal() {
                    const pathSegments = window.location.pathname.split('/');
                    const season = pathSegments[1];
                    this.tampilDownloadFilterTanggal = true
                    this.tampilDownloadFilterData = false
                    const checkedKandang = [];
                    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                    const dates = document.getElementById('dates').value;
                    checkboxes.forEach((checkbox) => {
                        checkedKandang.push(checkbox.value);
                    });
                    console.log(checkedKandang);
                    const response = await fetch(`/${season}/laporan-pertanggal`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            kandang: checkedKandang,
                            tanggal: dates,
                            season: season
                        })
                    });
                    const data = await response.json();
                    this.tugas = data;
                    console.log(data);
                }
            }
        }).mount('#app')
    </script>

    <script>
        $(function() {
            $('input[name="dates"]').daterangepicker({
                opens: 'left',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month')
                        .endOf('month')
                    ]
                },
                alwaysShowCalendars: true
            });
        });
    </script>
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

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
