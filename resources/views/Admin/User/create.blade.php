@extends('Admin')

@section('title')
    <title>Add new user</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Add New User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/user">User</a></li>
                            <li class="breadcrumb-item active">create</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="POST" enctype="multipart/form-data" action="{{url('/user/store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Name</label>
                                    <input autocomplete="off" id="title" name="name" class="form-control" required >
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Email</label>
                                    <input type="email" autocomplete="off" id="title" name="email" class="form-control" required >
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Password</label>
                                    <input type="text" autocomplete="off" id="title" name="password" class="form-control" required >
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">User role</label>
                                    <select id="role" class="form-control" name="role" required="">
                                        <option value="1">Admin</option>
                                        <option value="0">User</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Status</label>
                                    <select id="role" class="form-control" name="status" required="">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>


                            </div>



                        </div>

                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection


