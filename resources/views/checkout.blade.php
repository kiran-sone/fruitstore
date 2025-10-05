<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Checkout | Fruit Store">

    <!-- title -->
    <title>Check Out | Fruit Store</title>

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
                        <p>Place Your Order</p>
                        <h1>Check Out</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- check out section -->
    <div class="checkout-section mt-150 mb-150">
        <form id="checkoutForm" action="{{ url('checkout') }}" method="POST">
			@csrf
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                            <!-- Billing Address -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Billing Address</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('b_fullName') is-invalid @enderror" id="b_fullName" name="b_fullName"
                                            placeholder="Name" value="{{ Auth::user()->name }}" required>
                                    </div>
									@error('b_fullName')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                    <div class="form-group">
                                        <input type="tel" class="form-control @error('b_phone_num') is-invalid @enderror" id="b_phone_num" name="b_phone_num"
                                            placeholder="Phone" required>
                                    </div>
									@error('b_phone_num')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                    <div class="form-group">
                                        <input type="email" class="form-control @error('b_emailId') is-invalid @enderror" id="b_emailId" name="b_emailId"
                                            placeholder="Email" value="{{ Auth::user()->email }}">
                                    </div>
									@error('b_emailId')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('b_fullAddr') is-invalid @enderror" id="b_fullAddr" name="b_fullAddr"
                                            placeholder="Full Address" required>
                                    </div>
									@error('b_fullAddr')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('b_pincode') is-invalid @enderror" id="b_pincode" name="b_pincode"
                                            placeholder="Pincode" required>
                                    </div>
									@error('b_pincode')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Shipping Address</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('s_fullName') is-invalid @enderror" id="s_fullName" name="s_fullName"
                                            placeholder="Name" value="{{ Auth::user()->name }}" required>
                                    </div>
									@error('s_fullName')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                    <div class="form-group">
                                        <input type="tel" class="form-control @error('s_phone_num') is-invalid @enderror" id="s_phone_num" name="s_phone_num"
                                            placeholder="Phone" required>
                                    </div>
									@error('s_phone_num')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                    <div class="form-group">
                                        <input type="email" class="form-control @error('s_emailId') is-invalid @enderror" id="s_emailId" name="s_emailId"
                                            placeholder="Email" value="{{ Auth::user()->email }}">
                                    </div>
									@error('s_emailId')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('s_fullAddr') is-invalid @enderror" id="s_fullAddr" name="s_fullAddr"
                                            placeholder="Full Address" required>
                                    </div>
									@error('s_fullAddr')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('s_pincode') is-invalid @enderror" id="s_pincode" name="s_pincode"
                                            placeholder="Pincode" required>
                                    </div>
									@error('s_pincode')
										<div class="text-danger mt-0 mb-2" role="alert">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
                                </div>
                            </div>
                    </div>

                    <div class="col-lg-4">
                        @php
                        $cartSubTotal = 0;
                        $cartTotal = 0;
                        @endphp
                        @if(!empty($cart_items))
                        <div class="order-details-wrap">
                            <table class="order-details mb-5">
                                <thead>
                                    <tr>
                                        <th>Item Details</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody class="order-details-body">
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                    @foreach($cart_items as $item)
                                    @php
                                    $fruit = (array) DB::table('fruits')
                                    ->where('fruit_id', $item['fruit_id'])
                                    ->first();
                                    $cartSubTotal += ($fruit['price'] * $item['quantity']);
                                    @endphp
                                    <tr>
                                        <td>{{ $fruit['name'] }}</td>
                                        <td>INR {{ $fruit['price'] * $item['quantity'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @php $cartTotal = $cartSubTotal + $SHIPPING_COST; @endphp
                                <tbody class="checkout-details">
                                    <tr>
                                        <th>Sub Total</th>
                                        <th>INR {{ $cartSubTotal }}</th>
                                    </tr>
                                    <tr>
                                        <td>Shipping</td>
                                        <td>INR {{ $SHIPPING_COST }}</td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total</th>
                                        <th>INR {{ $cartTotal }}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="theme-btn">Place Order</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end check out section -->

    <!-- footer -->
    @include('layout.footer')
    <!-- end footer -->

    <!-- js scripts -->
    @include('layout.scripts')
    <!-- end js scripts -->

</body>

</html>