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

                <div class="p-4">
                    <p class="fs-5 ">{{ $certificate->ec_var_description }}</p>
                </div>
            </div>
        </div>


    </div>



@endsection
