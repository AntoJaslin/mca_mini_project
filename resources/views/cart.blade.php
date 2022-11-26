@extends('layouts.app.master')

@section('content')
<header class="header-global">
    <nav id="navbar-main" aria-label="Primary navigation" class="navbar navbar-main navbar-expand-lg navbar-theme-primary pt-4 navbar-dark">
        <div class="container position-relative">
            <div class="navbar-collapse collapse me-auto" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="./index.html">
                                <img src="./assets/img/brand/light.svg" alt="Volt logo">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <a href="#navbar_global" class="fas fa-times" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" title="close" aria-label="Toggle navigation"></a>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                    <li class="nav-item me-2">
                        <a href="/" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="{{URL::route('user-login')}}" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="{{URL::route('user-signup')}}" class="nav-link">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h3>Your cart items!</h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-sm-6">
                <h6>Item</h6>
            </div>
            <div class="col-sm-6 text-center">
                <h6>Price</h6>
            </div>
        </div>
        <hr>
        @php
        $total = 0;
        $cartProducts = '';
        @endphp
        @if($cartCount > 0) 
        @foreach($products as $product)
        @php
        $total = $total + $product->price;
        $cartProducts = $cartProducts.$product->id.',';
        @endphp
        <div class="row mt-5">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="{{URL::asset($product->image)}}" alt="">
                    </div>
                    <div class="col-sm-8">
                        <p>{{$product->name}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 text-center">
                <p>Rs. {{$product->price}}</p>
            </div>
        </div>
        @endforeach
        @else 
        <p>Cart is Empty!</p>
        @endif
        @if($total > 0) 
        <hr>
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6 text-center">
                <h6><b>Rs. {{$total}}</b></h6>
                <a id="btn-checkout" data-products="{{$cartProducts}}" data-total="{{$total}}" class="btn btn-secondary d-flex align-items-center justify-content-center mb-0 mt-2 btn-cart">Checkout <svg class="icon icon-xs ms-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg></a>
            </div>
        </div>
        @endif
    </div>
</main>
@endsection('content')
@section('scripts')
<script>
    var $checkout_btn = $("#btn-checkout");
    $checkout_btn.on('click', function() {
      var $products = $(this).data('products');
      var $total = $(this).data('total');
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Access-Control-Allow-Origin': "*" },
          url: "{{ asset('/create-order') }}",
          method: 'post',
          data: {
            products: $products,
            total: $total
          },
          success: function(result){
              console.log(result);
          }
      });
    })
</script>
@endsection


