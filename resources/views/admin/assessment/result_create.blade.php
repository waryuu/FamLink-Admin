@extends('layouts.base')
@section('title', 'Add Assessment Result')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Tambah Result Assesment</h4></div>
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
                            <input type="hidden" name="assesment_id" value="{{ $model['id'] }}" />
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group form-show-validation row">
                                        <label for="detail_category" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Title Result <span class="required-label">*</span></label>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="title" placeholder="Masukan Title Result" required>
                                        </div>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="detail_category" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Result Label Color <span class="required-label">*</span></label>
                                        <div class="col-12">
                                            <input type="color" name="color" placeholder="Masukan Warna" required>
                                        </div>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="detail_category" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Description Result <span class="required-label">*</span></label>
                                        <div class="col-12">
                                            <textarea id="summernote" name="description" placeholder="Masukan Content" autofocus="autofocus" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="detail_category" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Range Down <span class="required-label">*</span></label>
                                        <div class="col-12">
                                            <input type="number" step="0.01" class="form-control" name="range_down" value="0" placeholder="Masukkan Range down" />
                                        </div>
                                    </div>

                                    <div class="form-group form-show-validation row">
                                        <label for="detail_category" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Range Up <span class="required-label">*</span></label>
                                        <div class="col-12">
                                            <input type="number" step="0.01" class="form-control" name="range_up" value="1" placeholder="Masukkan Range Up" />
                                        </div>
                                    </div>


                                    <div class="modal-footer border-0">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-danger">Close</button></a>
                                    </div>
                                </div>
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
    $(document).ready(function(){
        $('form').loading();
        $('#summernote').summernote({
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            tabsize: 2,
            height: 300
        });
    })
</script>
@endsection
