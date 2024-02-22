@props([
'name'=>'',
'options',
'checked'=>false,
'id'=>''
])
@php $i=1; @endphp
@foreach ($options as $value=>$text )
<div class="form-check">
    <input type="radio" name="{{$name}}" value="{{$value}}" id="{{$id.$i}}"
     @checked(old($name,$checked)==$value)
     {{$attributes->class([ "form-check-input" ,"is-invalid"=>$errors->has($name)])}}
    >
    @error($name) <div class="invalid-feedback">{{$message}}</div> @enderror
    <label class="form-check-label" for="{{$id.$i++}}">{{$text}}</label>
</div>
@endforeach

{{-- <div class="form-check">
    <input @class([ "form-check-input" , "is-invalid"=>$errors->has($name)])
    type="radio" name="{{$name}}" id="gridRadios2" value="archive"
    @checked(old($name,$value)=="archive")>
    @error($name) <div class="invalid-feedback">{{$message}}</div> @enderror
    <label class="form-check-label" for="gridRadios2">archive</label>
</div> --}}
