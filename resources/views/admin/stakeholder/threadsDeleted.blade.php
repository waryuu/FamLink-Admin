@extends('layouts.base')
@section('title', 'Master Stakeholder')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex flex-row justify-content-start align-items-center">
                <a href="/admin/stakeholder/threads" class="text-light">
                    <button type="button" class='btn btn-rounded btn-primary pr-3 pl-3 ml-0 mr-3'>
                        <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>
                        <span class="mr-1">KEMBALI</span>
                    </button>
                </a>
                <h4 class="page-title">Diskusi yang telah dihapus</h4>
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
                                        <th>Created at</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width: 7%">ID</th>
                                        <th>Nama lengkap</th>
                                        <th>Judul</th>
                                        <th>Nama lembaga</th>
                                        <th>Created at</th>
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
                                <span id="stakeholder_name_thread" class='text-muted'></span>
                                <h5 class="modal-title font-weight-bold" id="title_thread" i="modal_title_thread"></h5>
                            </div>
                            <button class="close pl-3" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <img id='img_thread' src=''
                            style='object-fit: contain;height: 18.75rem;width: auto;background: #EEEEEE;' />
                        <div id="content_thread" class="modal-body pb-0 text-justify"></div>
                        <hr id='divider_replies' class='w-100 mt-2 mb-2 border-top' />
                        <div id="replies_thread" class='pt-0 pb-4 modal-body text-justify'></div>
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

        var table = null;
        var table_id = '#table_view';
        var modal_show_threads = "#modal_show_threads";
        var repliesContainer = document.getElementById('replies_thread');
        var dividerReplies = document.getElementById('divider_replies');

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

            table = initDataTableLoad(table_id, base_endpoint + 'create', columnData);
            $(modal_show_threads).click(function(e) {
                showData(e);
            });
        });

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
                    var isClosed = responseText.detail.closed_at != null;
                    $("#writer_date_thread").html(`${responseText.detail.name_user}  •  ${date}`);
                    $("#stakeholder_name_thread").html(responseText.detail.name_stakeholder);
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

        function restoreAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }

            showDialogConfirmationAjax(null, 'Apakah Anda yakin akan menampilkan kembali diskusi ini?',
                'Data berhasil ditampilkan kembali!',
                base_endpoint + id, 'PATCH', body, table_id);
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
