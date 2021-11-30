@extends('layouts.base')
@section('title', 'Update Profile')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Update Profile</h4></div>
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
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="edit_form_validation" action="{{$model['base_url']}}" method="POST">
                            @csrf
                            <input type="hidden" id="edit_binding_id" name="edit_binding_id" value="{{$model['data']->id}}" >
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label for="name">Nama Admin <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Masukan Nama Admin" value="{{$model['data']->name}}" required>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="email">Email <span class="required-label">*</span></label>
                                        <input type="email" class="form-control" id="edit_email" name="email" placeholder="Masukan Email" value="{{$model['data']->email}}" required>
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

    var base_endpoint = "{{$model['base_url']}}";
    var table_id = '#table_view';
    var table = null;
    var formId = '#form_validation';
    var formEditId = '#edit_form_validation';
    var modalEditButtonId = '#modal_edit_btn_update';
    var rulesForm = null;
    var rulesFormEdit = {
        edit_confirmpassword: {
            equalTo: "#edit_password"
        }
    };

    $(document).ready(function() {
        initFormValidation(formEditId, rulesFormEdit);
        $(modalEditButtonId).click(function(e){
            setEditAction();
        });
    });

    function setEditAction() {
        var valid = $(formEditId).valid();
        if (valid) {
            var id = $("#edit_binding_id").val();
            var name = $("#edit_name").val();
            var email = $("#edit_email").val();
            var password = $("#edit_password").val();
            var body = {
                "_token": token,
                "id": id,
                "name": name,
                "email": email,
                "password": password,
            };

            var endpoint = base_endpoint + id;
            showDialogConfirmationAjax('#modal_edit_form', 'Apakah anda yakin akan mengupdate data?', 'Update data berhasil!', endpoint, 'PUT', body, table_id, true);
        }
    }

</script>
@endsection
