@extends('layouts.dashboard')
@section('title') الأقسام @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active"><a href="#"> الأقسام</a></li>
<li class="breadcrumb-item active"><a href="#"> تعديل</a></li>
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.categories.update',$category->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.categories._form',[
            'button_label'=>'update'
        ])
    </form>

</div>
@endsection
