@extends('layouts.dashboard')
@section('title') الأقسام @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active"><a href="#"> الأقسام</a></li>
<li class="breadcrumb-item active"><a href="#"> تعديل</a></li>
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.products.update',$product->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @include('dashboard.products._form',[
            'button_label'=>'update'
        ])
    </form>

</div>
@endsection
