<div class="form-group row">
    <label for="exampleInputName">Category Name</label>
    <input type="text" name="name" @class([ "form-control" , "is-invalid"=>$errors->has('name')])
    value="{{old('name',$category->name)}}" id="exampleInputName">
    @error('name') <div class="invalid-feedback">{{$message}}</div> @enderror
</div>
<div class="form-group row">
    <label for="exampleInputParent">Parent</label>
    <select name="parent_id" class="form-control form-select" id="exampleInputParent">
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
        <option value="{{old('parent_id', $parent->id)}}" @selected(old('parent_id',($category->parent_id ==
            $parent->id))) >
            {{ $parent->name }}</option>
        @endforeach
    </select>

</div>
<div class="form-group row">
    <label for="Image" class="form-label">Image</label>
    <input type="file" name="image" accept="image/*" id="Image" class="form-control">
    @if($category->image)
    <img src="{{asset('storage/'.$category->image)}}" alt="{{$category->name}}" height="50" width="50" />
    @endif
</div>
<div class="form-group row">
    <label class="form-label " for="InputDescription">Description</label>
    <textarea name="description" class="form-control"
        id="InputDescription">{{old('description',$category->description)}}</textarea>
</div>
<div class="form-group">
    <fieldset class="row mb-3">
        <legend class="col-form-label col-sm-2 pt-0"><span class="text-bold">Status</span> </legend>
        <div class="col-sm-10">
            <div class="form-check">
                <input @class([ "form-check-input" , "is-invalid"=>$errors->has('status')])
                type="radio" name="status" id="gridRadios1" value="active"
                @checked(old('status',$category->status=='active')=="active")>
                @error('status') <div class="invalid-feedback">{{$message}}</div> @enderror
                <label class="form-check-label" for="gridRadios1">active</label>
            </div>

            <div class="form-check">
                <input @class([ "form-check-input" , "is-invalid"=>$errors->has('status')])
                type="radio" name="status" id="gridRadios2" value="archive"
                @checked(old('status',$category->status)=="archive")>
                @error('status') <div class="invalid-feedback">{{$message}}</div> @enderror
                <label class="form-check-label" for="gridRadios2">archive</label>
            </div>
        </div>
    </fieldset>
</div>
<div class="form-group row">
    <button type="submit" class="btn btn-primary">{{$button_label??'save'}}</button>
</div>
