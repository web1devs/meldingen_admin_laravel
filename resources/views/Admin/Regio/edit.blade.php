@extends('Admin')

@section('title')
    <title>Edit Regio</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Regio Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/regio">Regio</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="post" action="{{url('/regio/update/'.$data->id)}}">
                        @csrf


                        <div class="form-group">
                            <label for="exampleInputEmail1">Regio</label>
                            <input type="text" value="{{$data->regio}}" class="form-control" id="straat" name="regio">

                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Regio Url</label>
                            <input type="text" value="{{$data->regio_url}}" class="form-control"  name="regio_url">

                        </div>





                        <div class="form-group">
                            <label for="description">Provincie</label>
                            <select  class="form-control"  name="provincie">
                                @foreach($provincies as $item)
                                    <option value="{{$item->id}}"
                                        {{$item->id === $data->provincie ? 'selected':''}}
                                    >{{$item->provincie}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Seo Keyword</label>
                            <textarea  class="form-control"  name="seo_keywords">{{$data->seo_keywords}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Seo Meta</label>
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

