@extends('layouts.dashboard')
@section('title')
    المنتجات
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="#"> المنتجات</a></li>
    <li class="breadcrumb-item active"><a href="#"> import product</a></li>
@endsection
@section('content')
    <div class="container">
        <form action="{{ route('dashboard.products.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <x-form.input label="Import Product" type="text" name="count" id="exampleInputName" />
            </div>
            <button type="submit"> start import...</button>
        </form>

    </div>
@endsection
