@extends('layouts.dashboard')
@section('title') الأقسام @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active"><a href="#"> الأدوار</a></li>
<li class="breadcrumb-item active"><a href="#"> اضافة</a></li>
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.roles.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.roles._form',[
            'button_label'=>'create'
        ])
    </form>

</div>
@endsection
