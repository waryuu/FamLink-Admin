@extends('layouts.base')
@section('title', 'Laporan Konsultasi')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Laporan Konsultasi</h4>
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
                                        <p class="card-category">Semua Konsultasi</p>
                                        <h4 class="card-title">{{ $model['total'] }} Konsultasi</h4>
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
                                        <img src="/consultation/consul-public.png" alt="..."
                                            class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Konsultasi Publik</p>
                                        <h4 class="card-title">{{ $model['total_public'] }} Konsultasi</h4>
                                        <a href="{{ $model['base_url'] }}?filter=public">LIHAT</a>
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
                                        <img src="/consultation/consul-private.png" alt="..."
                                            class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Konsultasi Privat</p>
                                        <h4 class="card-title">{{ $model['total_private'] }} Konsultasi</h4>
                                        <a href="{{ $model['base_url'] }}?filter=private">LIHAT</a>
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
                                        <p class="card-category">Konsultasi Berlangsung</p>
                                        <h4 class="card-title">{{ $model['total_ongoing'] }} Konsultasi</h4>
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
                                        <p class="card-category">Konsultasi Selesai</p>
                                        <h4 class="card-title">{{ $model['total_closed'] }} Konsultasi</h4>
                                        <a href="{{ $model['base_url'] }}?filter=closed">LIHAT</a>
                                    </div>
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

                            <div class="table-responsive">
                                <table id="table_view" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Tipe</th>
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
                                            <th>Tipe</th>
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
        var consul_base_endpoint = "{{ $model['consul_base_url'] }}";
        var table_id = '#table_view';
        var table = null;

        var repliesContainer = document.getElementById('replies_consultation');
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
                    data: 'nama_lengkap',
                    name: 'nama_lengkap',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['nama_lengkap'] +
                            '</strong>';
                    }
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function(data, type, row) {
                        var textTag = '<strong class="col-red text-center" style="font-size: 12px">';
                        if (row['type'] == 'public') textTag += 'Publik</strong>';
                        else textTag += 'Privat</strong>';
                        return textTag;
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
                        if (row['state'] == 'closed') textTag += 'Ditutup</strong>';
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
            $.get(consul_base_endpoint + id, function(responseText) {
                if (typeof responseText === 'object') {
                    var date = toLocaleDate(responseText.details.created_at);
                    var isClosed = responseText.details.closed_at != null;
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
    </script>
@endsection
