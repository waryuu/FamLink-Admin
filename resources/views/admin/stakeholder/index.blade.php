@extends('layouts.base')
@section('title', 'Master Stakeholder')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Master Stakeholder</h4>
            </div>

            <div id='chip_section' class='mb-4'>
                <button type="button" class='btn btn-primary btn-rounded'>
                    LEMBAGA
                </button>
                <a href='/admin/stakeholder/members'>
                    <button type="button" class='btn btn-outline-primary btn-rounded ml-1'>
                        ANGGOTA
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 id='title_table' class="card-title">Daftar Lembaga Aktif</h4>
                                <button id="btn_status" class="btn btn-secondary btn-round ml-auto"
                                    onclick="onChangeStatusStakeholder('nonactive')">
                                    <i class="fas fa-user-slash mr-1"></i>
                                    LEMBAGA NONAKTIF
                                </button>
                                <button id='btn_add_data' class="btn btn-primary btn-round ml-2" data-toggle="modal"
                                    data-target="#modal_add_form">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="table_active" class="table-responsive">
                                <table id="table_view" class="display w-100 table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lembaga</th>
                                            <th>Tanggal dibentuk</th>
                                            <th>Fokus Lembaga</th>
                                            <th>Email</th>
                                            <th>Narahubung</th>
                                            <th>Nomor Narahubung</th>
                                            <th>Logo</th>
                                            <th>Galeri</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lembaga</th>
                                            <th>Tanggal dibentuk</th>
                                            <th>Fokus Lembaga</th>
                                            <th>Email</th>
                                            <th>Narahubung</th>
                                            <th>Nomor Narahubung</th>
                                            <th>Logo</th>
                                            <th>Galeri</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div id="table_nonactive" class="table-responsive d-none">
                                <table id="table_view_nonactive" class="display w-100 table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lembaga</th>
                                            <th>Tanggal dibentuk</th>
                                            <th>Fokus Lembaga</th>
                                            <th>Email</th>
                                            <th>Narahubung</th>
                                            <th>Nomor Narahubung</th>
                                            <th>Logo</th>
                                            <th>Galeri</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 7%">ID</th>
                                            <th>Nama Lembaga</th>
                                            <th>Tanggal dibentuk</th>
                                            <th>Fokus Lembaga</th>
                                            <th>Email</th>
                                            <th>Narahubung</th>
                                            <th>Nomor Narahubung</th>
                                            <th>Logo</th>
                                            <th>Galeri</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div id="modal_add_form" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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

                                        <form id="form_validation" action="{{ '/admin/stakeholder' }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="p-0 form-group form-show-validation w-100">
                                                    <div class="w-100">
                                                        <label for="parent_header">
                                                            Nama lembaga <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" id="name_stakeholder"
                                                            name="name" required />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Tanggal didirikan <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="date" id="established"
                                                            name="established" required />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Fokus lembaga <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" id="focus_stakeholder"
                                                            name="focus" required />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            E-mail
                                                        </label>
                                                        <input class="form-control" type="email" id="email"
                                                            name="email" />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Nama Narahubung
                                                        </label>
                                                        <input class="form-control" type="text" id="cp_name"
                                                            name="cp_name" />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Nomor Narahubung
                                                        </label>
                                                        <input class="form-control" type="tel" minlength="9"
                                                            maxlength="13" id="cp_number" name="cp_number" />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">Provinsi <span
                                                                class="required-label">*</span></label>
                                                        <input class="form-control" type="search" autoComplete="on"
                                                            list="province_list" id="id_province" name="id_province"
                                                            required onchange="getRegencies(this)" />
                                                        <datalist id="province_list">
                                                            @foreach ($model['provinces'] as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">Kabupaten <span
                                                                class="required-label">*</span></label>
                                                        <input class="form-control" type="search" autoComplete="on"
                                                            list="regency_list" id="id_regency" name="id_regency" disabled
                                                            required />
                                                        <datalist id="regency_list"></datalist>
                                                    </div>
                                                    <div class="mt-4 w-100">
                                                        <label class="w-100" for="parent_header">Logo
                                                            lembaga</label></br>
                                                        <div class="d-flex justify-content-center w-100">
                                                            <img id="preview_logo_stakeholder"
                                                                class="ml-4 mt-3 mb-3 rounded-circle row" width="200"
                                                                height="200" style="object-fit: cover; display: none;" />
                                                        </div>
                                                        <input class="form-control" type="file" accept="image/*"
                                                            name="logo" onchange="loadPreviewLogo(event)" />
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

                            <div id="modal_edit_form" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">

                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">
                                                <span class="fw-mediumbold">
                                                    Edit
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

                                        <form id="form_edit_validation" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="p-0 form-group form-show-validation w-100">
                                                    <input type="hidden" id="edit_id_stakeholder" name="id" value="" />
                                                    <div class="w-100">
                                                        <label for="parent_header">
                                                            Nama lembaga <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" id="edit_name_stakeholder"
                                                            name="name" required />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Tanggal didirikan <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="date" id="edit_established"
                                                            name="established" required />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Fokus lembaga <span class="required-label">*</span>
                                                        </label>
                                                        <input class="form-control" type="text"
                                                            id="edit_focus_stakeholder" name="focus" required />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            E-mail
                                                        </label>
                                                        <input class="form-control" type="email" id="edit_email"
                                                            name="email" />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Nama Narahubung
                                                        </label>
                                                        <input class="form-control" type="text" id="edit_cp_name"
                                                            name="cp_name" />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">
                                                            Nomor Narahubung
                                                        </label>
                                                        <input class="form-control" type="tel" minlength="9"
                                                            maxlength="13" id="edit_cp_number" name="cp_number" />
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">Provinsi <span
                                                                class="required-label">*</span></label>
                                                        <input class="form-control" type="search" autoComplete="on"
                                                            list="province_list" id="edit_id_provinces" name="id_province"
                                                            required onchange="getRegencies(this)" />
                                                        <datalist id="province_list">
                                                            @foreach ($model['provinces'] as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                    <div class="w-100 mt-4">
                                                        <label for="parent_header">Kabupaten <span
                                                                class="required-label">*</span></label>
                                                        <input class="form-control" type="search" autoComplete="on"
                                                            list="regency_list" id="edit_id_regency" name="id_regency"
                                                            disabled required />
                                                        <datalist id="regency_list"></datalist>
                                                    </div>
                                                    <div class="mt-4 w-100">
                                                        <label class="w-100" for="parent_header">Logo
                                                            lembaga</label></br>
                                                        <div class="d-flex justify-content-center w-100">
                                                            <img id="preview_edit_logo_stakeholder"
                                                                class="ml-4 mt-3 mb-3 rounded-circle row" width="200"
                                                                height="200" style="object-fit: cover; display: none;" />
                                                        </div>
                                                        <input class="form-control" type="file" accept="image/*"
                                                            name="logo" id="edit_logo"
                                                            onchange="onChangeInputLogo(event)" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" id="editRowButton"
                                                    class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div id="modal_add_gallery_form" class="modal fade" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">

                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 id="title_gallery_stakeholder" class="modal-title">
                                                <span class="fw-mediumbold">
                                                    Galeri Stakeholder
                                                </span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div id="empty_gallery" class="d-none"
                                            style="height: 22rem; background: #EEEEEE">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <i class="fas fa-image btn-link btn-primary mr-2"
                                                    style="font-size: 3rem"></i>
                                                <h5 class="fw-bold mb-0">Galeri kosong</h5>
                                            </div>
                                        </div>

                                        <div id="carousel_stakeholder_gallery" class="carousel slide" data-ride="carousel">
                                            {{-- Data carousel --}}
                                            <ol id="gallery_indicators" class="carousel-indicators"></ol>
                                            <div id="gallery_dataset" class="carousel-inner"></div>
                                            {{-- Control Carousel --}}
                                            <a class="carousel-control-prev" href="#carousel_stakeholder_gallery"
                                                role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carousel_stakeholder_gallery"
                                                role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>

                                        <div id="container_form_add_gallery" class="modal-body">
                                            <form id="form_add_gallery_validation"
                                                action="{{ '/admin/stakeholder/gallery' }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="p-0 form-group form-show-validation w-100">
                                                    <div class="w-50"></div>
                                                    <input type="hidden" id="gallery_id_stakeholder" name="id_stakeholder"
                                                        value="" />
                                                    <div class="w-100">
                                                        <label class="w-100" for="parent_header">Tambah
                                                            Gambar</label></br>
                                                        <div class="d-flex justify-content-center w-100">
                                                            <img id="preview_gallery_stakeholder"
                                                                class="ml-4 mt-3 mb-3 rounded-circle row" width="200"
                                                                height="200" style="object-fit: cover; display: none;" />
                                                        </div>
                                                        <input class="form-control" type="file" accept="image/*"
                                                            name="photo" id="gallery_photo"
                                                            onchange="loadPreviewGallery(event)" />
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="submit" id="submitGalleryButton"
                                                        class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
        var table = null;
        var table_nonactive = null;

        var table_id = '#table_view';
        var root_table_id = '#table_active';
        var modal_form = '#modal_add_form';
        var modalEditId = "#modal_edit_form";
        var modalEditButtonId = "#editRowButton";
        var formEditId = '#form_edit_validation';
        var editLogoFiles = null;

        var table_id_nonactive = '#table_view_nonactive';
        var root_table_id_nonactive = '#table_nonactive';

        $(document).ready(function() {
            var columnsData = [{
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<strong class="col-red" style="font-size: 12px">' + row['id'] +
                            '</strong>';
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        return '<strong class="col-red" style="font-size: 12px">' + row['name'] +
                            '</strong>';
                    }
                },
                {
                    data: 'established',
                    name: 'established',
                    render: function(data, type, row) {
                        return '<strong class="col-red" style="font-size: 12px">' +
                            toLocaleDate(row['established'], {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }) +
                            '</strong>';
                    }
                },
                {
                    data: 'focus',
                    name: 'focus',
                    render: function(data, type, row) {
                        return '<strong class="col-red" style="font-size: 12px">' + row['focus'] +
                            '</strong>';
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data, type, row) {
                        var isNull = row['email'] == null;
                        return isNull ? '<strong class="col-red" style="font-size: 12px">—</strong>' :
                            '<strong class="col-red" style="font-size: 12px">' + row['email'] +
                            '</strong>';
                    }
                },
                {
                    data: 'cp_name',
                    name: 'cp_name',
                    render: function(data, type, row) {
                        var isNull = row['cp_name'] == null;
                        return isNull ? '<strong class="col-red" style="font-size: 12px">—</strong>' :
                            '<strong class=" col-red" style="font-size: 12px">' + row['cp_name'] +
                            '</strong>';
                    }
                },
                {
                    data: 'cp_number',
                    name: 'cp_number',
                    render: function(data, type, row) {
                        var isNull = row['cp_number'] == null;
                        return isNull ? '<strong class="col-red" style="font-size: 12px">—</strong>' :
                            '<strong class=" col-red" style="font-size: 12px">' + row['cp_number'] +
                            '</strong>';
                    }
                },
                {
                    data: 'logo',
                    name: 'logo',
                    render: function(data, type, row) {
                        return '<img src="{{ $model['public_url'] }}' + row['logo'] +
                            '"class="rounded-circle row" width="150" height="150" style="object-fit: cover;" / >';
                    }
                },
            ];

            var actionActive = [{
                    data: 'id',
                    name: 'gallery',
                    render: function(data, type, row) {
                        return '<div class="form-button-action">' +
                            '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-lg" data-original-title="Buka Galeri"' +
                            `onclick="showGallery(${row['id']}, 'active')">` +
                            '<i class="fas fa-image" style="font-size: 1.25rem"></i></button></div>';
                    }
                },
                {
                    data: 'id',
                    name: 'action',
                    render: function(data, type, row) {
                        return '<div class="form-button-action">' +
                            '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit"' +
                            `onclick="editData(${row['id']})">` +
                            '<i class="fa fa-edit"></i></button>' +
                            '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus"' +
                            `onclick="deleteAlert(${row['id']})">` +
                            '<i class="fa fa-times"></i></button></div>';
                    }
                }
            ]

            var actionNonActive = [{
                    data: 'id',
                    name: 'gallery',
                    render: function(data, type, row) {
                        return '<div class="form-button-action">' +
                            '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-lg" data-original-title="Buka Galeri"' +
                            `onclick="showGallery(${row['id']}, 'nonactive')">` +
                            '<i class="fas fa-image" style="font-size: 1.25rem"></i></button></div>';
                    }
                },
                {
                    data: 'id',
                    name: 'action',
                    render: function(data, type, row) {
                        return '<div class="form-button-action">' +
                            '<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Restore"' +
                            `onclick="restoreAlert(${row['id']})">` +
                            '<i class="fa fa-history"></i></button></div>';
                    }
                }
            ]

            table = initDataTableLoad(table_id, base_endpoint + 'create', createColumnsAny(columnsData.concat(
                actionActive)));
            table_nonactive = initDataTableLoad(table_id_nonactive, base_endpoint + 'nonactive', createColumnsAny(
                columnsData
                .concat(actionNonActive)));

            $(modal_form).on('hidden.bs.modal', function(e) {
                $(this).find('form').trigger('reset');
            })
            $(modalEditButtonId).click(function(e) {
                setEditAction(e);
            });
            initFormValidation(formEditId, rulesFormEdit);
            $('#form_add_gallery_validation').on('submit', (function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        swal({
                            title: 'Pemberitahuan',
                            icon: 'success',
                            text: "Gambar berhasil ditambahkan",
                            type: 'success',
                            cancel: false,
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        }).then(() => {
                            fetchGallery(formData.get("id_stakeholder"));
                        });
                    },
                    error: function(data) {
                        swal({
                            title: 'Pemberitahuan',
                            icon: 'error',
                            text: "Gambar gagal ditambahkan, cek kembali gambar yang akan diunggah!",
                            type: 'error',
                            cancel: false,
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                    }
                });
            }));
        });

        function onChangeStatusStakeholder(status) {
            switch (status) {
                case 'active':
                    $('#title_table').html('Daftar Lembaga Aktif');
                    $(root_table_id).toggleClass('d-none');
                    $(root_table_id_nonactive).toggleClass('d-none');
                    $("#btn_status").attr('onclick', 'onChangeStatusStakeholder("nonactive")');
                    $("#btn_status").html('<i class="fas fa-user-slash mr-1"></i>LEMBAGA NON AKTIF');
                    $("#btn_add_data").attr('style', 'display: block;');
                    loadTable(table_id);
                    return;
                case 'nonactive':
                    $('#title_table').html('Daftar Lembaga Non-aktif');
                    $(root_table_id).toggleClass('d-none');
                    $(root_table_id_nonactive).toggleClass('d-none');
                    $("#btn_status").attr('onclick', 'onChangeStatusStakeholder("active")');
                    $("#btn_status").html('<i class="fas fa-user mr-1"></i>LEMBAGA AKTIF');
                    $("#btn_add_data").attr('style', 'display: none;');
                    loadTable(table_id_nonactive);
                    return;
                default:
                    return;
            }
        }

        function getRegencies(data) {
            var id_province = data.value;
            var regency_list = document.getElementById('regency_list');
            var containerRegency = document.getElementById('id_regency');

            $.get(base_endpoint + "regencies" + "/" + id_province, function(responseText) {
                responseText.forEach(function(item) {
                    var option = document.createElement('option');
                    containerRegency.disabled = false;
                    option.value = item.id;
                    option.innerHTML = item.name;
                    regency_list.appendChild(option);
                });
            });
        }

        var rulesFormEdit = {
            id: {
                required: true,
            },
            name: {
                required: true,
            },
            established: {
                required: true,
            },
            focus: {
                required: true,
            },
            id_province: {
                required: true,
            },
            id_regency: {
                required: true,
            },
        };

        var rulesAddGallery = {
            id_stakeholder: {
                required: true,
            },
            photo: {
                required: true,
                extension: 'jpeg | jpg | png | gif',
                filesize: 5,
            },
        };

        function editData(id) {
            $.get(base_endpoint + id, function(responseText) {
                $("#edit_id_stakeholder").val(responseText.id);
                $("#edit_name_stakeholder").val(responseText.name);
                $("#edit_established").val(responseText.established);
                $("#edit_focus_stakeholder").val(responseText.focus);
                $("#edit_email").val(responseText.email);
                $("#edit_cp_name").val(responseText.cp_name);
                $("#edit_cp_number").val(responseText.cp_number);
                $("#edit_id_provinces").val(responseText.id_province);
                $("#edit_id_regency").val(responseText.id_regency);
                $("#edit_id_regency").removeAttr("disabled");
                $("#preview_edit_logo_stakeholder").attr('src', '{{ $model['public_url'] }}' + responseText
                    .logo);
                $("#preview_edit_logo_stakeholder").attr('style', 'object-fit: cover; display: block;');
                $('#modal_edit_form').modal('show');
            })
        }

        function showGallery(id, status) {
            fetchGallery(id, status);
            // Show modal
            $('#modal_add_gallery_form').modal('show');
        }

        function fetchGallery(id, status) {
            $.get(base_endpoint + 'gallery/' + id, function(responseText) {
                // Set stakeholder ID
                $("#gallery_id_stakeholder").val(id);
                // Reset previous gallery
                $("#gallery_indicators").html("");
                $("#gallery_dataset").html("");
                if (status == "active") $("#container_form_add_gallery").removeClass('d-none');
                if (status == "nonactive") $("#container_form_add_gallery").addClass('d-none');
                // Show empty container
                if (responseText.length == 0) {
                    $("#carousel_stakeholder_gallery").addClass("d-none");
                    $("#carousel_stakeholder_gallery").removeClass("d-block");
                    $("#empty_gallery").attr("class", "d-flex justify-content-center align-items-center");
                    $("#empty_gallery").removeClass("d-none");
                } else {
                    $("#carousel_stakeholder_gallery").addClass("d-block");
                    $("#carousel_stakeholder_gallery").removeClass("d-none");
                    $("#empty_gallery").attr("class", "");
                    $("#empty_gallery").addClass("d-none");

                    // Create carousel
                    responseText.forEach((item, index) => {
                        var indicators = $("<li></li>")
                            .attr("data-target", "#carousel_stakeholder_gallery")
                            .attr("data-slide-to", index);
                        if (index === 0) $(indicators).attr("class", "active");

                        var container_images = $("<div></div>");
                        if (index == 0) $(container_images).attr("class", "carousel-item active");
                        else $(container_images).attr("class", "carousel-item");

                        var images = $("<img></img>")
                            .attr("src", `/stakeholder/gallery/${item.photo}`)
                            .attr("class", "d-block w-100")
                            .attr('style', 'background: #EEEEEE; height:22rem; object-fit: contain;')
                            .attr("alt", `Gambar ke-${index+1}`);
                        $(container_images).append(images);

                        if (status == 'active') {
                            var btn_delete = $("<div class='carousel-caption'>" +
                                "<button type='button' class='btn btn-rounded btn-danger btn-sm'><i class='fas fa-trash mr-1'></i>HAPUS GAMBAR</button>" +
                                "</div>"
                            ).attr("onclick", `onDeleteImage(${item.id}, ${item.id_stakeholder})`);
                            $(container_images).append(btn_delete);
                        }
                        $("#gallery_indicators").append(indicators);
                        $("#gallery_dataset").append(container_images);
                    })
                }
            })
        }

        function onDeleteImage(id, id_stakeholder) {
            var body = {
                "id": id,
                "_token": token,
            }

            swal({
                title: 'Pemberitahuan',
                text: "Apakah anda yakin akan menghapus gambar ini?",
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
            }).then((Okay) => {
                if (Okay) {
                    var responseAjax = {
                        url: base_endpoint + 'gallery/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        type: 'DELETE',
                        data: body,
                        success: function() {
                            showSuccessDialog('Gambar berhasil dihapus!', null, null);
                            fetchGallery(id, 'active');
                        }
                    };
                    $.ajax(responseAjax);
                } else {
                    swal.close();
                }
            });
        }

        function blobToBase64(blob) {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            return new Promise(resolve => {
                reader.onloadend = () => {
                    resolve(reader.result);
                };
            });
        };

        async function setEditAction(e) {
            var valid = $(formEditId).valid();
            if (valid) {
                var id = $("#edit_id_stakeholder").val();
                var name = $("#edit_name_stakeholder").val();
                var established = $("#edit_established").val();
                var focus = $("#edit_focus_stakeholder").val();
                var email = $("#edit_email").val();
                var cp_name = $("#edit_cp_name").val();
                var cp_number = $("#edit_cp_number").val();
                var id_province = $("#edit_id_provinces").val();
                var id_regency = $("#edit_id_regency").val();
                var logo = null;
                var fileName = null;
                if (editLogoFiles != null) {
                    logo = await blobToBase64(editLogoFiles);
                    fileName = `${id}_${name}.${editLogoFiles.name.split(".").pop()}`;
                }

                var body = {
                    "_token": token,
                    "id": id,
                    "name": name,
                    "established": established,
                    "cp_name": cp_name == "" ? null : cp_name,
                    "cp_number": cp_number == "" ? null : cp_number,
                    "focus": focus,
                    "email": email == "" ? null : email,
                    "id_province": id_province,
                    "id_regency": id_regency,
                    "logo": logo,
                    "fileName": fileName,
                };
                // if (email == null || email == '') delete body["email"];
                // if (cp_name == null || cp_name == '') delete body["cp_name"];
                // if (cp_number == null || cp_number == '') delete body["cp_number"];
                if (logo == null || logo == '') delete body["logo"];
                if (fileName == null || fileName == '') delete body["fileName"];
                console.log(body);

                var endpoint = base_endpoint + id;
                showDialogConfirmationAjax(modalEditId, 'Apakah anda yakin akan mengupdate data?',
                    'Update data berhasil!',
                    endpoint, 'PUT', body, table_id);
            }
        }

        function onChangeInputLogo(event) {
            var output = document.getElementById('preview_edit_logo_stakeholder');
            if (event.target.files.length == 0) {
                output.src = "";
                output.style.display = "none";
                editLogoFiles = null;
            } else {
                var logoFiles = event.target.files[0];
                editLogoFiles = logoFiles;
                output.src = URL.createObjectURL(logoFiles);
                output.onload = function() {
                    output.style.display = "block";
                    URL.revokeObjectURL(output.src);
                }
            }
        };

        function loadPreviewGallery(event) {
            var output = document.getElementById('preview_gallery_stakeholder');
            if (event.target.files.length == 0) {
                output.src = "";
                output.style.display = "none";
            } else {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    output.style.display = "block";
                    URL.revokeObjectURL(output.src);
                }
            }
        };

        function loadPreviewLogo(event) {
            var output = document.getElementById('preview_logo_stakeholder');
            if (event.target.files.length == 0) {
                output.src = "";
                output.style.display = "none";
            } else {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    output.style.display = "block";
                    URL.revokeObjectURL(output.src);
                }
            }
        };

        function deleteAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan menonaktifkan Lembaga?',
                'Lembaga berhasil dinonaktifkan!',
                base_endpoint + id, 'DELETE', body, table_id);
        }

        function restoreAlert(id) {
            var body = {
                "id": id,
                "_token": token,
            }
            showDialogConfirmationAjax(null, 'Apakah anda yakin akan mengaktifkan Lembaga?',
                'Lembaga berhasil diaktifkan kembali!',
                base_endpoint + 'restore/' + id, 'PATCH', body, table_id_nonactive);
        }
    </script>
@endsection
