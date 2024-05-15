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
    </style>
    <div class="page-content">

        <div class="row">
            <div class="col-5 col-md-3 pe-0">
                <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-init-tab" data-bs-toggle="pill" href="#v-init" role="tab"
                        aria-controls="v-init" aria-selected="true">Initial Payment</a>
                    <a class="nav-link" id="v-progress-tab" data-bs-toggle="pill" href="#v-progress" role="tab"
                        aria-controls="v-progress" aria-selected="false">Progress Order</a>
                    <a class="nav-link" id="v-complete-tab" data-bs-toggle="pill" href="#v-complete" role="tab"
                        aria-controls="v-complete" aria-selected="false">Complete Payment</a>
                    <a class="nav-link" id="v-delivery-tab" data-bs-toggle="pill" href="#v-delivery" role="tab"
                        aria-controls="v-delivery" aria-selected="false">Delivery</a>
                    <a class="nav-link" id="v-review-tab" data-bs-toggle="pill" href="#v-review" role="tab"
                        aria-controls="v-review" aria-selected="false">Review & Rating</a>
                </div>
            </div>
            <div class="col-7 col-md-9 ps-0">
                <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                    <div class="tab-pane fade show active" id="v-init" role="tabpanel" aria-labelledby="v-init-tab">
                        <h3 class="mb-1">Initial Payment</h3>
                        {{-- {"jp_int_ref":27,"jp_jm_ref":15,"jp_var_up_ref":"hj2RpkvwX5bv1V3rRHZYoaqL5vW2","jp_int_type":0,"jp_var_acount_transfer_name":"satiya","jp_date_account_transfer_date":"2024-04-24","jp_double_account_transfer_amount":21,"jp_var_account_transfer_remark":"none","jp_var_receipt":"app\/uploads\/files\/PaymentReceipt\/WLKLURhjkf0Xa2Fkk2MZ4Xmhg6xqfd6du364DudJ.jpg","jp_int_status":1,"jp_ts_created_at":"2024-04-24T12:27:26.000000Z","jp_ts_updated_at":"2024-04-24T12:27:26.000000Z"} --}}

                        <label class="form-label mt-3">Payment Status:</label>
                        @if ($jobPaymentInitial != null)
                            @if ($jobPaymentInitial->jp_int_status == 0)
                                <input class="form-control" value="Pending" disabled />
                            @elseif ($jobPaymentInitial->jp_int_status == 1)
                                <input class="form-control" value="Accept" disabled />
                            @elseif ($jobPaymentInitial->jp_int_status == 2)
                                <input class="form-control" value="Reject" disabled />
                            @endif

                            <br>

                            <div>
                                <p class="form-label">Payment Receipt:</p>
                                <a
                                    href="http://goolancer.online/user/displayImage/{{ $jobPaymentInitial->jp_var_receipt }}"><i
                                        class="fs-6 text-dark link-icon" data-feather="file-text"
                                        style="height: 20"></i></a>
                            </div>
                        @else
                            <input class="form-control" value="Pending" disabled />
                        @endif
                    </div>
                    <div class="tab-pane fade" id="v-progress" role="tabpanel" aria-labelledby="v-progress-tab">
                        <h3 class="mb-1">Progress Order Details</h3>
                        {{-- <p>{{ $jobResults[0] }}</p> --}}
                        <hr>
                        @if ($jobResults != null)
                            @foreach ($jobResults as $jobResult)
                                <div class="m-3">
                                    <p class="pb-3">{{ $jobResult->jr_txt_description }}</p>

                                    @if ($jobResult->fileURL != null)
                                        @foreach ($jobResult->fileURL as $jobResultFile)
                                            @php
                                                $extension = pathinfo(
                                                    $jobResultFile->jrf_files_path,
                                                    PATHINFO_EXTENSION,
                                                );
                                            @endphp

                                            @if ($extension == 'pdf')
                                                <a
                                                    href="http://goolancer.online/user/displayImage/{{ $jobResultFile->jrf_files_path }}"><img
                                                        src="https://img.freepik.com/premium-vector/pdf-file-icon-flat-design-graphic-illustration-vector-pdf-icon_676691-2007.jpg?w=740"
                                                        alt="" height="150"></a>
                                            @else
                                                <a
                                                    href="http://goolancer.online/user/displayImage/{{ $jobResultFile->jrf_files_path }}"><img
                                                        src="http://goolancer.online/user/displayImage/{{ $jobResultFile->jrf_files_path }}"
                                                        alt="" height="150"></a>
                                            @endif
                                        @endforeach
                                    @else
                                    @endif

                                </div>

                                <hr>
                            @endforeach
                        @else
                            <div class="p-5 h-50 text-center">
                                <p>No progress</p>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="v-complete" role="tabpanel" aria-labelledby="v-complete-tab">
                        <h3 class="mb-1">Complete Payment</h3>
                        {{-- <p>{{ $jobPaymentComplete }}</p> --}}

                        <label class="form-label mt-3">Payment Status:</label>
                        @if ($jobPaymentComplete != null)
                            @if ($jobPaymentComplete->jp_int_status == 0)
                                <input class="form-control" value="Pending" disabled />
                            @elseif ($jobPaymentComplete->jp_int_status == 1)
                                <input class="form-control" value="Accept" disabled />
                            @elseif ($jobPaymentComplete->jp_int_status == 2)
                                <input class="form-control" value="Reject" disabled />
                            @endif

                            <br>

                            <div>
                                <p class="form-label">Payment Receipt:</p>
                                <a
                                    href="http://goolancer.online/user/displayImage/{{ $jobPaymentComplete->jp_var_receipt }}"><i
                                        class="fs-6 text-dark link-icon" data-feather="file-text"
                                        style="height: 20"></i></a>
                            </div>
                        @else
                            <input class="form-control" value="Pending" disabled />
                        @endif
                    </div>
                    <div class="tab-pane fade" id="v-delivery" role="tabpanel" aria-labelledby="v-delivery-tab">
                        <h3 class="mb-1">Delivery</h3>
                        <hr>
                        @if (count($jobResultsDeliverys) > 0)


                            <div class="m-3">
                                <p class="pb-3">{{ $jobResultsDeliverys[0]->jr_txt_description }}</p>

                                @if ($jobResultsDeliverys[0]->fileURL != null)
                                    @foreach ($jobResultsDeliverys[0]->fileURL as $jobResultFile)
                                        @php
                                            $extension = pathinfo($jobResultFile->jrf_files_path, PATHINFO_EXTENSION);
                                        @endphp

                                        @if ($extension == 'pdf')
                                            <a
                                                href="http://goolancer.online/user/displayImage/{{ $jobResultFile->jrf_files_path }}"><img
                                                    src="https://img.freepik.com/premium-vector/pdf-file-icon-flat-design-graphic-illustration-vector-pdf-icon_676691-2007.jpg?w=740"
                                                    alt="" height="150"></a>
                                        @else
                                            <a
                                                href="http://goolancer.online/user/displayImage/{{ $jobResultFile->jrf_files_path }}"><img
                                                    src="http://goolancer.online/user/displayImage/{{ $jobResultFile->jrf_files_path }}"
                                                    alt="" height="150"></a>
                                        @endif
                                    @endforeach
                                @else
                                @endif

                            </div>

                            <hr>
                        @else
                            <div class="p-5 h-50 text-center">
                                <p>No progress</p>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="v-review" role="tabpanel" aria-labelledby="v-review-tab">
                        <h3 class="mb-1">Review & Rating</h3>
               

                        @if ($jobUserRating != null)
                        <div class="d-flex align-items-start mt-4">
                            <img src="http://goolancer.online/user/displayImage/{{ $clientDetails->up_var_pic_first_name }}" class="align-self-start wd-50 wd-sm-100 me-3 rounded-5" alt="...">
                            <div>
                                <h5 class="mb-2">{{$clientDetails->up_var_first_name}} {{$clientDetails->up_var_last_name}}</h5>
                                <p>{{$jobUserRating->jur_txt_comment}}</p>
                            </div>

                            
                        </div>

                        <div class="d-flex justify-content-end">
                            
                                <i class="link-icon text-warning pr-2" data-feather="star"></i>
                                <p class="fs-4">{{$jobUserRating->jur_rating_point}}</p>
                        </div>

                        <hr>
                        @else
                        <div class="p-5 h-50 text-center">
                            <p>No rating</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
