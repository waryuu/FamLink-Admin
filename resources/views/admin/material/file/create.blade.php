@extends('layouts.base')
@section('title', 'Update Event')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Tambah File Baru</h4></div>
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
                        <form action="/admin/material/{{$model['materials']->id}}/create" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <div>
                                        <h4><b>Materi : {{$model['materials']->id}}. {{$model['materials']->title}}</b></h4>
                                    </div>
                                    <div class="separator-solid"></div>
                                    <input type="hidden" id="id_materials" name="id_materials" value={{$model['materials']->id}}>
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Judul File <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Judul File" required>
                                    </div>
                                    
                                    <div class="form-group form-show-validation row">
                                        <div>
                                            <label for="file">Upload File <span class="required-label">*</span></label>
                                        </div>
                                        <input class="form-control" type="file" accept=".pdf" id="new_file" name="new_file">
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="status">Status <span class="required-label">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" >Aktif</option>
                                            <option value="0" >Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="/admin/material/{{$model['materials']->id}}"><button type="button" class="btn btn-warning">Kembali</button></a>
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
