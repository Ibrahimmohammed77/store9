@extends('layouts.dashboard')
@section('title') الأقسام @endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item "><a href="#">كل الأقسام</a></li>
<li class="breadcrumb-item active"><a href="#">{{$category->name}}</a></li>
@endsection
@section('content')
@php $i=1;@endphp

{{-- < component alert> --}}
    <x-alert type="success" color="success" />
    <x-alert type="error" color="danger" />
    {{-- < end component alert> --}}
    <div class="container-fluid">

        <div class="d-flex justify-content-center mb-3 text-bold">
           {{$category->name}}
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>image</th>
                    <th>Name</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th colspan="2">Options</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if ($category->products->count()) --}}
                @if ($products)
                @foreach ($category->products as $product)
                <tr>
                    <td>{{$i++}}</td>
                    <td>
                        @if($product->image)
                        <img src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}" height="50"
                            width="50" />
                        @endif
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->store->name}}</td>
                    <td>{{$product->status}}</td>
                    <td>{{$product->created_at}}</td>
                    <td>
                        <a href="{{route('dashboard.products.edit', $product->id)}}"
                            class="btn btn-sm btn-outline-success">edit</a>
                    </td>
                    <td>
                        <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit">delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-center">No products Selected</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
        {{$products->withQueryString()->links()}}
        @endsection
