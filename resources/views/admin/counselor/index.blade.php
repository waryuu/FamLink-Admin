@extends('layouts.base')
@section('title', 'Master Konselor')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex flex-row align-items-center">
                <h4 class="page-title ml-0 mr-auto">Master Konselor</h4>
                <a href="#" class="text-light">
                    @if ($model['rules'] == null)
                        <button type="button" class='ml-1 btn btn-rounded btn-info' id='rules_section' data-toggle="modal"
                            data-target="#modal_create_rules">
                            <i class="fa fa-book mr-1" aria-hidden="true"></i>
                            <span>BUAT ATURAN UNTUK KONSELOR</span>
                        </button>
                    @else
                        <button type="button" class='ml-1 btn btn-rounded btn-info' id='rules_section' data-toggle="modal"
                            data-target="#modal_edit_rules">
                            <i class="fa fa-book mr-1" aria-hidden="true"></i>
                            <span>ATURAN TERSIMPAN</span>
                        </button>
                    @endif
                </a>
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
                                <h4 id="section_titile" class="card-title">Daftar Konselor Aktif</h4>
                                <button id="btn_status" class="btn btn-secondary btn-round ml-auto"
                                    onclick="onChangeStatus('nonactive')">
                                    <i class="fas fa-user-slash mr-1"></i>
                                    KONSELOR NONAKTIF
                                </button>
                                <button id="btn_add_data" class="btn btn-primary btn-round ml-2" data-toggle="modal"
                                    data-target="#modal_add_form">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="root_active_table" class="table-responsive">
                                <table id="table_view" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Keahlian</th>
                                            <th style="width: 7%">JK</th>
                                            <th>Edukasi</th>
                                            <th>Pekerjaan</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Fokus</th>
                                            <th>Waktu dibuat</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Keahlian</th>
                                            <th style="width: 7%">JK</th>
                                            <th>Edukasi</th>
                                            <th>Pekerjaan</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Fokus</th>
                                            <th>Waktu dibuat</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div id="root_nonactive_table" class="d-none table-responsive">
                                <table id="table_view_nonactive" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Keahlian</th>
                                            <th style="width: 7%">JK</th>
                                            <th>Edukasi</th>
                                            <th>Pekerjaan</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Fokus</th>
                                            <th>Waktu dibuat</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Keahlian</th>
                                            <th style="width: 7%">JK</th>
                                            <th>Edukasi</th>
                                            <th>Pekerjaan</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Fokus</th>
                                            <th>Waktu dibuat</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="modal fade" id="modal_add_form" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">

                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">
                                                <span class="fw-mediumbold">
                                                    Tambah Konselor
                                                </span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form id="form_validation" action="{{ '/admin/counselor' }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row w-100">
                                                        <div id="user_selection" class="w-100">
                                                            <label for="parent_header">
                                                                Pilih Pengguna <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="search" autoComplete="on"
                                                                list="konselor_list" id="id_user" name="id_user" required
                                                                style="width: 100%" />
                                                            <datalist id="konselor_list">
                                                                @foreach ($model['users'] as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->nama_lengkap }}
                                                                    </option>
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div id="stakeholder_selection" class="w-100 mt-4">
                                                            <label for="parent_header">Stakeholder <span
                                                                    class="required-label">*</span></label>
                                                            <input class="form-control" type="search" autoComplete="on"
                                                                list="stakeholder_list" id="id_stakeholder"
                                                                name="id_stakeholder" required />
                                                            <datalist id="stakeholder_list">
                                                                @foreach ($model['stakeholders'] as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="w-100 mt-4">
                                                            <label for="parent_header">
                                                                Keahlian Konselor <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="text" id="expertise"
                                                                name="expertise" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" id="addRowButton" class="btn btn-primary">Add</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modal_edit_counselor" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">

                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">
                                                <span class="fw-mediumbold">
                                                    Edit Konselor
                                                </span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        
                                        <form id="edit_form_validation" action="" method="POST">
                                            @csrf
                                            <input type="hidden" id="edit_binding_id"
                                                name="edit_binding_id" value="">
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row w-100">
                                                        <div id="user_selection" class="w-100">
                                                            <label for="parent_header">
                                                                Pilih Pengguna <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" id="edit_id_user" name="id_user" required
                                                                style="width: 100%" disabled/>
                                                            <div id="edit_nama_user"></div>
                                                        </div>
                                                        <div id="stakeholder_selection" class="w-100 mt-4">
                                                            <label for="parent_header">Stakeholder <span
                                                                    class="required-label">*</span></label>
                                                            <input class="form-control" id="edit_id_stakeholder"
                                                                name="id_stakeholder" required disabled/>
                                                            <div id="edit_nama_stakeholder"></div>
                                                        </div>
                                                        <div class="w-100 mt-4">
                                                            <label for="parent_header">
                                                                Keahlian Konselor <span class="required-label">*</span>
                                                            </label>
                                                            <input class="form-control" type="text" id="edit_expertise"
                                                                name="expertise" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" id="btn_edit_counselor" class="btn btn-primary">Ubah</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modal_edit_rules" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header align-items-center">
                                            <h3 class="modal-title font-weight-bold">Ubah Aturan Konsultasi untuk Konselor
                                            </h3>
                                            <div class="action-button">
                                                <button type="button" id="modal_rules_btn_delete"
                                                    class='btn btn-rounded btn-danger'>
                                                    <i class="fa fa-trash mr-1" aria-hidden="true"></i>
                                                    <span>Hapus Aturan</span>
                                                </button>
                                                <button class="close pl-3" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                        <form id="rules_form_validation" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="rules_edit_binding_id" name="rules_edit_binding_id"
                                                value=@if ($model['rules'] != null) {{ $model['rules']->id }} @endif>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="">
                                                        <label for="description"><b>Aturan </b><span
                                                                class="required-label">*</span></label>
                                                        <div>
                                                            <textarea id="summernote_edit" name="rule_edit" placeholder="Masukan Aturan disini" required>
                                                                @if ($model['rules'] != null)
                                                                    {{ $model['rules']->rule }}
                                                                @endif
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" id="modal_rules_btn_update"
                                                    class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-outline-danger"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="modal_create_rules" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title font-weight-bold">Buat Aturan Konsultasi untuk Konselor
                                            </h3>
                                            <button class="close pl-3" type="button" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="rules_form_validation" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="">
                                                        <label for="description"><b>Aturan </b><span
                                                                class="required-label">*</span></label>
                                                        <div>
                                                            <textarea id="summernote_create" name="rule_create" placeholder="Masukan Aturan disini" required>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" id="modal_rules_btn_create"
                                                    class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-outline-danger"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
        var id_menu = "{{ $model['menu_id'] }}";
        var rules_endpoint = "{{ $model['rules_url'] }}";

        var table = null;
        var root_active_table = '#root_active_table';
        var table_id = '#table_view';
        var modal_form = '#modal_add_form'

        var table_nonactive = null;
        var root_nonactive_table = '#root_nonactive_table';
        var table_view_nonactive = '#table_view_nonactive';

        var btn_edit_counselor = "#btn_edit_counselor";
        var edit_form_validation = "#edit_form_validation";

        var modal_create_rules = "#modal_create_rules";
        var modal_edit_rules = "#modal_edit_rules";
        var modal_rules_btn_create = "#modal_rules_btn_create";
        var modal_rules_btn_update = "#modal_rules_btn_update";
        var modal_rules_btn_delete = "#modal_rules_btn_delete";
        var rules_form_validation = "#rules_form_validation";

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
                    data: 'nama_lengkap',
                    name: 'nama_lengkap',
                    render: function(data, type, row) {
                        return '<p class="mb-1 mt-1 col-red" style="font-size: 12px; min-width: 6rem"><strong>' +
                            row['nama_lengkap'] +
                            '</strong></p>';
                    }
                },
                {
                    data: 'expertise',
                    name: 'expertise',
                    render: function(data, type, row) {
                        return '<p class="mb-1 mt-1 col-red" style="font-size: 12px; min-width: 6rem"><strong>' +
                            row['expertise'] +
                            '</strong></p>';
                    }
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['jenis_kelamin'] +
                            '</strong>';
                    }
                },
                {
                    data: 'education',
                    name: 'education',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['education'] +
                            '</strong>';
                    }
                },
                {
                    data: 'pekerjaan',
                    name: 'pekerjaan',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['pekerjaan'] +
                            '</strong>';
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        return '<p class="mb-1 mt-1 col-red" style="font-size: 12px; min-width: 6rem"><strong>' +
                            row['name'] +
                            '</strong></p>';
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
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        var date = toLocaleDate(row['created_at']);
                        var time = toLocaleTime(row['created_at']);
                        return '<p class="mt-1 mb-1 col-red" style="font-size: 12px; min-width: 5.2rem"><strong>' +
                            date + ' ' + time + '</strong></p>';
                    }
                },
            ];
            var actionActive = [{
                data: 'id',
                name: 'action',
                render: function(data, type, row) {
                    return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="Ubah" class="btn btn-link btn-danger" data-original-title="Ubah" onclick="editExpertise(' +
                        row['id'] + ')"><i class="fa fa-edit"></i></button> <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert(' +
                        row['id'] + ')"><i class="fa fa-times"></i></button> </div>';
                }
            }];
            var actionNonActive = [{
                data: 'id',
                name: 'action',
                render: function(data, type, row) {
                    return '<div class="form-button-action">' +
                        '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success" data-original-title="Restore"' +
                        `onclick="restoreAlert('${row['id']}')">` +
                        '<i class="fa fa-history"></i></button></div>';
                }
            }];

            table = initDataTableLoad(table_id, base_endpoint + 'create', createColumnsAny(columnsData.concat(
                actionActive)));
            table_nonactive = initDataTableLoad(table_view_nonactive, base_endpoint + 'nonactive',
                createColumnsAny(
                    columnsData.concat(actionNonActive)));
            $(modal_form).on('hidden.bs.modal', function(e) {
                $(this).find('form').trigger('reset');
            })
            $(modal_edit_rules).on('shown.bs.modal', function() {
                $('#summernote_edit').summernote();
            })
            $(modal_create_rules).on('shown.bs.modal', function() {
                $('#summernote_create').summernote();
            })
            $(modal_rules_btn_update).click(function(e) {
                saveEditRules(e);
            });
            $(modal_rules_btn_create).click(function(e) {
                createRules(e);
            });
            $(modal_rules_btn_delete).click(function(e) {
                deleteRules(e);
            });
            $(btn_edit_counselor).click(function(e) {
                saveEditExpertise();
            });
        });

        function saveEditExpertise() {
            var valid = $(edit_form_validation).valid();
            if (valid) {
                var id = $("#edit_binding_id").val();
                var id_user = $("#edit_id_user").val();
                var id_stakeholder = $("#edit_id_stakeholder").val();
                var expertise = $("#edit_expertise").val();
                var body = {
                    "_token": token,
                    "id": id,
                    "id_user": id_user,
                    "id_stakeholder": id_stakeholder,
                    "expertise": expertise,
                };

                var endpoint = base_endpoint + id;
                showDialogConfirmationAjax('#modal_edit_counselor', 'Apakah anda yakin akan mengupdate data?',
                    'Update data berhasil!', endpoint, 'PUT', body, table_id);
            }
        }

        function editExpertise(id) {
            $.get(base_endpoint + id + '/edit', function(data) {
                $('#modal_edit_counselor').modal('show');
                $('#edit_binding_id').val(data.data.id);
                $('#edit_id_user').val(data.data.id_user);
                $('#edit_nama_user').text("Nama Lengkap : " + data.data.nama_lengkap);
                $('#edit_id_stakeholder').val(data.data.id_stakeholder);
                $('#edit_nama_stakeholder').text("Nama Lembaga : " + data.data.nama_stakeholder);
                $('#edit_expertise').val(data.data.expertise);
            })
        }

        function deleteRules() {
            var id = $("#rules_edit_binding_id").val();
            var endpoint = rules_endpoint + '/' + id;

            var body = {
                "id": id,
                "_token": token,
            }

            showDialogConfirmationAjax(modal_edit_rules, 'Apakah anda yakin akan menghapus aturan?',
                'Aturan berhasil dihapus!',
                endpoint, 'DELETE', body, table_id, true);
        }

        function createRules() {
            var valid = $(rules_form_validation).valid();
            if (valid) {
                var rule = $("#summernote_create").val();
                var body = {
                    "_token": token,
                    "id_menu": id_menu,
                    "rule": rule,
                };
                console.log(body);
                var endpoint = rules_endpoint;
                showDialogConfirmationAjax(modal_create_rules, 'Apakah anda yakin akan membuat aturan?',
                    'Aturan berhasil disimpan!', endpoint, 'POST', body, table_id, true);
            }
        }

        function saveEditRules() {
            var valid = $(rules_form_validation).valid();
            if (valid) {
                var id = $("#rules_edit_binding_id").val();
                var rule = $("#summernote_edit").val();
                var body = {
                    "_token": token,
                    "id": id,
                    "rule": rule,
                };

                var endpoint = rules_endpoint + '/' + id;
                showDialogConfirmationAjax(modal_edit_rules, 'Apakah anda yakin akan memperbaharui aturan?',
                    'Aturan berhasil diperbaharui!', endpoint, 'PUT', body, table_id, true);
            }
        }

        function onChangeStatus(status) {
            if (status === "active") {
                $(root_active_table).attr("class", "d-block table-responsive");
                $(root_nonactive_table).attr("class", "d-none table-responsive");
                $("#section_titile").html("Data Konselor Aktif")
                $("#btn_status").html("<i class='fas fa-user-slash mr-1'></i>KONSELOR NONAKTIF");
                $("#btn_status").attr("onclick", "onChangeStatus('nonactive')");
                $("#btn_add_data").toggleClass("d-none");
                loadTable(table_id);
            }
            if (status == "nonactive") {
                $(root_active_table).attr("class", "d-none table-responsive");
                $(root_nonactive_table).attr("class", "d-block table-responsive");
                $("#section_titile").html("Data Konselor Non-aktif");
                $("#btn_status").html("<i class='fas fa-user mr-1'></i>KONSELOR AKTIF");
                $("#btn_status").attr("onclick", "onChangeStatus('active')");
                $("#btn_add_data").toggleClass("d-none");
                loadTable(table_view_nonactive);
            }
        }

        function deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menon-aktifkan konselor?',
                'Konselor berhasil dinon-aktifkan!',
                base_endpoint + id, 'DELETE', body, table_id);
        }

        function restoreAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan mengaktifkan konselor?',
                'Konselor berhasil diaktifkan kembali!',
                base_endpoint + 'restore/' + id, 'PATCH', body, table_view_nonactive);
        }
    </script>
@endsection
