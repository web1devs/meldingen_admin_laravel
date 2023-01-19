@extends('Admin')

@section('title')
    <title>Seo Data</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Seo Data </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active">SEO Data</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (session('status'))
                            <div class="container-fluid px-4">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Congratulations!</strong>  {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <h3 class="card-title">SEO Data</h3>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edit SEO Data
                                        </button>

                                        @php

                                            $pages = \Illuminate\Support\Facades\DB::table('seo_data_tables')->select('page')->get();
                                        @endphp

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            @foreach($pages as $page)
                                            <a class="dropdown-item" href="{{url('/seo-data/edit/'.$page->page)}}">{{$page->page}}</a>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">

                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Page</th>
                                        <th>SEO keywords</th>
                                        <th>SEO Meta</th>


                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Page</th>
                                        <th>SEO keywords</th>
                                        <th>SEO Meta</th>

                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <script src="//code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(function () {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": '/fetch-seo-data'
            });
        });
    </script>


@endsection

