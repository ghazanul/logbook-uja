@extends('layouts.app')

@section('title', 'Halaman belakang')

@section('content')

    <body>



        <div class=" mx-[16px] mt-[90px] md:mt-[0px]  md:mx-[60px] md:pt-[213px] ">
            <div class="flex flex-col items-center justify-center">
                <div
                    class="bg-[#047857] flex items-center justify-center text-white font-semibold text-center text-[18px] md:text-[20px] w-[142px] h-[45px] md:w-[215px] shadow-md/50 md:h-[54px] rounded-[10px] mb-[50px]">
                    {{ $kandang->name }}
                </div>
            </div>

            <div class="flex flex-col">

                <div class="mb-[15px]">
                    <label class="block mb-[5px] text-[18px] font-semibold">Download Data Berdasarkan Tanggal</label>
                    <!-- Input -->
                    <form action="/tugas/export" class="flex  flex-col md:flex-row gap-5">

                        <input name="dates" id="dates"
                            class="border-2 border-[#A3A1A1] px-[12px] text-center py-[20px] rounded-[10px] w-[362px] md:w-[320px] h-[62px] focus:outline-none focus:ring-[2px] focus:ring-[#047857]">

                        <!-- Tombol Download -->
                        <button  type="submit"
                            class="flex items-center gap-2 bg-[#047857]  hover:bg-emerald-800 w-[362px] md:w-[200px]  justify-center text-white px-4 py-2 h-[62px] rounded-md shadow-md">
                            <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24">
                                <path d="M12 16l4-5h-3V4h-2v7H8l4 5zm-9 4v2h18v-2H3z" />
                            </svg>
                            Download Data
                        </button>
                    </form>
                </div>

                <div>
                    <label class="block mb-[5px] text-[18px] font-semibold">Download Data Keseluruhan</label>
                    <form action="/tugas/export">
                        <button type="submit"
                            class="flex items-center text-center gap-2 bg-[#047857] w-[362px] justify-center md:w-[200px]  hover:bg-emerald-800 text-white px-4 py-2 ] h-[62px] rounded-md shadow-md">
                            <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24">
                                <path d="M12 16l4-5h-3V4h-2v7H8l4 5zm-9 4v2h18v-2H3z" />
                            </svg>Download All Data</button>
                    </form>
                </div>

            </div>
        </div>
    </body>

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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


@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@endsection
