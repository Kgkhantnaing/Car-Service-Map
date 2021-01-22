@extends('layouts.default')
@section('content')
<nav aria-label="breadcrumb" class="container-fluid">
    <ol class="breadcrumb" style="background-color: transparent">
        <li class="breadcrumb-item active" aria-current="page">Home</li>
    </ol>
</nav>
<div class="card" style="margin: 16px">
    <div class="card-header">
        <div class="row">
            <div class="col-10">
                Shop List
            </div>
            <div class="col-2">
                <!-- <a href="/customers/create" class="btn btn-sm btn-info">add new customer</a> -->
            </div>
        </div>
    </div>

    <div class="row" style="margin:10px">
        @foreach($shopList as $shop)
        <div class="col-md-4">
            <div class="card shadow" style="width: 90%; margin-bottom: 25px; height:25rem">
                <img class="card-img-top" src="{{ $shop->image_url}}" alt="{{$shop->image_url}}" loading="lazy" height="200px">
                <!-- <img class="card-img-top lazy" src="{{ URL::to('/') }}/img/shop-hover.png" data-src="{{ $shop->image_url}}" alt="{{$shop->image_url}}" /> -->
                <div class="card-body">
                    <h5 class="card-title">{{$shop->name}}</h5>
                    <p class="card-text">{{$shop->address}}</p>
                </div>
                <div class="card-footer">
                    <a href="/shops/show/{{$shop->id}}" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <div class="card-footer">
        <div class="text-center">{{$shopList->links()}}</div>
    </div>

</div>

<!-- <script>
    function imgLoaded(img, $shop) {
        var imgWrapper = img.parentNode;

        imgWrapper.className += imgWrapper.className ? ' loaded' : 'loaded';
    };


    document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages = document.querySelectorAll("img.lazy");    
  var lazyloadThrottleTimeout;
  
  function lazyload () {
    if(lazyloadThrottleTimeout) {
      clearTimeout(lazyloadThrottleTimeout);
    }    
    
    lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) { 
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
    }, 20);
  }
  
  document.addEventListener("scroll", lazyload);
  window.addEventListener("resize", lazyload);
  window.addEventListener("orientationChange", lazyload);
});
</script> -->

@stop