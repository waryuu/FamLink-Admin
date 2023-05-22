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
                        <form action="{{$model['base_url']}}{{$model['data']->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Pertanyaan <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="question" placeholder="Masukan Pertanyaan" value="{{$model['data']->question}}" required>
                                    </div>
                                    <div class="separator-solid"></div>

                                    <label for="answer" >Jawaban <span class="required-label">*</span>
                                    </label>
                                    @foreach($model['answer'] as $answer)
                                    <div class="form-group form-show-validation row">
                                        <input type="hidden" name="id[]" value="{{$answer->id}}"> 

                                        {{chr(64+ $loop->iteration)}}.
                                        <input type="text" class="form-control" id="answer" name="answer[]" placeholder="Masukan Jawaban" value="{{$answer->answer}}" required>
                                    </div>
                                    @endforeach
                                    
                                    <div class="form-group form-show-validation row">
                                        <label for="status">Jawaban Benar <span class="required-label">*</span></label>
                                        <select class="form-control" id="status" name="correct_answer" required>
                                            <option value="1" 
                                            @if($model['data']->correct_answer == '1') selected @endif >A</option>
                                            <option value="2" 
                                            @if($model['data']->correct_answer == '2') selected @endif >B</option>
                                            <option value="3" 
                                            @if($model['data']->correct_answer == '3') selected @endif >C</option>
                                            <option value="4" 
                                            @if($model['data']->correct_answer == '4') selected @endif >D</option>
                                            <option value="5" 
                                            @if($model['data']->correct_answer == '5') selected @endif >E</option>
                                        </select>
                                    </div>                                    
                                    <div class="form-group form-show-validation row">
                                        <label for="status">Status <span class="required-label">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" @if($model['data']->status == '1') selected @endif >Aktif</option>
                                            <option value="0" @if($model['data']->status == '0') selected @endif >Tidak Aktif</option>
                                        </select>
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
