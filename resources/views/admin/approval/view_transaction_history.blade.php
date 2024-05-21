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

        <div class="row">
            <div class="row">
                <div class="col-lg-3 grid-margin stretch-card ">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">User Details</h6>

                            <img width="100"
                                src="http://goolancer.online/user/displayImage/{{ $transactionDetail->userProfile->up_var_pic_first_name }}"
                                alt="image" style="border-radius: 10%;">

                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                                <p class="text-muted">{{ $transactionDetail->userProfile->up_var_first_name }}
                                    {{ $transactionDetail->userProfile->up_var_last_name }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                                <p class="text-muted">{{ $transactionDetail->userProfile->up_var_email_contact }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone Number:</label>
                                <p class="text-muted">{{ $transactionDetail->userProfile->up_var_contact_no }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">User Role:</label>
                                <p>
                                    @if ($transactionDetail->userProfile->up_int_role == '0')
                                        <span class="badge rounded-pill bg-info">Client</span>
                                    @elseif ($transactionDetail->userProfile->up_int_role == '1')
                                        <span class="badge rounded-pill bg-info">Expert</span>
                                    @elseif ($transactionDetail->userProfile->up_int_role == '3')
                                        <span class="badge rounded-pill bg-info">In-House Expert</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Transaction Details</h6>
                            <form class="forms-sample" id="myform"
                                action="{{ route('admin.approval.transaction_approval', ['id' => $transactionDetail->th_int_ref]) }}"
                                method="POST">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Transaction ID:</label>
                                        <input class="form-control mb-4 mb-md-0"
                                            value="{{ $transactionDetail->th_int_ref }}" data-inputmask="'alias': 'number'"
                                            disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-label">Transaction Type:</p>
                                        @if ($transactionDetail->th_int_transaction_type == 0)
                                            <span class="badge bg-success">Credit</span>
                                        @elseif ($transactionDetail->th_int_transaction_type == 1)
                                            <span class="badge bg-success">Withdraw</span>
                                        @elseif ($transactionDetail->th_int_transaction_type == 2)
                                            <span class="badge bg-info">Refund</span>
                                        @elseif ($transactionDetail->th_int_transaction_type == 3)
                                            <span class="badge bg-danger">Penalty</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Amount (RM):</label>
                                        <input class="form-control mb-4 mb-md-0"
                                            value="{{ $transactionDetail->th_int_transaction_type == 1 ? $transactionDetail->th_double_amount *0.9 : $transactionDetail->th_double_amount  }}"
                                            data-inputmask="'alias': 'currency', 'prefix':'RM'" disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">

                                            @if ($transactionDetail->th_int_payment_proof != null)
                                                <div>
                                                    <p class="form-label">Receipt:</p>
                                                    <a href="http://goolancer.online/user/displayImage/{{ $transactionDetail->th_int_payment_proof }}"><i
                                                            class="fs-6 text-dark link-icon" data-feather="file-text"
                                                            style="height: 20"></i></a>
                                                </div>

                                                <div class="w-25"></div>
                                            @endif


                                                @if ($transactionDetail->th_jm_int_ref != null)
                                                <div>
                                                    <p class="form-label">Order Details:</p>
                                                    <a
                                                        href={{route('admin.viewOrderInfo', ['id' => $transactionDetail->th_jm_int_ref])}}><i
                                                            class="fs-6 text-dark link-icon" data-feather="shopping-bag"
                                                            style="height: 20"></i></a>
                                                </div>
                                                    
                                                @endif
                                           

                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    @if ($transactionDetail->th_status == 0)
                                        <div class="mb-3">
                                            <label for="ageSelect" class="form-label">Transaction Type:</label>
                                            <select class="form-select" name="status" id="statusDropdown">
                                                <option selected disabled>Select Status</option>
                                                <option value="0"
                                                    {{ $transactionDetail->th_status == 0 ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="1"
                                                    {{ $transactionDetail->th_status == 1 ? 'selected' : '' }}>Accept
                                                </option>
                                                <option value="2"
                                                    {{ $transactionDetail->th_status == 2 ? 'selected' : '' }}>Reject
                                                </option>
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <label class="form-label">Transaction status : </label>
                                            <input class="form-control mb-4 mb-md-0"
                                                value="{{ $transactionDetail->th_status == 0 ? 'Pending' : ($transactionDetail->th_status == 1 ? 'Accepted' : 'Rejected') }}"
                                                disabled />
                                        </div>
                                    @endif

                                </div>

                                <hr>

                                <h6 class="card-title pt-2">DEBIT/CREDIT Details</h6>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Account Holder:</label>

                                        @if ($transactionDetail->th_status == 0)
                                            @if ($transactionDetail->th_int_transaction_type == 2)
                                                <input class="form-control" name="accountHolderName" />
                                            @else
                                                <input class="form-control"
                                                    value="{{ $transactionDetail->th_var_transfer_account_name }}"
                                                    disabled />
                                            @endif
                                        @else
                                            <input class="form-control"
                                                value="{{ $transactionDetail->th_var_transfer_account_name }}" disabled />
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Account Number:</label>
                                        @if ($transactionDetail->th_status == 0)
                                            @if ($transactionDetail->th_int_transaction_type == 2)
                                                <input class="form-control" id="cardnumber" type="number"
                                                    name="accountNumber" pattern="[0-9]*" />
                                            @else
                                                <input class="form-control"
                                                    value="{{ $transactionDetail->th_int_transfer_account_num }}"
                                                    disabled />
                                            @endif
                                        @else
                                            <input class="form-control"
                                                value="{{ $transactionDetail->th_int_transfer_account_num }}" disabled />
                                        @endif

                                    </div>

                                    @if ($transactionDetail->th_status == 0)
                                        @if ($transactionDetail->th_int_transaction_type == 1 || $transactionDetail->th_int_transaction_type == 2)
                                            <div class="mt-3">
                                                <label class="form-label" for="formFile">Upload Receipt</label>
                                                <input class="form-control" type="file" id="receipt"
                                                    name="receipt">
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                {{-- 
                                <div class="text-center mt-5"> --}}

                                <div class="d-grid gap-2 pt-5">
                                    @csrf
                                    <button type="submit" id="refundSubmitBtn" class="btn btn-primary  text-light"
                                        data-mdb-ripple-init><b>Submit</b></button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @endsection
