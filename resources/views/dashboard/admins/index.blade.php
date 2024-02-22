@extends('layouts.dashboard')
@section('title') {{__('Admins')}} @endsection
@section('breadcrumb')
@parent
{{-- <li class="breadcrumb-item active"><a href="{{/*route('dashboard./')*/}}">الرئيسية</a></li> --}}
<li class="breadcrumb-item active"><a href="#">{{__('Admins')}}</a></li>
@endsection
@section('content')
@php $i=1;@endphp
<div class="d-flex justify-content-between">
    @if(Auth::user()->can('admins.create'))
    <div class="mb-4 mx-4 ">
        <a href="{{route('dashboard.admin.create')}}" class="btn btn-sm btn-outline-primary">{{__('Create')}}</a>
    </div>
    @endif
    <div class="mb-4  ml-3">
        {{-- <a href="{{route('dashboard.admin.trash')}}" class="btn btn-sm btn-outline-info">Trash</a> --}}
    </div>
</div>


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
                @if ($admins->count())
                @foreach ($admins as $admin)
                <tr>
                    <td>{{$i++}}</td>
                   
                    <td>{{$admin->name}}</td>
                    {{-- <td>{{$admin->parent_name}}</td> --}}
                    <td>{{$admin->created_at}}</td>
                    {{-- @can('admins.update') --}}
                    <td>
                        <a href="{{route('dashboard.admin.edit', $admin->id)}}"
                            class="btn btn-sm btn-outline-success">edit</a>
                    </td>
                    {{-- @endcan --}}
                    {{-- @can('admins.view')                         --}}
                    <td>
                        <a href="{{route('dashboard.admin.show', $admin->id)}}"
                            class="btn btn-sm btn-outline-info">show</a>
                    </td>
                    {{-- @endcan --}}
                    {{-- @can('admins.delete') --}}
                    <td>
                        <form action="{{route('dashboard.admin.destroy',$admin->id)}}" method="post">
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
                    <td colspan="10" class="text-center">{{__('No Admin Selected')}}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
        {{$admins->withQueryString()->links()}}
        @endsection
