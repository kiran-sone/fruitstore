<?php
// echo "<pre>"; print_r($f_data);exit;
if(empty($f_data[0]->fruit_id)){
	echo "<h2>Product data not found!</h2>";
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Product Title | FruitStore">

	<!-- title -->
	<title><?php echo $f_data[0]->name; ?></title>

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
						<p>See more Details</p>
						<h1><?php echo $f_data[0]->name; ?></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- single product -->
	<div class="single-product mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<div class="single-product-img">
						@if(!empty($f_data[0]->image))
						<img src="{{ url('assets/uploads/'.$f_data[0]->image) }}" height="">
						@endif
					</div>
				</div>
				<div class="col-md-7">
					<div class="single-product-content">
						<h3><?php echo $f_data[0]->name; ?></h3>
						<p class="single-product-pricing"><span>Per Kg</span> INR <?php echo $f_data[0]->price; ?></p>
						<p><?php echo $f_data[0]->description; ?></p>
						<div class="single-product-form">
							@if($inCart)
								<!-- <form action="{{ route('addtocart', $f_data[0]->fruit_id) }}" method="POST" id="add_to_cart"> -->
									@csrf
									<input type="number" name="quantity" value="{{ $cartQty }}" min="1" class="form-control w-25 mb-2">
									<button type="button" class="theme-btn">
										<i class="fas fa-check"></i> In Cart
									</button>
								<!-- </form> -->
							@else
								<form action="{{ route('addtocart', $f_data[0]->fruit_id) }}" method="POST" id="add_to_cart">
									@csrf
									<input type="number" name="quantity" value="1" min="1" class="form-control w-25 mb-2">
									<button type="submit" class="theme-btn">
										<i class="fas fa-shopping-cart"></i> Add to Cart
									</button>
								</form>
							@endif
							<p><strong>Category: </strong><?php echo $f_data[0]->type_name; ?></p>
						</div>
						<h4>Share:</h4>
						<ul class="product-share">
							<li><a href=""><i class="fab fa-facebook-f"></i></a></li>
							<li><a href=""><i class="fab fa-twitter"></i></a></li>
							<li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
							<li><a href=""><i class="fab fa-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end single product -->

	<!-- more products -->
	<?php
	if(!empty($rel_products)){
		?>
		<div class="more-products mb-150">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 text-center">
						<div class="section-title">	
							<h3><span class="orange-text">Related</span> Products</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
						</div>
					</div>
				</div>
				
				<div class="row">
				<?php
					foreach ($rel_products as $rkey => $rdata) {
						if($rdata->fruit_id != $f_data[0]->fruit_id){
							$frNameSlug = strtolower(trim(str_replace(' ', '', $rdata->name)));
							?>
							<div class="col-lg-4 col-md-6 text-center">
								<div class="single-product-item">
									<div class="product-image">
										<a href="<?php echo $frNameSlug; ?>">
											@if(!empty($rdata->image))
											<img src="{{ asset('/assets/uploads/'.$rdata->image) }}" height="150">
											@endif
										</a>
									</div>
									<h3><a href="<?php echo $frNameSlug; ?>"><?php echo $rdata->name; ?></a></h3>
									<p class="product-price"><span>Per Kg</span> INR <?php echo $rdata->price; ?> </p>
									<a href="<?php echo $frNameSlug; ?>" class="cart-btn"><i class="fas fa-shopping-cart"></i> Buy It</a>
								</div>
							</div>
							<?php
						}
					}
				?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
	<!-- end more products -->

	<!-- footer -->
	@include('layout.footer')
	<!-- end footer -->
	
	<!-- js scripts -->
	@include('layout.scripts')
	<!-- end js scripts -->

	<script>
	$(document).ready(function () {
		$('#add_to_cart').on('submit', function (e) {
			e.preventDefault(); // stop default form submit

			let form = $(this);
			let url  = form.attr('action');
			let data = form.serialize(); // serialize form data (includes CSRF + quantity)

			$.ajax({
				url: url,
				method: 'POST',
				data: data,
				success: function (response) {
					// You can return JSON from controller
					Swal.fire({
						title: (response.message || 'Product added to cart!'),
						text: "Moving you to Cart",
						icon: "success"
					}).then((result) => {
						window.location.href = cartUrl;
					});
				},
				error: function (xhr) {
					alert('Something went wrong!');
					console.log(xhr.responseText);
				}
			});
		});
	});
	</script>

</body>
</html>