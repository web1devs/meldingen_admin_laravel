@extends('Admin')

@section('title')
    <title>Edit Meldingen</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Meldingen</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/meldingen">meldingen</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

                <div class="row">
                    <div class="col-md-8 float-left">
                        <form method="post" action="{{url('/meldingen/update/'.$data->id)}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">P2000</label>
                                <textarea id="description" name="description">

                                    {{$data->p2000}}
                                </textarea>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Straat</label>
                                <input type="text" value="{{$data->straat}}" class="form-control" id="straat" name="straat">

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Straat Url</label>
                                <input type="text" value="{{$data->straat_url}}" class="form-control" id="description" name="straat_url">

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">lat</label>
                                <input type="text" value="{{$data->lat}}" class="form-control" id="description" name="lat">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">lng</label>
                                <input type="text" value="{{$data->lng}}" class="form-control" id="description" name="lng">

                            </div>
                            <div class="form-group">
                                <label for="description">Priority</label>
                                <input type="text" value="{{$data->prio}}" class="form-control" id="description" name="prio">
                            </div>
                            <div class="form-group">
                                <label for="description">Dienst</label>
                                <select  class="form-control" id="description" name="dienst">
                                    @foreach($diensts as $dienst)
                                        <option value="{{$dienst->id}}" {{$dienst->id === $data->dienst ? 'selected':''}}>{{$dienst->dienst}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Category</label>
                                <select  class="form-control" id="description" name="category">

                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id === $data->categorie ? 'selected':''}}>{{$category->categorie}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Provincie</label>
                                <select  class="form-control" id="description" name="provincie">
                                    @foreach($provincies as $item)
                                    <option value="{{$item->id}}"
                                        {{$item->id === $data->provincie ? 'selected':''}}
                                    >{{$item->provincie}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Regio</label>
                                <select  class="form-control" id="description" name="regio">

                                    @foreach($regios as $regio)
                                    <option value="{{$regio->id}}" {{$regio->id === $data->regio ? 'selected':''}}>{{$regio->regio}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Stad</label>
                                <select  class="form-control" id="description" name="stad">
                                    @foreach($stads as $stad)
                                    <option value="{{$stad->id}}" {{$stad->id === $data->stad ? 'selected':''}}>{{$stad->stad}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description">Seo Keyword</label>
                                <textarea  class="form-control" id="description" name="seo_keywords">


                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Seo Meta</label>
                                <textarea  class="form-control" id="description" name="seo_meta">


                                </textarea>
                            </div>

                            <button class="btn btn-md btn-primary m-2">Update</button>
                        </form>
                    </div>

            </div>

        </section>
    </div>



@endsection
