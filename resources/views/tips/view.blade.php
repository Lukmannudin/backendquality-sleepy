@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Tips
      </h1><span class="text-lowercase">Semua tips di database</span>
      <ol class="breadcrumb">
        <li><a href="home">Admin</a></li>
        <li><a href="tips" class="text-capitalize">Tips</a></li>
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
                    <a href="tips/create"><button style='margin-top: 0.3cm; margin-bottom: 0.3cm;' class="btn btn-primary btn-md">+ Tambah Tips</button></a>
                </div>
                <table class="table table-responsive">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <!-- <th>Konten</th> -->
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                    <!-- 
                    1       1       
                    11      2
                    21      3
                    31      4
                    41      5
                    51      6


                    11*1 = 11-10 =1
                    11*2 = 22-11 =11
                    11*3 = 33-12 =21
                    11*4 = 44-13 =31
                    11*5 = 55-14 =41 -->

                    <?php 
                        if(!$page){
                            $page=1;
                        }
                        $no=(11*$page)-(9+$page); 
                    ?>
                    
                    @foreach ($tips as $data)
                    <tr>
                        <td>{{ $no++}}</td>
                        <td>{{ $data->tanggal}}</td>
                        <td>{{ $data->judul}}</td>
                        <!-- <td>{!! substr($data->isi, 0, 97)!!} ...</td> -->
                        <td>{{ $data->kategori }}</td>
                        <td><a href="tips/detail/{!! $data->id !!}"><button class="btn btn-space btn-info btn-sm">Lihat</button></a>
                        <a href="tips/edit/{!! $data->id !!}"><button class="btn btn-space btn-success btn-sm">Edit</button></a>
                        <a href="tips/delete/{!! $data->id !!}" onclick="return confirmFunct()"><button class="btn btn-space btn-danger btn-sm">Hapus</button></a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <center>{{ $tips->links() }}</center>
    </div>
    <script>
        function confirmFunct() {         
            return confirm("Anda yakin ingin menghapus data tips ini ?");
        }
    </script>
@endsection