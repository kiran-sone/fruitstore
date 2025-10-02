<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Cart | Fruit Store">

	<!-- title -->
	<title>Cart | Fruit Store</title>

	<!-- CSS includes and styles -->
	@include('layout.styles')

</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	@include('layout.header')
	<!-- end header -->

	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Your Items</p>
						<h1>Cart</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- cart -->
	<div class="cart-section mt-150 mb-150">
		<form action="{{ url('updatecart') }}" method="POST">
			@csrf
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						@if (session('success'))
							<div class="alert alert-success">
								{{ session('success') }}
							</div>
						@endif
						@if (session('error'))
							<div class="alert alert-danger">
								{{ session('error') }}
							</div>
						@endif
					</div>
					<div class="col-lg-7 col-md-12">
						<div class="cart-table-wrap">
						@php
							$cartSubTotal = 0;
							$cartTotal = 0;
						@endphp
						@if(!empty($cart_items))
							<table class="cart-table">
								<thead class="cart-table-head">
									<tr class="table-head-row">
										<th class="product-remove"></th>
										<th class="product-image">Product Image</th>
										<th class="product-name">Name</th>
										<th class="product-price">Price</th>
										<th class="product-quantity">Quantity</th>
										<th class="product-total">Total</th>
									</tr>
								</thead>
								<tbody>
									@foreach($cart_items as $item)
										@php
											$fruit = (array) DB::table('fruits')
												->where('fruit_id', $item['fruit_id'])
												->first();
											$cartSubTotal += ($fruit['price'] * $item['quantity']);
										@endphp
										<tr class="table-body-row">
											<td class="product-remove remove-citem" data-cartid="<?php echo htmlspecialchars($item['cart_item_id']); ?>" data-fid="<?php echo htmlspecialchars($item['fruit_id']); ?>">
												<a href="javascript:void(0);"><i class="far fa-window-close"></i></a>
											</td>
											<td class="product-image">
												<img src="{{ url('assets/uploads/'.$fruit['image']) }}" alt="">
											</td>
											<td class="product-name">{{ $fruit['name'] }}</td>
											<td class="product-price">INR {{ intval($fruit['price']) }}</td>
											<input type="hidden" name="cartitems[]" value="<?php echo htmlspecialchars($item['cart_item_id']); ?>">
											<input type="hidden" name="fruitids[]" value="<?php echo htmlspecialchars($item['fruit_id']); ?>">
											<td class="product-quantity"><input type="number" name="quantity[]" value="{{ $item['quantity'] }}" min="1"></td>
											<td class="product-total">INR {{ $fruit['price'] * $item['quantity'] }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							@php $cartTotal = $cartSubTotal + $SHIPPING_COST; @endphp
						@else
							<h4 class="text-danger">No Items in Cart</h4>
							<div class="cart-buttons">
								<a href="{{ url('products') }}" class="boxed-btn">Shop for Fruits</a>
							</div>
						@endif
						</div>
					</div>

					<div class="col-lg-5">
						<div class="total-section">
							@if(!empty($cart_items))
							<table class="total-table">
								<thead class="total-table-head">
									<tr class="table-total-row">
										<th>Total</th>
										<th>Price</th>
									</tr>
								</thead>
								<tbody>
									<tr class="total-data">
										<td><strong>Subtotal: </strong></td>
										<td>INR {{ $cartSubTotal }}</td>
									</tr>
									<tr class="total-data">
										<td><strong>Shipping: </strong></td>
										<td>INR {{ $SHIPPING_COST }}</td>
									</tr>
									<tr class="total-data">
										<td><strong>Total: </strong></td>
										<td>INR {{ $cartTotal }}</td>
									</tr>
								</tbody>
							</table>
							<div class="cart-buttons">
								<button type="submit" class="btn-sm theme-btn">Update Cart</button>
								<a href="{{ url('/checkout') }}" class="btn-sm boxed-btn black">Check Out</a>
								<a href="{{ url('/products') }}" class="btn-sm boxed-btn black">Shop More</a>
							</div>
							@endif
						</div>

						<!-- <div class="coupon-section">
							<h3>Apply Coupon</h3>
							<div class="coupon-form-wrap">
								<form action="index.html">
									<p><input type="text" placeholder="Coupon"></p>
									<p><input type="submit" value="Apply"></p>
								</form>
							</div>
						</div> -->
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- end cart -->

	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/5.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->

	<!-- footer -->
	@include('layout.footer')
	<!-- end footer -->
	
	<!-- js scripts -->
	@include('layout.scripts')
	<!-- end js scripts -->

	<script>
	let url = "{{ url('deletecartitem') }}";
	$(document).ready(function () {
		$('.remove-citem').on('click', function (e) {
			let cartid = $(this).data('cartid');
			let fid = $(this).data('fid');

			$.ajax({
				url: url,
				method: 'POST',
				data: {
					cartid:cartid,
					fid:fid,
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				success: function (response) {
					// You can return JSON from controller
					if(response.status) {
						Swal.fire({
							title: (response.message || 'Item removed from cart!'),
							text: "Reloading Cart",
							icon: "success"
						}).then((result) => {
							window.location.href = cartUrl;
						});
					}
					else {
						Swal.fire({
							title: (response.message || 'Something went wrong!'),
							icon: "error"
						});
					}
				},
				error: function (xhr) {
					Swal.fire({
						title: 'Something went wrong!',
						icon: "error"
					});
					console.log(xhr.responseText);
				}
			});
		});
	});
	</script>

</body>
</html>