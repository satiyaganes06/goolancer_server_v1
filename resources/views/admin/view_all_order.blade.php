@extends('admin.admin_dashboard')
@section('admin_content')
    <style>
        .searchLogo {
            background-color: aliceblue;
            border: 0 !important;
            border-radius: 20px 0 0 20px !important;
        }

        .searchField {
            border: 0 !important;
            border-radius: 0 20px 20px 0 !important;
        }

        .ellipse {
            white-space: nowrap;
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: justify
        }

        .two-lines {
            -webkit-line-clamp: 5;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            white-space: normal;
        }

        .width {
            width: auto;
        }

        .post_container {
            margin-top: 20px;
            min-height: 70vh;
            width: 40vw;
            overflow-y: scroll;
            overflow-x: hidden;
            border-radius: 30px;
            background-color: rgb(255, 255, 255);
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <div class="page-content">
        <div class="w-100">
            <h4 class="pb-3 text-center">Orders</h4>
        </div>

        <div id="servicesGrid" class="row row-cols-1 row-cols-md-4 g-4 mt-1 ">

            @foreach ($orders as $order)
                <div style="margin-right: 10px" class="bg-white p-3 rounded-3">
                    <div class="d-flex justify-content-between">
                        @if ($order->jm_int_status == 0)
                            <span class="badge rounded-pill bg-primary">
                                In-Progress

                            </span>
                        @elseif ($order->jm_int_status == 1)
                            <span class="badge rounded-pill bg-success">
                                Delivered

                            </span>
                        @elseif ($order->jm_int_status == 2)
                            <span class="badge rounded-pill bg-danger">

                                Rejected
                            </span>
                        @endif


                        <p style="color: #d3d3d3">{{ \Carbon\Carbon::parse($order->jm_ts_created_at)->diffForHumans() }}</p>
                    </div>

                    <div class="d-flex justify-content-start align-items-center pt-4">
                        <img width="50" height="50"
                            src="http://goolancer.online/user/displayImage/{{ $order->up_var_pic_first_name }}"
                            alt="image" style="border-radius: 50%;">


                        <p style="margin-left: 10px">{{ $order->br_var_title }}</p>
                    </div>
                    <p style="margin-top: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $order->br_txt_desc }}</p>

                    <hr>

                    <div class="d-flex justify-content-between pb-2">
                        <b>Delivery Time: </b>
                        <p>{{ $order->br_var_delivery_time }}</p>

                    </div>

                    <div class="d-flex justify-content-between pb-2">
                        <b>Budget: </b>
                        <p>RM {{ $order->br_double_price }}</p>

                    </div>
                    @if ($order->br_var_address != null)
                        <div class="d-flex justify-content-between pb-2">


                            <b>Address: </b>
                            <p>{{ $order->br_var_address }}, {{ $order->br_int_zip_code }}, {{ $order->br_var_state }}</p>

                        </div>
                    @endif

                    <div class="d-grid gap-2 pt-3">

                        <button id="refundSubmitBtn" class="btn btn-dark rounded-3  text-light" data-mdb-ripple-init> <a
                                href="{{ route('admin.viewOrderInfo', ['id' => $order->jm_int_ref]) }}"><b
                                    class="text-light">View More</b></a></button>
                    </div>

                </div>
            @endforeach

        </div>



    </div>
@endsection
