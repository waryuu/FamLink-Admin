@extends('layouts.base')
@section('title', 'Update Assignment')
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
                        <form action="{{$model['instrument_url']}}{{$model['instrument']->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="modal-body">
                                <div class="card-body">

                                    <div class="form-group form-show-validation row">
                                        <label for="category">Kategori <span class="required-label">*</span></label>
                                        <select class="form-control" id="category" name="id_assignment" required>
                                            @foreach ($model['assignment'] as $assignment)
                                            <option @if($model['instrument']->id_assignment == $assignment->id) selected @endif  value={{$assignment->id}}>{{$assignment->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Pertanyaan <span class="required-label">*</span></label>
                                        <textarea type="text" class="form-control" id="title" name="question" placeholder="Masukan Pertanyaan" rows="5" required>{{$model['instrument']->question}}</textarea>
                                    </div>
                                    <div class="separator-solid"></div>


                                    <label for="answer" >Jawaban <span class="required-label">*</span>
                                    </label>
                                  
                                    <div class="form-group row"> 
                                        <label for="A" class="col-sm-1 col-form-label">A</label>

                                        <textarea type="text" class="col-sm-11 form-control" name="option_a"
                                         id="option_a" placeholder="Masukan Jawaban" rows="2">{{$model['instrument']->option_a}}</textarea>
                                    </div>

                                    <div class="form-group row"> 
                                        <label for="B" class="col-sm-1 col-form-label">B</label>

                                        <textarea type="text" class="col-sm-11 form-control" name="option_b" 
                                         id="option_b" placeholder="Masukan Jawaban" rows="2">{{$model['instrument']->option_b}}</textarea>
                                    </div>

                                    <div class="form-group row"> 
                                        <label for="C" class="col-sm-1 col-form-label">C</label>

                                        <textarea type="text" class="col-sm-11 form-control" name="option_c" 
                                         id="option_c" placeholder="Masukan Jawaban" rows="2">{{$model['instrument']->option_c}}</textarea>
                                    </div>

                                    <div class="form-group row"> 
                                        <label for="D" class="col-sm-1 col-form-label">D</label>
                                        <textarea type="text" class="col-sm-11 form-control" name="option_d" 
                                         id="option_d" placeholder="Masukan Jawaban" rows="2">{{$model['instrument']->option_d}}</textarea>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="correct_answer" class="col-sm-2">Jawaban yang benar 
                                            <span class="required-label">*</span></label>
                                        <div class="form-check form-check-inline ">
                                            <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="correct_answer" id="A" style="height:20px; width:20px;" value=1 
                                            @if($model['instrument']->correct_answer == 1) checked @endif>
                                            <label class="form-check-label" for="A"> A </label>

                                            <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="correct_answer" id="B" style="height:20px; width:20px;" value=2
                                            @if($model['instrument']->correct_answer == 2) checked @endif>
                                            <label class="form-check-label" for="B"> B </label>

                                            <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="correct_answer" id="C" style="height:20px; width:20px;" value=3
                                            @if($model['instrument']->correct_answer == 3) checked @endif>
                                            <label class="form-check-label" for="C"> C </label>

                                            <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="correct_answer" id="D" style="height:20px; width:20px;" value=4
                                            @if($model['instrument']->correct_answer == 4) checked @endif>
                                            <label class="form-check-label" for="D"> D </label>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group form-show-validation row">
                                        <label for="status" class="col-sm-2">Status <span class="required-label">*</span></label>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="status" id="active-status" value="1" @if($model['instrument']->status == '1') checked @endif>
                                          <label class="form-check-label" for="active-status">Aktif</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="status" id="inactive-status" value="0" @if($model['instrument']->status == '0') checked @endif >
                                          <label class="form-check-label" for="inactive-status">Arsipkan</label>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary">Update</button>
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
