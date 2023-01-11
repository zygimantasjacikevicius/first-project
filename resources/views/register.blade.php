@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h1>Please register below</h1>
                    </div>

                    <form action="{{ route('register_store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 form-group">
                                Email: <input type="email" class="form-control" name="email"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-4 form-group">
                                Password: <input type="password" class="form-control" name="password" value="">
                            </div>
                            <div class="col-4 form-group">
                                Confirm Password: <input type="password" class="form-control" name="password_confirmation"
                                    value="">
                            </div>



                            <button type="submit" class="btn btn-success mt-2">Register</button>
                        </div>
                    </form>
                </div>


            </div>





        </div>
    </div>
@endsection
