@extends('Admin')

@section('title')
    <title>Edit Cookiebeleid </title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Edit Cookiebeleid</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/Cookiebeleid">Cookiebeleid </a></li>
                            <li class="breadcrumb-item active">edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="POST" enctype="multipart/form-data" action="{{url('/Cookiebeleid/update/'.$data->id)}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input autocomplete="off" id="title" value="{{$data->title}}" name="title" class="form-control" required >

                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Content</label>
                                    <textarea id="description" name="content" class="form-control" rows="8" required >
                                        {{$data->content}}
                                    </textarea>

                                </div>



                            </div>



                        </div>

                        <button type="submit" class="btn btn-primary">update</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection


