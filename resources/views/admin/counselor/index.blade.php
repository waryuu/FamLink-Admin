@extends('layouts.base')
@section('title', 'Master Konselor')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Master Konselor</h4>
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
                                            <th style="width: 7%">JK</th>
                                            <th>Edukasi</th>
                                            <th>Pekerjaan</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Fokus</th>
                                            <th>Created At</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th style="width: 7%">JK</th>
                                            <th>Edukasi</th>
                                            <th>Pekerjaan</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Fokus</th>
                                            <th>Created At</th>
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
                                            <th style="width: 7%">JK</th>
                                            <th>Edukasi</th>
                                            <th>Pekerjaan</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Fokus</th>
                                            <th>Created At</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th style="width: 7%">JK</th>
                                            <th>Edukasi</th>
                                            <th>Pekerjaan</th>
                                            <th>Nama Stakeholder</th>
                                            <th>Fokus</th>
                                            <th>Created At</th>
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

                                        <form id="form_validation" action="{{ '/admin/counselor' }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row w-100">
                                                        <div id="user_selection" class="row w-100">
                                                            <label for="parent_header">
                                                                Pilih pengguna <span class="required-label">*</span>
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
                                                        <div id="stakeholder_selection" class="row w-100 mt-4">
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
        var root_active_table = '#root_active_table';
        var table_id = '#table_view';
        var modal_form = '#modal_add_form'

        var table_nonactive = null;
        var root_nonactive_table = '#root_nonactive_table';
        var table_view_nonactive = '#table_view_nonactive';

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
                        return '<strong class=" col-red" style="font-size: 12px">' + row['nama_lengkap'] +
                            '</strong>';
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
                        return '<strong class=" col-red" style="font-size: 12px">' + row['name'] +
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
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['created_at'] +
                            '</strong>';
                    }
                },
            ];
            var actionActive = [{
                data: 'id',
                name: 'action',
                render: function(data, type, row) {
                    return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert(' +
                        row['id'] + ')"><i class="fa fa-times"></i></button></div>';
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
        });

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
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menon-aktifkan konselor?', 'Konselor berhasil dinon-aktifkan!',
                base_endpoint + id, 'DELETE', body, table_id);
        }

        function restoreAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan mengaktifkan konselor?', 'Konselor berhasil diaktifkan kembali!',
                base_endpoint + 'restore/' + id, 'PATCH', body, table_view_nonactive);
        }
    </script>
@endsection
