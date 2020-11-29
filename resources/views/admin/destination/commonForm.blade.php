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
    <label class="control-label">Location/Destination *</label>
    <input type="text" name="destination" value="{{ isset($editDestination) ? $editDestination->destination : '' }}" class="form-control"  placeholder="City, Country, etc">
    @error('destination')
    <div class="text-danger" role="alert">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group mb-4 ">
    <div class="row">
        <div class="col-6">
            <label class="control-label">Satus:</label>
        </div>
        <div class="col-6">
            <label class="float-right switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                <input type="checkbox" name="status" {{ isset($editDestination)? ($editDestination->status == "Active" ? "checked" : '') : "checked" }}>
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>
