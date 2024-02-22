@props([
'name'=>'',
'options'=>'',
'selected'=>false,
// 'id'=>''
])

<select name="{{$name}}" class="form-control form-select" id="exampleInputParent">
    <option value="">Primary Category</option>
    @foreach ($options as $parent)
    <option value="{{old($name, $parent->id)}}" @selected(old($name,($selected==$parent->id))) >
        {{ $parent->name }}</option>
    @endforeach
</select>
