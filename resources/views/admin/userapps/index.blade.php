@extends('layouts.base')
@section('title', 'Laporan Pengguna Aplikasi')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Laporan Pengguna Aplikasi</h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <img src="https://www.famlink.id/assets/img/logo.png" width="100px">
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Registrasi Pengguna</p>
                                        <h4 class="card-title">{{ $model['total'] }} Akun</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="display:none">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Pengguna Registrasi</div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="display:none">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Persentase Jenis Kelamin</div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="pieChart" style="width: 100%; height: 100%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <a href="{{ $model['base_url'] }}download/excel">
                                    <button class="btn btn-success btn-round ml-auto">
                                        <i class="fa fa-download"></i>
                                        Download Data
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
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="form_validation" action="{{ $model['base_url'] }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row">
                                                        <label for="title" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama
                                                            User Apps <span class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Masukan Nama Banner" required>
                                                        </div>
                                                    </div>
                                                    <div class="separator-solid"></div>
                                                    <div class="form-group form-show-validation row">
                                                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Icon <span
                                                                class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <div class="input-file input-file-image">
                                                                <img class="img-upload-preview img-circle" width="100"
                                                                    height="100" src="http://placehold.it/100x100"
                                                                    alt="preview">
                                                                <input type="file" class="form-control form-control-file"
                                                                    id="image" name="image" accept="image/*" required>
                                                                <label for="image"
                                                                    class="btn btn-primary bg-primary btn-round btn-lg"><i
                                                                        class="fa fa-file-image"></i> Upload a Image</label>
                                                            </div>
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
                                                    Update
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
                                        <form id="edit_form_validation" action="/menu" method="POST">
                                            @csrf
                                            <input type="hidden" id="edit_binding_id" name="edit_binding_id" value="">
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group form-show-validation row">
                                                        <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Nama
                                                            Role <span class="required-label">*</span></label>
                                                        <div class="col-12">
                                                            <input type="text" class="form-control" id="edit_name"
                                                                name="name" placeholder="Masukan Nama Role" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" id="modal_edit_btn_update"
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
                                            <th style="width: 5%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Agama</th>
                                            <th>Pekerjaan</th>
                                            <th>Pendidikan</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten</th>
                                            <th>Tanggal Registrasi</th>
                                            <th style="width: 5%"></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Agama</th>
                                            <th>Pekerjaan</th>
                                            <th>Pendidikan</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten</th>
                                            <th>Tanggal Registrasi</th>
                                            <th></th>
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
                        return '<strong class=" col-red" style="font-size: 12px; text-transform: uppercase;">' +
                            row['nama_lengkap'] + '</strong>';
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
                    data: 'tanggal_lahir',
                    name: 'tanggal_lahir',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + getAge(row[
                            'tanggal_lahir']) + '</strong>';
                    }
                },
                {
                    data: 'agama',
                    name: 'agama',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['agama'] +
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
                    data: 'education',
                    name: 'education',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['education'] +
                            '</strong>';
                    }
                },
                {
                    data: 'provinsi_ket',
                    name: 'provinsi_ket',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['provinsi_ket'] +
                            '</strong>';
                    }
                },
                {
                    data: 'kabupaten_ket',
                    name: 'kabupaten_ket',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['kabupaten_ket'] +
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
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert(' +
                            row['id'] + ')"><i class="fa fa-times"></i></button></div>';
                    }
                }
            ];
            table = datatable(table_id, base_endpoint + 'datatable/list', columnsData, [
                [0, "desc"]
            ]);
            FormValidation(formId, rulesForm);
            FormValidation(formEditId, rulesFormEdit);
            $(modalEditButtonId).click(function(e) {
                setEditAction();
            });

            var lineChart = document.getElementById('lineChart').getContext('2d'),
                pieChart = document.getElementById('pieChart').getContext('2d');

            var myLineChart = new Chart(lineChart, {
                type: 'line',
                data: {
                    labels: <?php echo $model['chart_user_date']; ?>,
                    datasets: [{
                        label: "User Registrasi",
                        borderColor: "#1d7af3",
                        pointBorderColor: "#FFF",
                        pointBackgroundColor: "#1d7af3",
                        pointBorderWidth: 2,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 1,
                        pointRadius: 4,
                        backgroundColor: 'transparent',
                        fill: true,
                        borderWidth: 2,
                        data: <?php echo $model['chart_user_jumlah']; ?>
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            fontColor: '#1d7af3',
                        }
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode: "nearest",
                        intersect: 0,
                        position: "nearest",
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10
                    },
                    layout: {
                        padding: {
                            left: 15,
                            right: 15,
                            top: 15,
                            bottom: 15
                        }
                    }
                }
            });

            var _data_chart_pekerjaan_title = <?php echo $model['chart_pekerjaan_jumlah']; ?>;

            var coloR = [];

            for (var i in _data_chart_pekerjaan_title) {
                coloR.push('#' + Math.floor(Math.random() * 16777215).toString(16));
            }

            var myPieChart = new Chart(pieChart, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: <?php echo $model['chart_pekerjaan_jumlah']; ?>,
                        backgroundColor: coloR,
                        borderWidth: 0
                    }],
                    labels: <?php echo $model['chart_pekerjaan_data']; ?>
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    pieceLabel: {
                        render: 'percentage',
                        fontColor: 'white',
                        fontSize: 14,
                    },
                }
            });


        });


        function datatable(view_id, endpoint, columns, order) {
            return $(view_id).DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                processing: true,
                serverSide: true,
                fixedColumns: true,
                order: order,
                pageLength: 10,
                ajax: endpoint,
                columns: columns,
            });
        }

        function formValidation(viewId, rules) {
            $(viewId).validate({
                validClass: "success",
                rules: rules,
                highlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                success: function(element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
            });
        }

        function random_rgba() {
            var o = Math.round,
                r = Math.random,
                s = 255;
            return 'rgba(' + o(r() * s) + ',' + o(r() * s) + ',' + o(r() * s) + ',' + r().toFixed(1) + ')';
        }


        function deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!',
                base_endpoint + id, 'DELETE', body, table_id);
        }

        function editData(id) {
            $.get(base_endpoint + id + '/edit', function(data) {
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
                showDialogConfirmationAjax('#modal_edit_form', 'Apakah anda yakin akan mengupdate data?',
                    'Update data berhasil!', endpoint, 'PUT', body, table_id);
            }
        }

        function getAge(time) {
            var MILLISECONDS_IN_A_YEAR = 1000 * 60 * 60 * 24 * 365;
            var date_array = time.split('-')
            var years_elapsed = (new Date() - new Date(date_array[0], date_array[1], date_array[2])) / (
                MILLISECONDS_IN_A_YEAR);
            return parseInt(years_elapsed);
        }
    </script>
@endsection
