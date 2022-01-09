@extends('layouts.base')
@section('title', 'Update Materi')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Update Materi</h4></div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <div class="col-12 col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{$model['base_url']}}{{$model['data']->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label for="category">Kategori <span class="required-label">*</span></label>
                                        <select class="form-control" id="category" name="id_category" required>
                                            @foreach ($model['category'] as $category)
                                            <option @if($model['data']->id_category == $category->id) selected @endif  value={{$category->id}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="tipe">Tipe Materi <span class="required-label">*</span></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option @if($model['data']->type == "default") selected @endif value="default">Standar</option>
                                            <option @if($model['data']->type == "video") selected @endif value="video">Video</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-show-validation row" id="input_image">
                                        <label >Gambar <span class="required-label">*</span></label>
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview" @if($model['data']->image) src="/material/{{$model['data']->image}}" @endif width="300">
                                            <input type="file" class="form-control form-control-file" id="image" name="image" accept="image/*" >
                                            <label for="image" class="btn btn-primary bg-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Ganti Gambar</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-show-validation row" id="input_link_yt"
                                        style="display: none">
                                        <label for="link_yt">Link Video YouTube <span
                                                class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="link_yt" name="link_yt" value="{{$model['data']->link_yt}}"
                                            placeholder="Masukan Link Video YouTube">
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Judul Event <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Judul Event" value="{{$model['data']->title}}" required>
                                    </div>
                                    <div class="">
                                        <label for="description" ><b>Deskripsi Event </b><span class="required-label">*</span></label>
                                        <div>
                                            <textarea id="summernote" name="description" placeholder="Masukan description" required>{{$model['data']->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="" id="input_locked">
                                        <div class="form-group form-show-validation row" id="input_is_locked">
                                            <label for="is_locked">Pengamanan <span class="required-label">*</span></label>
                                            <select class="form-control" id="is_locked" name="is_locked">
                                                <option value="1" @if($model['data']->is_locked == '1') selected @endif >Terkunci</option>
                                                <option value="0" @if($model['data']->is_locked == '0') selected @endif >Tidak Terkunci</option>
                                            </select>
                                        </div>
                                        <div class="form-group form-show-validation row" id="input_download_pass">
                                            <label for="download_pass">Download Password <span
                                                    class="required-label">*</span></label>
                                            <input type="text" class="form-control" id="download_pass" name="download_pass"
                                                placeholder="Masukan Password Baru (jika tidak ingin mengubah password kosongkan saja).">
                                            Pastikan anda mengingat password yang dimasukan.
                                        </div>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="status">Status <span class="required-label">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" @if($model['data']->status == '1') selected @endif >Aktif</option>
                                            <option value="0" @if($model['data']->status == '0') selected @endif >Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{$model['base_url']}}"><button type="button" class="btn btn-warning">Kembali</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@section('js')
<script>

    var formId = '#form_validation';
    var rulesForm = {
        image: {
            required: true,
        }
    };

    $(document).ready(function() {
        initFormValidation(formId, rulesForm);
        $('#summernote').summernote({
			fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
			tabsize: 2,
			height: 300
		});
        $('#type').on('change', function() {
            if (this.value == 'video') {
                $('#input_link_yt').show();
                $('#input_image').hide();
                $('#input_locked').hide();
            } else {
                $('#input_link_yt').hide();
                $('#input_image').show();
                $('#input_locked').show();
            }
        }).trigger('change');

        $('#is_locked').on('change', function() {
            if (this.value == 0) {
                $('#input_download_pass').hide();
            } else {
                $('#input_download_pass').show();
            }
        }).trigger('change');
    });
</script>
@endsection
