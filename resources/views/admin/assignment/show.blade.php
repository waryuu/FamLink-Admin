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
                        <form action="{{$model['base_url']}}{{$model['assignment']->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="modal-body">
                                <div class="card-body">

                                    <div class="form-group form-show-validation row">
                                        <label for="category">Kategori <span class="required-label">*</span></label>
                                        <select class="form-control" id="category" name="id_category" required>
                                            @foreach ($model['category'] as $category)
                                            <option @if($model['assignment']->id_category == $category->id) selected @endif  value={{$category->id}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="title" >Pertanyaan <span class="required-label">*</span></label>
                                        <input type="text" class="form-control" id="title" name="question" placeholder="Masukan Pertanyaan" value="{{$model['assignment']->question}}" required>
                                    </div>
                                    <div class="separator-solid"></div>


                                    <label for="answer" >Jawaban <span class="required-label">*</span>
                                    </label>
                                  
                                    <div class="form-group row"> 
                                        <label for="A" class="col-sm-1 col-form-label">A</label>

                                        <input type="text" class="col-sm-11 form-control" name="option_a" 
                                         id="option_a" placeholder="Masukan Jawaban" 
                                         value="{{$model['assignment']->option_a}}" >
                                    </div>

                                    <div class="form-group row"> 
                                        <label for="B" class="col-sm-1 col-form-label">B</label>

                                        <input type="text" class="col-sm-11 form-control" name="option_b" 
                                         id="option_b" placeholder="Masukan Jawaban" 
                                         value="{{$model['assignment']->option_b}}" >
                                    </div>

                                    <div class="form-group row"> 
                                        <label for="C" class="col-sm-1 col-form-label">C</label>

                                        <input type="text" class="col-sm-11 form-control" name="option_c" 
                                         id="option_c" placeholder="Masukan Jawaban" 
                                         value="{{$model['assignment']->option_c}}">
                                    </div>

                                    <div class="form-group row"> 
                                        <label for="D" class="col-sm-1 col-form-label">D</label>
                                        <input type="text" class="col-sm-11 form-control" name="option_d" 
                                         id="option_d" placeholder="Masukan Jawaban" 
                                         value="{{$model['assignment']->option_d}}">
                                    </div>
                                    
                                    
                                    <div class="form-group row">
                                        <label for="correct_answer" class="col-sm-2">Jawaban yang benar 
                                            <span class="required-label">*</span></label>
                                        <div class="form-check form-check-inline ">
                                            <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="correct_answer" id="A" style="height:20px; width:20px;" value="A" 
                                            @if($model['assignment']->correct_answer == "A") checked @endif>
                                            <label class="form-check-label" for="A"> A </label>

                                            <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="correct_answer" id="B" style="height:20px; width:20px;" value="B"
                                            @if($model['assignment']->correct_answer == "B") checked @endif>
                                            <label class="form-check-label" for="B"> B </label>

                                            <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="correct_answer" id="C" style="height:20px; width:20px;" value="C"
                                            @if($model['assignment']->correct_answer == "C") checked @endif>
                                            <label class="form-check-label" for="C"> C </label>

                                            <input class="form-check-input" style="height:20px; width:20px;" type="radio" name="correct_answer" id="D" style="height:20px; width:20px;" value="D"
                                            @if($model['assignment']->correct_answer == "D") checked @endif>
                                            <label class="form-check-label" for="D"> D </label>
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
