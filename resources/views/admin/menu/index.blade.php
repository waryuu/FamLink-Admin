@extends('layouts.base')
@section('title', 'Master Menu')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Master Menu</h4></div>
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
                                                    <label for="title">Menu Name <span class="required-label">*</span></label>
                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Menu Name" required>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="url">Url Path <span class="required-label">*</span></label>
                                                    <input type="text" class="form-control" id="url" name="url" placeholder="Masukan Url Menu" required>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="icon">Icon Menu <span class="required-label">*</span></label>
                                                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Masukan Icon Menu" required>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label>Menu Type <span class="required-label">*</span></label>
                                                    <div class="col-lg-4 col-md-9 col-sm-8 d-flex align-items-center" id="menu_type_container">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="header" name="menu_type" class="custom-control-input" value="header">
                                                            <label class="custom-control-label" for="header">Header</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="sub_header" name="menu_type" class="custom-control-input" value="sub_header" checked>
                                                            <label class="custom-control-label" for="sub_header">Sub Header</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row" id="parent_header_container">
                                                    <label for="parent_header">Header <span class="required-label">*</span></label>
                                                    <select class="form-control" id="parent_header" name="parent_header" required>
                                                        @foreach ($model['menu_header'] as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                        @endforeach
                                                    </select>
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
                                                    <label for="title">Menu Name <span class="required-label">*</span></label>
                                                    <input type="text" class="form-control" id="edit_title" name="title" placeholder="Masukan Menu Name" required>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="url">Url Path <span class="required-label">*</span></label>
                                                    <input type="text" class="form-control" id="edit_url" name="url" placeholder="Masukan Url Menu" required>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="icon">Icon Menu <span class="required-label">*</span></label>
                                                    <input type="text" class="form-control" id="edit_icon" name="icon" placeholder="Masukan Icon Menu" required>
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

                        @foreach ($model['menu_header_view'] as $item)
                        <ul class="list-group list-group-bordered">
                            <li class="list-group-item align-items-center active">
                                <i class="{{$item->icon}}"></i>
                                <b style="padding-left: 4px;">{{$item->title}}</b>
                                <span class="ml-auto">
                                    <div class="form-button-action">
                                        <ul class="pagination pg-primary">
                                            <li class="page-item">
                                                <a class="page-link" href="#" onclick="editData('{{$item->id}}')">
                                                    <i class="fa fa-edit text-primary"></i>
                                                </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" onclick="deleteAlert('{{$item->id}}')">
                                                    <i class="fa fa-times text-danger"></i>
                                                </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="/admin/menu-up/{{$item->id}}">
                                                    <i class="flaticon-up-arrow-1"></i>
                                                </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="/admin/menu-down/{{$item->id}}">
                                                    <i class="flaticon-down-arrow-1"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </span>
                            </li>
                            @foreach($item->data as $item_parent)
                            <li class="list-group-item align-items-center">
                                -> <span style="padding-left: 4px; padding-right: 4px; font-weight:bold;">{{$item_parent->title}}</span> | path = {{$item_parent->url}}
                                <span class="ml-auto">
                                    <div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit" onclick="editData('{{$item_parent->id}}')"><i class="fa fa-edit"></i></button>
                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert('{{$item_parent->id}}')"><i class="fa fa-times"></i></button>
                                    </div>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                        <br>
                        @endforeach
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
    var rulesFormEdit = null;

    $(document).ready(function() {
        var action = {
            data: 'id',
            name: 'id',
            render : function(data, type, row) {
                return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit" onclick="editData('+row['id']+')"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert('+row['id']+')"><i class="fa fa-times"></i></button></div>';
            }
        };
        var columns = createColumnsAction(['id', 'name', 'created_at'], action) ;
        table = initDataTableLoad(table_id, base_endpoint+'create', columns);
        initFormValidation(formId, rulesForm);
        initFormValidation(formEditId, rulesFormEdit);
        $(modalEditButtonId).click(function(e){
            setEditAction();
        });

        $('input[type=radio][name=menu_type]').change(function() {
            if (this.value == 'header'){
                $('#parent_header_container').hide();
            }else{
                $('#parent_header_container').show();
            }
        });
    });

    function deleteAlert(id) {
        var body = {
            "id": id,
            "_token": token,
        }
        showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!', base_endpoint+id, 'DELETE', body, table_id, true);
    }

    function editData(id){
        $.get(base_endpoint + id + '/edit', function (data) {
            $('#modal_edit_form').modal('show');
            $('#edit_binding_id').val(data.data.id);
            $('#edit_title').val(data.data.title);
            $('#edit_url').val(data.data.url);
            $('#edit_icon').val(data.data.icon);
        })
    }

    function setEditAction() {
        var valid = $(formEditId).valid();
        if (valid) {
            var id = $("#edit_binding_id").val();
            var title = $("#edit_title").val();
            var url = $("#edit_url").val();
            var icon = $("#edit_icon").val();
            var body = {
                "_token": token,
                "id": id,
                "title": title,
                "url": url,
                "icon": icon,
            };

            var endpoint = base_endpoint + id;
            showDialogConfirmationAjax('#modal_edit_form', 'Apakah anda yakin akan mengupdate data?', 'Update data berhasil!', endpoint, 'PUT', body, table_id, true);
        }
    }

</script>
@endsection
