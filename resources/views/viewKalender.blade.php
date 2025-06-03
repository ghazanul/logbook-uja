@extends('layouts.app')

@section('title', 'Halaman belakang')

@section('content')

    <body>
        <div class="mx-[16px] mt-[90px] md:mt-[0px]  md:mx-[60px] md:pt-[213px]">
            <div class="flex flex-col items-center justify-center">
                <!-- Judul / Kandang -->
                <div class="flex flex-col items-center justify-center">
                    <div
                        class="bg-[#047857] flex items-center justify-center text-white font-semibold text-center text-[18px] md:text-[20px] w-[142px] h-[45px] md:w-[215px] shadow-md/50 md:h-[54px] rounded-[10px] mb-[50px]">
                        {{ $kandang->name }}
                    </div>
                </div>

                <!-- Kalender-->
                <div class="border-2 border-[#047857] rounded-xl p-6 w-[350px] h-[450px] md:w-[650px] md:h-[550px] overflow-auto"
                    style="">
                    <div id="calendar" class="w-full  h-full"></div>
                </div>

                




    </body>

    <!-- JS FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/locales/id.global.min.js'></script>

    <script>
        // Tunggu hingga seluruh konten DOM dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen div dengan ID 'calendar'
            var calendarEl = document.getElementById('calendar');

            // Inisialisasi kalender dengan konfigurasi FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Tampilan default: bulanan
                locale: 'id', // Gunakan Bahasa Indonesia
                headerToolbar: {
                    right: 'prev,next', // Tombol di sebelah kanan: navigasi bulan
                    left: 'title', // Judul di sebelah kiri
                    center: '' // Tidak ada isi di tengah
                },

                // Custom tombol navigasi bulan
                customButtons: {
                    prev: {
                        text: '<', // Teks tombol sebelumnya
                        click: function() {
                            calendar.prev(); // Pindah ke bulan sebelumnya
                            updateNavButtonStyle(); // Terapkan ulang gaya tombol
                        }
                    },
                    next: {
                        text: '>', // Teks tombol selanjutnya
                        click: function() {
                            calendar.next(); // Pindah ke bulan berikutnya
                            updateNavButtonStyle(); // Terapkan ulang gaya tombol
                        }
                    }
                },

                // Hapus warna latar default untuk hari ini
                dayCellDidMount: function(info) {
                    const today = new Date();
                    const cellDate = info.date;

                    if (
                        cellDate.getDate() === today.getDate() &&
                        cellDate.getMonth() === today.getMonth() &&
                        cellDate.getFullYear() === today.getFullYear()
                    ) {
                        info.el.style.backgroundColor = 'transparent'; // Hilangkan latar belakang
                    }
                },

                // Tambahkan event hover pada tanggal
                dayCellMouseover: function(info) {
                    const hoveredDate = info.dateStr; // Format: YYYY-MM-DD
                    info.el.style.backgroundColor = '#047857'; // Latar belakang abu-abu
                },
                dayCellMouseout: function(info) {
                    info.el.style.backgroundColor = 'transparent'; // Hilangkan latar belakang
                },

                // Tambahkan event klik pada tanggal
                dateClick: function(info) {
                    const clickedDate = info.dateStr; // Format: YYYY-MM-DD
                    const currentURL = window.location.href; // Ambil URL saat ini
                    window.location.href = `${currentURL}/${clickedDate}` // Ganti path sesuai kebutuhan
                }
            });

            // Render kalender ke dalam elemen
            calendar.render();

            // Terapkan styling langsung ke tombol navigasi
            updateNavButtonStyle();

            // Fungsi untuk menata tombol prev & next
            function updateNavButtonStyle() {
                setTimeout(() => {
                    document.querySelectorAll('.fc-prev-button, .fc-next-button').forEach(btn => {
                        btn.style.backgroundColor = '#047857'; // Warna latar hijau
                        btn.style.color = 'white'; // Teks putih
                        btn.style.borderRadius = '[10px]';
                        btn.style.padding = '8px'; // Padding dalam tombol
                        btn.style.border = 'none'; // Hilangkan garis tepi
                        btn.style.outline = 'none'; // Hilangkan outline saat fokus
                        btn.style.boxShadow = 'none'; // Hilangkan shadow saat diklik
                        btn.style.cursor = 'pointer'; // Ganti kursor jadi tangan
                        btn.addEventListener('mouseover', () => {
                            btn.style.backgroundColor = '#065f46'; // Warna latar saat hover
                        });

                        btn.addEventListener('mouseout', () => {
                            btn.style.backgroundColor =
                                '#047857'; // Kembali ke warna latar semula
                        });

                    });
                }, 0); // Delay singkat agar tombol sudah muncul saat diubah
            }
        });
    </script>

@endsection
