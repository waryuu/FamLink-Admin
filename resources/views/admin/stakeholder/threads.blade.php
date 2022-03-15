@extends('layouts.base')
@section('title', 'Master Stakeholder')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex flex-row align-items-center">
                <h4 class="page-title ml-0 mr-auto">Master Stakeholder</h4>
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
                <a href="{{ $model['base_url'] }}trash" class="text-light">
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

            <div class="col-md-12 pl-0 pr-0">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Diskusi Lembaga</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_view" class="display table table-striped table-hover w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 7%">ID</th>
                                        <th>Nama lengkap</th>
                                        <th>Judul</th>
                                        <th>Nama lembaga</th>
                                        <th>Status</th>
                                        <th>Waktu dibuat</th>
                                        <th>Waktu ditutup</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width: 7%">ID</th>
                                        <th>Nama lengkap</th>
                                        <th>Judul</th>
                                        <th>Nama lembaga</th>
                                        <th>Status</th>
                                        <th>Waktu dibuat</th>
                                        <th>Waltu ditutup</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_show_threads" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <span id="writer_date_thread" class='text-muted'></span>
                                <h6 id="stakeholder_name_thread" class='text-muted font-weight-bold'></h6>
                                <h5 class="modal-title font-weight-bold" id="title_thread" i="modal_title_thread"></h5>
                            </div>
                            <div class='ml-auto d-flex flex-row' id='action_show_thread'>
                                <button class="close pl-3" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <img id='img_thread' src=''
                            style='object-fit: contain;height: 18.75rem;width: auto;background: #EEEEEE;' />
                        <div id="content_thread" class="modal-body pb-0 text-justify"></div>
                        <hr id='divider_replies' class='w-100 mt-2 mb-2 border-top' />
                        <div id="replies_thread" class='pt-0 pb-4 modal-body text-justify'></div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_edit_rules" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h3 class="modal-title font-weight-bold">Ubah Aturan Konsultasi</h3>
                            <div class="action-button">
                                <button type="button" id="modal_rules_btn_delete"
                                    class='ml-1 btn btn-rounded btn-secondary'>
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
                            <h3 class="modal-title font-weight-bold">Buat Aturan Diskusi Jejaring</h3>
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
        var thread_public_endpoint = "{{ $model['public_url_thread'] }}";
        var replies_public_endpoint = "{{ $model['public_url_replies'] }}";
        var id_menu = "{{ $model['menu_id'] }}";
        var rules_endpoint = "{{ $model['rules_url'] }}";

        var table = null;
        var table_id = '#table_view';
        var modal_show_threads = "#modal_show_threads";
        var repliesContainer = document.getElementById('replies_thread');
        var dividerReplies = document.getElementById('divider_replies');

        var modal_create_rules = "#modal_create_rules";
        var modal_edit_rules = "#modal_edit_rules";
        var modal_rules_btn_create = "#modal_rules_btn_create";
        var modal_rules_btn_update = "#modal_rules_btn_update";
        var modal_rules_btn_delete = "#modal_rules_btn_delete";
        var rules_form_validation = "#rules_form_validation";

        $(document).ready(function() {
            var columnData = [{
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['id'] +
                            '</strong>';
                    }
                },
                {
                    data: 'name_user',
                    name: 'name_user',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['name_user'] +
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
                    data: 'name_stakeholder',
                    name: 'name_stakeholder',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row[
                                'name_stakeholder'] +
                            '</strong>';
                    }
                },
                {
                    data: 'state',
                    name: 'state',
                    render: function(data, type, row) {
                        if (row['state'] == 'OPEN') {
                            return '<button class="btn btn-success">Dibuka</button>';
                        } else {
                            return '<button class="btn btn-danger">Ditutup</button>';
                        }
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
                    data: 'closed_at',
                    name: 'closed_at',
                    render: function(data, type, row) {
                        var date = toLocaleDate(row['closed_at']);
                        var time = toLocaleTime(row['closed_at']);
                        return `<strong class=" col-red" style="font-size: 12px">${row['closed_at'] === null ? '—' : `${date}, ${time}`}</strong>`;
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

            table = initDataTableLoad(table_id, base_endpoint + 'create', columnData);
            $(modal_show_threads).click(function(e) {
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

        function toLocaleDate(date, format = {
            weekday: 'short',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }) {
            var dateObj = new Date(date);
            return dateObj.toLocaleDateString('id-ID', format);
        }

        function toLocaleTime(date, format = {
            hour: '2-digit',
            minute: '2-digit'
        }) {
            var dateObj = new Date(date);
            return dateObj.toLocaleTimeString('id-ID', format)
        }

        function showData(id) {
            $.get(base_endpoint + id, function(responseText) {
                if (typeof responseText === 'object') {
                    var date = toLocaleDate(responseText.detail.created_at);
                    var isClosed = responseText.detail.state == "CLOSED";
                    $("#writer_date_thread").html(`${responseText.detail.name_user}  •  ${date}`);
                    $("#stakeholder_name_thread").html(responseText.detail.name_stakeholder);
                    $("#action_show_thread").children('#btn_action_show_thread').first().remove();
                    $("#action_show_thread").prepend(
                        `<button id='btn_action_show_thread' class='btn pr-3 pl-3 btn-rounded ${isClosed ? 'btn-secondary' : 'btn-primary'}' type="button" onclick='closeThread(${id}, ${isClosed})'>
                            <i class="fa ${isClosed ? 'fa-envelope-open' : 'fa-ban'}" aria-hidden="true"></i>
                            <span>${isClosed ? 'Buka' : 'Tutup'}</span></button>`
                    );
                    $("#title_thread").html(responseText.detail.title);
                    if (responseText.detail.images != null) {
                        $("#img_thread").css('display', 'block');
                        $("#img_thread").attr('src', `${thread_public_endpoint}${responseText.detail.images}`);
                        $("#img_thread").attr('alt', 'Gambar thread ' + responseText.detail.title);
                    } else {
                        $("#img_thread").css('display', 'none');
                        $("#img_thread").attr('src', '');
                        $("#img_thread").attr('alt', '');
                    }
                    $("#content_thread").html('');
                    (responseText.detail.content).split('\n').forEach((item) => {
                        $("#content_thread").append(`<p>${item}</p>`);
                    })
                    showReplies(responseText.replies);
                    $(modal_show_threads).modal('show');
                }
            });
        }

        function closeThread(id, isClosed) {
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
            
            showDialogConfirmationAjax(null, `Apakah anda yakin akan ${message} konsultasi ini?`,
                `Konsultasi berhasil ${feedback}!`,
                endpoint, 'PATCH', body, table_id)
            $('#modal_show_threads').modal('hide');
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

                    var image_replies = document.createElement('img');
                    image_replies.className = 'w-100';
                    image_replies.style =
                        'object-fit: contain;height: 18.75rem;width: auto;background: #EEEEEE;';
                    image_replies.src = arrReplies[i].images != null ? `${replies_public_endpoint}${arrReplies[i].images}` :
                        '';

                    var answerer_date = document.createElement('span');
                    answerer_date.className = 'card-text font-weight-bold';
                    var content = '';

                    var answerer = `${arrReplies[i].name_user}  •  ${toLocaleDate(arrReplies[i].created_at)}`;
                    answerer_date.innerHTML = answerer +
                        `<br/><span class='text-muted font-weight-normal'>dari ${arrReplies[i].name_stakeholder}</span>`;

                    arrReplies[i].content.split('\n').forEach((item) => {
                        content += `<p class='card-text'>${item}</p>`
                    })
                    card_header.appendChild(answerer_date);
                    card_body.innerHTML = content;
                    card_parent.appendChild(card_header);
                    if (arrReplies[i].images !== null) card_parent.appendChild(image_replies);
                    card_parent.appendChild(card_body);
                    repliesContainer.appendChild(card_parent);
                }
            }
        }

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
