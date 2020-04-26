


@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Artikel
      </h1><span class="text-lowercase">Buat artikel baru</span>
      <ol class="breadcrumb">
        <li><a href="/admin/home">Admin</a></li>
        <li><a href="/admin/artikel" class="text-capitalize">Artikel</a></li>
        <li class="active">New</li>
      </ol>
    </section>
    <script type="text/javascript">
                        function stoppedTyping(){
                            var judulvalue = document.getElementById('judul').value;
                            var kontenvalue =  $('#isi').summernote('code');
                            if(judulvalue.length > 0 && kontenvalue.length > 0 ) { 
                                document.getElementById('publish').disabled = false; 
                            } else { 
                                document.getElementById('publish').disabled = true;
                            }
                        }


        function ValidateFileUpload() {
                var fuData = document.getElementById('gambar');
                var FileUploadPath = fuData.value;

                //To check if user upload any file
              
                    var Extension = FileUploadPath.substring(
                            FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

                //The file uploaded is an image

                if (Extension == "gif" || Extension == "png" || Extension == "bmp"
                                    || Extension == "jpeg" || Extension == "jpg") {

                // To Display
                                if (fuData.files && fuData.files[0]) {
                                    var reader = new FileReader();

                                    reader.onload = function(e) {
                                        $('#blah').attr('src', e.target.result);
                                    }

                                    reader.readAsDataURL(fuData.files[0]);
                                }

                            }

                //The file upload is NOT an image
                else {
                                alert("Format file yang Anda upload tidak sesuai. Silahkan masukkan file gambar untuk Artikel ini dengan format GIF, PNG, JPG, JPEG atau BMP!");

                                var reader = new FileReader();

                                    reader.onload = function(e) {
                                        $('#blah').attr('src', '{{ URL::to('/') }}/image/noimagefound.jpg');
                                    }

                                    reader.readAsDataURL(fuData.files[0]);
                            }
                        
            }
    </script>
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
                
                <div class="form-group">
                
                {{Form::open(['url' => '/admin/artikel/create/post','enctype' => 'multipart/form-data'])}}
                {{csrf_field()}}
                <div class="box-body">
                <div class="form-group">
                    {{Form::label('judul', 'Judul')}}
                    {{Form::text('judul',null,array('class' => 'form-control', 'placeholder'=>'Judul Artikel', 'id' => 'judul', 'onkeyup'=>'stoppedTyping()'))}}
                    <!-- <input class="form-control" name="judul" id="judul" type="text" placeholder="Judul Artikel"onkeyup="stoppedTyping()"> -->
                </div>
                <div class="form-group">
                    {{Form::label('gambar','Gambar Artikel')}}
                    {{Form::file('gambar', array('id'=>'gambar', 'class' => 'image', 'onchange'=>'return ValidateFileUpload()')) }}
                    <img src="{{ URL::to('/') }}/image/noimagefound.jpg" height="140px" width="140px" id="blah">
                </div>
                <div class="form-group">
                    {{Form::label('body', 'Konten')}}
                    {{Form::textarea('isi',null,array('class' => 'form-control', 'placeholder'=>'Isi Konten Artikel', 'id' => 'isi', 'onkeyup'=>'stoppedTyping()'))}}
                    <!-- <input class="form-control" name="isi" id="isi" type="textarea" placeholder="Isi Konten" onkeyup="stoppedTyping()"> -->
                </div>

                <div class="form-group">
                    {{Form::label('sumber', 'Sumber')}}
                    {{Form::text('sumber',null,array('class' => 'form-control', 'placeholder'=>'Sumber Artikel'))}}
                </div>
                    <!-- {{Form::submit('Publikasi Artikel',array('class' => 'btn btn-primary btn-sm'))}}  -->
                    <input id="publish" class="btn btn-primary btn-sm" type="submit" name="publish" value="Publikasi Artikel" disabled="true">
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

@endsection
</html>