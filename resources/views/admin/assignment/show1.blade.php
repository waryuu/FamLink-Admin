@extends('layouts.base')
@section('title', 'Update Event')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Update Soal</h4></div>
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
                        <form action="{{$model['base_url']}}{{$model['assignment']->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Pertanyaan <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="question" placeholder="Masukan Pertanyaan" value="{{$model['assignment']->question}}" required>
                                    </div>
                                    <div class="separator-solid"></div>


                                    <label for="answer" >Jawaban <span class="required-label">*</span>
                                    </label>
                                    @foreach($model['answer'] as $answer)
                                    @php
                                        $label = "inlineRadio".strval($loop->iteration + 1);
                                    @endphp
                                    <div class="form-group row"> 
                                        <input type="hidden" name="id[]" value="{{$answer->id}}"> 
                                        <label for={{$label}} class="col-sm-1 col-form-label">{{chr(64+ $loop->iteration)}}</label>

                                        <input type="text" class="col-sm-11 form-control" name="answer[]" 
                                         id="answer" placeholder="Masukan Jawaban" 
                                         value="{{$answer->answer}}" required>
                                    </div>
                                    @endforeach
                                    
                                    
                                    
                                    <div class="form-group form-show-validation row">
                                        <label for="correct_answer" class="col-sm-2">Jawaban yang benar <span class="required-label">*</span></label>
                                        <div class="form-check form-check-inline col-sm-2">

                                            @foreach ($model['answer'] as $answer)
                                            @php
                                                $checked = "checked";
                                                $label = "inlineRadio".strval($loop->iteration + 1);
                                            @endphp
                                            @if ($answer->correctness == $model['assignment']->correct_answer)
                                                <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="{{$label}}" style="height:20px; width:20px;" value="{{$answer->correctness}}" {{$checked}}>
                                                  <label class="form-check-label" for="{{$label}}">
                                                      {{chr(64+ $answer->correctness)}} 
                                                  </label>
                                            @else
                                                <input class="form-check-input col-sm-2" type="radio" name="correct_answer" id="{{$label}}" style="height:20px; width:20px;" value="{{$answer->correctness}}">
                                                  <label class="form-check-label" for="{{$label}}">
                                                      {{chr(64+ $answer->correctness)}} 
                                                  </label>
                                            @endif
                                            @endforeach
                                        </div>
                                         
                                    </div>
                                   
                                    <div class="form-group form-show-validation row">
                                        <label for="status" class="col-sm-2">Status <span class="required-label">*</span></label>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="status" id="active-status" value="1" @if($model['assignment']->status == '1') checked @endif>
                                          <label class="form-check-label" for="active-status">Aktif</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="status" id="inactive-status" value="0" @if($model['assignment']->status == '0') checked @endif >
                                          <label class="form-check-label" for="inactive-status">Arsipkan</label>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Update</button>
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
