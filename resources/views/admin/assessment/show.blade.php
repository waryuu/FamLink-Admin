@extends('layouts.base')
@section('title', 'Update Assessment')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Update Assessment</h4></div>
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
            <div class="col-4 col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{$model['base_url']}}{{$model['data']->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label >Icon <span class="required-label">*</span></label>
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview img-circle" width="100" height="100" src="/public/menu/{{$model['data']->image}}" alt="preview">
                                            <input type="file" class="form-control form-control-file" id="image" name="image" accept="image/*" >
                                            <label for="image" class="btn btn-primary bg-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Ganti Icon</label>
                                        </div>
                                    </div>
                                    <div class="separator-solid"></div>
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Nama Assessment <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Nama Assessment" value="{{$model['data']->title}}" required>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="description" >Deskripsi <span class="required-label">*</span></label>
                                        <textarea class="form-control" id="description" name="description" placeholder="Masukan Deskripsi" rows="10"  required>{{$model['data']->description}}</textarea>
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
            <div class="col-8 col-lg-8 col-sm-12">
                <div class="col-12 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Kategori</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#instrument_modal_add_form">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="modal fade" id="instrument_modal_add_form" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <form id="form_validation" action="/admin/assessment-detail" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id_assessment" value="{{$model['data']->id}}"/>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row">
                                                        <label for="detail_category" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Kategori <span class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <input type="text" class="form-control" id="detail_category" name="category" placeholder="Masukan Nama Kategori" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-show-validation row">
                                                        <label for="detail_percentage" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Jumlah Persentase <span class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <input type="number" class="form-control" id="detail_percentage" name="percentage" placeholder="Masukan Jumlah Persentase" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-show-validation row">
                                                        <label for="detail_type" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Tipe Jawaban Instrument <span class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <select class="form-control" id="detail_type" name="type" required>
                                                                <option value="0">YA / TIDAK</option>
                                                                <option value="2">1 - 7</option>
                                                                <option value="3">1 - 4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-primary">Add</button>
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
                                        <form id="detail_edit_form_validation" action="/menu" method="POST">
                                            @csrf
                                            <input type="hidden" id="detail_edit_binding_id" name="detail_edit_binding_id" value="">
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row">
                                                        <label for="detail_edit_category" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Kategori <span class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <input type="text" class="form-control" id="detail_edit_category" name="category" placeholder="Masukan Nama Kategori" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-show-validation row">
                                                        <label for="detail_edit_percentage" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Jumlah Persentase <span class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <input type="number" class="form-control" id="detail_edit_percentage" name="percentage" placeholder="Masukan Jumlah Persentase" required>
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
                                            <th>Kategori</th>
                                            <th>Persentase nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Kategori</th>
                                            <th>Persentase nilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Result --}}
                <div class="col-12 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Assesment Result</h4>
                                <a href="{{'/admin/assessment-result/'.$model['data']->id}}" class="ml-auto">
                                    <button class="btn btn-primary btn-round">
                                        <i class="fa fa-plus"></i>
                                        Tambah Data
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="result_table_view" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">ID</th>
                                            <th>Title</th>
                                            <th>Range Down</th>
                                            <th>Range Up</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Range Down</th>
                                            <th>Range Up</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Pertanyaan (Instrument) - <b>{{$model['data']->title}}</b></h4>
                            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#isntrument_modal_add_form">
                                <i class="fa fa-plus"></i>
                                Tambah Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal fade" id="isntrument_modal_add_form" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <form id="instrument_form_validation" action="/admin/assessment-instrument" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id_assessment" value="{{$model['data']->id}}"/>
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label ><strong>{{$model['data']->title}}</strong>
                                                    </div>
                                                    <div class="form-group form-show-validation row">
                                                        <div class="input-file input-file-image">
                                                            <img class="img-upload-preview img-circle" width="100" height="100" src="/public/menu/{{$model['data']->image}}" alt="preview">
                                                        </div>
                                                    </div>
                                                    <div class="separator-solid"></div>
                                                    <div class="form-group form-show-validation row">
                                                        <label for="parent_header">Category <span class="required-label">*</span></label>
                                                        <select class="form-control" id="assessment_detail_category" name="assessment_detail_category" required>
                                                            @foreach ($model['detail'] as $item)
                                                            <option value="{{$item->id}}">
                                                                {{$item->category}} -
                                                                (
                                                                @if($item->type == 0)
                                                                YA / TIDAK
                                                                @elseif($item->type == 2)
                                                                1 - 7
                                                                @elseif($item->type == 3)
                                                                1 - 4
                                                                @endif
                                                                )
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group form-show-validation row">
                                                        <label for="instrument_question" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Pertanyaan (Instrument) <span class="required-label">*</span></label>
                                                        <textarea class="form-control" id="instrument_question" name="question" placeholder="Masukan Nama Pertanyaan (Instrument)" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-primary">Add</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="instrument_modal_edit_form" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <form id="instrument_edit_form_validation">
                                            <input type="hidden" id="instrument_edit_binding_id" name="instrument_edit_binding_id" value="">
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row">
                                                        <label for="instrument_edit_question" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Pertanyaan (Instrument) <span class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <input type="text" class="form-control" id="instrument_edit_question" name="question" placeholder="Masukan Nama Pertanyaan (Instrument)" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" id="instrument_modal_edit_btn_update" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="instrument_table_view" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">ID</th>
                                            <th>Category)</th>
                                            <th>Pertanyaan (Instrument)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category)</th>
                                            <th>Pertanyaan (Instrument)</th>
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

        var base_endpoint = "/admin/assessment-detail/";
        var table_id = '#table_view';
        var table = null;
        var formId = '#form_validation';
        var formEditId = '#detail_edit_form_validation';
        var modalEditButtonId = '#modal_edit_btn_update';

        var rulesForm = null;
        var rulesFormEdit = null;

        var instrument_base_endpoint = "/admin/assessment-instrument/";
        var instrument_table_id = '#instrument_table_view';
        var instrument_table = null;
        var instrument_formId = '#instrument_form_validation';
        var instrument_formEditId = '#instrument_edit_form_validation';
        var instrument_modalEditButtonId = '#instrument_modal_edit_btn_update';

        var instrument_rulesForm = null;
        var instrument_rulesFormEdit = null;

        var result_base_endpoint = "/admin/assessment-result/";
        var result_table_id = "#result_table_view"
        var result_table = null;
        var result_formId = "#result_form_validation"
        var result_formEditButtonId = ""

        $(document).ready(function() {

            // Result
            let res_columns = [
            { data: 'id', name: 'id', render : function(data, type, row) {
                return '<strong class=" col-red" style="font-size: 12px">'+row['id']+'</strong>';
            }},
            { data: 'title', name: 'title', render : function(data, type, row) {
                return `<strong class=" col-red" style="font-size: 12px; color: ${row['color']}">${row['title']}</strong>`;
            }},
            { data: 'range_down', name: 'range_down', render : function(data, type, row) {
                return `<strong class=" col-red" style="font-size: 12px; color: ${row['color']}">${row['range_down']}</strong>`;
            }},
            { data: 'range_up', name: 'range_up', render : function(data, type, row) {
                return `<strong class=" col-red" style="font-size: 12px; color: ${row['color']}">${row['range_up']}</strong>`;
            }},
            { data: 'id', name: 'id', render : function(data, type, row) {
                return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit" onclick="res_editData('+row['id']+')"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="res_deleteAlert('+row['id']+')"><i class="fa fa-times"></i></button></div>';
            }}
            ];
            let res_endpoint = '/admin/assessment-result/datatable/list/{{$model['data']->id}}';
            res_table = initDataTableLoad(result_table_id, res_endpoint, res_columns);

            var columns = createColumns(['id', 'category', 'percentage']);
            table = initDataTableLoad(table_id, base_endpoint+'datatable/list/{{$model['data']->id}}', columns);
            initFormValidation(formId, rulesForm);
            initFormValidation(formEditId, rulesFormEdit);
            $(modalEditButtonId).click(function(e){
                setEditAction();
            });

            var instrument_columns = [
            { data: 'id', name: 'id', render : function(data, type, row) {
                return '<strong class=" col-red" style="font-size: 12px">'+row['id']+'</strong>';
            }},
            { data: 'detail'.category, name: 'detail'.category, render : function(data, type, row) {
                return '<strong class=" col-red" style="font-size: 12px">'+row['detail'].category+'</strong>';
            }},
            { data: 'question', name: 'question', render : function(data, type, row) {
                return '<strong class=" col-red" style="font-size: 12px">'+row['question']+'</strong>';
            }},
            { data: 'id', name: 'id', render : function(data, type, row) {
                return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit" onclick="instrument_editData('+row['id']+')"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="instrument_deleteAlert('+row['id']+')"><i class="fa fa-times"></i></button></div>';
            }}];
            instrument_table = initDataTableLoad(instrument_table_id, instrument_base_endpoint+'datatable/list/{{$model['data']->id}}', instrument_columns);
            initFormValidation(instrument_formId, instrument_rulesForm);
            initFormValidation(instrument_formEditId, instrument_rulesFormEdit);
            $(instrument_modalEditButtonId).click(function(e){
                instrument_setEditAction();
            });
        });

        function deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!', base_endpoint+id, 'DELETE', body, table_id);
        }

        function editData(id){
            $.get(base_endpoint + id + '/edit', function (data) {
                $('#modal_edit_form').modal('show');
                $('#detail_edit_binding_id').val(data.data.id);
                $('#detail_edit_category').val(data.data.category);
                $('#detail_edit_percentage').val(data.data.percentage);
            })
        }

        function setEditAction() {
            var valid = $(formEditId).valid();
            if (valid) {
                var id = $("#detail_edit_binding_id").val();
                var category = $("#detail_edit_category").val();
                var percentage = $("#detail_edit_percentage").val();
                var body = {
                    "_token": token,
                    "id": id,
                    "category": category,
                    "percentage": percentage,
                };

                var endpoint = base_endpoint + id;
                showDialogConfirmationAjax('#modal_edit_form', 'Apakah anda yakin akan mengupdate data?', 'Update data berhasil!', endpoint, 'PUT', body, table_id);
            }
        }

        function instrument_deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!', instrument_base_endpoint+id, 'DELETE', body, instrument_table_id);
        }

        function res_deleteAlert(id){
            let res_endpoint = result_base_endpoint + id;
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!', res_endpoint, 'DELETE', body, result_table_id);
        }

        function instrument_editData(id){
            $.get(instrument_base_endpoint + id + '/edit', function (data) {
                $('#instrument_modal_edit_form').modal('show');
                $('#instrument_edit_binding_id').val(data.data.id);
                $('#instrument_edit_question').val(data.data.question);
            })
        }

        function res_editData(id){
            let endpoint = result_base_endpoint + id + '/edit';
            window.location.pathname = endpoint
        }

        function instrument_setEditAction() {
            var valid = $(instrument_formEditId).valid();
            if (valid) {
                var id = $("#instrument_edit_binding_id").val();
                var question = $("#instrument_edit_question").val();
                var body = {
                    "_token": token,
                    "id": id,
                    "question": question,
                };

                var endpoint = instrument_base_endpoint + id;
                showDialogConfirmationAjax('#instrument_modal_edit_form', 'Apakah anda yakin akan mengupdate data?', 'Update data berhasil!', endpoint, 'PUT', body, instrument_table_id);
            }
        }

    </script>
    @endsection
