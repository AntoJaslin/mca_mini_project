@extends('layouts.app.master')

@section('content')
<style>
    #section-header {
        height: 700px;
        background-image: url("/assets/img/header-image-2.webp");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<header class="header-global">
    <nav id="navbar-main" aria-label="Primary navigation" class="navbar navbar-main navbar-expand-lg navbar-theme-primary pt-4 navbar-dark">
        <div class="container position-relative">
            <div class="navbar-collapse collapse me-auto" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="./index.html">
                                <img src="../assets/img/brand/dillards.png" alt="Volt logo">
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
                    
                    @if(Session::has('customer-user'))
                    <li class="nav-item me-2">
                        <a href="cart" class="nav-link">Cart</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="my_orders" class="nav-link">My orders</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="{{URL::route('user-logout')}}" class="nav-link">Logout</a>
                    </li>
                    @else
                    <li class="nav-item me-2">
                        <a href="{{URL::route('user-login')}}" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="{{URL::route('user-signup')}}" class="nav-link">Signup</a>
                    </li>
                    @endif
                </ul>
            </div>
            <!-- <div class="d-flex align-items-center ms-auto">
                <a href="./pages/upgrade-to-pro.html" class="btn btn-outline-white d-inline-flex align-items-center me-md-3">
                    <svg class="icon icon-xxs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd"></path></svg>
                    Download
                </a>
            </div> -->
        </div>
    </nav>
</header>
<main>
    <section id="section-header" class="container-fluid">
    
    </section>
    <div id="cart-alert" class="alert alert-warning d-none" role="alert">
        Please login to continue shopping!
    </div>
    @if(Session::has('signin-success'))
    <div class="alert alert-success" role="alert">
        {{Session::get('signin-success')}}
    </div>
    @endif
    <div class="container mt-5">
        <ul id="nav-pills" class="nav nav-pills nav-fill mt-5">
            @php
            $index = 0;
            @endphp
            @foreach($categories as $category)
            @php
            $index = $index+1;
            @endphp
            @if($index==1) 
            <li class="nav-item">
                <button type="button" class="nav-link active" data-bs-toggle="pill" data-bs-target="#pill-bnp-{{$category->id}}">{{ $category->name }}</button>
            </li>
            @else
            <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#pill-bnp-{{$category->id}}">{{ $category->name }}</button>
            </li>
            @endif
            @endforeach

            <!-- <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#pill-bnp-2">Tops</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#pill-bnp-3">Dresses</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#pill-bnp-4">Sarees</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#pill-bnp-5">Suites</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#pill-bnp-6">Ethnic sets</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#pill-bnp-7">Bottoms</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#pill-bnp-8">Winter</button>
            </li> -->
        </ul>
        <div class="tab-content">
            @if(Session::has('customer-user'))
            <input id="is_logged" type="hidden" value="true">
            @else
            <input id="is_logged" type="hidden" value="false">
            @endif
            @php
            $index = 0;
            @endphp
            @foreach($categories as $category)
            @php
            $index = $index+1;
            @endphp
            @if($index==1) 
            <div class="tab-pane fade show active" id="pill-bnp-{{$category->id}}" role="tabpanel">
            @else
            <div class="tab-pane fade show" id="pill-bnp-{{$category->id}}" role="tabpanel">
            @endif   
                <div class="row">
                    @foreach($products as $product)
                    @if($product->category_id == $category->id)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>{{ strtoupper($product->name) }}</h6>
                            </div>
                            <div class="product-card product-card--body">
                                <img src="{{URL::asset($product->image)}}" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                            <a data-id="{{$product->id}}" class="btn btn-secondary d-flex align-items-center justify-content-center mb-0 mt-2 btn-cart">Add to cart <svg class="icon icon-xs ms-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg></a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <!-- <div class="col-md-4">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>DIP INTO THE MIDNIGHT HUES</h6>
                            </div>
                            <div class="product-card product-card--body">
                            <img src="./assets/img/products/dress-2.jpg" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>DIP INTO THE MIDNIGHT HUES</h6>
                            </div>
                            <div class="product-card product-card--body">
                                <img src="./assets/img/products/dress-3.jpg" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>DIP INTO THE MIDNIGHT HUES</h6>
                            </div>
                            <div class="product-card product-card--body">
                                <img src="./assets/img/products/dress-4.jpg" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>DIP INTO THE MIDNIGHT HUES</h6>
                            </div>
                            <div class="product-card product-card--body">
                            <img src="./assets/img/products/dress-5.jpg" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>DIP INTO THE MIDNIGHT HUES</h6>
                            </div>
                            <div class="product-card product-card--body">
                                <img src="./assets/img/products/dress-6.jpg" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>DIP INTO THE MIDNIGHT HUES</h6>
                            </div>
                            <div class="product-card product-card--body">
                                <img src="./assets/img/products/dress-7.jpg" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>DIP INTO THE MIDNIGHT HUES</h6>
                            </div>
                            <div class="product-card product-card--body">
                            <img src="./assets/img/products/dress-8.jpg" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="product-card">
                            <div class="product-card product-card--title">
                                <h6>DIP INTO THE MIDNIGHT HUES</h6>
                            </div>
                            <div class="product-card product-card--body">
                                <img src="./assets/img/products/dress-3.jpg" alt="" class="product-img">
                            </div>
                            <div class="product-card product-card--footer">
                                
                            </div>
                        </div>
                    </div> -->
                </div>
                
            </div>
            @endforeach
            <!-- <div class="tab-pane fade" id="pill-bnp-2" role="tabpanel"><h4>Dillard's Tops</h4></div>
            <div class="tab-pane fade" id="pill-bnp-3" role="tabpanel"><h4>Dillard's Dresses</h4></div>
            <div class="tab-pane fade" id="pill-bnp-4" role="tabpanel"><h4>Dillard's Sarees</h4></div>
            <div class="tab-pane fade" id="pill-bnp-5" role="tabpanel"><h4>Dillard's Suites</h4></div>
            <div class="tab-pane fade" id="pill-bnp-6" role="tabpanel"><h4>Dillard's Ethnic sets</h4></div>
            <div class="tab-pane fade" id="pill-bnp-7" role="tabpanel"><h4>Dillard's Bottoms</h4></div>
            <div class="tab-pane fade" id="pill-bnp-8" role="tabpanel"><h4>Dillard's Winter</h4></div> -->
        </div>
    </div>
</main>
@endsection('content')
@section('scripts')
<script>
    //Init tabs example with 5 items per page & the class "nav-link" for navigation buttons
    //document.querySelector("#nav-tabs").BsNavPaginator(5, "nav-link");

    //Init pills example with 5 items per page & the class "nav-link" for navigation buttons
    document.querySelector("#nav-pills").BsNavPaginator(5, "nav-link");

    // $.ajaxSetup({
    //   headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   }
    // });

    var $cart_btns = $('.btn-cart');
    $cart_btns.each(function($i, $btn) {
      $(this).on('click', function() {
        var $isLogged = $("#is_logged").val();
        console.log("Is logged", $isLogged);
        if($isLogged == 'true') {
            var $product_id = $(this).data('id');
            $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Access-Control-Allow-Origin': "*" },
            url: "{{ asset('/add-cart') }}",
            method: 'post',
            data: {
                product_id: $product_id,
            },
            success: function(result){
                console.log(result);
            }
            });
        } else{
            $('#cart-alert').removeClass('d-none');
        }
        
          
      });
    })
</script>
@endsection

