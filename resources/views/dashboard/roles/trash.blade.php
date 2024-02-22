@extends('layouts.dashboard')
@section('title') الأقسام : (سلة المحذوفات ) @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item "><a href="{{route('dashboard.categories.index')}}"> الأقسام</a></li>
<li class="breadcrumb-item active"><a href="#"> سلة المحذوفات </a></li>
@endsection
@section('content')
 @php $i=1;@endphp
<div class="mb-4 mx-4">
    <a href="{{route('dashboard.categories.index')}}" class="btn btn-sm btn-outline-primary">home</a>
</div>

{{-- < component alert> --}}
    <x-alert type="success" color="success" />
    <x-alert type="error" color="danger" />
    {{-- < end component alert> --}}
        <div class="container-fluid">
            <form action="{{URL::current()}}" method="get" class="d-flex justify-content-around mb-4">
                <x-form.input name="name" placeholder="Name" class="mx-2" value="{{request('name')}}" />
                <select class="form-control mx-2" name="status">
                    <option value="">All</option>
                    <option value="active" @selected(request('status')=="active" )>Active</option>
                    <option value="archive" @selected(request('status')=="archive" )>Archive</option>
                </select>
                <button type="submit" class="btn btn-dark">Filter</button>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>image</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Deleted At</th>
                        <th colspan="2">Options</th>
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
                        <td>{{$category->parent_name}}</td>
                        <td>{{$category->status}}</td>
                        <td>{{$category->deleted_at}}</td>
                        <td>

                            <form action="{{route('dashboard.categories.restore',$category->id)}}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-outline-info" type="submit">إسترجاع</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{route('dashboard.categories.force_delete',$category->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" type="submit">حذف نهائيا</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No Categories Selected</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {{$categories->withQueryString()->links()}}
        @endsection
