{{-- @if (session()->has('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif --}}
@if (session()->has($type))
<div class="alert alert-{{$color}}">
    {{session($type)}}
</div>
@endif
