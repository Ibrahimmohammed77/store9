<x-front-layout>
 @section('breadcrumbs')
     <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{config("app.name")}}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route("home")}}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="javascript:void(0)">Categories</a></li>
                        <li>{{$category->name}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
 @endsection
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2> {{$category->name}}</h2>
                        <p>{{$category->description}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @php
                    $i = 1;
                @endphp
                @foreach ($category->products as $category_product)
                    <div class="col-lg-2 col-md-6 col-12">
                       <!-- Start Single Product -->
                       <x-product-card :product="$category_product"/>
                    <!-- End Single Product -->
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-frony-layout>
