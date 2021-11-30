@extends('layouts.base')
@section('title', 'Master User Admin')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Master User Admin</h4></div>
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
                                    <form id="form_validation" action="{{$model['base_url']}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="username">Username <span class="required-label">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="username" aria-label="username" aria-describedby="username-addon" id="username" name="username" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="email">Email <span class="required-label">*</span></label>
                                                    <div class="input-group">
                                                        <input type="email" class="form-control" placeholder="Email" aria-label="email" aria-describedby="email-addon" id="email" name="email" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="name">Nama Akun <span class="required-label">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Akun" required>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="parent_header">Role <span class="required-label">*</span></label>
                                                    <select class="form-control" id="role" name="role" required>
                                                        @foreach ($model['role'] as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="password">Password <span class="required-label">*</span></label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="confirmpassword">Confirm Password <span class="required-label">*</span></label>
                                                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Password" required>
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
                                    <form id="edit_form_validation" action="{{$model['base_url']}}" method="POST">
                                        @csrf
                                        <input type="hidden" id="edit_binding_id" name="edit_binding_id" value="">
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="username">Username <span class="required-label">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="username" aria-label="username" aria-describedby="username-addon" id="edit_username" name="username" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="email">Email <span class="required-label">*</span></label>
                                                    <div class="input-group">
                                                        <input type="email" class="form-control" placeholder="email" aria-label="email" aria-describedby="email-addon" id="edit_email" name="email" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="name">Nama Akun <span class="required-label">*</span></label>
                                                    <input type="text" class="form-control" id="edit_name" name="name" placeholder="Masukan Nama Akun" required>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="parent_header">Role <span class="required-label">*</span></label>
                                                    <select class="form-control" id="edit_role" name="role" required>
                                                        @foreach ($model['role'] as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="password">Password <span class="required-label">*</span></label>
                                                    <input type="password" class="form-control" id="edit_password" name="password" placeholder="Enter Password">
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="confirmpassword">Confirm Password <span class="required-label">*</span></label>
                                                    <input type="password" class="form-control" id="edit_confirmpassword" name="edit_confirmpassword" placeholder="Enter Password">
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
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Created At</th>
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
        confirmpassword: {
            equalTo: "#password"
        }
    };

    var rulesFormEdit = {
        edit_confirmpassword: {
            equalTo: "#edit_password"
        }
    };

    $(document).ready(function() {
        var columns = createColumns(['id', 'name', 'created_at']);
        table = initDataTableLoad(table_id, base_endpoint+'create', columns);
        initFormValidation(formId, rulesForm);
        initFormValidation(formEditId, rulesFormEdit);
        $(modalEditButtonId).click(function(e){
            setEditAction();
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
            $('#edit_binding_id').val(data.data.id);
            $('#edit_name').val(data.data.name);
            $('#edit_email').val(data.data.email);
            $('#edit_username').val(data.data.username);
            $('#edit_role').append($("<option></option>")
            .attr("value", data.role.id)
            .attr("selected", true)
            .text(data.role.name))
        })
    }

    function setEditAction() {
        var valid = $(formEditId).valid();
        if (valid) {
            var id = $("#edit_binding_id").val();
            var name = $("#edit_name").val();
            var email = $("#edit_email").val();
            var username = $("#edit_username").val();
            var role = $("#edit_role").val();
            var password = $("#edit_password").val();
            var body = {
                "_token": token,
                "id": id,
                "name": name,
                "email": email,
                "username": username,
                "role": role,
                "password": password,
            };

            var endpoint = base_endpoint + id;
            showDialogConfirmationAjax('#modal_edit_form', 'Apakah anda yakin akan mengupdate data?', 'Update data berhasil!', endpoint, 'PUT', body, table_id);
        }
    }
</script>
@endsection
