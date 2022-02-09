@extends('layouts.base')
@section('title', 'Update Event')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Update File</h4></div>
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
                                    <div>
                                        <h4><b>Materi : {{$model['materi']->id}}. {{$model['materi']->title}}</b></h4>
                                    </div>
                                    <div class="separator-solid"></div>
                                    <input type="hidden" id="id_materials" name="id_materials" value={{$model['materi']->id}}>
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Judul File <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Judul File" value="{{$model['data']->title}}" required>
                                    </div>
                                    
                                    <div class="form-group form-show-validation row">
                                        <div>
                                            <label for="file">Upload File</label>
                                            <a class="btn btn-primary ml-2 mb-2" href="/material/file/{{$model['data']->file}}" role="button" id="file_existing" name="file_existing">Download File Lama</a>
                                        </div>
                                        <input class="form-control" type="file" accept=".pdf" id="new_file" name="new_file">
                                        Jika ingin mengganti file silahkan upload yang baru, jika tidak kosongkan saja.
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
                                <a href="/admin/material/{{$model['materi']->id}}"><button type="button" class="btn btn-warning">Kembali</button></a>
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
