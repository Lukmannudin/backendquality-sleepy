@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Tips
      </h1><span class="text-lowercase">Buat tips baru</span>
      <ol class="breadcrumb">
        <li><a href="/admin/home">Admin</a></li>
        <li><a href="/admin/tips" class="text-capitalize">Tips</a></li>
        <li class="active">Edit</li>
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
    <div class="row">
        <div class="col-md-12">
            <div class="box body">
                
                <div class="form-group">
                
                <form action="{{url('/admin/tips/edit')}}/{{$tips->id}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="box-body">
                <div class="form-group">
                    {{Form::label('judul', 'Judul')}}
                    {{Form::text('judul', $tips->judul,array('class' => 'form-control', 'placeholder'=>'Judul Tips', 'id' => 'judul', 'onkeyup'=>'stoppedTyping()'))}}
                </div>

                <div class="form-group">
                    {{Form::label('kategori','Kategori')}}
                    {{Form::select('kategori', array('Gangguan Tidur' => 'Gangguan Tidur',
                                                    'Durasi Tidur' => 'Durasi Tidur', 
                                                    'Latensi Tidur' => 'Latensi Tidur', 
                                                    'Efisiensi Kebiasaan Tidur' => 'Efisiensi Kebiasaan Tidur', 
                                                    'Penggunaan Obat' => 'Penggunaan Obat',
                                                    'Disfungsi Siang Hari' => 'Disfungsi Siang Hari'), $tips->kategori, array('class' => 'form-control')) 
                                                    }}
                </div>

                <div class="form-group">
                    {{Form::label('gambar','Gambar Tips')}}
                    {{Form::file('gambar', array('id' => 'gambar', 'class' => 'image', 'onchange'=>'return ValidateFileUpload()')) }}
                    <p class="help-block">{{$tips->gambar}}</p>
                </div>

                <div class="form-group">
                    {{Form::label('body', 'Konten')}}
                    {{Form::textarea('isi',$tips->isi,array('class' => 'form-control', 'placeholder'=>'Isi Konten Tips', 'id' => 'isi', 'onkeyup'=>'stoppedTyping()'))}}
                </div>

                <div class="form-group">
                    {{Form::label('sumber', 'Sumber')}}
                    {{Form::text('sumber',$tips->sumber,array('class' => 'form-control', 'placeholder'=>'Sumber Tips'))}}
                </div>
                    <!-- {{Form::submit('Update Tips',array('class' => 'btn btn-success btn-sm'))}}  -->
                    <input id="publish" class="btn btn-success btn-sm" type="submit" name="publish" value="Update Tips">
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
</html>