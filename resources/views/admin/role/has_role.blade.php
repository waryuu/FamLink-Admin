@extends('layouts.base')
@section('title', $model['detail']->name)
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">{{ $model['detail']->name }}</h4>
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
                                <h4 class="card-title">Manage</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ $model['base_url'] }}save-has-role" method="POST">
                                @csrf
                                <input type="hidden" name="id_role" value="{{ $model['detail']->id }}" />
                                @foreach ($model['menu_header_view'] as $item)
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item align-items-center active">
                                            <i class="{{ $item->icon }}"></i>
                                            <b style="padding-left: 4px;">{{ $item->title }}</b>
                                            <span class="ml-auto">
                                                <div class="form-button-action">
                                                    <ul class="pagination pg-primary">
                                                        <li class="page-item">
                                                            <label class="form-check-label">
                                                                <?php $exist_head = false; ?>
                                                                @foreach ($model['menu_has_role'] as $item_has_role)
                                                                    @if ($item->id == $item_has_role->id_menu)
                                                                        <?php $exist_head = true; ?>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                            @if ($exist_head)
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="menu[]" value="{{ $item->id }}" checked>
                                                            @else
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="menu[]" value="{{ $item->id }}">
                                                            @endif
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </span>
                                    </li>
                                    @foreach ($item->data as $item_parent)
                                        <li class="list-group-item align-items-center">
                                            -> <span
                                                style="padding-left: 4px; padding-right: 4px; font-weight:bold;">{{ $item_parent->title }}</span>
                                            | path = {{ $item_parent->url }}
                                            <span class="ml-auto">
                                                <label class="form-check-label">
                                                    <?php $exist_head = false; ?>
                                                    @foreach ($model['menu_has_role'] as $item_has_role)
                                                        @if ($item_parent->id == $item_has_role->id_menu)
                                                            <?php $exist_head = true; ?>
                                                        @break
                                                    @endif
                                                @endforeach
                                                @if ($exist_head)
                                                    <input class="form-check-input" type="checkbox" name="menu[]"
                                                        value="{{ $item_parent->id }}" checked>
                                                @else
                                                    <input class="form-check-input" type="checkbox" name="menu[]"
                                                        value="{{ $item_parent->id }}">
                                                @endif

                                            </label>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                        @endforeach
                        <button type="submit" id="modal_edit_btn_update" class="btn btn-primary">Update</button>
                        <a href="{{ $model['base_url'] }}"><button type="button" class="btn btn-danger"
                                data-dismiss="modal">Cancel</button></a>
                    </form>
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
    var token = $("meta[name='csrf-token']").attr("content");

    function initDataTableLoad(view_id, endpoint) {
        table = $(view_id).DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            processing: true,
            serverSide: true,
            fixedColumns: true,
            order: [
                [1, "asc"]
            ],
            ajax: endpoint,
            columns: [{
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<strong class=" col-red" style="font-size: 12px">' + row['id'] +
                            '</strong>';
                    }
                },
                {
                    data: 'parent',
                    name: 'parent',
                    render: function(data, type, row) {
                        if (row['parent'] == 0) {
                            return '<strong class=" col-red" style="font-size: 12px">' + row['title'] +
                                '</strong>';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type, row) {
                        if (row['parent'] > 0) {
                            return '<strong class=" col-red" style="font-size: 12px">' + row['title'] +
                                '</strong>';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit" onclick="editData(' +
                            row['id'] +
                            ')"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert(' +
                            row['id'] + ')"><i class="fa fa-times"></i></button></div>';
                    }
                },
            ],
        });
    }

    function deleteAlert(id) {
        swal({
            title: 'Peringatan',
            text: "Apakah anda yakin akan menghapus data?",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Ya',
                    className: 'btn btn-success'
                },
                cancel: {
                    text: 'Tidak',
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $.ajax({
                    url: base_endpoint + id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function() {
                        swal({
                            title: 'Terhapus!',
                            icon: 'success',
                            text: 'Berhasil menghapus data',
                            type: 'success',
                            cancel: false,
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        }).then((Delete) => {
                            location.reload();
                        });


                    }
                });
            } else {
                swal.close();
            }
        });
    }

    function editData(id) {
        $.get(base_endpoint + id + '/edit', function(data) {
            $('#modal_edit_form').modal('show');
            $('#edit_binding_id').val(data.data.id);
            $('#edit_title').val(data.data.title);
            $('#edit_url').val(data.data.url);
            $('#edit_icon').val(data.data.icon);
        })
    }

    function editDataAction() {
        $('#modal_edit_btn_update').click(function(e) {
            var valid = $("#edit_form_validation").valid();
            if (valid) {
                swal({
                    title: 'Peringatan',
                    text: "Apakah anda yakin akan mengupdate data?",
                    type: 'warning',
                    buttons: {
                        confirm: {
                            text: 'Ya',
                            className: 'btn btn-success'
                        },
                        cancel: {
                            text: 'Tidak',
                            visible: true,
                            className: 'btn btn-danger'
                        }
                    }
                }).then((Confirm) => {
                    if (Confirm) {
                        $('#modal_edit_form').modal('hide');

                        var id = $("#edit_binding_id").val();
                        var title = $("#edit_title").val();
                        var url = $("#edit_url").val();
                        var icon = $("#edit_icon").val();

                        $.ajax({
                            url: base_endpoint + id,
                            type: "PUT",
                            data: {
                                "_token": token,
                                "id": id,
                                "title": title,
                                "url": url,
                                "icon": icon,
                            },
                            dataType: 'json',
                            success: function(data) {
                                swal({
                                    title: 'Berhasil!',
                                    icon: 'success',
                                    text: 'Berhasil meengupdate data',
                                    type: 'success',
                                    cancel: false,
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-success'
                                        }
                                    }
                                }).then((Delete) => {
                                    location.reload();
                                });
                            }
                        });
                    } else {
                        swal.close();
                    }
                });
            }
        });
    }

    function initFomrUI() {
        $("#form_validation").validate({
            validClass: "success",
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
        });

        $("#edit_form_validation").validate({
            validClass: "success",
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
        });

        $('#menu_type_container input[type=radio]').change(function() {
            if ($(this).val() == 'header') {
                $('#parent_header_container').hide();
                $('#parent_header').prop('required', false);
                $('#parent_header').prop('aria-invalid', false);
            } else {
                $('#parent_header_container').show();
                $("#parent_header").prop('required', true);
            }
        });
    }

    $(document).ready(function() {
        initDataTableLoad(table_id, base_endpoint + 'create')
        initFomrUI();
        editDataAction();
    });
</script>
@endsection
