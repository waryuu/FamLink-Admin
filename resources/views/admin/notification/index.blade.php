@extends('layouts.base')
@section('title', 'Master Notifikasi')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Master Notifikasi</h4>
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
            <div class="p">Kirim notifikasi kepada pengguna dengan memilih channel yang sesuai</div>
            <br />
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <h3 class="card-header">GLOBAL</h3>
                        <div class="card-body">
                            <p class="card-text">Kirim notifikasi kepada seluruh <b>pengguna</b>, termasuk
                                <b>konselor</b> dan <b>jejaring</b>.
                            </p>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal_send_global">Kirim</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <h3 class="card-header">KONSELOR</h3>
                        <div class="card-body">
                            <p class="card-text">Kirim notifikasi kepada seluruh <b>konselor</b> yang masih aktif.
                            </p>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal_send_counselor">Kirim</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <h3 class="card-header">JEJARING</h3>
                        <div class="card-body">
                            <p class="card-text">Kirim notifikasi kepada seluruh pengurus <b>jejaring</b> yang masih
                                aktif.
                            </p>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal_send_stakeholder">Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ---------------------MODAL SEND GLOBAL-------------------------- --}}
    <div class="modal fade" id="modal_send_global" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                            Kirim Notifikasi
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="global_form_validation" action="notification/send" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <h3 class="mx-2">Channel: GLOBAL</h3>
                            <input type="hidden" id="to" name="to" value="/topics/GLOBAL">
                            <div class="form-group form-show-validation row">
                                <label for="title" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Judul
                                    <span class="required-label">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Masukan Judul Notifikasi" required>
                                </div>
                            </div>
                            <div class="form-group form-show-validation row">
                                <label for="body" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Deskripsi
                                    <span class="required-label">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="body" name="body"
                                        placeholder="Masukan Deskripsi Notifikasi" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" id="send_global_btn" class="btn btn-primary">Kirim</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ---------------------MODAL SEND KONSELOR-------------------------- --}}
    <div class="modal fade" id="modal_send_counselor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                            Kirim Notifikasi
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="counselor_form_validation" action="notification/send" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <h3 class="mx-2">Channel: KONSELOR</h3>
                            <input type="hidden" id="to" name="to" value="/topics/COUNSELOR">
                            <div class="form-group form-show-validation row">
                                <label for="title" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Judul
                                    <span class="required-label">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Masukan Judul Notifikasi" required>
                                </div>
                            </div>
                            <div class="form-group form-show-validation row">
                                <label for="body" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Deskripsi
                                    <span class="required-label">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="body" name="body"
                                        placeholder="Masukan Deskripsi Notifikasi" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" id="send_counselor_btn" class="btn btn-primary">Kirim</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ---------------------MODAL SEND STAKEHOLDER-------------------------- --}}
    <div class="modal fade" id="modal_send_stakeholder" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                            Kirim Notifikasi
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="stakeholder_form_validation" action="notification/send" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <h3 class="mx-2">Channel: JEJARING</h3>
                            <input type="hidden" id="to" name="to" value="/topics/STAKEHOLDER">
                            <div class="form-group form-show-validation row">
                                <label for="title" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Judul
                                    <span class="required-label">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Masukan Judul Notifikasi" required>
                                </div>
                            </div>
                            <div class="form-group form-show-validation row">
                                <label for="body" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Deskripsi
                                    <span class="required-label">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="body" name="body"
                                        placeholder="Masukan Deskripsi Notifikasi" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" id="send_stakeholder_btn" class="btn btn-primary">Kirim</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection