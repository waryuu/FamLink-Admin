@extends('layouts.base')
@section('title', 'Tambah Soal')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Tambah Pertanyaan</h4></div>
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
                        <form id="form_validation" action="{{$model['instrument_url']}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">

                                    

                                    <div class="form-group form-show-validation">
                                        <b> Silahkan masukkan pertanyaan dan jawaban </b>
                                    </div>
                                    <div class="separator-solid"></div>

                                    <div class="form-group form-show-validation row">
                                        <label for="assignment">Kategori <span class="required-label">*</span></label>
                                        <select class="form-control" id="assignment" name="id_assignment" required>
                                            @foreach ($model['assignment'] as $assignment)
                                            <option value={{$assignment->id}}>{{$assignment->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="question" >Pertanyaan <span class="required-label">*</span></label>
                                            <textarea class="form-control" name="question" id="question" placeholder="Masukan Pertanyaan" rows="5" required></textarea>
                                    </div>

                                    <div class="form-group form-show-validation">
                                        <label for="answer" >Jawaban </label>
                                        
                                        <div class="form-group row"> 
                                                <label class="btn default" for="option_A" class="col-sm-1 col-form-label">A</label>
                                                <textarea type="text" class="col-sm-11 form-control" name="option_a" id="option_a" placeholder="Masukkan Jawaban"></textarea>  
                                        </div>

                                        <div class="form-group row"> 
                                                <label class="btn default" for="option_B" class="col-sm-1 col-form-label">B</label>
                                                <textarea type="text" class="col-sm-11 form-control" name="option_b" id="option_b" placeholder="Masukkan Jawaban"></textarea>
                                        </div>

                                        <div class="form-group row"> 
                                                <label class="btn default" for="option_C" class="col-sm-1 col-form-label">C</label>
                                                <textarea type="text" class="col-sm-11 form-control" name="option_c" id="option_c" placeholder="Masukkan Jawaban"></textarea> 
                                        </div>

                                        <div class="form-group row"> 
                                                <label class="btn default" for="option_D" class="col-sm-1 col-form-label">D</label>
                                                <textarea type="text" class="col-sm-11 form-control" name="option_d" id="option_d" placeholder="Masukkan Jawaban"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group form-show-validation">
                                        <label for="correct_answer" class="col-sm-2">Jawaban yang benar <span class="required-label">*</span></label>
                                        <br>

                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="option_A" style="height:20px; width:20px;" value=1 required>
                                          <label class="form-check-label" for="option_A">A</label>

                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="option_B" style="height:20px; width:20px;" value=2>
                                          <label class="form-check-label" for="option_B">B</label>

                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="option_C" style="height:20px; width:20px;" value=3>
                                          <label class="form-check-label" for="option_C">C</label>

                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="option_D" style="height:20px; width:20px;" value=4>
                                         <label class="form-check-label" for="option_D">D</label>
                                    </div>

                                    <div class="form-group form-show-validation">
                                        <label for="status" class="col-sm-2">Status <span class="required-label">*</span></label>
                                        <br>

                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input col-sm-5" style="height:20px; width:20px;" type="radio" name="status" id="active-status" value="1" checked>
                                          <label class="form-check-label" for="active-status">Aktif</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input col-sm-5" type="radio" style="height:20px; width:20px;"  name="status" id="inactive-status" value="0" >
                                          <label class="form-check-label" for="inactive-status">Arsipkan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                        
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{$model['assignment_url']}}"><button type="button" class="btn btn-warning">Kembali</button></a>
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


@endsection
