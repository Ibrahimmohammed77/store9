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
    @if(Auth::user()->can('categories.create'))
    <div class="mb-4 mx-4 ">
        <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
    </div>
    @endif
    <div class="mb-4  ml-3">
        <a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-outline-info">Trash</a>
    </div>
</div>


{{-- < component alert> --}}
    <x-alert type="success" color="success" />
    <x-alert type="error" color="danger" />
    {{-- < end component alert> --}}
    <div class="container-fluid">
        <div class="col-12">
            <form action="{{URL::current()}}" method="get" class="d-flex justify-content-around mb-4">
                <x-form.input name="name" placeholder="Name" class="form-control mx-2" value="{{request('name')}}" />
                <select class="form-control mr-5" name="status" >
                    <option value="">All</option>
                    <option value="active" @selected(request('status')=="active")>Active</option>
                    <option value="archive" @selected(request('status')=="archive")>Archive</option>
                </select>
                <button type="submit" class="btn btn-dark">Filter</button>
            </form>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>image</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Product #</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th colspan="3">Options</th>
                </tr>
            </thead>
            <tbody>
                @if ($categories->count())
                @foreach ($categories as $category)
                <tr>
                    <td>{{$i++}}</td>
                    <td><img src="{{asset('storage/'.$category->image)}}" alt="{{$category->name}}" height="50"
                            width="50" /></td>
                    <td>{{$category->name}}</td>
                    {{-- <td>{{$category->parent_name}}</td> --}}
                    <td>{{$category->parent->name}}</td>
                    <td>{{$category->products_count}}</td>
                    <td>{{$category->status}}</td>
                    <td>{{$category->created_at}}</td>
                    @can('categories.update')
                    <td>
                        <a href="{{route('dashboard.categories.edit', $category->id)}}"
                            class="btn btn-sm btn-outline-success">edit</a>
                    </td>
                    @endcan
                    @can('categories.view')                        
                    <td>
                        <a href="{{route('dashboard.categories.show', $category->id)}}"
                            class="btn btn-sm btn-outline-info">show</a>
                    </td>
                    @endcan
                    @can('categories.delete')
                    <td>
                        <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit">delete</button>
                        </form>
                    </td>
                    @endcan
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10" class="text-center">No Categories Selected</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
        {{$categories->withQueryString()->links()}}
        @endsection
