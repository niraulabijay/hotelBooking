<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                <tr class="table-secondary ">
                    <th class="text-dark">Room Type</th>
                    @if(isset($period))
                        @foreach($period as $date)
                            <th class="text-dark">{{substr($date->format('l'),0,3)}}<br>{{$date->format('d').' '.substr($date->format('F'),0,3)}}</th>
                        @endforeach
                    @endif
                </tr>
                </thead>
                <tbody>

                @if(isset($roomTypes))
                    @foreach($roomTypes as $roomType)
                        <tr>
                            <td>{{$roomType->title}}</td>
                            @if(isset($period))
                                @foreach($period as $date)
                                    <td>{{ $roomType->base_price_format() }}</td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                @endif

                </tbody>
                <tfoot>
                <tr class="table-secondary">
                    <th>Room Type</th>
                    @if(isset($period))
                        @foreach($period as $date)
                            <th>{{substr($date->format('l'),0,3)}}<br>{{$date->format('d').' '.substr($date->format('F'),0,3)}}</th>
                        @endforeach
                    @endif
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>