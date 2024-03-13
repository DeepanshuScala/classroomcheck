<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GrocerPod | Forgot Password</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('admin/css/all.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-orange">
                <div class="card-header text-center">
                    <a class="h1"><b>Grocers</b>Pod</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                    @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ Session::get('error') }}
                    </div>
                    @endif
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    <form action="" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <select name="role" id="role" class="form-control" required="">
                                <option value="" disabled="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="shopper">Shopper</option>
                                <option value="associate">Associate</option>
                                <option value="supervisor">Supervisor</option>

                            </select>
                        </div>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email" name="email" id="email" required="">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-block bg-orange border-warning" style="color:white !important">Request new password</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a class="text-warning" href="{{ URL('login') }}">Login</a>
                    </p>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('admin/js/adminlte.min.js') }}"></script>
    </body>
</html>
