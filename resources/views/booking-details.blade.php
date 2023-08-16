@extends('layout.main')

@section('content')
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb-content text-center">
                        <h2 class="title">Booking Details</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Booking Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- customer-details-area -->
    <section class="customer-details-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="customer-details-content">
                        <div class="icon">
                            <img src="{{ asset('assets/img/icon/customer_det_icon.jpg') }}" alt="">
                        </div>
                        <div class="content">
                            <h2 class="title">Customer Details: Please fill in with valid information.</h2>
                            <div class="customer-progress-wrap">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="customer-progress-step">
                                    <ul>
                                        <li>
                                            <span>1</span>
                                            <p>Guest Information</p>
                                        </li>
                                        <li>
                                            <span>2</span>
                                            <p>Payment</p>
                                        </li>
                                        <li>
                                            <span>3</span>
                                            <p>Confirmation</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- customer-details-area-end -->

    <!-- booking-details-area -->
    <section class="booking-details-area">
        <form action="{{route('processBooking')}}" method="POST">
            @csrf
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-73">
                        <div class="primary-contact">
                            <i class="fa-regular fa-user"></i>
                            <h2 class="title">Contact Details (for E-ticket/Voucher)</h2>
                        </div>
                        <div class="booking-details-wrap">
                            {{-- <form action="#"> --}}
                            <ul>
                                <li>
                                    <div class="form-grp">
                                        <div class="icon">
                                            <i class="flaticon-user-1"></i>
                                        </div>
                                        <div class="form">
                                            <input type="text" placeholder="First Name *" name="firstname">
                                        </div>
                                    </div>
                                </li>
                                <!-- <li>
                                                <div class="form-grp">
                                                    <input type="text" placeholder="Give Name">
                                                </div>
                                            </li> -->
                                <li>
                                    <div class="form-grp">
                                        <input type="text" placeholder="Last Name *" name="lastname">
                                    </div>
                                </li>
                            </ul>
                            <div class="gender-select">
                                <h2 class="title">Select Your Gender*</h2>

                                <div class="radio-buttons-container">
                                    <div class="radio-button">
                                        <input name="gender" id="radio22" class="radio-button__input" type="radio" value="1" checked>
                                        <label for="radio22" class="radio-button__label">
                                            <span class="radio-button__custom"></span>

                                            Male
                                        </label>
                                    </div>
                                    <div class="radio-button">
                                        <input name="gender" id="radio11" class="radio-button__input" value="0" type="radio">
                                        <label for="radio11" class="radio-button__label">
                                            <span class="radio-button__custom"></span>

                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-grp">
                                        <div class="icon">
                                            <i class="flaticon-telephone-call"></i>
                                        </div>
                                        <div class="form">
                                            <input type="number" placeholder="Mobile Number *" name="phone">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-grp">
                                        <div class="icon">
                                            <i class="flaticon-calendar"></i>
                                        </div>
                                        <div class="form">
                                            <label for="shortBy">Date of Birth*</label>
                                            <input type="text" class="date" placeholder="Select Date" name="birthday">
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- <div class="col-md-6">
                                                <div class="form-grp">
                                                    <div class="icon">
                                                        <i class="flaticon-home"></i>
                                                    </div>
                                                    <div class="form">
                                                        <input type="text" placeholder="Post Code *">
                                                    </div>
                                                </div>
                                            </div> -->
                                <div class="col-md-6">
                                    <div class="form-grp">
                                        <div class="icon">
                                            <i class="flaticon-arroba"></i>
                                        </div>
                                        <div class="form">
                                            <label for="email">Your Email*</label>
                                            <input type="email" id="email" placeholder="youinfo@gmail.com" name="email">
                                        </div>
                                    </div>
                                </div>
                            </div>

        </form>
        </div>

        @for ($i = 1; $i <= $qty; $i++) <!-- Passenger area-->
            <div class="primary-contact">
                <i class="fa-regular fa-user"></i>
                <h2 class="title">Traveler Details: Passenger no. {{ $i }}</h2>
            </div>
            <div class="booking-details-wrap">
                <p>Make sure that the passenger's name is exactly as written in the government issued ID/Passport/Driving License. </p>
                {{-- <form action="#"> --}}
                <ul>
                    <li>
                        <div class="form-grp">
                            <div class="icon">
                                <i class="flaticon-user-1"></i>
                            </div>
                            <div class="form">
                                <input type="text" placeholder="First Name *" name="pass_firstname[<?php echo $i; ?>]">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="form-grp">
                            <input type="text" placeholder="Last Name *" name="pass_lastname[<?php echo $i; ?>]">
                        </div>
                    </li>
                </ul>
                <div class="gender-select" style="margin-bottom: 40px;">
                    <h2 class="title">Select Your Gender*</h2>
                    <div class="radio-buttons-con ">
                        <div class="radio-but">
                            <input name="pass_gender[<?php echo $i; ?>]" id="radio1.[<?php echo $i; ?>]" class="radio-but__input" type="radio" value="1" checked>
                            <label for="radio1.[<?php echo $i; ?>]" class="radio-but__label">
                                <span class="radio-but__custom"></span> 

                                Male
                            </label>
                        </div>
                        <div class="radio-but">
                            <input name="pass_gender[<?php echo $i; ?>]" id="radio2.[<?php echo $i; ?>]" class="radio-but__input" value="0" type="radio">
                            <label for="radio2.[<?php echo $i; ?>]" class="radio-but__label">
                                <span class="radio-but__custom"></span>

                                Female
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-grp">
                            <div class="icon">
                                <i class="flaticon-calendar"></i>
                            </div>
                            <div class="form">
                                <label for="shortBy">Date of Birth*</label>
                                <input type="date" placeholder="Select Date" name="birthday[<?php echo $i; ?>]">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-grp">
                            <div class="icon">
                                <i class="flaticon-five-stars"></i>
                            </div>
                            <div class="form">
                                <input type="text" placeholder="Passport number *" name="passport[<?php echo $i; ?>]">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-grp checkbox-grp">
                    {{-- <input type="checkbox" id="checkbox">
                                        <label for="checkbox">Add this person to passenger quick pick list</label> --}}
                </div>
                </form>
            </div>
            @endfor

            <!-- Passengers-area-end -->
            </div>
            <div class="col-27">
                <aside class="booking-sidebar">
                    <h2 class="main-title">Booking Info</h2>
                    <div class="widget">
                        <h2 class="widget-title">Departure Ticket Infomarion</h2>
                        <ul class="flight-info">
                            <li><img src="{{ asset('assets/img/icon/sidebar_flight_icon.jpg') }}" alt="">
                                <p>{{ date('h : i A', strtotime($depart->departure)) }}
                                    <span>{{ $depart->FromPlace }}</span>
                                </p>
                            </li>
                            <li>
                                <p>{{ date('h : i A', strtotime($depart->arrival)) }} <span>{{ $depart->ToPlace }}</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h2 class="widget-title">Departure price summary</h2>
                        <div class="price-summary-top">
                            <ul>
                                <li>Details</li>
                                <li>Amount</li>
                            </ul>
                        </div>
                        <div class="price-summary-detail">
                            <ul>
                                <li>Adult x {{ $qty }} <span>${{ $qty * $price1 }}</span></li>
                                {{-- <li>Tax x {{ $qty }} <span>${{ $qty * $price1 * 0.1 }}</span></li> --}}
                                {{-- <li>Total Airfare: <span>${{ $qty * $price1  }}</span></li> --}}
                                {{-- <li>Discount<span>- $110</span></li> --}}
                                {{-- <li>Total Payable<span>${{ $qty * $price1 + $qty * $price1 * 0.1 }}</span></li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="widget">
                        <h2 class="widget-title">Arrival Ticket Infomarion </h2>
                        <ul class="flight-info">
                            <li><img src="{{ asset('assets/img/icon/sidebar_flight_icon.jpg') }}" alt="">
                                <p>{{ date('h : i A', strtotime($arri->departure)) }}
                                    <span>{{ $arri->FromPlace }}</span>
                                </p>
                            </li>
                            <li>
                                <p>{{ date('h : i A', strtotime($arri->arrival)) }} <span>{{ $arri->ToPlace }}</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                    {{-- <div class="widget">
                                <h2 class="widget-title">Select Discount Option</h2>
                                <form action="#" class="discount-form">
                                    <i class="flaticon-coupon"></i>
                                    <input type="text" placeholder="Enter Code">
                                    <button type="submit"><i class="flaticon-tick-1"></i></button>
                                </form>
                            </div> --}}
                    {{-- <div class="widget">
                                <h2 class="widget-title">Your Preferred Bank</h2>
                                <ul class="preferred-bank-wrap">
                                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo01.png') }}"
                    alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo02.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo03.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo04.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo05.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo06.png') }}" alt=""></a></li>
                    </ul>
            </div> --}}
            <div class="widget">
                <h2 class="widget-title">Arrival price summary</h2>
                <div class="price-summary-top">
                    <ul>
                        <li>Details</li>
                        <li>Amount</li>
                    </ul>
                </div>
                <div class="price-summary-detail">
                    <ul>
                        <li>Adult x {{ $qty }} <span>${{ $qty * $price2 }}</span></li>
                        {{-- <li>Tax x {{ $qty }} <span>${{ $qty * $price2 * 0.1 }}</span></li> --}}
                        {{-- <li>Total Airfare: <span>${{ $qty * $price2  }}</span></li> --}}
                        {{-- <li>Discount<span>- $110</span></li> --}}
                        <li>Total Payable<span>${{ ($qty * $price2 ) + ($qty * $price1 )}} </span></li>
                    </ul>
                    <input type="hidden" name="quantity" value="{{$qty}}">
                    <input type="hidden" name="totalprice" value="{{($qty * $price2 ) + ($qty * $price1 )}}">
                    <input type="hidden" name="class" value="{{$class}}">
                    <input type="hidden" name="price1" value="{{$price1}}">
                    <input type="hidden" name="price2" value="{{$price2}}">
                    <input type="hidden" name="flightid1" value="{{$depart->flight_id}}">
                    <input type="hidden" name="flightid2" value="{{$arri->flight_id}}">
                    <button type="submit" style="width:100%" class="btn">Pay now</button>
                </div>
            </div>
            <div class="widget">
                <h2 class="widget-title">Your Preferred Bank</h2>
                <ul class="preferred-bank-wrap">
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo01.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo02.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo03.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo04.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo05.png') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('assets/img/images/bank_logo06.png') }}" alt=""></a></li>
                </ul>
            </div>
            </aside>
            </div>
            </div>
            </div>
            </form>

    </section>
    <!-- booking-details-area-end -->

</main>
<!-- main-area-end -->
@endsection