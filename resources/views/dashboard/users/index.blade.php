@extends('layouts.dashboard')
@section('title') {{__('Users')}} @endsection
@section('breadcrumb')
@parent
{{-- <li class="breadcrumb-item active"><a href="{{/*route('dashboard./')*/}}">الرئيسية</a></li> --}}
<li class="breadcrumb-item active"><a href="#">{{__('Users')}}</a></li>
@endsection
@section('content')
@php $i=1;@endphp
<div class="d-flex justify-content-between">
    @if(Auth::user()->can('users.create'))
    <div class="mb-4 mx-4 ">
        <a href="{{route('dashboard.users.create')}}" class="btn btn-sm btn-outline-primary">{{__('Create')}}</a>
    </div>
    @endif
    <div class="mb-4  ml-3">
        {{-- <a href="{{route('dashboard.users.trash')}}" class="btn btn-sm btn-outline-info">Trash</a> --}}
    </div>
</div>
{{-- @include('dashboard.includes._succes') --}}
{{-- @include('dashboard.includes._error') --}}

{{-- < component alert> --}}
    <x-alert type="success" color="success" />
    <x-alert type="error" color="danger" />
    {{-- < end component alert> --}}
    <div class="container-fluid">

        <form action="{{URL::current()}}" method="get" class="d-flex justify-content-around mb-4">
            <x-form.input name="name" placeholder="Name" class="mx-2" value="{{request('name')}}" />
            <select class="form-control mx-2" name="status" >
                <option value="">All</option>
                <option value="active" @selected(request('status')=="active")>{{__('Active')}}</option>
                <option value="archive" @selected(request('status')=="archive")>{{__('Archive')}}</option>
            </select>
            <button type="submit" class="btn btn-dark">{{__('Filter')}}</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>{{__('ID')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Created At')}}</th>
                    <th colspan="3">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count())
                @foreach ($users as $user)
                <tr>
                    <td>{{$i++}}</td>
                   
                    <td>{{$user->name}}</td>
                    {{-- <td>{{$user->parent_name}}</td> --}}
                    <td>{{$user->created_at}}</td>
                    {{-- @can('users.update') --}}
                    <td>
                        <a href="{{route('dashboard.users.edit', $user->id)}}"
                            class="btn btn-sm btn-outline-success">edit</a>
                    </td>
                    {{-- @endcan --}}
                    {{-- @can('users.view')                         --}}
                    <td>
                        <a href="{{route('dashboard.users.show', $user->id)}}"
                            class="btn btn-sm btn-outline-info">show</a>
                    </td>
                    {{-- @endcan --}}
                    {{-- @can('users.delete') --}}
                    <td>
                        <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit">delete</button>
                        </form>
                    </td>
                    {{-- @endcan --}}
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10" class="text-center">{{__('No User Selected')}}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
        {{$users->withQueryString()->links()}}
        @endsection
