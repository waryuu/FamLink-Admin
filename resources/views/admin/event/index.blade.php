@extends('layouts.base')
@section('title', 'Master Event')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Master Event</h4>
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
                            {{-- <h4 class="card-title">Add Row</h4> --}}
                            <a href="{{$model['base_url']}}create">
                                <button class="btn btn-primary btn-round ml-auto">
                                    <i class="fa fa-plus"></i>

                                    Tambah Data
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                      

                        <div class="table-responsive">
                            <table id="table_view" class="display table table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th style="width: 10%">Gambar</th>
                                        <th style="width: 10%">Judul</th>
                                        <th style="width: 5%">Harga</th>
                                        <th style="width: 5%">Penyelengara</th>
                                        <th style="width: 5%">Waktu Mulai</th>
                                        {{-- <th style="width: 5%">Waktu Selesai</th> --}}
                                        <th style="width: 5%">Lokasi</th>
                                        {{-- <th style="width: 20%">Deskripsi</th> --}}
                                        {{-- <th style="width: 10%">Link</th> --}}
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gambar</th>
                                        <th>Judul</th>
                                        <th>Harga</th>
                                        <th>Penyelengara</th>
                                        <th>Waktu Mulai</th>
                                        {{-- <th>Waktu Selesai</th> --}}
                                        <th>Lokasi</th>
                                        {{-- <th>Deskripsi</th> --}}
                                        {{-- <th>Link</th> --}}
                                        <th>Status</th>
                                        <th>Action</th>
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

    var base_endpoint = "{{$model['base_url']}}";
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

    $(document).ready( function() {
        var columnsData = [
        { data: 'id', name: 'id', render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['id']+'</strong>';
        }},
        { data: 'image', name: 'image', render : function(data, type, row) {
            return '<img src="/event/'+row['image']+'" width="100px"/>';
        }},
        { data: 'title', name: 'title',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['title']+'</strong>';
        }},
        { data: 'price', name: 'price',
        render : function(data, type, row) {
            if (row['price'] == 0) {
                return '<strong class=" col-red" style="font-size: 12px">Gratis</strong>';
            }else{
                return '<strong class=" col-red" style="font-size: 12px">'+row['price']+'</strong>';
            }
        }},
        { data: 'organizer', name: 'organizer',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['organizer']+'</strong>';
        }},
        { data: 'start_time', name: 'start_time',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['start_time']+'</strong>';
        }},
        // { data: 'end_time', name: 'end_time',
        // render : function(data, type, row) {
        //     return '<strong class=" col-red" style="font-size: 12px">'+row['end_time']+'</strong>';
        // }}
        { data: 'location', name: 'location',
        render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['location']+'</strong>';
        }},
        // { data: 'description', name: 'description',
        // render : function(data, type, row) {
        //     return '<strong class=" col-red" style="font-size: 12px">'+row['description']+'</strong>';
        // }},
        // { data: 'registlink', name: 'registlink',
        // render : function(data, type, row) {
        //     return '<strong class=" col-red" style="font-size: 12px">'+row['registlink']+'</strong>';
        // }},
        { data: 'status', name: 'status',
        render : function(data, type, row) {
            if (row['status'] == 1) {
                return '<button class="btn btn-success">Aktif</button>';
            }else{
                return '<button class="btn btn-danger">Tidak Aktif</button>';
            }
        }},
        { data: 'id', name: 'id', render : function(data, type, row) {
            return '<div class="form-button-action"><a href="'+base_endpoint+row['id']+'"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Edit"><i class="fa fa-eye"></i></button></a><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert('+row['id']+')"><i class="fa fa-times"></i></button></div>';
        }}];
        var columns = createColumnsAny(columnsData) ;
        table = initDataTableLoad(table_id, base_endpoint+'datatable/list', columns);
        initFormValidation(formId, rulesForm);
        initFormValidation(formEditId, rulesFormEdit);
        $(modalEditButtonId).click(function(e){
            setEditAction();
        });
    });

    function deleteAlert(id) {
        var body = {
            "id": id,
            "_token": token
        }
        showDialogConfirmationAjax(null, 'Apakah anda yakin akan menghapus data?', 'Data berhasil dihapus!', base_endpoint+id, 'DELETE', body, table_id);
    }

    function editData(id){
        $.get(base_endpoint + id + '/edit', function (data) {
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
            showDialogConfirmationAjax('#modal_edit_form', 'Apakah anda yakin akan mengupdate data?', 'Update data berhasil!', endpoint, 'PUT', body, table_id);
        }
    }

</script>
@endsection
