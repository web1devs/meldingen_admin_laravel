@extends('Admin')

@section('title')
    <title>Edit Seo Data</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Seo Data Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/seo-data">SEO Data</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="POST" action="{{url('/seo-data/update/'.$data->page)}}">
                        @csrf

                        <div class="mb-3">
                            <label for="image" class="form-label">Title</label>
                            <input type="text" name="title" value="{{stripslashes($data->title)}}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">SEO Keyword</label>
                            <textarea id="image" name="seo_keyword" class="form-control">{{$data->seo_keywords}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">SEO Meta</label>
                            <textarea id="image" name="seo_meta" class="form-control">{{$data->seo_meta}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Structured Data</label>
                            <textarea id="image" name="structured_data" class="form-control">{{$data->structured_data}}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">update</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection

