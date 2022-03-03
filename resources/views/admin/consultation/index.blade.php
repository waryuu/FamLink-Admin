@extends('layouts.base')
@section('title', 'Master Konsultasi')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Master Konsultasi</h4>
            </div>
            <div class="d-flex mb-3">
                <button type="button" class="mr-1 btn btn-primary" id="public_text_section"
                    onclick="showSectionConsultation('public')">
                    PUBLIC</button>
                <button type="button" class="ml-1 btn btn-outline-primary" id="private_text_section"
                    onclick="showSectionConsultation('private')">
                    PRIVAT</button>
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
            <div class="row" id="public_consultation">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Konsultasi Publik</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_view_public" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Judul</th>
                                            <th>Status Jawaban</th>
                                            <th>Konselor</th>
                                            <th>Lembaga</th>
                                            <th>Created At</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Judul</th>
                                            <th>Status Jawaban</th>
                                            <th>Konselor</th>
                                            <th>Lembaga</th>
                                            <th>Created At</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_show_consultation" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="title_consultation" i="modal_title_consultation"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <p id="content_consultation" class="text-justify"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="private_consultation" style="display: none;">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Konsultasi Private</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_view_private" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Judul</th>
                                            <th>Status Jawaban</th>
                                            <th>Konselor</th>
                                            <th>Lembaga</th>
                                            <th>Created At</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Judul</th>
                                            <th>Status Jawaban</th>
                                            <th>Konselor</th>
                                            <th>Lembaga</th>
                                            <th>Created At</th>
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
        var firebase_endpoint = "{{ $model['firebase_url'] }}";

        var table_public = null;
        var table_private = null;
        var table_id_public = '#table_view_public';
        var table_id_private = '#table_view_private';

        var modal_show_consultation = "#modal_show_consultation";
        var section_public_consultation = document.getElementById("public_consultation");
        var section_private_consultation = document.getElementById("private_consultation");
        var currentSection = "public";

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
                    data: 'title',
                    name: 'title',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['title'] +
                            '</strong>';
                    }
                },
                {
                    data: 'is_replied',
                    name: 'is_replied',
                    render: function(data, type, row) {
                        var textTag = '<strong class="col-red text-center">'
                        if (row['is_replied'] == 1) {
                            textTag += 'Sudah</strong>';
                        } else {
                            textTag += 'Belum</strong>';
                        }
                        var buttonNotif =
                            `<button class="btn btn-primary" ${row['is_replied'] == 1 ? 'disabled' : ''} onclick='sendNotification("${row['kode_konselor']}", "${row['nama_lengkap']}", "${row['title']}")'><i class="fa-solid fa-comment-arrow-up-right"></i>Kirim Notifikasi</button>`;
                        return `<div class="mt-2 mb-3">${textTag + buttonNotif}</div>`;
                    }
                },
                {
                    data: 'nama_konselor',
                    name: 'nama_konselor',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['nama_konselor'] +
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
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['created_at'] +
                            '</strong>';
                    }
                },
                {
                    data: 'id',
                    name: 'action',
                    render: function(data, type, row) {
                        return `<div class="form-button-action">
                          <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success" data-original-title="Lihat"
                            onclick="showData(${row['id']})">
                            <i class="fa fa-eye"></i>
                          </button>
                          <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" 
                            onclick="deleteAlert(${row['id']})">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>`;
                    }
                }
            ];
            var columns = createColumnsAny(columnsData);
            table_public = initDataTableLoad(table_id_public, base_endpoint + 'public', columns);
            table_private = initDataTableLoad(table_id_private, base_endpoint + 'private', columns);
            $(modal_show_consultation).click(function(e) {
                showData(e);
            });
        });

        function showSectionConsultation(type) {
            if (type === "public") {
                currentSection = "public"
                section_public_consultation.style.display = "block";
                document.getElementById("public_text_section").className = "mr-1 btn btn-primary";
                document.getElementById("private_text_section").className = "ml-1 btn btn-outline-primary";
                section_private_consultation.style.display = "none";
            } else {
                currentSection = "private"
                section_public_consultation.style.display = "none";
                document.getElementById("private_text_section").className = "ml-1 btn btn-primary";
                document.getElementById("public_text_section").className = "mr-1 btn btn-outline-primary";
                section_private_consultation.style.display = "block";
            }
        }

        function sendNotification(kodeKonselor, namaUser, title) {
            var isKodeExist = kodeKonselor !== "null";
            var typeConsultation = isKodeExist ? "privat" : "publik";
            var body = {
                "_token": token,
                "to": "",
                "data": {
                    "title": `${namaUser} Menunggu Jawabanmu`,
                    "body": `Konsultasi ${typeConsultation} berjudul ${title} belum kamu jawab nih, Yuk segera jawab!`
                }
            }
            body['to'] = isKodeExist ? "/topics/USER_" + kodeKonselor : "/topics/COUNSELOR";
            showDialogSendNotificationAjax(firebase_endpoint, body, isKodeExist ? table_id_private : table_id_public);
        }

        function showData(id) {
            $.get(base_endpoint + "id" + "/" + id, function(responseText) {
                $("#title_consultation").html(responseText.title);
                $("#content_consultation").html(responseText.content);
                $('#modal_show_consultation').modal('show');
            });
        }

        function deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }

            var target_table_id = currentSection === "public" ? table_id_public : table_id_private
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!',
                base_endpoint + id, 'DELETE', body, target_table_id);
        }
    </script>
@endsection
