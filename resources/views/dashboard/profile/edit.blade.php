@extends('layouts.dashboard')
@section('title') Profile @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active"><a href="#"> تعديل الملف الشخصي</a></li>
@endsection
@section('content')
<x-alert type="success" color="success" />
<div class="container">
    <form action="{{route('dashboard.profile.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group row">
            <div class="col-md-6">
                <x-form.input type="text" name="first_name" id="first_name" label="First Name"
                    :value="$user->profile->first_name??''" />
            </div>
            <div class="col-md-6">
                <x-form.input type="text" name="last_name" id="last_name" label="Last Name"
                    :value="$user->profile->last_name??''" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0"><span class="text-bold">Gender</span> </legend>
                    <div class="col-sm-10">
                        {{-- Component Radio --}}
                        <x-form.radio name="gender" id="gridRadios" :checked="$user->profile->gender??''"
                            :options="['male'=>'Male','female'=>'Female']" />
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <x-form.input type="date" name="birth_day" id="birht_day" label="BirhtDay"
                    :value="$user->profile->birth_day??''" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <x-form.input type="text" name="city" id="city" label="City" :value="$user->profile->city??''" />
            </div>
            <div class="col-md-6">
                <x-form.input type="text" name="state" id="state" label="State" :value="$user->profile->state??''" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <x-form.input type="text" name="postal_code" id="postal_code" label="PostalCode"
                    :value="$user->profile->postal_code??''" />
            </div>
            <div class="col-md-6">
                <x-form.label>Country</x-form.label>
                <x-form.select name="country" :options="$countries" :selected="$user->profile->country??''" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <x-form.label> Locale</x-form.label>
                <x-form.select name="local" :options="$locales" :selected="$user->profile->local??''" />
            </div>
        </div>
        <div class="form-group row">
            <button type="submit" class="btn btn-primary ">Save</button>
        </div>

    </form>

</div>
@endsection
