@extends('Admin')

@section('title')
    <title>Edit Blog</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Blog Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/blogs">Blog</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="POST" enctype="multipart/form-data" action="{{'/blog/update/'.$data->id}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input autocomplete="off" id="title" value="{{$data->blog_title}}" name="title" class="form-control" required>
                                    @error('title')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Short Description</label>
                                    <textarea id="short_description" name="short_description" class="form-control" rows="8" required>{{stripslashes($data->description)}}</textarea>
                                    @error('description')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea id="description" name="blog_content" required >
                                        {{stripslashes($data->content)}}

                                  </textarea>
                                    @error('blog_content')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>






                                <div class="mb-3">
                                    <label for="image" class="form-label">Image upload</label>
                                    <input type="file" name="images" class="form-control" >
                                    @error('images')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">slug</label>
                                    <input autocomplete="off" id="title" value="{{$data->slug}}" name="slugs" class="form-control" required>
                                    @error('title')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">SEO Keyword</label>
                                    <textarea id="image" name="seo_keyword" class="form-control">{{$data->seo_keywords}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">SEO Meta Description</label>
                                    <textarea id="image" name="seo_meta" value="{{$data->seo_meta}}" class="form-control" >{{$data->seo_meta}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="stad_regio" class="form-label">Status</label>
                                    <select name="status" id="stad_regio" class="form-control" required="">
                                        <option value="published"{{$data->status === 'published' ? 'selected' : ''}}>Published</option>
                                        <option value="unpublished" {{$data->status === 'unpublished' ? 'selected' : ''}} >Unpublished</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5 class="mt-2">Categories</h5>
                                @foreach ($categories as $item)
                                    <div class="form-check">
                                        @php
                                            $separated_category = explode(',',$data->categories);
                                        @endphp

                                        <input class="form-check-input" type="checkbox" name="category[]" data-name="'s Gravenmoer" value="{{$item->id}}" id="{{$item->id}}"  {{in_array($item->id,$separated_category) ? 'checked' : ''}} >
                                        <label class="form-check-label" for="{{$item->id}}">
                                            {{$item->category_name}}
                                        </label> <br>


                                    </div>
                                @endforeach
                                @error('category')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>


                        </div>

                        <button type="submit" class="btn btn-primary">update</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection


