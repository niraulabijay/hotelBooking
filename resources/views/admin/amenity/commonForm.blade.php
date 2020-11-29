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
    <label class="control-label">Amenity Name *</label>
    <input type="text" name="title" value="{{ isset($editAmenity)? $editAmenity->title : '' }}" class="form-control"  placeholder="Amenity Name">
    @error('title')
    <div class="text-danger" role="alert">
        {{ $message }}
    </div>
    @enderror
    @error('amenity_id')
    <div class="text-danger" role="alert">
        Amenity not found for Update !!
    </div>
    @enderror
</div>
<div class="form-group mb-4">
    <label class="control-label">Amenity Icon *</label>
    <input type="text" name="icon" value="{{ isset($editAmenity)? $editAmenity->icon() : '' }}" class="form-control"  placeholder="Amenity FA-Icon">
    @error('icon')
    <div class="text-danger" role="alert">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="form-group mb-4">
    <label class="control-label">Quick Description:</label>
    <textarea class="form-control" rows="3" name="description" aria-label="With textarea" placeholder="Short Description About the Amenity">{{ isset($editAmenity)? $editAmenity->description : '' }}</textarea>
</div>

<div class="form-group mb-4 ">
    <div class="row">
        <div class="col-6">
            <label class="control-label">Satus:</label>
        </div>
        <div class="col-6">
            <label class="float-right switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                <input type="checkbox" name="status" {{ isset($editAmenity)? ($editAmenity->status == "Active" ? "checked" : '') : "checked" }}>
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>
