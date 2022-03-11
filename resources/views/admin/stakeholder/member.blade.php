@extends('layouts.base')
@section('title', 'Master Stakeholder')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Master Stakeholder</h4>
            </div>
            <div id='chip_section' class='mb-4'>
                <a href='/admin/stakeholder'>
                    <button type="button" class='btn btn-outline-primary btn-rounded'>
                        LEMBAGA
                    </button>
                </a>
                <button type="button" class='btn btn-primary btn-rounded ml-1'>
                    ANGGOTA
                </button>
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
                                <h4 id="section_title" class="card-title">Daftar Anggota Aktif</h4>
                                <button class="btn btn-secondary btn-round ml-auto" id='btn_nonactive_members'
                                    onclick="onChangeTableStatus('nonactive')" style='display: block;'>
                                    <i class="fas fa-user-slash mr-1"></i>
                                    PENGGUNA NON AKTIF
                                </button>
                                <button class="btn btn-secondary btn-round ml-auto" id='btn_active_members'
                                    onclick="onChangeTableStatus('active')" style='display: none;'>
                                    <i class="fas fa-user mr-1"></i>
                                    PENGGUNA AKTIF
                                </button>
                                <button class="btn btn-primary btn-round ml-2" data-toggle="modal"
                                    data-target="#modal_add_form" id="btn_add_data">
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

                                        <form id="form_validation" action="{{ '/admin/stakeholder/members' }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="p-0 form-group form-show-validation w-100">
                                                    <div class="w-100">
                                                        <label for="parent_header">
                                                            ID Pengguna <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="search" autoComplete="on"
                                                            style="width: 100%" list="user_list" id="id_user" name="id_user"
                                                            required />
                                                        <datalist id="user_list">
                                                            @foreach ($model['users'] as $item)
                                                                <option value="{{ $item->id }}" style="width: 100%">
                                                                    {{ $item->nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            ID Lembaga <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="search" autoComplete="on"
                                                            list="stakeholder_list" id="id_stakeholder" style="width: 100%"
                                                            name="id_stakeholder" required />
                                                        <datalist id="stakeholder_list">
                                                            @foreach ($model['stakeholders'] as $item)
                                                                <option value="{{ $item->id }}" style="width: 100%">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Posisi Anggota Baru <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" id="position"
                                                            name="position" required />
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
                            <div id="root_table_id" class="table-responsive" style='display:block;'>
                                <table id="table_view" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th style="width: 12%">Nama lengkap</th>
                                            <th style='width: 7%'>JK</th>
                                            <th>Lembaga</th>
                                            <th>Fokus</th>
                                            <th>Posisi</th>
                                            <th>Pekerjaan</th>
                                            <th>Pendidikan</th>
                                            <th>Created at</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th style="width: 12%">Nama lengkap</th>
                                            <th style='width: 7%'>JK</th>
                                            <th>Lembaga</th>
                                            <th>Fokus</th>
                                            <th>Posisi</th>
                                            <th>Pekerjaan</th>
                                            <th>Pendidikan</th>
                                            <th>Created at</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="root_table_id_nonactive" class="table-responsive" style="display:none;">
                                <table id="table_view_nonactive" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th style="width: 12%">Nama lengkap</th>
                                            <th style='width: 7%'>JK</th>
                                            <th>Lembaga</th>
                                            <th>Fokus</th>
                                            <th>Posisi</th>
                                            <th>Pekerjaan</th>
                                            <th>Pendidikan</th>
                                            <th>Created at</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th style="width: 12%">Nama lengkap</th>
                                            <th style='width: 7%'>JK</th>
                                            <th>Lembaga</th>
                                            <th>Fokus</th>
                                            <th>Posisi</th>
                                            <th>Pekerjaan</th>
                                            <th>Pendidikan</th>
                                            <th>Created at</th>
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
        var table_nonactive = null;
        var table_id = '#table_view';
        var table_id_nonactive = '#table_view_nonactive';
        var root_table_id = "#root_table_id";
        var root_table_id_nonactive = "#root_table_id_nonactive";
        var modal_form = '#modal_add_form';

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
                    data: 'name_stakeholder',
                    name: 'name_stakeholder',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row[
                                'name_stakeholder'] +
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
                    data: 'position',
                    name: 'position',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['position'] +
                            '</strong>';
                    }
                },
                {
                    data: 'pekerjaan',
                    name: 'pekerjaan',
                    render: function(data, type, row) {
                        return '<strong class="text-capitalize col-red" style="font-size: 12px">' + row[
                                'pekerjaan'].toLowerCase() +
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
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + toLocaleDate(row[
                                'created_at']) + ' ' + toLocaleTime(row[
                                'created_at']) +
                            '</strong>';
                    }
                },
            ];
            var action_active = [{
                data: 'id',
                name: 'action',
                render: function(data, type, row) {
                    return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert(' +
                        row['id'] + ')"><i class="fa fa-times"></i></button></div>';
                }
            }];
            var action_nonactive = [{
                data: 'id',
                name: 'action',
                render: function(data, type, row) {
                    return '<div class="form-button-action ">' +
                        '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success"' +
                        `data-original-title="Restore" onclick="restoreAlert(${row['id']})">` +
                        '<i class="fa fa-history"></i></button>';
                }
            }];
            table = initDataTableLoad(table_id, base_endpoint + 'create', createColumnsAny(columnsData.concat(
                action_active)));
            table_nonactive = initDataTableLoad(table_id_nonactive, base_endpoint + 'nonactive', createColumnsAny(
                columnsData.concat(action_nonactive)));
            $(modal_form).on('hidden.bs.modal', function(e) {
                $(this).find('form').trigger('reset');
            })
        });

        function onChangeTableStatus(state) {
            if (state == 'active') {
                loadTable(table_id);
                $("#section_title").html("Daftar Anggota Aktif");
                $('#btn_nonactive_members').attr('style', 'display: block;');
                $('#btn_active_members').attr('style', 'display: none;');
                $('#btn_add_data').attr('style', 'display: block;');
                $(root_table_id).attr('style', 'display: block;');
                $(root_table_id_nonactive).attr('style', 'display: none;');
            }
            if (state == 'nonactive') {
                loadTable(table_id_nonactive);
                $("#section_title").html("Daftar Anggota Non-aktif");
                $('#btn_nonactive_members').attr('style', 'display: none;');
                $('#btn_active_members').attr('style', 'display: block;');
                $('#btn_add_data').attr('style', 'display: none;');
                $(root_table_id).attr('style', 'display: none;');
                $(root_table_id_nonactive).attr('style', 'display: block;');
            }
            return;
        }

        function deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menonaktifkan anggota?',
                'Anggota berhasil dinon-aktifkan!',
                base_endpoint + id, 'DELETE', body, table_id);
        }

        function restoreAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan mengaktifkan anggota?',
                'Anggota berhasil diaktifkan kembali!',
                base_endpoint + 'restore/' + id, 'PATCH', body, table_id_nonactive);
        }
    </script>
@endsection
