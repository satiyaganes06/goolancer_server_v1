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
                <h4 class="mb-3 mb-md-0">Refund Approval</h4>
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
                                        <th>REQUESTED BY</th>
                                        <th>REASON</th>
                                        <th>REFUND AMOUNT (RM)</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($refundDetails as $refundDetail)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <th class="">{{ $i }}</th>
                                            <td>
                                                <p>{{ $refundDetail->up_var_first_name }}
                                                    {{ $refundDetail->up_var_last_name }} </p>

                                            </td>
                                            <td>
                                                <p style="width: 200px" class="ellipse">{{ $refundDetail->rr_var_reason }}
                                                </p>
                                            </td>
                                            <td>

                                                <p> {{ $refundDetail->rr_double_amount }}</p>


                                            </td>
                                            <td>
                                                @if ($refundDetail->rr_int_status == 0)
                                                    <p class="text-warning">Pending</p>
                                                @elseif ($refundDetail->jp_int_status == 1)
                                                    <p class="text-success">Approved</p>
                                                @else
                                                    <p class="text-danger">Rejected</p>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex ">
                                                    <a href="{{route('admin.viewsRefundInfo', ['id' => $refundDetail->rr_int_ref])}}"><i class="fs-6 " class="link-icon" data-feather="eye"
                                                            style="height: 20"></i></a>
                                                    <div style="width:10px"></div>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $refundDetails->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>

        <!-- Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Title</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="myForm">
                            <input type="hidden" name="refund_id" id="refund_id">
                            <div class="form-group">
                                <label for="remark">Remark:</label>
                                <input type="text" class="form-control" id="remark" name="remark">
                            </div>
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitBtn">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Handle click event on the link to open the modal
                $('.open-modal').click(function() {
                    var refundId = $(this).data('refund-id');
                    $('#refund_id').val(refundId); // Set the refund_id in the hidden input field
                    $('#myModal').modal('show'); // Open the modal
                });

                // Handle form submission
                $('#submitBtn').click(function() {
                    var formData = $('#myForm').serialize(); // Serialize form data
                    $.post('/your-controller-url', formData, function(response) {
                        // Handle response from the controller if needed
                        console.log(response);
                        $('#myModal').modal('hide'); // Hide the modal after submission
                    });
                });
            });
        </script>

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
