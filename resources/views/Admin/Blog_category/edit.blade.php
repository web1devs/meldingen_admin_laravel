@extends('Admin')

@section('title')
    <title>Edit Blog Category</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Blog Category Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/blog-category">Blog Category</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="post" enctype="multipart/form-data" action="{{url('/blog-category/update/'.$data->id)}}">
                        @csrf


                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <input type="text" value="{{$data->category_name}}" class="form-control" id="straat" name="category_name" required>
                        </div>
                        @error('category_name')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Category title</label>
                            <input type="text" value="{{$data->category_title}}" class="form-control"  name="category_title" required>

                        </div>
                        @error('category_title')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror

                        <div class="form-group">
                            <label for="description">Short Description</label>
                            <textarea  class="form-control"  name="short_description" required>{{$data->short_description}}</textarea>
                        </div>

                        @error('short_description')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Images</label>
                            <input type="file"  class="form-control"  name="images" >
                        </div>

                        @error('images')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" value="{{$data->slug}}" class="form-control"  name="slug" required>

                        </div>


                        <div class="form-group">
                            <label for="seo_keywords">Seo Keyword</label>
                            <textarea  class="form-control"  name="seo_keywords">{{$data->seo_keywords}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="seo_meta">Seo Meta</label>
                            <textarea  class="form-control"  name="seo_meta">
                                {{$data->seo_meta}}
                            </textarea>
                        </div>

                        <button class="btn btn-md btn-primary m-2">Update</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection

