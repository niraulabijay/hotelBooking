@extends('admin.layouts.master')

@push('styles')

<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="{{ asset('cork/custom/css/infobox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('cork/assets/css/forms/switches.css') }}">
<!--  END CUSTOM STYLE FILE  -->

@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>Hotels</h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Hotels</a></li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')

    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="card component-card_1">
            <div class="card-body">
                @if($hotels->isNotEmpty())
                    @foreach($hotels as $hotel)
                        <div class="infobox-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="info-heading">{{ $hotel->title }} &nbsp;&nbsp;@if($hotel->status =="Active")<span class="badge badge-success">Active</span>@else<span class="badge badge-danger">Inactive</span> @endif</h5>
                                    <div class="infobox-image">
                                        <img src="@if($hotel->hasMedia('hotel_feature')){{ asset($hotel->featureImage()->getUrl('feature-thumb')) }} @endif" alt="">
                                    </div>
                                    <p class="info-text"><i data-feather="map-pin"></i>&nbsp;{{ $hotel->destination->destination ?? '' }}</p>
                                    {{-- <a class="info-link" href="">Discover <svg> ... </svg></a> --}}

                                </div>
                                <div class="col-md-3">
                                    <div class="infobox-image float-right">
                                    <img src="@if($hotel->brand->hasMedia('brand_logo')){{ asset($hotel->brand->logo()->getUrl('logo-thumb')) }} @endif" alt="">
                                    </div>
                                    <div class="btn-group float-left" role="group" aria-label="Basic example">
                                        <a href="{{ route('admin.hotel.setting',$hotel->id) }}" type="button" class="btn btn-primary">Settings</a>
                                        <a href="{{ route('admin.hotels.edit',$hotel->id)}}" class="btn btn-secondary">Edit</a>
                                        <button type="button" class="btn btn-danger" data-target="#deleteContent{{$hotel->id}}" data-toggle="modal">
                                            Delete
                                        </button>
                                        @include('admin.hotel.delete')
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                        <span class="badge badge-warning">No Hotels Added.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="card component-card_1">
            <div class="card-body">
                <h4 class="media-heading">
                    @if(isset($editHotel))
                        <span class="media-title">
                            Edit Hotel
                        </span>
                        <a href="{{ route('admin.hotels')}}" class="float-right  btn btn-sm btn-primary">Add Hotel</a>
                    @else
                        <span class="media-title">
                            Add Hotel
                        </span>
                    @endif
                </h4>
                @if(isset($editHotel))
                    <form class="form-vertical" method="post" action="{{ route('admin.hotels.edit',[$editHotel->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$editHotel->id}}">
                @else
                    <form class="form-vertical" method="post" action="{{ route('admin.hotels.add') }}" enctype="multipart/form-data">
                @endif

                @csrf

                    @if(session()->has('message-success'))
                    <div class="alert alert-success">
                        {{ session()->get('message-success') }}
                    </div>
                    @elseif(session()->has('message-danger'))
                    <div class="alert alert-danger">
                        {{ session()->get('message-danger') }}
                    </div>
                    @endif
                    <div class="form-group mb-4">
                        <label class="control-label">Hotel Name:</label>
                        <input type="text" name="title" value="{{ isset($editHotel)? $editHotel->title : '' }}" class="form-control" placeholder="Hotel Name">
                        @error('title')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="exampleFormControlSelect1">Brand</label>
                        <select name="brand" class="form-control" id="exampleFormControlSelect1">
                            <option value="">Select Hotel's Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    @if(isset($editHotel) && $editHotel->brand_id == $brand->id) selected @endif>
                                    {{ $brand->title }}</option>
                            @endforeach
                        </select>
                        @error('brand')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="control-label">Hotel Location: (For Booking Bar Search)</label>
                        <select name="destination" class="form-control">
                            <option value="">Select Destination</option>
                            @foreach($destinations as $destination)
                                <option value="{{$destination->id}}" @if(isset($editHotel)) {{$editHotel->destination_id == $destination->id ? "selected" : ""}} @endif>
                                    {{$destination->destination}}
                                </option>
                            @endforeach
                        </select>
                        @error('destination')
                            <div class="text-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4 ">
                        <div class="row">
                            <div class="col-6">
                                <label class="control-label">Status:</label>
                            </div>
                            <div class="col-6">
                            <label class="float-right switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                <input type="checkbox" name="status" {{ isset($editHotel)? ($editHotel->status == "Active" ? "checked" : '') : "checked" }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="custom-file-container" data-upload-id="myFirstImage">
                        <label>Logo/Featured Image <a href="javascript:void(0)" class="custom-file-container__image-clear float-right" title="Clear Image"><span class="badge badge-danger">Discard</span></a></label>
                        <label class="custom-file-container__custom-file" >
                            <input type="file" name="feature" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                        </label>
                        @error('feature')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="custom-file-container__image-preview"></div>
                    </div>

                    <input type="submit" value="Submit" class="btn btn-primary ml-3 mt-3">
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>

    <script>
        //First upload .
        @if(isset($editHotel) && $editHotel->hasMedia('hotel_feature'))
            var importedBaseImage = "{{ isset($editHotel)? $editHotel->featureImage()->getUrl() : ''}}"
            var firstUpload = new FileUploadWithPreview('myFirstImage', {
                images: {
                        baseImage: importedBaseImage,
                    },
            })
        @else
            var firstUpload = new FileUploadWithPreview('myFirstImage')
        @endif
    </script>


@endpush
