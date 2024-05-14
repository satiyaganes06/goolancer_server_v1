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
    </style>
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Payment Approval</h4>
            </div>

            <div class="col-md-12 grid-margin stretch-card mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">

                            <form class="d-flex input-group w-auto mr-4" action="" method="GET">

                                <span class="input-group-text searchLogo bg-light" id="search-addon">
                                    <button type="submit" class="border-0 bg-light"><i class="link-icon"
                                            data-feather="search"></i></button>
                                </span>

                                <input type="search" id="form1" class="form-control searchField bg-light" name="searchTerm"
                                    placeholder="Search" aria-label="Search" aria-describedby="search-addon" onkeyup="myFunction()"/>

                            </form>
                        </div>
                        <p class="text-muted mb-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>BIL</th>
                                        <th>PAID BY (EMAIL)</th>
                                        <th>PAYMENT TYPE</th>
                                        <th>TRANSACTION DETAILS</th>
                                        <th>RECEIPT</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($payments as $payment)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <th class="">{{ $i }}</th>
                                            <td > <p> {{$payment->up_var_email_contact}} </p> </td>
                                            <td >
                                                <span class="badge rounded-pill bg-success">
                                                    @if ($payment->jp_int_type == 0)
                                                        Initial Payment
                                                    @elseif ($payment->jp_int_type == 1)
                                                        Final Payment
                                                    @endif

                                                </span>
                                            </td>
                                            <td>
                                               <div>
                                                <p>Name: {{ $payment->jp_var_acount_transfer_name }}</p>
                                                <p>Amount: RM {{ $payment->jp_double_account_transfer_amount }} <a href="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="RM {{$payment->br_double_price * 0.1}}"><i class="fs-6 text-secondary " class="link-icon" data-feather="dollar-sign"
                                                    style="height: 20"></i></a>
                                            <div style="width:10px"></div></p>
                                                <p>Payment Date: {{ $payment->jp_date_account_transfer_date }}</p>
                                               </div>
                                            </td>
                                            <td>
                                                <a href="http://goolancer.online/user/displayImage/{{ $payment->jp_var_receipt }}"><i class="fs-6 text-dark link-icon"  data-feather="file-text"
                                                    style="height: 20"></i></a>
                                            </td>
                                            <td>
                                                @if ($payment->jp_int_status == 0)
                                                    <p class="text-warning">Pending</p>
                                                @elseif ($payment->jp_int_status == 1)
                                                    <p class="text-success">Approved</p>
                                                @else
                                                    <p class="text-danger">Rejected</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($payment->jp_int_status == 0)
                                                    <div class="d-flex ">
                                                    <a href="{{route('admin.approvePayment', ['id' => $payment->jp_int_ref, 'status' => 2, 'paymentType' => $payment->jp_int_type])}}"><i class="fs-6 text-danger " class="link-icon" data-feather="x"
                                                        style="height: 20"></i></a>
                                                <div style="width:10px"></div>
                                                    <a href="{{route('admin.approvePayment', ['id' => $payment->jp_int_ref, 'status' => 1, 'paymentType' => $payment->jp_int_type])}}"><i class="fs-6 text-success" class="link-icon" data-feather="check"
                                                            style="height: 20"></i></a>
                                                    <div style="width:10px"></div>

                                                </div>
                                                @else
                                                    <p>-</p>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $payments->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>

    </div>
        <script>
            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("form1");
                filter = input.value.toUpperCase();
                table = document.getElementsByTagName("table")[0];
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0]; // Change index to match the column you want to search
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

            function myFunction2() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("form2");
                filter = input.value.toUpperCase();
                table = document.getElementsByTagName("table")[1];
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[2]; // Change index to match the column you want to search
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
    @endsection
