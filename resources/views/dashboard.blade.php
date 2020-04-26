@extends('backpack::layout')
@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/admin/home">Sleepy</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style type="text/css">
      .w3-container{
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
      }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <!-- <div class="box-header with-border">
                    <div class="box-title">{{ trans('backpack::base.login_status') }}</div>
                </div>

                <div class="box-body">{{ trans('backpack::base.logged_in') }}</div> -->
                <p>
                <div class="w3-container">  
                  <div class="w3-card-4" style="width:40%;">
                    <header class="w3-container w3-indigo">
                      <h1>Artikel</h1>
                    </header>

                    <div class="w3-container">
                      <p>Informasi mengenai tidur berupa Artikel yang tersedia pada sistem adalah artikel yang dikelola dari berbagai sumber terpercaya untuk menjaga kepercayaan pengguna aplikasi Sleepy.</p>
                    </div>
                    <div class="w3-section"><br>
                      <center><a href="/admin/artikel"><button class="w3-button w3-green">Lihat</button></a></center>
                    </div>
                    <footer class="w3-container w3-indigo">
                      <center><b>Total Artikel</b> <h3><b>{{ $dashboard['totalArtikel'] }}</b></h3></center>
                    </footer>
                  </div>

                  <div class="w3-card-4" style="width:40%;">
                    <header class="w3-container w3-indigo">
                      <h1>Tips</h1>
                    </header>

                    <div class="w3-container">
                      <p>Tips mengenai tidur untuk meningkatkan kualitas tidur pengguna Aplikasi diperoleh dari berbagai sumber yang terpercaya dan menyesuaikan dengan kategori tips yang dibutuhkan untuk meningkatkan kualitas tidurnya.</p>
                    </div>
                    <div class="w3-section">
                      <center><a href="/admin/tips"><button class="w3-button w3-green">Lihat</button></a></center>
                    </div>
                    <footer class="w3-container w3-indigo">
                      <center><b>Total Tips</b> <h3><b>{{ $dashboard['totalTips'] }}</b></h3></center>
                    </footer>
                  </div>

                </div>
                
                </p>

            </div>
        </div>
    </div>
@endsection