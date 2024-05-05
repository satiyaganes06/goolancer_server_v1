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

        <div class="d-flex justify-content-center align-items-center flex-wrap grid-margin">
            <div class="post_container">
                <div>
                    <a href="http://goolancer.online/user/displayImage/{{ $post->ep_var_image }}"><img
                            src="http://goolancer.online/user/displayImage/{{ $post->ep_var_image }}"
                            class="card-img-top rounded-3" alt="..."></a>

                    <div class="p-4">
                        <p class="fs-5 ">{{ $post->ep_txt_desc }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-start  p-4 pt-0">
                    <div>
                        <p>Status</p>
                        @if ($post->ep_int_status == 0)
                            <p class="text-warning">Pending</p>
                        @elseif ($post->ep_int_status == 1)
                            <p class="text-success">Published</p>
                        @else
                            <p class="text-danger">Rejected</p>
                        @endif
                    </div>

                    <div style="width: 20px;"></div>
                    <div>
                        <p>Posted On</p>
                        <td>{{ $post->ep_ts_created_at->format('m/d/Y h:i A') }}</td>
                    </div>
                </div>

                <div class="d-flex justify-content-center m-3">
                    <a href="{{ route('admin.approvePost', ['id' => $post->ep_int_ref, 'status' => 2]) }}"><button
                            type="button" class="btn btn-danger btn-icon-text ">
                            <i class="btn-icon-prepend" data-feather="x"></i>
                            Reject
                        </button></a>
                    <div style="width: 20px"></div>
                    <a href="{{ route('admin.approvePost', ['id' => $post->ep_int_ref, 'status' => 1]) }}"><button
                            type="button" class="btn btn-success btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="check"></i>
                            Approve
                        </button></a>
                </div>
            </div>


        </div>
    @endsection
