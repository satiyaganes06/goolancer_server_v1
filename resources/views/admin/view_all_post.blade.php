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

        .image-container {
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(95, 158, 57, 255);
            border-radius: 50px;
            /* Change as needed */
            color: white;
            /* Change as needed */
            padding: 5px;
            margin-top: 10px;
            margin-left: 10px;
            /* Change as needed */
        }
    </style>
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div class="w-100">
                <h4 class="mb-3 mb-md-0 text-center">Posts</h4>
            </div>
            {{-- <form class="d-flex input-group  mr-4 justify-content-center"
                style="margin-right: 20%; margin-left: 20%; margin-top:30px" action="" method="GET">

                <span class="input-group-text searchLogo bg-light" id="search-addon">
                    <button type="submit" class="border-0 bg-light"><i class="link-icon"
                            data-feather="search"></i></button>
                </span>

                <input type="search" id="form1" class="form-control searchField bg-light" name="searchTerm"
                    placeholder="Search" aria-label="Search" aria-describedby="search-addon" onkeyup="myFunction()" />

            </form> --}}
            <div class="example">
                <!-- Button trigger modal -->



                <div id="servicesGrid" class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                    <!-- Your service cards here -->
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
                </div>
                <div class="mt-3">
                    {{ $posts->links('pagination::bootstrap-5') }}
                </div>

            </div>




        </div>
    </div>
@endsection
