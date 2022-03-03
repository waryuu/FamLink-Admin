@extends('layouts.base')
@section('title', 'Master Stakeholder')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Master Stakeholder</h4>
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
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal"
                                    data-target="#modal_add_form">
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
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form id="form_validation" action="{{ '/admin/stakeholder' }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row w-100">
                                                        <div class="row w-100">
                                                            <label for="parent_header">
                                                                Nama lembaga <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="text" id="name_stakeholder"
                                                                name="name" required />
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">
                                                                Tanggal didirikan <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="date" id="established"
                                                                name="established" required />
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">
                                                                Fokus lembaga <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="text" id="focus_stakeholder"
                                                                name="focus" required />
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">
                                                                E-mail
                                                            </label>
                                                            <input class="form-control" type="email" id="email"
                                                                name="email" />
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">Provinsi <span
                                                                    class="required-label">*</span></label>
                                                            <input class="form-control" type="search" autoComplete="on"
                                                                list="province_list" id="id_province" name="id_province"
                                                                required onchange="getRegencies(this)" />
                                                            <datalist id="province_list">
                                                                @foreach ($model['provinces'] as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">Kabupaten <span
                                                                    class="required-label">*</span></label>
                                                            <input class="form-control" type="search" autoComplete="on"
                                                                list="regency_list" id="id_regency" name="id_regency"
                                                                disabled required />
                                                            <datalist id="regency_list"></datalist>
                                                        </div>
                                                        <div class="row mt-4 w-100">
                                                            <label class="w-100" for="parent_header">Logo
                                                                lembaga</label></br>
                                                            <div class="d-flex justify-content-center w-100">
                                                                <img id="preview_logo_stakeholder"
                                                                    class="ml-4 mt-3 mb-3 rounded-circle row" width="200"
                                                                    height="200"
                                                                    style="object-fit: cover; display: none;" />
                                                            </div>
                                                            <input class="form-control" type="file" accept="image/*"
                                                                name="logo" onchange="loadPreviewLogo(event)" />
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
                                                    Edit
                                                </span>
                                                <span class="fw-light">
                                                    Data
                                                </span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form id="form_edit_validation" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row w-100">
                                                        <input type="hidden" id="edit_id_stakeholder" name="id" value="" />
                                                        <div class="row w-100">
                                                            <label for="parent_header">
                                                                Nama lembaga <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="text"
                                                                id="edit_name_stakeholder" name="name" required />
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">
                                                                Tanggal didirikan <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="date" id="edit_established"
                                                                name="established" required />
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">
                                                                Fokus lembaga <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="text"
                                                                id="edit_focus_stakeholder" name="focus" required />
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">
                                                                E-mail
                                                            </label>
                                                            <input class="form-control" type="email" id="edit_email"
                                                                name="email" />
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">Provinsi <span
                                                                    class="required-label">*</span></label>
                                                            <input class="form-control" type="search" autoComplete="on"
                                                                list="province_list" id="edit_id_provinces"
                                                                name="id_province" required onchange="getRegencies(this)" />
                                                            <datalist id="province_list">
                                                                @foreach ($model['provinces'] as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="row w-100 mt-4">
                                                            <label for="parent_header">Kabupaten <span
                                                                    class="required-label">*</span></label>
                                                            <input class="form-control" type="search" autoComplete="on"
                                                                list="regency_list" id="edit_id_regency" name="id_regency"
                                                                disabled required />
                                                            <datalist id="regency_list"></datalist>
                                                        </div>
                                                        <div class="row mt-4 w-100">
                                                            <label class="w-100" for="parent_header">Logo
                                                                lembaga</label></br>
                                                            <div class="d-flex justify-content-center w-100">
                                                                <img id="preview_edit_logo_stakeholder"
                                                                    class="ml-4 mt-3 mb-3 rounded-circle row" width="200"
                                                                    height="200"
                                                                    style="object-fit: cover; display: none;" />
                                                            </div>
                                                            <input class="form-control" type="file" accept="image/*"
                                                                name="logo" id="edit_logo"
                                                                onchange="onChangeInputLogo(event)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" id="editRowButton"
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
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lembaga</th>
                                            <th>Tanggal dibentuk</th>
                                            <th>Fokus Lembaga</th>
                                            <th>Email</th>
                                            <th>Logo</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lembaga</th>
                                            <th>Tanggal dibentuk</th>
                                            <th>Fokus Lembaga</th>
                                            <th>Email</th>
                                            <th>Logo</th>
                                            <th style="width: 10%">Action</th>
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
        var base_endpoint = "{{ $model['base_url'] }}";
        var table = null;
        var table_id = '#table_view';
        var modal_form = '#modal_add_form';
        var modalEditId = "#modal_edit_form";
        var modalEditButtonId = "#editRowButton";
        var formEditId = '#form_edit_validation';
        var editLogoFiles = null;

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
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['name'] +
                            '</strong>';
                    }
                },
                {
                    data: 'established',
                    name: 'established',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['established'] +
                            '</strong>';
                    }
                },
                {
                    data: 'focus',
                    name: 'focus',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['focus'] +
                            '</strong>';
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['email'] +
                            '</strong>';
                    }
                },
                {
                    data: 'logo',
                    name: 'logo',
                    render: function(data, type, row) {
                        return '<img src="{{ $model['public_url'] }}' + row['logo'] +
                            '"class="rounded-circle row" width="150" height="150" style="object-fit: cover;" / >';
                    }
                },
                {
                    data: 'id',
                    name: 'action',
                    render: function(data, type, row) {
                        return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit" onclick="editData(' +
                            row['id'] +
                            ')"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert(' +
                            row['id'] + ')"><i class="fa fa-times"></i></button></div>';
                    }
                }
            ];
            var columns = createColumnsAny(columnsData);
            table = initDataTableLoad(table_id, base_endpoint + 'create', columns);
            $(modal_form).on('hidden.bs.modal', function(e) {
                $(this).find('form').trigger('reset');
            })
            $(modalEditButtonId).click(function(e) {
                setEditAction(e);
            });
            initFormValidation(formEditId, rulesFormEdit);
        });

        function getRegencies(data) {
            var id_province = data.value;
            var regency_list = document.getElementById('regency_list');
            var containerRegency = document.getElementById('id_regency');

            $.get(base_endpoint + "regencies" + "/" + id_province, function(responseText) {
                responseText.forEach(function(item) {
                    var option = document.createElement('option');
                    containerRegency.disabled = false;
                    option.value = item.id;
                    option.innerHTML = item.name;
                    regency_list.appendChild(option);
                });
            });
        }

        var rulesFormEdit = {
            id: {
                required: true,
            },
            name: {
                required: true,
            },
            established: {
                required: true,
            },
            focus: {
                required: true,
            },
            id_province: {
                required: true,
            },
            id_regency: {
                required: true,
            },
        };

        function editData(id) {
            $.get(base_endpoint + id, function(responseText) {
                $("#edit_id_stakeholder").val(responseText.id);
                $("#edit_name_stakeholder").val(responseText.name);
                $("#edit_established").val(responseText.established);
                $("#edit_focus_stakeholder").val(responseText.focus);
                $("#edit_email").val(responseText.email);
                $("#edit_id_provinces").val(responseText.id_province);
                $("#edit_id_regency").val(responseText.id_regency);
                $("#edit_id_regency").removeAttr("disabled");
                $("#preview_edit_logo_stakeholder").attr('src', '{{ $model['public_url'] }}' + responseText.logo);
                $("#preview_edit_logo_stakeholder").attr('style', 'object-fit: cover; display: block;');
                $('#modal_edit_form').modal('show');
            })
        }

        function blobToBase64(blob) {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            return new Promise(resolve => {
                reader.onloadend = () => {
                    resolve(reader.result);
                };
            });
        };

        async function setEditAction(e) {
            var valid = $(formEditId).valid();
            if (valid) {
                var id = $("#edit_id_stakeholder").val();
                var name = $("#edit_name_stakeholder").val();
                var established = $("#edit_established").val();
                var focus = $("#edit_focus_stakeholder").val();
                var email = $("#edit_email").val();
                var id_province = $("#edit_id_provinces").val();
                var id_regency = $("#edit_id_regency").val();
                var logo = null;
                var fileName = null;
                if (editLogoFiles != null) {
                    logo = await blobToBase64(editLogoFiles);
                    fileName = `${id}_${name}.${editLogoFiles.name.split(".").pop()}`;
                }

                var body = {
                    "_token": token,
                    "id": id,
                    "name": name,
                    "established": established,
                    "focus": focus,
                    "email": email,
                    "id_province": id_province,
                    "id_regency": id_regency,
                    "logo": logo,
                    "fileName": fileName,
                };
                if (email == null || email == '') delete body["email"];
                if (logo == null || logo == '') delete body["logo"];
                if (fileName == null || fileName == '') delete body["fileName"];

                var endpoint = base_endpoint + id;
                showDialogConfirmationAjax(modalEditId, 'Apakah anda yakin akan mengupdate data?',
                    'Update data berhasil!',
                    endpoint, 'PUT', body, table_id);
            }
        }

        function onChangeInputLogo(event) {
            var output = document.getElementById('preview_edit_logo_stakeholder');
            if (event.target.files.length == 0) {
                output.src = "";
                output.style.display = "none";
                editLogoFiles = null;
            } else {
                var logoFiles = event.target.files[0];
                editLogoFiles = logoFiles;
                output.src = URL.createObjectURL(logoFiles);
                output.onload = function() {
                    output.style.display = "block";
                    URL.revokeObjectURL(output.src);
                }
            }
        };

        function loadPreviewLogo(event) {
            var output = document.getElementById('preview_logo_stakeholder');
            if (event.target.files.length == 0) {
                output.src = "";
                output.style.display = "none";
            } else {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    output.style.display = "block";
                    URL.revokeObjectURL(output.src);
                }
            }
        };

        function deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!',
                base_endpoint + id, 'DELETE', body, table_id);
        }
    </script>
@endsection
