@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Artikel
      </h1><span class="text-lowercase">Semua artikel di database</span>
      <ol class="breadcrumb">
        <li><a href="home">Admin</a></li>
        <li><a href="artikel" class="text-capitalize">Artikel</a></li>
        <li class="active">List</li>
      </ol>
    </section>
    <style type="text/css">
        .btn-space {
            margin-right: 3px;
            margin-bottom: 3px;
        }
    </style>

@endsection


@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <div class="row">
        <div class="col-md-12">
            <div class="box body">
                <div class="col-md-2 col-sm-2">
                    <a href="artikel/create"><button style='margin-top: 0.3cm; margin-bottom: 0.4cm' class="btn btn-primary btn-md">+ Tambah Artikel</button></a>
                </div>
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Konten</th>
                        <th>Aksi</th>
                    </tr>
                    <?php 
                        if(!$page){
                            $page=1;
                        }
                        $no=(11*$page)-(9+$page); 
                    ?>
                    @foreach ($artikel as $data)
                    <tr>
                        <td>{{ $no++}}</td>
                        <td>{{ $data->tanggal}}</td>
                        <td>{{ $data->judul}}</td>
                        <td>{{ substr($data->isi, 0, 97)}} ...</td>
                        <td><a href="artikel/detail/{!! $data->id !!}"><button class="btn btn-space btn-info btn-sm">Lihat</button></a>
                        <a href="artikel/edit/{!! $data->id !!}"><button class="btn btn-space btn-success btn-sm">Edit</button></a>
                        <a href="artikel/delete/{!! $data->id !!}" onclick="return confirmFunct()"><button class="btn btn-space btn-danger btn-sm"><i class="fa fa-remove"></i><span class="title">Hapus</span></button></a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <center>{{ $artikel->links() }}</center>
    </div>
    <script>
        function confirmFunct() {         
            return confirm("Anda yakin ingin menghapus data artikel ini ?");
        }
    </script>
@endsection