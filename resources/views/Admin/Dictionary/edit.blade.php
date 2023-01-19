@extends('Admin')

@section('title')
    <title>Edit Dictionary Data</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1>Dictionary Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/dictionary">Dictionary</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-8 float-left">
                    <form method="POST" enctype="multipart/form-data" action="{{url('/dictionary/update/'.$data->id)}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Main Word</label>
                                    <input autocomplete="off" id="main_word" value="{{$data->main_word}}" name="main_word" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Synonyms (Comma separated value ) </label>
                                    <textarea id=""  name="synonyms" class="form-control" rows="8" required> {{stripslashes($data->synonyms)}} </textarea>
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

