@extends('layouts.base')
@section('title', 'Master Assessment')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Master Assessment</h4>
        </div>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Add Row</h4>
                            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modal_add_form">
                                <i class="fa fa-plus"></i>
                                Tambah Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal fade" id="modal_add_form" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                New
                                            </span>
                                            <span class="fw-light">
                                                Data
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="form_validation" action="{{$model['base_url']}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="title" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Assessment <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Nama Assessment" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="description" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Deskripsi <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="description" name="description" placeholder="Masukan Deskripsi" required>
                                                    </div>
                                                </div>
                                                <div class="separator-solid"></div>
                                                <div class="form-group form-show-validation row">
                                                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Icon <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <div class="input-file input-file-image">
                                                            <img class="img-upload-preview img-circle" width="100" height="100" src="http://placehold.it/100x100" alt="preview">
                                                            <input type="file" class="form-control form-control-file" id="image" name="image" accept="image/*" required >
                                                            <label for="image" class="btn btn-primary bg-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Upload a Image</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" id="addRowButton" class="btn btn-primary">Add</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modal_edit_form" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                Update
                                            </span>
                                            <span class="fw-light">
                                                Data
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="edit_form_validation" action="/menu" method="POST">
                                        @csrf
                                        <input type="hidden" id="edit_binding_id" name="edit_binding_id" value="">
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Role <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Masukan Nama Role" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" id="modal_edit_btn_update" class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table_view" class="display table table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

    var base_endpoint = "{{$model['base_url']}}";
    var table_id = '#table_view';
    var table = null;
    var formId = '#form_validation';
    var formEditId = '#edit_form_validation';
    var modalEditButtonId = '#modal_edit_btn_update';

    var rulesForm = {
        image: {
            required: true,
        }
    };

    var rulesFormEdit = {
        image: {
            required: true,
        }
    };

    $(document).ready( function() {
        var columnsData = [
        { data: 'id', name: 'id', render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['id']+'</strong>';
        }},
        { data: 'image', name: 'image', render : function(data, type, row) {
            return '<img src="/menu/'+row['image']+'" width="100px"/>';
        }},
        { data: 'title', name: 'title',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['title']+'</strong>';
        }},
        { data: 'description', name: 'description',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['description']+'</strong>';
        }},
        { data: 'status', name: 'status',
        render : function(data, type, row) {
            if (row['status'] == 1) {
                return '<button class="btn btn-success">Aktif</button>';
            }else{
                return '<button class="btn btn-danger">Tidak Aktif</button>';
            }
        }},
        { data: 'id', name: 'id', render : function(data, type, row) {
            return '<div class="form-button-action"><a href="'+base_endpoint+row['id']+'"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Edit"><i class="fa fa-eye"></i></button></a><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert('+row['id']+')"><i class="fa fa-times"></i></button></div>';
        }}];
        var columns = createColumnsAny(columnsData) ;
        table = initDataTableLoad(table_id, base_endpoint+'create', columns, [[0, "asc"]]);
        initFormValidation(formId, rulesForm);
        initFormValidation(formEditId, rulesFormEdit);
        $(modalEditButtonId).click(function(e){
            setEditAction();
        });
    });

    function deleteAlert(id) {
        var body = {
            "id": id,
            "_token": token
        }
        showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!', base_endpoint+id, 'DELETE', body, table_id);
    }

    function editData(id){
        $.get(base_endpoint + id + '/edit', function (data) {
            $('#modal_edit_form').modal('show');
            $('#edit_binding_id').val(data.data.id);
            $('#edit_name').val(data.data.name);
        })
    }

    function setEditAction() {
        var valid = $(formEditId).valid();
        if (valid) {
            var id = $("#edit_binding_id").val();
            var name = $("#edit_name").val();
            var body = {
                "_token": token,
                "id": id,
                "name": name,
            };

            var endpoint = base_endpoint + id;
            showDialogConfirmationAjax('#modal_edit_form', 'Apakah anda yakin akan mengupdate data?', 'Update data berhasil!', endpoint, 'PUT', body, table_id);
        }
    }

</script>
@endsection
