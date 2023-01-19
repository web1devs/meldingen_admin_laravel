@extends('Admin')

@section('title')
    <title>Create ADS</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Create ADS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/ads">ADS</a></li>
                            <li class="breadcrumb-item active">create</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="POST" enctype="multipart/form-data" action="{{url('/ads/store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input autocomplete="off" id="title" name="title" class="form-control" required >
                                    @error('title')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">ADS Script</label>
                                    <textarea id="description" name="ads_code" class="form-control" rows="8" required ></textarea>
                                    @error('ads_code')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="description" class="form-label">From </label>
                                            <input type="time" name="start_time" class="form-control" required>
                                            @error('start_time')
                                            <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="description" class="form-label">To</label>
                                            <input type="time" name="end_time" class="form-control" required>
                                            @error('end_time')
                                            <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>




                                <div class="mb-3">
                                    <label for="stad_regio" class="form-label">Sections</label>
                                    <select name="section" id="stad_regio" class="form-control" required>
                                        <option value="">--Select a Section--</option>
                                        <option value="1">Meldingen Home 1</option>
                                        <option value="2">Meldingen Home 2</option>
                                        <option value="3">Meldingen Home 3</option>
                                        <option value="4">Meldingen Details 1</option>
                                        <option value="5">Meldingen Details 2</option>
                                        <option value="6">Meldingen Details 3</option>
                                        <option value="7">News 1</option>
                                        <option value="8">News 2</option>
                                        <option value="9">News 3</option>
                                        <option value="10">News Details 1</option>
                                        <option value="11">News Details 2</option>
                                        <option value="12">News Details 3</option>
                                        <option value="13">Blog</option>
                                        <option value="14">Partner Blogs</option>
                                      
                                       
                                    </select>

                                    @error('section')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="mb-3">

                                    <div class="form-check">
                                        <label for="is_active" class="form-label">Is active ?</label>
                                        <input  type="checkbox" name="status" value="1" id="is_active">


                                    </div>
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

