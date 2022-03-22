@extends('layouts.base')
@section('title', 'Config Contact')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Config Contact Us</h4>
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
            <div class="p">Atur informasi kontak FamLink untuk menu <b>Hubungi Kami</b> pada aplikasi android.
            </div>
            <br />

            <div id="current_contactus" class="row">
                <div class="col-12 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body m-4">
                            <div>
                                <h4><b>Informasi Kontak Tersimpan</b></h4>
                            </div>
                            <div class="separator-solid"></div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>Email</b>
                                </div>
                                <div class="col-sm-9">
                                    : {{ $model['data']->email }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>Nomor WhatsApp</b>
                                </div>
                                <div class="col-sm-9">
                                    : (+62) {{ $model['data']->phone }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>Tanggal Update</b>
                                </div>
                                <div class="col-sm-9">
                                    : {{ $model['data']->updated_at->format('d/m/Y H:i') }} WIB
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div id="update_contactus" class="row">
                <div class="col-12 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ $model['base_url']}}{{$model['data']->id}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input name="_method" type="hidden" value="PUT">
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div>
                                            <h4><b>Update Informasi Kontak</b></h4>
                                        </div>
                                        <div class="separator-solid"></div>
                                        <div class="form-group form-show-validation row">
                                            <label for="email">Email <span class="required-label">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Masukan Email FamLink yang aktif"
                                                value="{{ $model['data']->email }}" required>
                                        </div>
                                        <div class="form-group form-show-validation row">
                                            <label for="phone">Nomor WA <span class="required-label">*</span></label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">+62</span>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    placeholder="Masukan Nomor WA Admin FamLink yang aktif"
                                                    value="{{ $model['data']->phone }}" required>
                                            </div>
                                            Masukan nomor WhatsApp tanpa menggunakan 0, Contoh: 081234567890 -> 81234567890
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection
