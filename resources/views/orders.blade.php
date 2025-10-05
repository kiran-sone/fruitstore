<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Orders | Fruit Store">

	<!-- title -->
	<title>Orders | Fruit Store</title>

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
						<p>Orders</p>
						<h1>Orders</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- cart -->
	<div class="cart-section mt-150 mb-150">
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
						@if (!empty($odata_error))
							<div class="alert alert-danger">
								{{ $odata_error }}
							</div>
						@endif
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="cart-table-wrap">
						@php
							$cartSubTotal = 0;
							$cartTotal = 0;
						@endphp
						@if(!empty($order_data))
							<table class="cart-table">
								<thead class="cart-table-head">
									<tr class="table-head-row">
										<th class="product-image">Order ID</th>
										<th class="product-name">Date</th>
										<th class="product-price">Payment Method</th>
										<th class="product-quantity">Shipping Cost</th>
										<th class="product-total">Total Amount</th>
										<th class=""></th>
									</tr>
								</thead>
								<tbody>
									@foreach($order_data as $order)
										<tr class="table-body-row">
											<td class="product-name">{{ $order['order_id'] }}</td>
											<td class="product-price">{{ date('d M, Y', strtotime($order['order_date'])) }}</td>
											<td class="product-quantity">{{ $order['pay_method'] }}</td>
											<td class="product-total">INR {{ $order['shipping_cost'] }}</td>
											<td class="product-total">INR {{ $order['total_amount'] }}</td>
											<td><a href="{{ url('/orderdetails/' . $order['order_id']) }}" class=""><i class="fas fa-arrow-circle-right" style="font-size: 20px"></i></a></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@else
							<h4 class="text-danger">Order data not found!</h4>
						@endif
						</div>
					</div>

				</div>
			</div>
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
							text: "Reloading Orders",
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