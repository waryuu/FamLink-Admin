@extends('layouts.base')
@section('title', 'Laporan Assessment')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Laporan Assessment</h4>
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
            @foreach($model['assessment'] as $item)
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <img src="/public/menu/{{ $item->image }}" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">{{ $item->title }}</p>
                                    <h4 class="card-title">{{ $item->jumlah }} Assessment</h4>
                                    <a href="{{$model['base_url']}}?id={{ $item->id }}">LIHAT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="{{$model['base_url']}}download/excel">
                                <button class="btn btn-success btn-round ml-auto">
                                    <i class="fa fa-download"></i>
                                    Download Data
                                </button>
                            </a>
                            <a href="{{$model['base_url']}}download/excel/native" style="margin-left: 8px;">
                                <button class="btn btn-success btn-round ml-auto">
                                    <i class="fa fa-download"></i>
                                    Download Data Mentah
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
                                    <form id="form_validation" action="{{$model['base_url']}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="title" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Banner <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Nama Banner" required>
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
                                        <th style="width: 10%">Assessment</th>
                                        <th style="width: 10%"></th>
                                        <th>Status</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Assessment</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Assessment</th>
                                        <th></th>
                                        <th>Status</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Assessment</th>
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
        { data: 'id', name: 'id', render : function(data, type, row) {
            return '<img src="/public/menu/'+row['assessment'].image+'" width="100px"/>';
        }},
        { data: 'id', name: 'id',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['assessment'].title+'</strong>';
        }},
        { data: 'id', name: 'id',
        render : function(data, type, row) {
            if (row['assessment_result'] != null) {
                return '<h1>'+row['result']+'</h1><strong style="font-size: 12px; color: '+row['assessment_result'].color+'">'+row['assessment_result'].title+'</strong>';
            } else {
                return '';
            }
        }},
        { data: 'id', name: 'id',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['user'].nama_lengkap+'</strong><br><span class=" col-red" style="font-size: 9px">'+row['user'].provinsi_ket+'</span><br><span class=" col-red" style="font-size: 9px">'+row['user'].kabupaten_ket+'</span>';
        }},
        { data: 'id', name: 'id',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['created_at']+'</strong>';
        }},];
        var columns = createColumnsAny(columnsData) ;
        <?php
        if(isset($_GET['id'])){
            ?>
            table = initDataTableLoad(table_id, base_endpoint+'datatable/list?id=<?php echo $_GET['id'] ?>', columns);
            <?php
        }else {
            ?>
            table = initDataTableLoad(table_id, base_endpoint+'datatable/list', columns);
            <?php
        }
        ?>
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
