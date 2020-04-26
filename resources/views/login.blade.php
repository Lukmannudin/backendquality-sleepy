
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('adminlte/') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('adminlte/') }}/dist/css/AdminLTE.min.css">
    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="{{ asset('backpack/backpack.base.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <title>Sleepy - Login</title>
    <style>
            html, body {
                background-color: #102055;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                margin: 0;
                height: 100%;
            }
            h1 {
                color: white;
            }
    </style>
    <script type="text/javascript">
                        function stoppedTyping(){
                            var emailvalue = document.getElementById('email').value;
                            var passvalue = document.getElementById('password').value;
                            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                            if(emailvalue.length > 0 && passvalue.length > 0 && (reg.test(emailvalue))) { 
                                document.getElementById('login').disabled = false; 
                            } else { 
                                document.getElementById('login').disabled = true;
                            }
                        }
                    </script>
</head>
<body>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <center><h1>Sleepy</h1>
            <img src="{{ asset('uploads/logodiamondsleep.png') }}" style="width:230">
            </center>
        </div>

    </div>
    <br/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">
                        <div class="panel-heading"><span class="glyphicon glyphicon-user">
                        </span> Login
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <p>@if(Session::has('message'))
                            <span class="label label-danger"> {{Session::get('message') }}</span>
                    @endif
                    </p>
                    {!! Form::open(['url' => '/admin']) !!}
                    Email: @if (isset($errors) && $errors->has(''))
                    <br/>
                    <span class="label label-danger">{!! $errors->first('email') !!}</span>
                    <p></p>
                    @endif
                    <!--{!! Form::text('email', '',['placeholder' => 'Email Admin','class' => 'form-control', 'onkeyup'=>'stoppedTyping()']) !!}-->
                    <input class="form-control" name="email" id="email" type="text" placeholder="Email  Admin"onkeyup="stoppedTyping()">
                    Password: @if (isset($errors) && $errors->has(''))
                    <br/>
                    <span class="label label-danger">{!! $errors->first('password') !!}</span>
                    <p></p>
                    @endif
                    <!--{!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password Admin', 'onkeyup'=>'stoppedTyping()')) !!}-->
                    <input class="form-control" name="password" id="password" type="password" placeholder="Password Admin" onkeyup="stoppedTyping()">
                    <p></p>
                    <input id="login" class="btn btn-success" type="submit" name="login" value="Login" disabled="true">
                    <!--{!! Form::submit('Login',['class' => 'btn btn-success']) !!}-->
                    
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    
</body>
    