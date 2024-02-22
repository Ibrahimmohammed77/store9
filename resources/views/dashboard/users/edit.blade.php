@extends('layouts.dashboard')
@section('title') {{__('Users')}} @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active"><a href="#"> {{__('Users')}}</a></li>
<li class="breadcrumb-item active"><a href="#"> {{__('Edit')}}</a></li>
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.users.update',$user->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.users._form',[
            'button_label'=>'update'
        ])
    </form>

</div>
@endsection
