@extends('layouts.base')
@section('title', 'Update Article')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Update Article</h4></div>
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
                                        <label >Gambar <span class="required-label">*</span></label>
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview" src="/article/{{$model['data']->image}}" width="300">
                                            <input type="file" class="form-control form-control-file" id="image" name="image" accept="image/*" >
                                            <label for="image" class="btn btn-primary bg-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Ganti Gambar</label>
                                        </div>
                                    </div>
                                    <div class="separator-solid"></div>
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Judul Article <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Judul Article" value="{{$model['data']->title}}" required>
                                    </div>
                                    <div class="">
                                        <label for="content" >Content <span class="required-label">*</span></label>
                                        <div>
                                            <textarea id="summernote" name="content" placeholder="Masukan Content" required>{{$model['data']->content}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="parent_header">Tipe <span class="required-label">*</span></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="1" @if($model['data']->type == '1') selected @endif >Text</option>
                                            <option value="2" @if($model['data']->type == '2') selected @endif>PDF</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-show-validation row" id="type_value_wrapper" @if($model['data']->type == 1) style="display: none" @endif>
                                        <label ><span>File PDF <span class="required-label">*</span></label>
                                        <a href="/article_pdf/{{$model['data']->type_value}}" target="blank">
                                            <div class="input-file input-file-image">
                                                <label class="btn btn-primary bg-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Download File</label>
                                            </div>
                                        </a>
                                        <input type="file" class="form-control" id="type_value" name="type_value" accept="application/pdf"/>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="parent_header">Status <span class="required-label">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" @if($model['data']->status == '1') selected @endif >Aktif</option>
                                            <option value="0" @if($model['data']->status == '0') selected @endif>Tidak Aktif</option>
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
            if (this.value == 2) {
                $('#type_value_wrapper').show();
            } else {
                $('#type_value_wrapper').hide();
            }
        });
    });
</script>
@endsection
