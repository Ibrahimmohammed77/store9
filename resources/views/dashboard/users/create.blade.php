@extends('layouts.dashboard')
@section('title') {{__('Users')}} @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active"><a href="#"> {{__('Users')}}</a></li>
<li class="breadcrumb-item active"><a href="#"> {{__('Create')}}</a></li>
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.users.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.users._form',[
            'button_label'=>'create'
        ])
    </form>

</div>
@endsection
