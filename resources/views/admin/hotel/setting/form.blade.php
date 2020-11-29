@extends('admin.layouts.master')

@push('styles')

<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="{{ asset('cork/custom/css/infobox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('cork/assets/css/forms/switches.css') }}">
<script src="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
<!--  END CUSTOM STYLE FILE  -->
<style>
    .my_border{
        border: 1px solid #ccc!important;
        border-radius: 16px;
    }
    /* .custom-file-container__image-preview{
        height: 150px;
        width: auto;
    } */
</style>
@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>Hotel Details - {{$hotel->title}}</h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.hotels')}}">Hotels</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$hotel->title}}</li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <form method="post" action="{{ route('admin.hotel.setting.update',$hotel->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
            <div class="card component-card_1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>Api Details</h3>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Booking URL</label>
                                <input type="text" name="booking_url" class="form-control" value="{{$hotel->settingMeta('booking_url')}}">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h3>Location Details</h3>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Street</label>
                                <input type="text" name="street" class="form-control" value="{{$hotel->settingMeta('street')}}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">City</label>
                                <input type="text" name="city" class="form-control" value="{{$hotel->settingMeta('city')}}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">State</label>
                                <input type="text" name="state" class="form-control" value="{{$hotel->settingMeta('state')}}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Postal Code</label>
                                <input type="text" name="postcode" class="form-control" value="{{$hotel->settingMeta('postcode')}}">
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary ">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')

@endpush
