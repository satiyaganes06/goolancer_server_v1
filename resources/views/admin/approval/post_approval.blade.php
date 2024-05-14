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
                <h4 class="mb-3 mb-md-0">Post Approval</h4>
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

                                <input type="search" id="form1" class="form-control searchField bg-light"
                                    name="searchTerm" placeholder="Search" aria-label="Search"
                                    aria-describedby="search-addon" onkeyup="myFunction()" />

                            </form>
                        </div>
                        <p class="text-muted mb-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>BIL</th>
                                        <th>DESCRIPTION</th>
                                        <th>POSTED TIME</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($posts as $post)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <th class="">{{ $i }}</th>
                                            <td>
                                                <p style="width: 200px" class="ellipse">{{ $post->ep_txt_desc }}</p>
                                            </td>
                                            <td>{{ $post->ep_ts_created_at->format('m/d/Y h:i A') }}</td>
                                            <td>
                                                @if ($post->ep_int_status == 0)
                                                    <p class="text-warning">Pending</p>
                                                @elseif ($post->ep_int_status == 1)
                                                    <p class="text-success">Published</p>
                                                @else
                                                    <p class="text-danger">Rejected</p>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a
                                                        href="{{ route('admin.approval.viewPostInfo', ['id' => $post->ep_int_ref]) }}"><i
                                                            class="fs-6 " class="link-icon" data-feather="eye"
                                                            style="height: 20"></i></a>
                                                    <div style="width:10px"></div>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $posts->links('pagination::bootstrap-5') }}
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
