@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Rincian Artikel
      </h1><span class="text-lowercase">Rincian atau deskripsi dari artikel</span>
      <ol class="breadcrumb">
        <li><a href="../../home">Admin</a></li>
        <li><a href="../../artikel" class="text-capitalize">Artikel</a></li>
        <li class="active">Rincian</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box body">
                <h1 align="center">
                    {{ $artikel->judul }}
                </h1>
                <center><span text-lowercase> {{ $artikel->tanggal }}</span></center>
                <hr>
                    <center><img style='width:400px; height:250px;' src="{{ URL::to('/') }}/uploads/images/{{ $artikel->gambar }}"></center>
                    <p style='margin-left: 0.3cm; margin-right: 0.3cm; margin-top: 0.3cm; margin-bottom: 0.3cm;'>
                        
                        {!! $artikel->isi !!}
                    </p>
            </div>
        </div>
    </div>
@endsection