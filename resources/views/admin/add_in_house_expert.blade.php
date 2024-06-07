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
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center pb-4">Add Expert</h3>
                        <form class="forms-sample"  action="{{ route('admin.addInHouseExperts') }}" method="POST">
                           
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">First
                                            Name</label>
                                        <input type="text"
                                            class="form-control"
                                            name="first_name"
                                            placeholder="John" required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">Last
                                            Name</label>
                                        <input type="text"
                                            class="form-control"
                                            name="last_name"
                                            placeholder="Doe" required>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">NRIC</label>
                                        <input type="text"
                                            class="form-control"
                                            name="nric"
                                            placeholder="01038927382823" required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">Role</label>
                                        <input type="text"
                                            class="form-control"
                                            value="In-House Expert"
                                            disabled
                                            placeholder="">
                                    </div>
                                </div><!-- Col -->
                               
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">Email
                                            address</label>
                                        <input type="email"
                                            class="form-control"
                                            name="email"    
                                            placeholder="johndoe@gmail.com" required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">Password</label>
                                        <input type="password"
                                            class="form-control"
                                            autocomplete="off"
                                            name="password" required> 
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->

                            <div class="row">
                                
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">Confirm Password</label>
                                        <input type="password"
                                            class="form-control"
                                            autocomplete="off"
                                            name="confirm_password"
                                            placeholder="" required>
                                    </div>
                                </div><!-- Col -->
                            </div>

                            <div class="d-grid gap-2 pt-5">
                                @csrf
                                <button type="submit"  class="btn btn-primary  text-light"
                                    data-mdb-ripple-init><b>Register</b></button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
