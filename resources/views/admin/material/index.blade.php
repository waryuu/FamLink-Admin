@extends('layouts.base')
@section('title', 'Master Material')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Master Material</h4>
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
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Kategori</h4>
                            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal"
                                data-target="#category_modal_add_form">
                                <i class="fa fa-plus"></i>
                                Tambah Kategori
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal fade" id="category_modal_add_form" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                Tambah Kategori
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="category_form_validation" action="/admin/category" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama
                                                        Kategori
                                                        <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="name" name="name"
                                                            placeholder="Masukan Nama Kategori" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="status"
                                                        class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Status <span
                                                            class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <select class="form-control" id="status" name="status" required>
                                                            <option value="1">Aktif</option>
                                                            <option value="0">Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" id="addRowButton"
                                                class="btn btn-primary">Tambah</button>
                                            <button type="button" class="btn btn-outline-danger"
                                                data-dismiss="modal">Batal</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="category_modal_edit_form" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                Update Kategori
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="category_edit_form_validation">
                                        <input type="hidden" id="category_edit_binding_id" name="category_edit_binding_id" value="">
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="category_edit_name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Kategori <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="category_edit_name" name="name" placeholder="Masukan Nama Kategori" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="category_edit_status"
                                                        class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Status <span
                                                            class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <select class="form-control" id="category_edit_status" name="status" required>
                                                            <option value="1">Aktif</option>
                                                            <option value="0">Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" id="category_modal_edit_btn_update" class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="category_table_view" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th style="width: 10%">Nama Kategori</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kategori</th>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Materi</h4>
                            <a href="{{$model['base_url']}}create">
                                <button class="btn btn-primary btn-round ml-auto">
                                    <i class="fa fa-plus"></i>
                                    Tambah Materi
                                </button>
                            </a>
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
                                    <form id="form_validation" action="" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="title" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama
                                                        Assessment <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="title" name="title"
                                                            placeholder="Masukan Nama Assessment" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="description"
                                                        class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Deskripsi <span
                                                            class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="description"
                                                            name="description" placeholder="Masukan Deskripsi" required>
                                                    </div>
                                                </div>
                                                <div class="separator-solid"></div>
                                                <div class="form-group form-show-validation row">
                                                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Icon <span
                                                            class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <div class="input-file input-file-image">
                                                            <img class="img-upload-preview img-circle" width="100"
                                                                height="100" src="http://placehold.it/100x100"
                                                                alt="preview">
                                                            <input type="file" class="form-control form-control-file"
                                                                id="image" name="image" accept="image/*" required>
                                                            <label for="image"
                                                                class="btn btn-primary bg-primary btn-round btn-lg"><i
                                                                    class="fa fa-file-image"></i> Upload a Image</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" id="addRowButton" class="btn btn-primary">Add</button>
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Close</button>
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
                                                    <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama
                                                        Role <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="edit_name"
                                                            name="name" placeholder="Masukan Nama Role" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" id="modal_edit_btn_update"
                                                class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table_view" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">ID</th>
                                        <th style="width: 10%">Gambar / Video</th>
                                        <th style="width: 30%">Judul</th>
                                        <th style="width: 10%">Kategori</th>
                                        <th style="width: 10%">Jenis</th>
                                        {{-- <th>Deskripsi</th> --}}
                                        <th style="width: 10%">Terkunci</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gambar / Video</th>
                                        <th>Judul</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        {{-- <th>Deskripsi</th> --}}
                                        <th>Terkunci</th>
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
            if (row['type'] == 'default') {
                return '<img src="/material/'+row['image']+'" width="100px"/>';
            }else{
                return '<iframe src="'+row['link_yt']+'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen </iframe>';
            } 
        }},
        { data: 'title', name: 'title',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['title']+'</strong>';
        }},
        { data: 'name', name: 'name',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['name']+'</strong>';
        }},
        { data: 'type', name: 'type',
        render : function(data, type, row) {
            if (row['type'] == 'default') {
                return '<button class="btn btn-info">Standar</button>';
            }else{
                return '<button class="btn btn-warning">Video</button>';
            }
        }},
        { data: 'is_locked', name: 'is_locked',
        render : function(data, type, row) {
            if (row['is_locked'] == 1) {
                return '<button class="btn btn-success">Terkunci</button>';
            }else{
                return '<button class="btn btn-danger">Terbuka</button>';
            }
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
        table = initDataTableLoad(table_id, base_endpoint+'datatable/list', columns);
        initFormValidation(formId, rulesForm);
        initFormValidation(formEditId, rulesFormEdit);
        $(modalEditButtonId).click(function(e){
            setEditAction();
        });
    });

    var category_base_endpoint = "{{$model['category_base_url']}}";
    var category_table_id = '#category_table_view';
    var category_table = null;
    var category_formId = '#category_form_validation';
    var category_formEditId = '#category_edit_form_validation';
    var category_modalEditButtonId = '#category_modal_edit_btn_update';

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
        { data: 'name', name: 'name',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['name']+'</strong>';
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
            return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit" onclick="category_editData('+row['id']+')"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="category_deleteAlert('+row['id']+')"><i class="fa fa-times"></i></button></div>';
        }}];
        var columns = createColumnsAny(columnsData) ;
        table = initDataTableLoad(category_table_id, category_base_endpoint+'datatable/list', columns);
        initFormValidation(category_formId, rulesForm);
        initFormValidation(category_formEditId, rulesFormEdit);
        $(category_modalEditButtonId).click(function(e){
            category_setEditAction();
        });
    });

    function deleteAlert(id) {
        var body = {
            "id": id,
            "_token": token
        }
        showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!', base_endpoint+id, 'DELETE', body, table_id);
    }

    function category_deleteAlert(id) {
        var body = {
            "id": id,
            "_token": token,
        }
        showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!', category_base_endpoint+id, 'DELETE', body, category_table_id);
    }

    function editData(id){
        $.get(base_endpoint + id + '/edit', function (data) {
            $('#modal_edit_form').modal('show');
            $('#edit_binding_id').val(data.data.id);
            $('#edit_name').val(data.data.name);
        })
    }

    function category_editData(id){
        $.get(category_base_endpoint + id + '/edit', function (data) {
            $('#category_modal_edit_form').modal('show');
            $('#category_edit_binding_id').val(data.data.id);
            $('#category_edit_name').val(data.data.name);
            $('#category_edit_status').val(data.data.status);
        })
    }

    function category_setEditAction() {
        var valid = $(category_formEditId).valid();
        if (valid) {
            var id = $("#category_edit_binding_id").val();
            var name = $("#category_edit_name").val();
            var status = $("#category_edit_status").val();
            var body = {
                "_token": token,
                "id": id,
                "name": name,
                "status": status,
            };

            var endpoint = category_base_endpoint + id;
            showDialogConfirmationAjax('#category_modal_edit_form', 'Apakah anda yakin akan mengupdate data?', 'Update data berhasil!', endpoint, 'PUT', body, category_table_id);
        }
    }

</script>
@endsection