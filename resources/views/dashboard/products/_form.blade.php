<div class="form-group row">
    <x-form.input label="Product Name" type="text" name="name" value="{{$product->name}}" id="exampleInputName" />
</div>
<div class="form-group row">
    <div class="col-md-6">
        <x-form.label for="exampleInputParent">Category</x-form.label>
        <x-form.selected name="category_id" :options="App\Models\Category::all()" :selected="$product->category_id"
            class="form-control form-select" id="exampleInputParent" />
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0"><span class="text-bold">Status</span> </legend>
                <div class="col-sm-10">
                    {{-- Component Radio --}}
                    <x-form.radio legend="Status" name="status" id="gridRadios" :checked="$product->status"
                        :options="['active'=>'Active','draft'=>'Draft','archived'=>'Archive']" />
                </div>
            </fieldset>
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-6">
        <x-form.label id="price">price</x-form.label>
        <x-form.input type="text" name="price" id="price" :value="$product->price" />
    </div>

    <div class="col-md-6">
        <x-form.label id="Compareprice">Compare price</x-form.label>
        <x-form.input type="text" name="compare_price" id="Compareprice" :value="$product->compare_price" />
    </div>
</div>
<div class="form-group row">
    <x-form.input type="text" name="tags" label="Tags" id="tags " :value="$tags"/>
</div>
<div class="form-group row">
    <x-form.label id="Image">Image</x-form.label>
    <x-form.input type="file" name="image" id="Image" accept="image/*" />
    @if($product->image)
    <img src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}" height="50" width="50" />
    @endif
</div>

<div class="form-group row">
    <x-form.label class="form-label" for="InputDescription">Description</x-form.label>
    <x-form.textarea name="description" id="InputDescription" :value="$product->description" />
</div>

<div class="form-group row">
    <button type="submit" class="btn btn-primary">{{$button_label??'save'}}</button>
</div>
@push('styles')

@endpush
@push('scripts')

<script> var inputElm=document.querySelector('name=tags');
tagify =new Tagify();
</script>
@endpush
