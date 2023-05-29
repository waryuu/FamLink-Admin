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
                        <form id="form_validation" action="{{$model['base_url']}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label >Silahkan masukkan pertanyaan dan jawaban</label>
                                    </div>
                                    <div class="separator-solid"></div>

                                    <div class="form-group form-show-validation">
                                        <label for="question" >Pertanyaan <span class="required-label">*</span></label>
                                        <div>
                                            <input type="text" class="form-control" name="question" id="question" placeholder="Masukkan Pertanyaan" required/>
                                        </div>
                                    </div>
                                    <div class="form-group form-show-validation">
                                        <label for="answer" >Jawaban </label>
        
                                        @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $label = "inlineRadio".strval($i);
                                        @endphp
                                        <div class="form-group row"> 
                                                <input type="hidden" name=correctness[] value={{$i}} > 
                                                <label for={{$label}} class="col-sm-1 col-form-label">{{chr(64+ $i)}}</label>
                                            
                                                
                                                <input type="text" class="col-sm-11 form-control" name="answer[]" id="answer" placeholder="Masukkan Jawaban"/>   
                                        </div>
                                        @endfor
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="correct_answer" class="col-sm-2">Jawaban yang benar <span class="required-label">*</span></label>

                                        <div class="form-check form-check-inline col-sm-3">
                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="inlineRadio1" style="height:20px; width:20px;" value="1" required>
                                          <label class="form-check-label" for="inlineRadio1">A</label>

                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="inlineRadio2" style="height:20px; width:20px;" value="2">
                                          <label class="form-check-label" for="inlineRadio2">B</label>

                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="inlineRadio3" style="height:20px; width:20px;" value="3">
                                          <label class="form-check-label" for="inlineRadio3">C</label>

                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="inlineRadio4" style="height:20px; width:20px;" value="4">
                                         <label class="form-check-label" for="inlineRadio4">D</label>

                                          <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="inlineRadio5" style="height:20px; width:20px;" value="5">
                                          <label class="form-check-label" for="inlineRadio5">E</label>
                                        </div>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="status" class="col-sm-2">Status <span class="required-label">*</span></label>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="status" id="active-status" value="1" checked>
                                          <label class="form-check-label" for="active-status">Aktif</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="status" id="inactive-status" value="0" >
                                          <label class="form-check-label" for="inactive-status">Arsipkan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                        
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Submit</button>
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


@endsection
