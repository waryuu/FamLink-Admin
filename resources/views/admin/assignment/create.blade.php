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
                                    <div class="">
                                        <label for="question" >Pertanyaan <span class="required-label">*</span></label>
                                        <div>
                                            <input type="text" class="form-control" name="question" id="question" placeholder="Masukkan Pertanyaan" />
                                        </div>
                                    </div>

                                    <div class="form-group form-show-validation">
                                        <label for="answer" >Jawaban <span class="required-label">*</span>
                                        </label>
        
                                        @for ($i = 1; $i <= 5; $i++)
                                        <div class="form-group form-show-validation "> 
                                            <input type="hidden" name=correctness[] value={{$i}} > 
                                            {{chr(64+ $i)}}
                                            <input type="text" class="form-control" name="answer[]" id="answer" placeholder="Masukkan Jawaban" />
                                        </div>
                                        @endfor

                                        <div class="form-group form-show-validation row">
                                        <label for="status">Jawaban yang benar <span class="required-label">*</span></label>
                                        <select class="form-control" name="correct_answer" required>
                                            <option value="1"> A </option>
                                            <option value="2">B </option>
                                            <option value="3">C </option>
                                            <option value="4">D </option>
                                            <option value="4">E </option>
                                        </select>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="status">Status <span class="required-label">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1"> Aktif </option>
                                            <option value="0">Arsipkan</option>
                                        </select>
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
<script>

    var choices = $('#choice').find(":selected").val();
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
			height: 100 
		});
        $('#type').on('change', function() {
            if (this.value == 2) {
                $('#type_value_wrapper').show();
            } else {
                $('#type_value_wrapper').hide();
            }
        });
    });

    document.getElementById("demo").innerHTML = text;
</script>
@endsection
