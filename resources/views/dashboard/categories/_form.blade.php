<div class="form-group row">
    <x-form.input label="Category Name" type="text" name="name" value="{{$category->name}}" id="exampleInputName" />
</div>
<div class="form-group row">
    <x-form.label for="exampleInputParent">Parent</x-form.label>
    <x-form.selected name="parent_id" :options="$parents" :selected="$category->parent_id"
        class="form-control form-select" id="exampleInputParent" />
</div>
<div class="form-group row">
    <x-form.label id="Image">Image</x-form.label>
    <x-form.input type="file" name="image" id="Image" accept="image/*" />
    @if($category->image)
    <img src="{{asset('storage/'.$category->image)}}" alt="{{$category->name}}" height="50" width="50" />
    @endif
</div>
<div class="form-group row">
    <x-form.label class="form-label" for="InputDescription">Description</x-form.label>
    <x-form.textarea name="description" id="InputDescription" :value="$category->description" />
</div>
<div class="form-group">
    <fieldset class="row mb-3">
        <legend class="col-form-label col-sm-2 pt-0"><span class="text-bold">Status</span> </legend>
        <div class="col-sm-10">
            {{-- Component Radio --}}
            <x-form.radio legend="Status" name="status" id="gridRadios" :checked="$category->status"
                :options="['active'=>'Active','archive'=>'Archive']" />
        </div>
    </fieldset>
</div>
<div class="form-group row">
    <button type="submit" class="btn btn-primary">{{$button_label??'save'}}</button>
</div>
