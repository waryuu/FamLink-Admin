@extends('layouts.base')
@section('title', 'Master Assignment')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Master Assignment</h4>
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
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="category_form_validation" action="/admin/assignment" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama
                                                        Kategori
                                                        <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="title" name="title"
                                                            placeholder="Masukan Nama Kategori" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="status"
                                                        class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Status <span
                                                            class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <select class="form-control" id="status" name="status"
                                                            required>
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

                        <div class="modal fade" id="category_modal_edit_form" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                Update Kategori
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form id="category_edit_form_validation" action="/admin/assignment" method="POST">
                                        @csrf
                                        <input type="hidden" id="category_edit_binding_id"
                                            name="category_edit_binding_id" value="">
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="category_edit_name"
                                                        class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama Kategori <span
                                                            class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control"
                                                            id="category_edit_name" name="title"
                                                            placeholder="Masukan Nama Kategori" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="category_edit_status"
                                                        class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Status <span
                                                            class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <select class="form-control" id="category_edit_status"
                                                            name="status" required>
                                                            <option value="1">Aktif</option>
                                                            <option value="0">Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" id="category_modal_edit_btn_update"
                                                class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-outline-danger"
                                                data-dismiss="modal">Batal</button>
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
                        <div class="d-flex align-items-center">
                            {{-- <h4 class="card-title">Add Row</h4> --}}
                            <a href="{{$model['instrument_url']}}create">
                                <button class="btn btn-primary btn-round ml-auto">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_view" class="display table table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th>Category</th>
                                        <th>Question</th>
                                        <th>Option 1</th>
                                        <th>Option 2</th>
                                        <th>Option 3</th>
                                        <th>Option 4</th>
                                        <th>Correct_Answer</th>
                                        <th>Diinput Oleh</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Question</th>
                                        <th>Option 1</th>
                                        <th>Option 2</th>
                                        <th>Option 3</th>
                                        <th>Option 4</th>
                                        <th>Correct_Answer</th>
                                        <th>Diinput Oleh</th>
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
        

        var category_base_endpoint = "{{ $model['assignment_url'] }}";
        var category_table_id = '#category_table_view';
        var category_table = null;
        var category_formId = '#category_form_validation';
        var category_formEditId = '#category_edit_form_validation';
        var category_modalEditButtonId = '#category_modal_edit_btn_update';
        var rulesForm = null;
        var rulesFormEdit = null;

        $(document).ready(function() {
            var columnsData = [{
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['id'] +
                        '</strong>';
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['title'] +
                            '</strong>';
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        if (row['status'] == 1) {
                            return '<button class="btn btn-success">Aktif</button>';
                        } else {
                            return '<button class="btn btn-danger">Tidak Aktif</button>';
                        }
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit" onclick="category_editData(' +
                            row['id'] +
                            ')"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="category_deleteAlert(' +
                            row['id'] + ')"><i class="fa fa-times"></i></button></div>';
                    }
                }
            ];

            var columns = createColumnsAny(columnsData);
            table = initDataTableLoad(category_table_id, category_base_endpoint + 'datatable/list', columns);
            initFormValidation(category_formId, rulesForm);
            initFormValidation(category_formEditId, rulesFormEdit);
            $(category_modalEditButtonId).click(function(e) {
                category_setEditAction();
            });
        });
        function category_deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!',
                category_base_endpoint + id, 'DELETE', body, category_table_id);
        }

        function category_editData(id) {
            $.get(category_base_endpoint + id + '/edit', function(data) {
                $('#category_modal_edit_form').modal('show');
                $('#category_edit_binding_id').val(data.data.id);
                $('#category_edit_name').val(data.data.title);
                $('#category_edit_status').val(data.data.status);
            })
        }

        function category_setEditAction() {
            var valid = $(category_formEditId).valid();
            if (valid) {
                var id = $("#category_edit_binding_id").val();
                var title = $("#category_edit_name").val();
                var status = $("#category_edit_status").val();
                var body = {
                    "_token": token,
                    "id": id,
                    "title": title,
                    "status": status,
                };

                var endpoint = category_base_endpoint + id;
                showDialogConfirmationAjax('#category_modal_edit_form', 'Apakah anda yakin akan mengupdate data?',
                    'Update data berhasil!', endpoint, 'PUT', body, category_table_id);
            }
        }

        var base_endpoint = "{{ $model['instrument_url'] }}";
        var table_id = '#table_view';
        var table = null;
        var modalEditButtonId = '#modal_edit_btn_update';

        $(document).ready(function() {
            var columnsData = [{
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['id'] +
                        '</strong>';
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['title'] +
                            '</strong>';
                    }
                },

                {
                    data: 'question',
                    name: 'question',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['question'] +
                            '</strong>';
                    }
                },

                {
                    data: 'option_a',
                    name: 'option_a',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['option_a'] +
                            '</strong>';
                    }
                },
                  
                {
                    data: 'option_b',
                    name: 'option_b',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['option_b'] +
                            '</strong>';
                    }
                },
                {
                    data: 'option_c',
                    name: 'option_c',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['option_c'] +
                            '</strong>';
                    }
                },
                {
                    data: 'option_d',
                    name: 'option_d',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['option_d'] +
                            '</strong>';
                    }
                },
                {
                    data: 'correct_answer',
                    name: 'correct_answer',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px"> Option : ' + row['correct_answer'] +
                            '</strong>';
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['name'] +
                            '</strong>';
                    }
                },

                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        if (row['status'] == 1) {
                            return '<button class="btn btn-success">Aktif</button>';
                        } else {
                            return '<button class="btn btn-danger">Tidak Aktif</button>';
                        }
                    }
                },

                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<div class="form-button-action"><a href="' + base_endpoint + row['id'] + 
                            '"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Edit"><i class="fa fa-edit"></i></button></a><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert(' +
                            row['id'] + ')"><i class="fa fa-times"></i></button></div>';
                    }
                }
            ];
            var columns = createColumnsAny(columnsData);
            table = initDataTableLoad(table_id, base_endpoint + 'datatable/list', columns);
        });

        function deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!',
                base_endpoint + id, 'DELETE', body, table_id);
        }
    </script>
@endsection