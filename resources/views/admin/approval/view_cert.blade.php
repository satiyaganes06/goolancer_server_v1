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
          display:inline-block;
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
      .width{
          width:auto;
      }
      .post_container{
            margin-top: 20px;
            min-height: 70vh;
            width:  40vw;
            overflow-y: scroll;
            overflow-x: hidden;
            border-radius: 30px;
            background-color: rgb(255, 255, 255);
      }
</style>
<div class="page-content">

    <div class="d-flex justify-content-center align-items-center flex-wrap grid-margin">
        <div class="post_container">
            <div>
                <a href="http://goolancer.online/user/displayImage/{{ $certificate->ec_var_image }}"><img src="http://goolancer.online/user/displayImage/{{ $certificate->ec_var_image }}"
                    class="card-img-top rounded-3" alt="..."></a>

                    <div class="p-4 pt-3 pb-0">
                        <p class="fs-3 "><b>{{ $certificate->ec_var_title }}</b></p>
                    </div>
                <div class="p-4">
                    <p class="fs-5 ">{{ $certificate->ec_var_description }}</p>
                </div>

                <div class="d-flex justify-content-between  p-4 pt-0">
                    <div>
                        <p>Issue Date</p>
                        <p class="fs-4"><b>{{ $certificate->ec_date_issue_date }}</b></p>
                    </div>
                    <div>
                        <p>Expiry Date</p>
                        <p class="fs-4"><b>{{ $certificate->ec_date_expiry_date ?? 'none' }}</b></p>
                    </div>
                    <div>
                        <p>No.Registration</p>
                        <p class="fs-4"><b>{{ $certificate->ec_var_registration_no  }}</b></p>
                    </div>
                </div>

                <div class="d-flex justify-content-center m-3">
                    <a href="{{route('admin.approveCertificate', ['id' => $certificate->ec_int_ref, 'status' => 2])}}"><button type="button" class="btn btn-danger btn-icon-text ">
                        <i class="btn-icon-prepend" data-feather="x"></i>
                        Reject
                    </button></a>
                    <div style="width: 20px"></div>
                    <a href="{{route('admin.approveCertificate', ['id' => $certificate->ec_int_ref, 'status' => 1])}}"><button type="button" class="btn btn-success btn-icon-text">
                        <i class="btn-icon-prepend" data-feather="check"></i>
                        Approve
                    </button></a>
                </div>
            </div>
        </div>


    </div>

</div>

@endsection
