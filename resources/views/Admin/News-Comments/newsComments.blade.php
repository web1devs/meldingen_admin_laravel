@extends('Admin')

@section('title')
    <title>Comments</title>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Comments <a href="/user/create"><i style="font-size: 25px" class="fa fa-plus m-1"></i></a> </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/meldingen">Home</a></li>
                            <li class="breadcrumb-item active">Comments</li>
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
                                    <h3 class="card-title">Comments</h3>


                                </div>


                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">

                                    <thead>
                                    <tr>
                                        <th>All <input type="checkbox" id="allcheck"><br/><br>
                                            <button class="btn btn-primary btn-sm" title="Approve selected records" id="approve_record"><i class="fa fa-check"></i></button> &nbsp;&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Delete selected records" id="delete_record"><i class="fa fa-trash"></i></button>
                                        </th>
                                        <th>Id</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Action</th>



                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Id</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Action</th>

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



        function checkcheckbox(){

            // Total checkboxes
            var length = $('.delete_check').length;

            // Total checked checkboxes
            var totalchecked = 0;
            $('.delete_check').each(function(){
                if($(this).is(':checked')){
                    totalchecked+=1;
                }
            });

            // Checked unchecked checkbox
            if(totalchecked == length){
                $("#allcheck").prop('checked', true);
            }else{
                $('#allcheck').prop('checked', false);
            }
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var dataTable = $('#example2').DataTable({
                rowReorder: true,
                columnDefs: [
                    { orderable: true, className: 'reorder', targets: 1 },
                    { orderable: false, targets: '_all' }
                ],
                order: [[1, 'desc']],
                processing: true,
                serverSide: true,
                ajax: '/comments-data',
            });

            // Check all
            $('#allcheck').click(function(){
                if($(this).is(':checked')){
                    $('.delete_check').prop('checked', true);
                }else{
                    $('.delete_check').prop('checked', false);
                }
            });

            // Approve record
            $('#approve_record').click(function(){

                var deleteids_arr = [];
                // Read all checked checkboxes
                $("input:checkbox[class=delete_check]:checked").each(function () {
                    deleteids_arr.push($(this).val());
                });

                // Check checkbox checked or not
                if(deleteids_arr.length > 0){

                    // Confirm alert
                    var confirmdelete = confirm("Do you really want to Approve records?");
                    if (confirmdelete == true) {
                        $.ajax({
                            url: '/comments/bulk-approve',
                            type: 'post',
                            data: {deleteids_arr: deleteids_arr},
                            success: function(response){
                                dataTable.ajax.reload();
                            }
                        });
                    }
                }
            });

            $('#delete_record').click(function(){

                var deleteids_arr = [];
                // Read all checked checkboxes
                $("input:checkbox[class=delete_check]:checked").each(function () {
                    deleteids_arr.push($(this).val());
                });

                // Check checkbox checked or not
                if(deleteids_arr.length > 0){

                    // Confirm alert
                    var confirmdelete = confirm("Do you really want to Delete records?");
                    if (confirmdelete == true) {
                        $.ajax({
                            url: '/comments/bulk-delete',
                            type: 'post',
                            data: {deleteids_arr: deleteids_arr},
                            success: function(response){
                                dataTable.ajax.reload();
                            }
                        });
                    }
                }
            });
        });

    </script>


@endsection



