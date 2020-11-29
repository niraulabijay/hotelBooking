@extends('admin.layouts.master')

@push('styles')

    <link href="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/assets/css/forms/switches.css') }}">
    <link href="{{ asset('cork/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('cork/plugins/table/datatable/dt-global_style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>Destinations</h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Destinations</li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')


    <div class="col-xl-8 col-lg-8 col-sm-12  layout-spacing">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Destination List </h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="zero-config" class="table table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>Sn</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th class="no-content">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($destinations))
                        @foreach($destinations as $destination)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $destination->destination }}</td>
                                <td> @if($destination->status == "Active" ) <span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Inactive</span> @endif</td>
                                <td>

                                    <a href="{{ route('admin.destination.edit',[$destination->id]) }}" title="Edit" class="badge badge-success"> <i data-feather="edit"></i></a>

                                    <a href="{{ route('admin.destination.delete',[$destination->id]) }}" title="Delete" class="badge badge-dark warning confirm"><i data-feather="archive"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Sn</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th class="no-content">Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-sm-12  layout-spacing">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    @if(isset($editDestination))
                        <h4>
                            Edit Destination
                            <a href="{{ route('admin.destinations')}}" class="float-right  btn btn-sm btn-primary">Add Destination</a>
                        </h4>
                    @else
                        <h4>Add New Destination</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6">
            @if(isset($editDestination))
                {!! Form::open(['url'=>route('admin.destination.update',[$editDestination->id]), 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
                <input type="hidden" name="destination_id" value="{{$editDestination->id}}">
            @else
                {!! Form::open(['url'=>route('admin.destination.store'), 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
            @endif

                @include('admin.destination.commonForm')

            <div class="form-group">
                {{Form::submit('Submit',['class'=>'btn btn-primary ml-3'])}}
            </div>
            {!! Form::close() !!}

        </div>
    </div>



@endsection

@push('scripts')

<script src="{{ asset('cork/plugins/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('cork/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('cork/plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<script>
    $('#zero-config').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 30, 50],
        "pageLength": 10
    });
</script>

<script>


    $('.widget-content .warning.confirm').on('click', function (event ) {
        $this = $(this);
        event.preventDefault();
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                window.location.href = $this.attr('href');
            }
        })
    })
</script>


@endpush
