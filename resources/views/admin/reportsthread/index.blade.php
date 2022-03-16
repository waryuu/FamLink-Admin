@extends('layouts.base')
@section('title', 'Laporan Diskusi Stakeholder')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Laporan Diskusi Stakeholder</h4>
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
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <img src="/consultation/consul-all.png" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Semua Diskusi</p>
                                        <h4 class="card-title">{{ $model['total'] }} Diskusi</h4>
                                        <a href="{{ $model['base_url'] }}">LIHAT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <img src="/consultation/consul-ongoing.png" alt="..."
                                            class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Diskusi Berlangsung</p>
                                        <h4 class="card-title">{{ $model['total_ongoing'] }} Diskusi</h4>
                                        <a href="{{ $model['base_url'] }}?filter=ongoing">LIHAT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <img src="/consultation/consul-closed.png" alt="..."
                                            class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Diskusi Ditutup</p>
                                        <h4 class="card-title">{{ $model['total_closed'] }} Diskusi</h4>
                                        <a href="{{ $model['base_url'] }}?filter=closed">LIHAT</a>
                                    </div>
                                </div>
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

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <a href="{{ $model['base_url'] }}download">
                                    <button class="btn btn-success btn-round ml-auto">
                                        <i class="fa fa-download"></i>
                                        Download Data
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="table_view" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Lembaga</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Tanggal Ditutup</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Lembaga</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Tanggal Ditutup</th>
                                            <th>Aksi</th>
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
        var sthread_base_endpoint = "{{ $model['sthread_base_url'] }}";
        var thread_public_endpoint = "{{ $model['public_url_thread'] }}";
        var replies_public_endpoint = "{{ $model['public_url_replies'] }}";
        var table_id = '#table_view';
        var table = null;

        var repliesContainer = document.getElementById('replies_thread');
        var dividerReplies = document.getElementById('divider_replies');

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
                    data: 'name_user',
                    name: 'name_user',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['name_user'] +
                            '</strong>';
                    }
                },
                {
                    data: 'name_stakeholder',
                    name: 'name_stakeholder',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['name_stakeholder'] +
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
                        if (row['state'] == 'CLOSED') textTag += 'Ditutup</strong>';
                        else textTag += 'Berlangsung</strong>';
                        return textTag;
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
                        return `<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success" data-original-title="Lihat"
                            onclick="showData(${row['id']})">
                            <i class="fa fa-eye"></i>
                          </button>`;
                    }
                }
            ];
            var columns = createColumnsAny(columnsData);

            <?php
            if(isset($_GET['filter'])){
                ?>
                table = initDataTableLoad(table_id, base_endpoint+'datatable/list/<?php echo $_GET['filter'] ?>', columns);
                <?php
            } else {
                ?>
                table = initDataTableLoad(table_id, base_endpoint+'datatable/list/all', columns);
                <?php
            }
            ?>
        });

        function showData(id) {
            $.get(sthread_base_endpoint + id, function(responseText) {
                if (typeof responseText === 'object') {
                    var date = toLocaleDate(responseText.detail.created_at);
                    var isClosed = responseText.detail.state == "CLOSED";
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
    </script>
@endsection
