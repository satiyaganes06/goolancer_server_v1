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

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Client Management</h4>
            </div>

            <div class="col-md-12 grid-margin stretch-card mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title">Client List</h6>
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
                                        <th>FULL NAME</th>
                                        <th>NRIC</th>
                                        <th>EMAIL</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($clients as $client)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <th class="pt-4">{{ $i }}</th>
                                            <td class="d-flex align-items-center"> <img
                                                    src="http://goolancer.online/user/displayImage/{{ $client->up_var_pic_first_name }}"
                                                    alt="image">
                                                <div style="width:10px"></div> {{ $client->up_var_first_name }}
                                                {{ $client->up_var_last_name }}
                                            </td>
                                            <td>
                                                <p class="pt-1">{{ $client->up_var_nric }}</p>
                                            </td>
                                            <td class="pt-3">{{ $client->up_var_email_contact }}</td>
                                            <td>
                                                <div class="d-flex ">
                                                    <a href=" {{route('admin.viewUserAccountInfo', ['id' => $client->up_int_ref])}}"><i class="fs-6 " class="link-icon" data-feather="eye"
                                                            style="height: 20"></i></a>
                                                    <div style="width:10px"></div>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $clients->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title">Expert List</h6>
                            <form class="d-flex input-group w-auto mr-4" action="" method="GET">

                                <span class="input-group-text searchLogo bg-light" id="search-addon">
                                    <button type="submit" class="border-0 bg-light"><i class="link-icon"
                                            data-feather="search"></i></button>
                                </span>

                                <input type="search" id="form2" class="form-control searchField bg-light" name="searchTerm"
                                    placeholder="Search" aria-label="Search" aria-describedby="search-addon" onkeyup="myFunction2()"/>

                            </form>
                        </div>
                        <p class="text-muted mb-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>BIL</th>
                                        <th>FULL NAME</th>
                                        <th>EMAIL</th>
                                        <th>Ongoing Projects</th>
                                        <th>Role</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($experts as $expert)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <th class="pt-4">1</th>
                                            <td class="d-flex align-items-center"> <img
                                                    src="http://goolancer.online/user/displayImage/{{ $expert->up_var_pic_first_name }}"
                                                    alt="image">
                                                <div style="width:10px"></div> {{ $expert->up_var_first_name }}
                                                {{ $expert->up_var_last_name }}
                                            </td>
                                            <td class="pt-3">
                                                <p>{{ $expert->up_var_email_contact }}</p>
                                            </td>
                                            <td class="pt-3">0</td>
                                            <td class="pt-3"><span class="badge rounded-pill bg-success">
                                                    @if ($expert->up_int_role == 2)
                                                        In-House
                                                    @else
                                                        Expert
                                                    @endif

                                                </span></td>
                                            <td>
                                                <div class="d-flex ">
                                                    <a href=""><i class="fs-6 " class="link-icon" data-feather="eye"
                                                            style="height: 20"></i></a>
                                                    {{-- {{ route('client.updateReport', ['id' => $report->id]) }} --}}
                                                    <div style="width:10px"></div>
                                                    {{-- <a href="" onclick="">
                                                    <i class="link-icon " data-feather="edit" style="height: 20"></i>
                                                </a>
                                                <div style="width:10px"></div> --}}
                                                    {{-- <a href="" onclick=""><i class="text-danger link-icon"
                                                        data-feather="trash" style="height: 20"></i><a> --}}

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $experts->links('pagination::bootstrap-5') }}
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
