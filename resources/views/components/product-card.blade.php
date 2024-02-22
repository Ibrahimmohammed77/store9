<div class="single-product">
    <div class="product-image">
        <img src='{{$product->image_url}}' alt="#">
        @if($product->sale_percent_price)
        <span class="sale-tag">-{{$product->sale_percent_price}}%</span>
        @endif
        <div class="button">
            <a href="{{route('products.show',$product->slug)}}" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
        </div>
    </div>
    <div class="product-info">
        <span class="category">{{$product->category->name}}</span>
        <h4 class="title">
            <a href="{{route('products.show',$product->slug)}}">{{$product->name}}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><span>5.0 Review(s)</span></li>
        </ul>
        <div class="price">
            <span>{{Curency::format($product->price)}}</span>
            <span class="discount-price">{{Curency::format($product->compare_price)}}</span>
        </div>
    </div>
</div>
