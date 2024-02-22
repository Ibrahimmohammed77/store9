@extends('layouts.dashboard')
@section('title') الأقسام @endsection
@section('breadcrumb')
@parent
{{-- <li class="breadcrumb-item active"><a href="{{/*route('dashboard./')*/}}">الرئيسية</a></li> --}}
<li class="breadcrumb-item active"><a href="#">كل الأقسام</a></li>
@endsection
@section('content')
@php $i=1;@endphp
<div class="d-flex justify-content-between">
    @if(Auth::user()->can('roles.create'))
    <div class="mb-4 mx-4 ">
        <a href="{{route('dashboard.roles.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
    </div>
    @endif
    <div class="mb-4  ml-3">
        {{-- <a href="{{route('dashboard.roles.trash')}}" class="btn btn-sm btn-outline-info">Trash</a> --}}
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
                <option value="active" @selected(request('status')=="active")>Active</option>
                <option value="archive" @selected(request('status')=="archive")>Archive</option>
            </select>
            <button type="submit" class="btn btn-dark">Filter</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th colspan="3">Options</th>
                </tr>
            </thead>
            <tbody>
                @if ($roles->count())
                @foreach ($roles as $role)
                <tr>
                    <td>{{$i++}}</td>
                   
                    <td>{{$role->name}}</td>
                    {{-- <td>{{$role->parent_name}}</td> --}}
                    <td>{{$role->created_at}}</td>
                    {{-- @can('roles.update') --}}
                    <td>
                        <a href="{{route('dashboard.roles.edit', $role->id)}}"
                            class="btn btn-sm btn-outline-success">edit</a>
                    </td>
                    {{-- @endcan --}}
                    {{-- @can('roles.view')                         --}}
                    <td>
                        <a href="{{route('dashboard.roles.show', $role->id)}}"
                            class="btn btn-sm btn-outline-info">show</a>
                    </td>
                    {{-- @endcan --}}
                    {{-- @can('roles.delete') --}}
                    <td>
                        <form action="{{route('dashboard.roles.destroy',$role->id)}}" method="post">
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
                    <td colspan="10" class="text-center">No Roles Selected</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
        {{$roles->withQueryString()->links()}}
        @endsection
