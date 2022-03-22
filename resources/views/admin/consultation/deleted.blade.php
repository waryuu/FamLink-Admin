@extends('layouts.base')
@section('title', 'Master Konsultasi')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <a href="/admin/consultation" class="text-light">
                    <button type="button" class='btn btn-rounded btn-primary pr-3 pl-3 ml-0 mr-3'>
                        <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>
                        <span class="mr-1">KEMBALI</span>
                    </button>
                </a>
                <h4 class="page-title">Konsultasi yang telah dihapus</h4>
            </div>
            <div class="d-flex mb-3">
                <button type="button" class="mr-1 btn btn-rounded btn-primary" id="public_text_section"
                    onclick="showSectionConsultation('public')">
                    PUBLIC</button>
                <button type="button" class="ml-1 mr-auto btn btn-rounded btn-outline-primary" id="private_text_section"
                    onclick="showSectionConsultation('private')">
                    PRIVAT</button>
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
                                            <th>Status</th>
                                            <th>Terbuka</th>
                                            <th>Ditutup oleh</th>
                                            <th>Waktu ditutup</th>
                                            <th>Created at</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Terbuka</th>
                                            <th>Ditutup oleh</th>
                                            <th>Waktu ditutup</th>
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

            <div class="modal fade" id="modal_show_consultation" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <span id="writer_date_consultation" class='text-muted'></span>
                                <h5 class="modal-title font-weight-bold" id="title_consultation"
                                    i="modal_title_consultation"></h5>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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
                                            <th>Nama Lengkap</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Konselor</th>
                                            <th>Lembaga</th>
                                            <th>Ditutup Oleh</th>
                                            <th>Waktu Ditutup</th>
                                            <th>Created At</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Konselor</th>
                                            <th>Lembaga</th>
                                            <th>Ditutup Oleh</th>
                                            <th>Waktu Ditutup</th>
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
                        var textTag = '<strong class="col-red text-center">';
                        if (row['state'] == 'closed' && row['rating'] != null) textTag += 'Ditutup, Penilaian diterima</strong>';
                        if (row['state'] == 'closed' && row['rating'] == null) textTag += 'Ditutup, Belum ada penilaian</strong>';
                        if (row['state'] == 'waiting_user') textTag += 'Menunggu pengguna</strong>';
                        if (row['state'] == 'waiting_counselor') textTag += 'Menunggu konselor</strong>';
                        return `<div class="mt-2 mb-3">${textTag}</div>`;
                    }
                }
            ];
            var publicColumns = [{
                data: 'open_to_all',
                name: 'open_to_all',
                render: function(data, type, row) {
                    return `<strong class=" col-red" style="font-size: 12px">${row['open_to_all'] == 0 ? 'Khusus Konselor' : 'Dibuka untuk umum'}</strong>`;
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
                            '<strong class=" col-red" style="font-size: 12px">—</strong>' :
                            `<strong class=" col-red" style="font-size: 12px">${row['role_who_closed']}</strong>`;
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
                          <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success" data-original-title="Kembalikan"
                            onclick="restoreAlert(${row['id']})">
                            <i class="fa fa-history"></i>
                          </button>
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
        });

        function showSectionConsultation(type) {
            if (type === "public") {
                currentSection = "public"
                section_public_consultation.style.display = "block";
                document.getElementById("public_text_section").className = "mr-1 btn btn-rounded btn-primary";
                document.getElementById("private_text_section").className = "ml-1 btn btn-rounded btn-outline-primary";
                section_private_consultation.style.display = "none";
            } else {
                currentSection = "private"
                section_public_consultation.style.display = "none";
                document.getElementById("private_text_section").className = "ml-1 btn btn-rounded btn-primary";
                document.getElementById("public_text_section").className = "mr-1 btn btn-rounded btn-outline-primary";
                section_private_consultation.style.display = "block";
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
                    var date = toLocaleDate(responseText.details.created_at)
                    $("#writer_date_consultation").html(`${responseText.details.nama_lengkap}  •  ${date}`);
                    $("#title_consultation").html(responseText.details.title);
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

        function restoreAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            
            var target_table_id = currentSection === "public" ? table_id_public : table_id_private
            showDialogConfirmationAjax(null, 'Apakah Anda yakin akan menampilkan kembali konsultasi ini?',
                'Data berhasil ditampilkan kembali!',
                base_endpoint + id + '/restore', 'PATCH', body, target_table_id);
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
