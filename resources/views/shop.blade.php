<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Shop | FruitStore">

	<!-- title -->
	<title>Shop | Fruit Store</title>
	
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
						<p>Fresh and Organic</p>
						<h1>Shop<?php if(!empty($f_type['type_name'])) echo ' | '.$f_type['type_name']; ?></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- products -->
	<div class="product-section mt-150 mb-150">
		<div class="container">

			<div class="row">
                <div class="col-md-12">
					<input type="hidden" id="fruit_type" value="<?php if(!empty($f_type['type_name'])) echo '.'.$f_type['type_name']; ?>">
                    <div class="product-filters">
						<?php if(!empty($fruit_types)) {
						?>
                        <ul>
                        <li class="active" data-filter="*">All</li>
						<?php
						foreach ($fruit_types as $tkey => $ftype) {
						?>
                            <li data-filter=".<?php echo str_replace(' ', '_', $ftype->type_name); ?>"><?php echo $ftype->type_name; ?></li>
						<?php } ?>
                        </ul>
						<?php
						}
						?>
                    </div>
                </div>
            </div>

			<div class="row product-lists">
				<?php if(!empty($fruits)) {
					foreach ($fruits as $fkey => $fruit) {
						$frNameSlug = strtolower(trim(str_replace(' ', '', $fruit->name)));
						?>
						<div class="col-lg-4 col-md-6 text-center <?php echo str_replace(' ', '_', $fruit->type_name); ?>">
							<div class="single-product-item">
								<div class="product-image">
									<a href="<?php echo $frNameSlug; ?>">
										@if(!empty($fruit->image))
										<img src="{{ url('assets/uploads/'.$fruit->image) }}" height="150">
										@endif
									</a>
								</div>
								<h3><a href="<?php echo $frNameSlug; ?>"><?php echo $fruit->name; ?></a></h3>
								<p class="product-price"><span>Per Kg</span> INR <?php echo $fruit->price; ?> </p>
								<a href="<?php echo $frNameSlug; ?>" class="cart-btn" data-cart="<?php echo $fruit->fruit_id; ?>"><i class="fas fa-shopping-cart"></i> Buy It</a>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>

			<!-- pagination start -->
			<!-- <div class="row">
				<div class="col-lg-12 text-center">
					<div class="pagination-wrap">
						<ul>
							<li><a href="#">Prev</a></li>
							<li><a class="active" href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">Next</a></li>
						</ul>
					</div>
				</div>
			</div> -->
			<!-- pagination end -->

		</div>
	</div>
	<!-- end products -->

	<!-- footer -->
	@include('layout.footer')
	<!-- end footer -->

	<!-- js scripts -->
	@include('layout.scripts')
	<!-- end js scripts -->
</body>
</html>