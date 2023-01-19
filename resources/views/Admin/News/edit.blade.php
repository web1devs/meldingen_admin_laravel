@extends('Admin')

@section('title')
    <title>Edit Nieuws</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Nieuws Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/nieuws">Nieuws</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="POST" enctype="multipart/form-data" action="{{url('/nieuws/update/'.$data->id)}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input autocomplete="off" id="title" value="{{stripslashes($data->title)}}" name="title" class="form-control" required>
                                    @error('title')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="post_url" class="form-label">Nieuws source url</label>
                                    <input autocomplete="off" id="post_url" name="post_url" value="{{$data->post_url}}" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="content" name="description" class="form-control" rows="8" required>{{stripslashes($data->description)}}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea id="description" name="story" required >
                                        {{stripslashes($data->content)}}
                                  </textarea>

                                </div>

                                <div class="mb-3">
                                    <label for="postal" class="form-label">Postcode</label>
                                    <input id="postal" name="postal" value="{{$data->postal}}" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="staddress" class="form-label">Adres</label>
                                    <input id="staddress" name="staddress" value="{{$data->staddress}}" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="stad_regio" class="form-label">Stad</label>
                                    <select name="stad" id="stad_regio" class="form-control" required="">
                                        @foreach($stads as $item)
                                            <option value="{{$item->stad}}" {{$item->stad === $data->city ? 'selected':''}}>{{$item->stad}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="stad_regio" class="form-label">Provincie</label>
                                    <select name="provincie" id="stad_regio" class="form-control" required="">
                                        @foreach($provincies as $item)
                                            <option value="{{$item->provincie}}" {{$item->provincie === $data->state ? 'selected':''}} >{{$item->provincie}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="lat_" class="form-label">Lat</label>
                                    <input id="lat_" name="lat" value="{{$data->lat}}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lng_" class="form-label">Lng</label>
                                    <input id="lng_" name="lon" value="{{$data->lon}}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lng_" class="form-label">Tags</label>
                                    <input id="lng_" name="tags" value="{{$data->tags}}" class="form-control" >
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image url</label>
                                    <input id="image" name="image" value="{{$data->image}}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Seo Keyword</label>
                                    <textarea id="image" name="seo_keyword" class="form-control">{{$data->seo_keywords}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Seo Meta</label>
                                    <textarea id="image" name="seo_meta" class="form-control">{{$data->seo_meta}} </textarea>
                                </div>

                            </div>



                        </div>

                        <button type="submit" class="btn btn-primary mb-3">Update Nieuws</button>
                    </form>
                </div>

            </div>

        </section>
    </div>



@endsection

