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
                        <h1>Edit ADS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/ads">ADS</a></li>
                            <li class="breadcrumb-item active">edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="POST" action="{{url('/ads/update/'.$data->id)}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input autocomplete="off" id="title" name="title" value="{{$data->title}}" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">content</label>
                                    <textarea id="description" name="ads_code" class="form-control" rows="8" required>{{$data->content}}</textarea>
                                </div>

                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="description" class="form-label">From </label>
                                            <input type="time" name="start_time" value="{{$data->from_hr}}" class="form-control" required>
                                            @error('start_time')
                                            <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="description" class="form-label">To</label>
                                            <input type="time" name="end_time" value="{{$data->to_hr}}" class="form-control" required>
                                            @error('end_time')
                                            <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>




                                <div class="mb-3">
                                    <label for="stad_regio" class="form-label">Sections</label>
                                    <select name="section" id="stad_regio" class="form-control" required="">
                                        <option value="" >--Select a Section--</option>
                                        <option value="1" {{$data->section == 1 ? 'selected':''}}>Meldingen Home 1</option>
                                        <option value="2" {{$data->section == 2 ? 'selected':''}}>Meldingen Home 2</option>
                                        <option value="3" {{$data->section == 3 ? 'selected':''}}>Meldingen Home 3</option>
                                        <option value="4" {{$data->section == 4 ? 'selected':''}}>Meldingen Details 1</option>
                                        <option value="5" {{$data->section == 5 ? 'selected':''}}>Meldingen Details 2</option>
                                        <option value="6" {{$data->section == 6 ? 'selected':''}}>Meldingen Details 3</option>
                                        <option value="7" {{$data->section == 7 ? 'selected':''}}>News 1</option>
                                        <option value="8" {{$data->section == 8 ? 'selected':''}}>News 2</option>
                                        <option value="9" {{$data->section == 9 ? 'selected':''}}>News 3</option>
                                        <option value="10" {{$data->section == 10 ? 'selected':''}}>News Details 1</option>
                                        <option value="11" {{$data->section == 11 ? 'selected':''}}>News Details 2</option>
                                        <option value="12" {{$data->section == 12 ? 'selected':''}}>News Details 3</option>
                                        <option value="13" {{$data->section == 13 ? 'selected':''}}>Blogs</option>
                                        <option value="14" {{$data->section == 13 ? 'selected':''}}>Partner Blogs</option>

                                    </select>
                                </div>

                                <div class="mb-3">

                                    <div class="form-check">
                                        <label for="is_active" class="form-label">Is active ?</label>
                                        <input  type="checkbox" name="status"  value="1" id="is_active" {{$data->status === 1 ? 'checked':''}}>

                                        @error('status')
                                        <span class="text-danger"> {{ $message }} </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>



                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection


