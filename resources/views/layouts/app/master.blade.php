<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('/css/app.css')}}">
  
  
</head>
<body>
@yield('content')
<!-- JS init here -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/js/bootstrap-nav-paginator.min.js')}}"></script>
@yield('scripts')
<!-- <script>
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
          
      });
    })

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
</script> -->
</body>
</html>
