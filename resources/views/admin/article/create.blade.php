@extends('layouts.base')
@section('title', 'Tambah Artikel')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Tambah Artikel</h4></div>
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
                        <form id="form_validation" action="{{$model['base_url']}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label >Gambar <span class="required-label">*</span></label>
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview" width="300">
                                            <input type="file" class="form-control form-control-file" id="image" name="image" accept="image/*" >
                                            <label for="image" class="btn btn-primary bg-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Ganti Gambar</label>
                                        </div>
                                    </div>
                                    <div class="separator-solid"></div>
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Judul Article <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Judul Article" required>
                                    </div>
                                    <div class="">
                                        <label for="content" >Content <span class="required-label">*</span></label>
                                        <div>
                                            <textarea id="summernote" name="content" placeholder="Masukan Content" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="parent_header">Tipe <span class="required-label">*</span></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="1">Text</option>
                                            <option value="2">PDF</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-show-validation row" id="type_value_wrapper" style="display: none">
                                        <label >File PDF <span class="required-label">*</span></label>
                                        <input type="file" class="form-control" id="type_value" name="type_value" accept="application/pdf"/>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="parent_header">Status <span class="required-label">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Simpan</button>
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
            if (this.value == 2) {
                $('#type_value_wrapper').show();
            } else {
                $('#type_value_wrapper').hide();
            }
        });
    });
</script>
@endsection
