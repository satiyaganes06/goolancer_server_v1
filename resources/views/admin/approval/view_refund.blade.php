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
    </style>
    <div class="page-content">

        <div class="row">
            <div class="row">
                <div class="col-lg-3 grid-margin stretch-card ">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">User Details</h6>

                            <img width="100"
                                src="http://goolancer.online/user/displayImage/{{ $refundDetail->userProfile->up_var_pic_first_name }}"
                                alt="image" style="border-radius: 10%;">

                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                                <p class="text-muted">{{ $refundDetail->userProfile->up_var_first_name }}
                                    {{ $refundDetail->userProfile->up_var_last_name }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                                <p class="text-muted">{{ $refundDetail->userProfile->up_var_email_contact }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone Number:</label>
                                <p class="text-muted">{{ $refundDetail->userProfile->up_var_contact_no }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 fw-bolder mb-0 text-uppercase">User Role:</label>
                                <p>
                                    @if ($refundDetail->userProfile->up_int_role == '0')
                                        <span class="badge rounded-pill bg-info">Client</span>
                                    @elseif ($refundDetail->userProfile->up_int_role == '1')
                                        <span class="badge rounded-pill bg-info">Expert</span>
                                    @elseif ($refundDetail->userProfile->up_int_role == '3')
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
                            <h6 class="card-title">Refund Details</h6>
                            <form class="forms-sample" action="{{ route('admin.approval.refund_approval', ['id' => $refundDetail->rr_int_ref]) }}"
                                method="post">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Refund ID:</label>
                                        <input class="form-control mb-4 mb-md-0" value="{{ $refundDetail->rr_int_ref }}"
                                            data-inputmask="'alias': 'number'" disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <p class="form-label">Transaction Type:</p>
                                        <span class="badge bg-info">Request Refund</span>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Amount (RM):</label>
                                        <input class="form-control mb-4 mb-md-0"
                                            value="{{ $refundDetail->rr_double_amount }}"
                                            data-inputmask="'alias': 'currency', 'prefix':'RM'" disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div>
                                                <p class="form-label">Order Details:</p>
                                                <a
                                                    href={{ route('admin.viewOrderInfo', ['id' => $refundDetail->rr_jm_ref]) }}><i
                                                        class="fs-6 text-dark link-icon" data-feather="shopping-bag"
                                                        style="height: 20"></i></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Refund Reason:
                                    </label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>{{ $refundDetail->rr_var_reason }}</textarea>
                                </div>

                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                               

                                    <div class="row mb-2">


                                        @if ($refundDetail->rr_int_status == 0)
                                            <div class="mb-3">
                                                <label for="ageSelect" class="form-label">Refund status:</label>
                                                <select class="form-select" name="status" id="statusDropdown">
                                                    <option selected disabled>Select Status</option>
                                                    <option value="0"
                                                        {{ $refundDetail->rr_int_status == 0 ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="1"
                                                        {{ $refundDetail->rr_int_status == 1 ? 'selected' : '' }}>Accept
                                                    </option>
                                                    <option value="2"
                                                        {{ $refundDetail->rr_int_status == 2 ? 'selected' : '' }}>Reject
                                                    </option>
                                                </select>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <label class="form-label">Transaction status : </label>
                                                <input class="form-control mb-4 mb-md-0"
                                                    value="{{ $refundDetail->rr_int_status == 0 ? 'Pending' : ($refundDetail->rr_int_status == 1 ? 'Accepted' : 'Rejected') }}"
                                                    disabled />
                                            </div>
                                        @endif

                                    </div>


                                    <div id="penalty" style="display: none;">

                                        <div class="pb-3">
                                            <label>Penalty Percentage</label>

                                            <select class="form-select" name="penaltyPercentage" id="statusDropdown">
                                                <option value="0.25">25%</option>
                                                <option value="0.5">50%</option>
                                                <option value="0.75">75%</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div id="remarkSection" style="display: none;">

                                        <div class="mb-3">
                                            <label class="form-label">Admin Remark : </label>

                                        <textarea name="remark" class="form-control" id="remark" cols="30" rows="5"></textarea>
                                        </div>

                                    </div>


                                    <div id="uploadSection" style="display: none;">

                                        <div class="row mb-3 mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Account Holder:</label>
                                                <input class="form-control" value="Goolancer" name="accountHolder" disabled />


                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Account Number:</label>
                                                <input class="form-control" value="193208497824421" name="accountNumber" disabled />

                                            </div>
                                        </div>

                                        <div class="mb-4 mt-3">

                                            <label class="form-label" for="formFile">Upload
                                                Receipt</label>
                                            <input class="form-control" type="file" id="receipt" name="receipt">
                                        </div>
                                    </div>

                                    @if ($refundDetail->rr_int_status == 0)
                                        <div class="d-grid gap-2 pt-2">
                                            @csrf
                                            <button type="submit" id="refundSubmitBtn"
                                                class="btn btn-primary  text-light"
                                                data-mdb-ripple-init><b>Submit</b></button>
                                        </div>
                                    @endif
                                


                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>




    </div>
    <script>
        $(document).ready(function() {
            // Listen for changes in the dropdown
            $('#statusDropdown').change(function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Show/hide the remark section based on the selected value
                if (selectedValue === '2') {
                    $('#remarkSection').show();
                    $('#penalty').show();
                    $('#uploadSection').hide();


                } else if (selectedValue === '1') {
                    $('#remarkSection').show();
                    $('#uploadSection').show();
                    $('#penalty').hide();
                } else {
                    $('#remarkSection').hide();
                    $('#uploadSection').hide();
                    $('#penalty').hide();
                }
            });

            // Trigger the change event on page load to set the initial visibility
            $('#statusDropdown').trigger('change');
        });
    </script>
@endsection
