@extends('Admin')

@section('title')
    <title>Edit Provincie</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Provincie Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/provincie">Provincie</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="post" enctype="multipart/form-data" action="{{url('/provincie/update/'.$data->id)}}">
                        @csrf


                        <div class="form-group">
                            <label for="exampleInputEmail1">Provincie</label>
                            <input type="text" value="{{$data->provincie}}" class="form-control" id="straat" name="provincie" required>
                        </div>
                        @error('provincie')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">provincie url</label>
                            <input type="text" value="{{$data->provincie_url}}" class="form-control"  name="provincie_url" required>

                        </div>
                        @error('provincie_url')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror




                        <div class="form-group">
                            <label for="description">Seo Keyword</label>
                            <textarea  class="form-control"  name="seo_keywords" >{{$data->seo_keywords}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Seo Meta</label>
                            <textarea  class="form-control"  name="seo_meta" >{{$data->seo_meta}}</textarea>
                        </div>

                        <button class="btn btn-md btn-primary m-2">update</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection

