@extends('layouts.base')
@section('title', 'Master Konsultasi')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Master Konsultasi</h4>
            </div>
            <div class="d-flex mb-3">
                <button type="button" class="mr-1 btn btn-rounded btn-primary" id="public_text_section"
                    onclick="showSectionConsultation('public')">
                    PUBLIC</button>
                <button type="button" class="ml-1 mr-auto btn btn-rounded btn-outline-primary" id="private_text_section"
                    onclick="showSectionConsultation('private')">
                    PRIVAT</button>
                <a href="#" class="text-light">
                    @if ($model['rules'] == null)
                        <button type="button" class='ml-1 btn btn-rounded btn-secondary' id='rules_section'
                            data-toggle="modal" data-target="#modal_create_rules">
                            <i class="fa fa-book mr-1" aria-hidden="true"></i>
                            <span>BUAT ATURAN</span>
                        </button>
                    @else
                        <button type="button" class='ml-1 btn btn-rounded btn-secondary' id='rules_section'
                            data-toggle="modal" data-target="#modal_edit_rules">
                            <i class="fa fa-book mr-1" aria-hidden="true"></i>
                            <span>ATURAN TERSIMPAN</span>
                        </button>
                    @endif
                </a>
                <a href="consultation/trash" class="text-light">
                    <button type="button" class='ml-1 btn btn-rounded btn-secondary' id='deleted_text_section'>
                        <i class="fa fa-trash mr-1" aria-hidden="true"></i>
                        <span>SAMPAH</span>
                    </button>
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
                                            <th>Nama lengkap</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Untuk umum?</th>
                                            <th>Ditutup oleh</th>
                                            <th>Waktu ditutup</th>
                                            <th>Waktu dibuat</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama lengkap</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Untuk umum?</th>
                                            <th>Ditutup oleh</th>
                                            <th>Waktu ditutup</th>
                                            <th>Waktu dibuat</th>
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
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <span id="writer_date_consultation" class='text-muted'></span>
                                <h5 class="modal-title font-weight-bold" id="title_consultation"
                                    i="modal_title_consultation"></h5>
                            </div>
                            <div class='ml-auto d-flex flex-row' id='action_show_consultation'>
                                <button class="close pl-3" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        <div id="content_consultation" class="modal-body pb-0 text-justify"></div>
                        <hr id='divider_replies' class='w-100 mt-2 mb-2 border-top' />
                        <div id="replies_consultation" class='pt-0 pb-4 modal-body text-justify'></div>
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
                                            <th>Nama lengkap</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Konselor</th>
                                            <th>Lembaga</th>
                                            <th>Ditutup oleh</th>
                                            <th>Waktu ditutup</th>
                                            <th>Waktu dibuat</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama lengkap</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Konselor</th>
                                            <th>Lembaga</th>
                                            <th>Ditutup oleh</th>
                                            <th>Waktu ditutup</th>
                                            <th>Waktu dibuat</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_edit_rules" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h3 class="modal-title font-weight-bold">Ubah Aturan Konsultasi</h3>
                            <div class="action-button">
                                <button type="button" id="modal_rules_btn_delete" class='ml-1 btn btn-rounded btn-secondary'>
                                    <i class="fa fa-trash mr-1" aria-hidden="true"></i>
                                    <span>Hapus Aturan</span>
                                </button>
                                <button class="close pl-3" type="button" data-dismiss="modal" aria-label="Close">
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
                                        <label for="description"><b>Aturan </b><span class="required-label">*</span></label>
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
                                <button type="button" id="modal_rules_btn_update" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_create_rules" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title font-weight-bold">Buat Aturan Konsultasi</h3>
                            <button class="close pl-3" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="rules_form_validation" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="">
                                        <label for="description"><b>Aturan </b><span class="required-label">*</span></label>
                                        <div>
                                            <textarea id="summernote_create" name="rule_create" placeholder="Masukan Aturan disini" required>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" id="modal_rules_btn_create" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
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
        var id_menu = "{{ $model['menu_id'] }}";
        var rules_endpoint = "{{ $model['rules_url'] }}";

        var table_public = null;
        var table_private = null;
        var table_id_public = '#table_view_public';
        var table_id_private = '#table_view_private';

        var modal_show_consultation = "#modal_show_consultation";
        var section_public_consultation = document.getElementById("public_consultation");
        var section_private_consultation = document.getElementById("private_consultation");
        var repliesContainer = document.getElementById('replies_consultation');
        var dividerReplies = document.getElementById('divider_replies');
        var currentSection = "public";

        var modal_create_rules = "#modal_create_rules";
        var modal_edit_rules = "#modal_edit_rules";
        var modal_rules_btn_create = "#modal_rules_btn_create";
        var modal_rules_btn_update = "#modal_rules_btn_update";
        var modal_rules_btn_delete = "#modal_rules_btn_delete";
        var rules_form_validation = "#rules_form_validation";

        $(document).ready(function() {
            var firstColumn = [{
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
                    data: 'state',
                    name: 'state',
                    render: function(data, type, row) {
                        var textTag = '<strong class="col-red text-center" style="font-size: 12px">';
                        var kodeForNotified = row['kode_user'];
                        var nameForNotified = row['nama_konselor'];
                        if (row['state'] == 'closed') textTag += 'Ditutup</strong>';
                        if (row['state'] == 'waiting_user') textTag += 'Menunggu pengguna</strong>';
                        if (row['state'] == 'waiting_counselor') {
                            textTag += 'Menunggu konselor</strong>';
                            kodeForNotified = row['kode_konselor'];
                            nameForNotified = row['nama_lengkap'];
                        }
                        var buttonNotif =
                            `<button class="mt-1 btn btn-primary" ${row['state'] == 'closed' ? 'disabled' : ''} onclick='sendNotification("${kodeForNotified}", "${nameForNotified}", "${row['title']}", "${row['state']}", "${row['type']}")'><i class="fa-solid fa-comment-arrow-up-right"></i>Kirim Notifikasi</button>`;
                        return `<div class="mt-2 mb-3 text-center">${textTag + buttonNotif}</div>`;
                    }
                }
            ];
            var publicColumns = [{
                data: 'open_to_all',
                name: 'open_to_all',
                render: function(data, type, row) {
                    var isNotOpen = row['open_to_all'] == 0;
                    var isClosed = row['closed_at'] != null;
                    var text =
                        `<strong class="col-red" style="font-size: 12px">${isNotOpen ? 'Tidak' : 'Terbuka'}</strong>`;
                    var action =
                        `<button type='button' ${isClosed ? 'disabled' : ''} class='mt-1 btn btn-primary ${isNotOpen ? 'btn-primary' : 'btn-secondary'}' onclick='doOpenPublicConsultation(${row['id']}, ${row['open_to_all']})'>${isNotOpen ? 'Buka' : 'Tutup'}</button>`;
                    return `<div class="mt-2 mb-3 text-center">${text + action}</div>`;
                }
            }];
            var privateColumns = [{
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
                }
            ];
            var lastColumn = [{
                    data: 'role_who_closed',
                    name: 'role_who_closed',
                    render: function(data, type, row) {
                        return row['role_who_closed'] === null ?
                            '<strong class="col-red" style="font-size: 12px">—</strong>' :
                            `<strong class="text-capitalize col-red" style="font-size: 12px">${row['role_who_closed']}</strong>`;
                    }
                },
                {
                    data: 'closed_at',
                    name: 'closed_at',
                    render: function(data, type, row) {
                        var date = toLocaleDate(row['closed_at']);
                        var time = toLocaleTime(row['closed_at']);
                        return `<strong class=" col-red" style="font-size: 12px">${row['closed_at'] === null ? '—' : `${date}, ${time}`}</strong>`;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        var date = toLocaleDate(row['created_at']);
                        var time = toLocaleTime(row['created_at']);
                        return `<strong class=" col-red" style="font-size: 12px">${date}, ${time}</strong>`;
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

            table_public = initDataTableLoad(table_id_public, base_endpoint + 'public',
                firstColumn.concat(publicColumns.concat(lastColumn)));
            table_private = initDataTableLoad(
                table_id_private, base_endpoint + 'private',
                firstColumn.concat(privateColumns.concat(lastColumn)));
            $(modal_show_consultation).click(function(e) {
                showData(e);
            });
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
        });

        function deleteRules() {
            var id = $("#rules_edit_binding_id").val();
            var endpoint = rules_endpoint + '/' + id;

            var body = {
                "id": id,
                "_token": token,
            }

            var target_table_id = currentSection === "public" ? table_id_public : table_id_private
            showDialogConfirmationAjax(modal_edit_rules, 'Apakah anda yakin akan menghapus aturan?', 'Aturan berhasil dihapus!',
                endpoint, 'DELETE', body, target_table_id, true);
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

                var endpoint = rules_endpoint;
                var target_table_id = currentSection === "public" ? table_id_public : table_id_private

                showDialogConfirmationAjax(modal_create_rules, 'Apakah anda yakin akan membuat aturan?',
                    'Aturan berhasil disimpan!', endpoint, 'POST', body, target_table_id, true);
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
                var target_table_id = currentSection === "public" ? table_id_public : table_id_private
                showDialogConfirmationAjax(modal_edit_rules, 'Apakah anda yakin akan memperbaharui aturan?',
                    'Aturan berhasil diperbaharui!', endpoint, 'PUT', body, target_table_id, true);
            }
        }

        function doOpenPublicConsultation(id, status) {
            var endpoint = `${base_endpoint + id}/${status === 0 ? 'open_user' : 'close_user'}`;
            var message = status === 0 ? 'membuka' : 'menutup';
            var feedback = status === 0 ? 'dibuka' : 'ditutup';

            var body = {
                "id": id,
                "_token": token,
            }
            var target_table_id = currentSection === "public" ? table_id_public : table_id_private

            showDialogConfirmationAjax(null, `Apakah anda yakin akan ${message} konsultasi untuk pengguna umum?`,
                `Konsultasi berhasil ${feedback} untuk umum!`,
                endpoint, 'patch', body, target_table_id);
        }

        function showSectionConsultation(type) {
            if (type === "public") {
                currentSection = "public"
                section_public_consultation.style.display = "block";
                document.getElementById("public_text_section").className = "mr-1 btn btn-rounded btn-primary";
                document.getElementById("private_text_section").className =
                    "ml-1 mr-auto btn btn-rounded btn-outline-primary";
                section_private_consultation.style.display = "none";
            } else {
                currentSection = "private"
                section_public_consultation.style.display = "none";
                document.getElementById("private_text_section").className = "ml-1 mr-auto btn btn-rounded btn-primary";
                document.getElementById("public_text_section").className = "mr-1 btn btn-rounded btn-outline-primary";
                section_private_consultation.style.display = "block";
            }
        }

        function sendNotification(kodePeserta, nama, title, state, type) {
            var isKodeExist = kodePeserta !== "null";
            var isWaitCounselor = state === 'waiting_counselor';
            var isPublic = type === 'public';
            var body = {
                "_token": token,
                "to": "",
                "data": {
                    "title": "",
                    "body": `Konsultasi ${type} berjudul ${title} belum kamu respon nih, Yuk segera respon!`
                }
            }
            body['to'] = isKodeExist ? "/topics/USER_" + kodePeserta : "/topics/COUNSELOR";
            body['data']['title'] = isWaitCounselor ? nama + " menunggu responmu" : isPublic ?
                "Konselor menunggu responmu" : "Konselor " + nama + " menunggu responmu";
            showDialogSendNotificationAjax(firebase_endpoint, body, isPublic ? table_id_public : table_id_private);
        }

        function showData(id) {
            $.get(base_endpoint + id, function(responseText) {
                if (typeof responseText === 'object') {
                    var date = toLocaleDate(responseText.details.created_at);
                    var isClosed = responseText.details.closed_at != null;
                    $("#writer_date_consultation").html(`${responseText.details.nama_lengkap}  •  ${date}`);
                    $("#title_consultation").html(responseText.details.title);
                    $("#action_show_consultation").children('#btn_action_show_consultation').first().remove();
                    $("#action_show_consultation").prepend(
                        `<button id='btn_action_show_consultation' class='btn pr-3 pl-3 btn-rounded ${isClosed ? 'btn-secondary' : 'btn-primary'}' type="button" onclick='closeConsultation(${id}, ${isClosed})'>
                            <i class="fa ${isClosed ? 'fa-envelope-open' : 'fa-ban'}" aria-hidden="true"></i>
                            <span>${isClosed ? 'Buka' : 'Tutup'}</span></button>`
                    );
                    $("#content_consultation").html('');
                    (responseText.details.content).split('\n').forEach((item) => {
                        $("#content_consultation").append(`<p>${item}</p>`);
                    })
                    showReplies(responseText.replies);
                    $('#modal_show_consultation').modal('show');
                }
            });
        }

        function showReplies(arrReplies) {
            repliesContainer.innerHTML = '';
            if (arrReplies.length === 0) {
                repliesContainer.style.display = 'none';
                dividerReplies.style.display = 'none';
            } else {
                repliesContainer.style.display = 'block';
                dividerReplies.style.display = 'block';

                for (var i = 0; i < arrReplies.length; i++) {
                    var card_parent = document.createElement('div');
                    card_parent.className = 'border mt-3';
                    var card_header = document.createElement('div');
                    card_header.className = 'card-header';
                    var card_body = document.createElement('div');
                    card_body.className = 'card-body';
                    var answerer_date = document.createElement('span');
                    answerer_date.className = 'card-text font-weight-bold';
                    var content = '';

                    var answerer = `${arrReplies[i].nama_pembalas}  •  ${toLocaleDate(arrReplies[i].created_at)}`;
                    answerer_date.innerHTML = arrReplies[i].reply_from === 'user' ? answerer : answerer +
                        `<br/><span class='text-muted font-weight-normal'>dari ${arrReplies[i].name_stakeholder}</span>`;

                    arrReplies[i].content.split('\n').forEach((item) => {
                        content += `<p class='card-text'>${item}</p>`
                    })
                    card_header.appendChild(answerer_date);
                    card_body.innerHTML = content;
                    card_parent.appendChild(card_header);
                    card_parent.appendChild(card_body);
                    repliesContainer.appendChild(card_parent);
                }
            }
        }

        function closeConsultation(id, isClosed) {
            var endpoint = base_endpoint + id;
            var body = {
                "id": id,
                "_token": token,
            }
            var message = '';
            var feedback = '';

            if (isClosed) {
                endpoint += '/open';
                message = 'membuka';
                feedback = 'dibuka';
            } else {
                endpoint += '/close';
                message = 'menutup';
                feedback = 'ditutup';
            }

            var target_table_id = currentSection === "public" ? table_id_public : table_id_private
            showDialogConfirmationAjax(null, `Apakah anda yakin akan ${message} konsultasi ini?`,
                `Konsultasi berhasil ${feedback}!`,
                endpoint, 'PATCH', body, target_table_id)
            $('#modal_show_consultation').modal('hide');
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
