@extends('Admin')

@section('content')
 <div class="container">
     <div class="row justify-content-center mt-5">
         <div class="col-md-8">
             <section class="content">
                 <div class="container-fluid">
                     <div class="row">
                         <!-- left column -->
                         <div class="col-md-12">
                             <!-- jquery validation -->
                             <div class="card card-primary">
                                 <div class="card-header">
                                     <h3 class="card-title">Meldingen Admin </h3>
                                 </div>
                                 <!-- /.card-header -->
                                 <!-- form start -->
                                 <form action="{{route('login')}}" method="post" id="quickForm">

                                     @if ($errors->any())
                                         <div class="alert alert-danger">
                                             <ul>
                                                 @foreach ($errors->all() as $error)
                                                     <li>{{ $error }}</li>
                                                 @endforeach
                                             </ul>
                                         </div>
                                     @endif

                                     @csrf
                                     <div class="card-body">
                                         <div class="form-group">
                                             <label for="exampleInputEmail1">Email address</label>
                                             <input type="email" autocomplete="off" value="" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required>

                                         </div>
                                         <div class="form-group">
                                             <label for="exampleInputPassword1">Password</label>
                                             <input type="password" autocomplete="off" value="" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                                         </div>

                                     </div>
                                     <!-- /.card-body -->
                                     <div class="card-footer">
                                         <button type="submit" class="btn btn-primary">Submit</button>
                                     </div>
                                 </form>
                             </div>
                             <!-- /.card -->
                         </div>
                         <!--/.col (left) -->
                         <!-- right column -->
                         <div class="col-md-6">

                         </div>
                         <!--/.col (right) -->
                     </div>
                     <!-- /.row -->
                 </div><!-- /.container-fluid -->
             </section>
         </div>
     </div>
 </div>
@endsection
