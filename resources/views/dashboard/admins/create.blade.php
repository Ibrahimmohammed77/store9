@extends('layouts.dashboard')
@section('title') {{__('Admins')}} @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active"><a href="#"> {{__('Admins')}}</a></li>
<li class="breadcrumb-item active"><a href="#"> {{__('Create')}}</a></li>
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.admin.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.admins._form',[
            'button_label'=>'create'
        ])
    </form>

</div>
@endsection
