@extends('layouts.base')
@section('title', 'Tambah Event')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Tambah Event</h4></div>
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
            <div class="col-12 col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form id="form_validation" action="{{$model['base_url']}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label >Gambar <span class="required-label">*</span></label>
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview" width="300">
                                            <input type="file" class="form-control form-control-file" id="image" name="image" accept="image/*" >
                                            <label for="image" class="btn btn-primary bg-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Ganti Gambar</label>
                                        </div>
                                    </div>
                                    <div class="separator-solid"></div>
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Judul Event <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Judul Event" required>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="organizer" >Penyelenggara Event <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="organizer" name="organizer" placeholder="Masukan Penyelenggara Event" required>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="price" >Harga Tiket <span class="required-label">* </span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Rp .</span>
                                            <input type="number" class="form-control" placeholder="Masukan Harga Satuan Tiket" id="price" name="price">
                                          </div>
                                        <p> Jika event tidak memungut biaya, anda bisa menuliskan harga 0</p> 
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="start_time" >Waktu Mulai <span class="required-label">*</span></label>
                                        <input type="datetime-local" class="form-control" id="start_time" name="start_time" placeholder="Masukan Waktu Event" required>
                                        <p>Waktu dalam zona Waktu Indonesia Barat (WIB)</p>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="end_time" >Waktu Selesai <span class="required-label">*</span></label>
                                        <input type="datetime-local" class="form-control" id="end_time" name="end_time" placeholder="Masukan Waktu Event" required>
                                        <p> Waktu dalam zona Waktu Indonesia Barat (WIB)</p>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="location" >Lokasi Event <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Masukan Lokasi Event" required>
                                    </div>
                                    <div class="">
                                        <label for="description" ><b>Deskripsi Event </b><span class="required-label">*</span></label>
                                        <div>
                                            <textarea id="summernote" name="description" placeholder="Masukan description" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="registlink" >Link Pendaftaran Event <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="registlink" name="registlink" placeholder="Masukan Link Pendaftaran" required>
                                    </div>
                                    <div class="form-group form-show-validation row">
                                        <label for="status">Status <span class="required-label">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{$model['base_url']}}"><button type="button" class="btn btn-warning">Kembali</button></a>
                            </div>
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

    var formId = '#form_validation';
    var rulesForm = {
        image: {
            required: true,
        }
    };

    $(document).ready(function() {
        initFormValidation(formId, rulesForm);
        $('#summernote').summernote({
			fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
			tabsize: 2,
			height: 300
		});
        $('#type').on('change', function() {
            if (this.value == 2) {
                $('#type_value_wrapper').show();
            } else {
                $('#type_value_wrapper').hide();
            }
        });
    });
</script>
@endsection
