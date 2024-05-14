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

        .img_container {
            width: 45vw;
            height: auto;

        }

        .service_info_container {
            height: auto;
            width: 30vw;
            padding: 10px;
            margin-left: 20px;


        }
    </style>
    <div class="page-content">

        <div class=" flex-wrap grid-margin">
            <div class="w-100 mt-3">
                <h4 class="mb-3 mb-md-0 ">{{ $service->es_var_title }}</h4>
            </div>

            <div class="d-flex mt-3">
                <img class="img_container rounded-3"
                    src="http://goolancer.online/user/displayImage/{{ $service->es_var_images }}"
                    class="card-img-top rounded-3" alt="...">

                <div class="service_info_container d-flex flex-column justify-content-between rounded-3">

                    <div>
                        <div class="w-100 d-flex justify-content-between align-items-end mb-3">
                            @php
                                $serviceCategoriesName = [
                                    'AI Artists',
                                    'Logo Design',
                                    'Photography',
                                    'Videography',
                                    'Web Development',
                                    'Mobile Development',
                                    'Translation',
                                    'Painting',
                                    'Video Editing',
                                    'Photo Editing',
                                ];
                            @endphp
                            <p>Service Category</p>
                            <p class="fs-4"><b>{{ $serviceCategoriesName[$service->es_int_service_type_ref] }}</b></p>
                        </div>

                        <div class=" w-100 d-flex justify-content-between align-items-end  mb-3">
                            <p>Delivery Time</p>
                            <p class="fs-4"> <b>{{ $service->es_estimate_delivery_time }} days</b></p>
                        </div>

                        <div class="w-100 d-flex justify-content-between align-items-end mb-3">
                            <p>Starting Price</p>
                            <p class="fs-4"><b>RM {{ $service->es_var_starting_price }}</b></p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        @if ($from == 1)
                            <a href="{{route('admin.approveService', ['id' => $service->es_int_ref, 'status' => 2])}}"><button type="button" class="btn btn-danger btn-icon-text ">
                                <i class="btn-icon-prepend" data-feather="x"></i>
                                Reject
                            </button></a>
                            <div style="width: 20px"></div>
                            <a href="{{route('admin.approveService', ['id' => $service->es_int_ref, 'status' => 1])}}"><button type="button" class="btn btn-success btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="check"></i>
                                Approve
                            </button></a>
                        @endif
                    </div>

                </div>

            </div>

            <p class="mt-4 mr-5 mb-5">{{ $service->es_txt_description }}</p>

            <h3>Certificate</h3>
            <div id="servicesGrid" class="row row-cols-1 row-cols-md-3 g-4 mt-1 mb-3">

                <!-- Your service cards here -->
                @if ($certificates->count() > 0)
                    @foreach ($certificates as $certificate)
                        <div class="col">
                            <div class="card rounded-3">
                                <div class="image-container">
                                    <img src="http://goolancer.online/user/displayImage/{{ $certificate->ec_var_image }}"
                                        class="card-img-top rounded-3" alt="...">
                                </div>
                                <!-- Add a data attribute to store post details -->
                                <div class="card-body text-center" data-post="{{ json_encode($certificate) }}">
                                    <a href="{{ route('admin.viewCertificateInfo', ['id' => $certificate->ec_int_ref]) }}">
                                        View More
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col w-100 text-center">
                        <p>No certificate available</p>
                    </div>
                @endif
            </div>

            <h3>Posts</h3>
            <div id="servicesGrid" class="row row-cols-1 row-cols-md-3 g-4 mt-1">

                <!-- Your service cards here -->
                @if ($posts->count() > 0)
                    @foreach ($posts as $post)
                        <div class="col">
                            <div class="card rounded-3">
                                <div class="image-container">
                                    <img src="http://goolancer.online/user/displayImage/{{ $post->ep_var_image }}"
                                        class="card-img-top rounded-3" alt="...">
                                </div>
                                <!-- Add a data attribute to store post details -->
                                <div class="card-body text-center" data-post="{{ json_encode($post) }}">
                                    <a href="{{ route('admin.viewPostInfo', ['id' => $post->ep_int_ref]) }}">
                                        View More
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col w-100 text-center">
                        <p>No post available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>


    @endsection
