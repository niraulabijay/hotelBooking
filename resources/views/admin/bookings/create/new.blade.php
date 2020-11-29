@extends('admin.layouts.master')

@push('styles')

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('cork/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('cork/assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/custom/css/infobox.css') }}" rel="stylesheet" type="text/css" />

    <!-- DateRange Picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Block UI -->
    <link href="{{asset('cork/assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('cork/plugins/animate/animate.css')}}">
    <style>
        .roomSelectorTitle{
            display: none;
        }
        .roomSelectorInner{
            display: none;
        }
        .error{
            color: red;
        }
    </style>

@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>New Booking - {{$hotel->title}}</h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Bookins</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">New Booking</a></li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')

    <div class="col-12 layout-spacing" id="initialSearchContainer">
        <form id="checkAvailableContainer">
            <div class="row mb-4 mt-3">
                <div class="col-sm-12 col-12" style="border-right:1px solid;">

                    <div class="statbox widget box box-shadow p-3" >
                        <div class="row">
                            <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        * Check-in / Check-out
                                    </label>
                                    <input type="text" class="range-date form-control" id="checkInOut">
                                    <input type="hidden" name="checkIn">
                                    <input type="hidden" name="checkOut">
                                </div>
                            </div>
                            <div class="col-2 ">
                                <div class="form-group">
                                    <label for="">* No. of persons</label>
                                    <select name="persons" class="form-control">
                                        @for($i=1; $i<=7; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                {{-- <div class="form-group">
                                    <label for="">Room Type (Optional)</label>
                                    <select name="persons" class="form-control">
                                        @foreach($hotel->roomTypes as $roomType)
                                            <option value="{{$roomType->id}}">{{$roomType->title}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>
                            <div class="col-2 text-right">
                                <button id="checkAvailableSearch" type="button" class="btn btn-rounded btn-success mt-3">
                                    Check Availability
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="statbox widget box box-shadow p-3 room-type-container">
                        <div class="tab-content room-available" id="rounded-vertical-pills-tabContent">

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12 layout-spacing">
        <div id="finalizeBookingContainer" style="display: none;">

        </div>
    </div>

@endsection

@push('scripts')

    <!-- Date Range Picker CDNs -->
    {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>--}}
    {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $('input[name="checkIn"]').val(moment().format('YYYY-MM-DD'));
        $('input[name="checkOut"]').val(moment().add(1, 'days').format('YYYY-MM-DD'));
        $('.range-date').daterangepicker({
            autoApply: true,
            endDate: moment().add(1, 'days'),

        });
        $('#checkInOut').on('change',function(){
            // if($(this).data('daterangepicker').startDate.isBefore(moment())){
            //     alert('Cannot Enter old date');
            //     $(this).data('daterangepicker').setStartDate(moment());
            // }
            var startDate = $(this).data('daterangepicker').startDate.format('YYYY-MM-DD');

            var endDate = $(this).data('daterangepicker').endDate.format('YYYY-MM-DD');
            console.log(startDate);
            console.log(endDate);
            $('input[name="checkIn"]').val(startDate);
            $('input[name="checkOut"]').val(endDate);

        })
    </script>
    <!-- Date Range Picker CDNs end -->


    <script src="{{asset('cork/plugins/blockui/jquery.blockUI.min.js')}}"></script>
    <script src="{{asset('cork/plugins/blockui/custom-blockui.js')}}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script>
        $('#checkAvailableSearch').on('click',function(){
            var form = $('#checkAvailableContainer');
            var formdata = new FormData(form[0]);
            var url = "{{ route('admin.booking.checkAvailable') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                contentType: false,
                processData: false,
                data:formdata,
                beforeSend: function(){
                    blockElement(form);
                    $('.room-available').hide();
                },
                success:function(data){
                    $('.room-available').html(data);
                },
                error: function(data){
                    console.log(data);
                },
                complete: function(){
                    $('.room-available').show();
                    $(form).unblock();
                }
            });

        })

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


    <script>
        function roomQuantityChanged(el){
            var id = $(el).attr('data-roomTypeId');
            var roomInner = $('.roomSelectorInner[data-roomTypeId="'+id+'"]')
            roomInner.each(function(){
                $(this).hide();
                $(this).find('select').attr('disabled','disabled');
            });
            var toShow =$(el).val();
            var i = 0;
            roomInner.each(function(){
                if(i < toShow){
                    $(this).show();
                    $(this).find('select').removeAttr('disabled');
                }else{
                    return;
                }
                i++;
            });
        }
    </script>

    <script>
        function proceedBooking(el){
            var form = $('#checkAvailableContainer');
            var formStatus = $(form).validate().form();
            if(true == formStatus){
                var formdata = new FormData(form[0]);
                var url = "{{ route('admin.booking.proceedBooking') }}";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: url,
                    contentType: false,
                    processData: false,
                    data:formdata,
                    beforeSend: function(){
                        blockElement(form);
                        $('#finalizeBookingContainer').hide();
                    },
                    success:function(data){
                        $('#finalizeBookingContainer').html(data);
                        $('#initialSearchContainer').hide();
                        $('#finalizeBookingContainer').show();
                    },
                    error: function(data){
                        alert(data.responseText);
                        console.log(data);
                    },
                    complete: function(){
                        $(form).unblock();
                    }
                });
            }else{
                alert('Fix Form Errors');
            }
        }
    </script>

    <script>
        function goBack(el){
            $('#finalizeBookingContainer').html('');
            $('#initialSearchContainer').show();
        }
    </script>

    <script>
        function finalBookingSubmit(el){
            var form = $('#finalizeBookingForm');
            var formStatus = $(form).validate().form();
            if(true == formStatus){
                var formdata = new FormData(form[0]);
                var url = "{{ route('admin.booking.finalize') }}";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: url,
                    contentType: false,
                    processData: false,
                    data:formdata,
                    beforeSend: function(){
                        blockElement(form);
                    },
                    success:function(data){
                        console.log(data)
                    },
                    error: function(data){
                        console.log(data.responseJSON.errors);
                        var msg = "";
                        if(data.responseJSON.errors){
                            var errors = data.responseJSON.errors;
                            for (const key in errors) {
                                console.log(errors[key]);
                                msg = msg + errors[key][0]+ ' ';
                            }
                        }else{
                            var msg = msg + data.responseText;
                        }
                        toastr.error(msg, 'Form Errors');
                    },
                    complete: function(){
                        $(form).unblock();
                    }
                });
            }else{
                alert('Fix Form Errors');
            }

        }
    </script>


@endpush
