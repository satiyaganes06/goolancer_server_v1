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
               <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.freepik.com%2Ficon%2Frefund_3585091&psig=AOvVaw3Q4WWv5FK9DkFabeu0NMqT&ust=1715460485542000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCJDMh736g4YDFQAAAAAdAAAAABAE"
                    class="card-img-top rounded-3" alt="...">

                    <div class="p-4 pt-3 pb-0">
                        <p class="fs-3 "><b>Reason</b></p>
                    </div>

                    <div class="p-4 pt-3 pb-0">
                        <p class="fs-4 ">{{ $refundDetail->rr_var_reason }}</p>
                    </div>
                <div class="p-4">
                    <p class="fs-5 ">{{ $refundDetail->rr_var_description }}</p>
                </div>

                <div class="d-flex justify-content-between  p-4 pt-0">
                    <div>
                        <p>Issue Date</p>
                        <p class="fs-4"><b>{{ $refundDetail->ec_date_issue_date }}</b></p>
                    </div>
                    <div>
                        <p>Expiry Date</p>
                        <p class="fs-4"><b>{{ $refundDetail->ec_date_expiry_date ?? 'none' }}</b></p>
                    </div>
                    <div>
                        <p>No.Registration</p>
                        <p class="fs-4"><b>{{ $refundDetail->ec_var_registration_no  }}</b></p>
                    </div>
                </div>


                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                
                <form action="{{ route('admin.approval.refund_approval', ['id' => $refundDetail->rr_int_ref]) }}" method="post">

                    <div class="d-flex align-items-center">
                        <div class="col-3">
                            <p><b>Status</b></p>
                        </div>
        
                        <select class="form-select" name="status" id="statusDropdown">
                            <option value="0" {{ $refundDetail->rr_int_status == 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $refundDetail->rr_int_status == 1 ? 'selected' : '' }}>Accept</option>
                            <option value="2" {{ $refundDetail->rr_int_status == 2 ? 'selected' : '' }}>Reject</option>
                        </select>
                    </div>
        
                    <hr class="border-0">

                    <div id="penalty" style="display: none;">
                        <div class="d-flex align-items-center">
                            <div class="col-3">
                                <p><b>Penalty Percentage</b></p>
                            </div>
            
                            <select class="form-select" name="penaltyPercentage" id="statusDropdown">
                                <option value="0.25" >25%</option>
                                <option value="0.5" >50%</option>
                                <option value="0.75">75%</option>
                            </select>
                        </div>
                    </div>

                    <hr class="border-0">
        
                    <div id="remarkSection" style="display: none;">
        
                        <div class="d-flex">
                            <div class="col-3">
                                <p><b>Admin Remark</b></p>
                            </div>
                            <div class="w-100">
                                <textarea name="remark" class="form-control" id="remark" cols="30" rows="5"></textarea>
                            </div>
                        </div>
        
                    </div>

                    <div id="uploadSection" style="display: none;">
                        <div class="d-flex">
                            <div class="col-3">
                                <p><b>Upload Receipt</b></p>
                            </div>
            
            
                            <div class="mb-3">
                                <input class="form-control" type="file" id="receipt"  name="receipt">
                            </div>
            
                        </div>
                    </div>
        
                    <div class="text-center mt-5">
                        @csrf
                        <button type="submit" id="refundSubmitBtn" class="btn pl-3 pr-3 mb-4 bg-white text-dark" data-mdb-ripple-init><b>Submit</b></button>
        
                    </div>
                </form>

                

                {{-- <div class="d-flex justify-content-center m-3">
                    <a href="{{route('admin.approveCertificate', ['id' => $certificate->ec_int_ref, 'status' => 2])}}"><button type="button" class="btn btn-danger btn-icon-text ">
                        <i class="btn-icon-prepend" data-feather="x"></i>
                        Reject
                    </button></a>
                    <div style="width: 20px"></div>
                    <a href="{{route('admin.approveCertificate', ['id' => $certificate->ec_int_ref, 'status' => 1])}}"><button type="button" class="btn btn-success btn-icon-text">
                        <i class="btn-icon-prepend" data-feather="check"></i>
                        Approve
                    </button></a>
                </div> --}}
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
                }else{
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
