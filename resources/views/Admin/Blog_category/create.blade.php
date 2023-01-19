@extends('Admin')

@section('title')
    <title>Create Blog Category</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Blog Category Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/blog-category">Blog Category</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="post" enctype="multipart/form-data" action="{{url('/store/Blog-category')}}">
                        @csrf


                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <input type="text" value="" class="form-control" id="straat" name="category_name" required>
                        </div>
                        @error('category_name')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Category title</label>
                            <input type="text" value="" class="form-control"  name="category_title" required>

                        </div>
                        @error('category_title')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror

                        <div class="form-group">
                            <label for="description">Short Description</label>
                            <textarea  class="form-control"  name="short_description" required></textarea>
                        </div>

                        @error('short_description')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail1">Images</label>
                            <input type="file"  class="form-control"  name="images" required>
                        </div>

                        @error('images')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror


                        <div class="form-group">
                            <label for="description">Seo Keyword</label>
                            <textarea  class="form-control"  name="seo_keywords"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Seo Meta</label>
                            <textarea  class="form-control"  name="seo_meta">
                            </textarea>
                        </div>

                        <button class="btn btn-md btn-primary m-2">Create</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection

