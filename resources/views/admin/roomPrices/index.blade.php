@extends('admin.layouts.master')

@push('styles')

    <!-- Table css -->
    <link href="{{ asset('cork/assets/css/tables/table-basic.css') }}" rel="stylesheet" type="text/css" />

    <!-- DateRange Picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Block UI -->
    <link href="{{asset('cork/assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('cork/plugins/animate/animate.css')}}">
    <style>
        .data_container{
            min-height: 500px;
        }
    </style>

@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>Room Prices</h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roomType') }}">RoomType</a></li>
                <li class="breadcrumb-item active" aria-current="page">Prices</li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')

    <input type="hidden" id="hotel_id" value="{{$hotel->id}}">
    <div class="col-12 layout-spacing data_container">
        <div class="row mb-4 mt-3">
            <div class="col-4">
                <div class="form-group">
                    <label for="searchStartEnd">Select Dates:</label>
                    <input type="text" class="range-date form-control" id="searchStartEnd">
                    <input type="hidden" name="searchStart">
                    <input type="hidden" name="searchEnd">
                </div>
            </div>
            <div class="col-8 text-right">
                <button class="btn btn-success" data-toggle="modal" data-target="add_price_modal">Add New Price</button>
            </div>
            <div class="col-12 mt-3">

                <div class="card">
                    <div class="card-body">
                        <div class="calendar-container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{asset('cork/plugins/blockui/jquery.blockUI.min.js')}}"></script>
    <script src="{{asset('cork/plugins/blockui/custom-blockui.js')}}"></script>

    <!-- DatePicker JS -->
    <script>
        $('input[name="searchStart"]').val(moment().subtract(5, "days").format('YYYY-MM-DD'));
        $('input[name="searchEnd"]').val(moment().add(10, 'days').format('YYYY-MM-DD'));
        $('.range-date').daterangepicker({
            autoApply: true,
            startDate: moment().subtract(5, "days"),
            endDate: moment().add(10, 'days'),
            maxSpan: {
                "days": 16
            },
        });
        $('#searchStartEnd').on('change',function(){
            var startDate = $(this).data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $(this).data('daterangepicker').endDate.format('YYYY-MM-DD');
            console.log(startDate);
            console.log(endDate);
            $('input[name="searchStart"]').val(startDate);
            $('input[name="searchEnd"]').val(endDate);
            loadCalendar();
        })
    </script>

    <!-- Load Calendar JS -->
    <script>

        $(document).ready(function () {
            loadCalendar();
        });

        function loadCalendar(){
            var today = moment.now();
            var url = "{{ route('admin.ajaxPriceCalendar') }}";
            var formData = {
                'hotel_id': $('#hotel_id').val(),
                'startDate':$('input[name="searchStart"]').val(),
                'endDate':$('input[name="searchEnd"]').val()
            };
            var el = $('.data_container');
            $.ajax({
                type: "GET",
                data: formData,
                dataType: 'json',
                url: url,
                beforeSend: function(){
                    blockElement(el);
                    $('.calendar-container').hide();
                },
                success: function (data) {
                    $('.calendar-container').html(data);
                    console.log(data);
                },
                error: function (data) {
                    console.log(data);
                },
                complete: function(){
                    $('.calendar-container').show();
                    $(el).unblock();
                }
            });
        }

        function blockElement(block){
            $(block).block({
                message: 'Fetching',
                overlayCSS: {
                    backgroundColor: '#f5f5f5f5',
                    opacity: 0.9,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    color: '#00000',
                    backgroundColor: 'transparent'
                }
            });
        }
    </script>

@endpush
