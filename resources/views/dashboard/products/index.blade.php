@extends('layouts.dashboard')
@section('title')
    المنتجات
@endsection
@section('breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item active"><a href="{{/*route('dashboard./')*/}}">الرئيسية</a></li> --}}
    <li class="breadcrumb-item active"><a href="#">كل المنتجات </a></li>
@endsection
@section('content')
    @php $i=1;@endphp
    <div class="d-flex justify-content-between">

        <div class="mb-4 mx-4 ">
            <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
        </div>
        <div class="mb-4  ml-3">
            {{-- <a href="/{{/*route('dashboard.products.trash')*/}}" class="btn btn-sm btn-outline-info">Trash</a> --}}
        </div>
    </div>
    @include('dashboard.includes._succes')
    @include('dashboard.includes._error')

    {{-- < component alert> --}}
    <x-alert type="success" color="success" />
    <x-alert type="error" color="danger" />
    {{-- < end component alert> --}}
    <div class="container-fluid">

        <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-around mb-4">
            <x-form.input name="name" placeholder="Name" class="mx-2" value="{{ request('name') }}" />
            <select class="form-control mx-2" name="status">
                <option value="">All</option>
                <option value="active" @selected(request('status') == 'active')>Active</option>
                <option value="draft" @selected(request('status') == 'draft')>Draft</option>
                <option value="archived" @selected(request('status') == 'archived')>Archive</option>
            </select>
            <button type="submit" class="btn btn-dark">Filter</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th colspan="2">Options</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count())
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        height="50" width="50" />
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->store->name }}</td>
                            <td>{{ $product->status }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>
                                <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                    class="btn btn-sm btn-outline-success">edit</a>
                            </td>
                            <td>
                                <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">No products Selected</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{ $products->withQueryString()->links() }}
@endsection
