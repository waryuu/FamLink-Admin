@extends('layouts.base')
@section('title', 'Bank Soal')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Bank Soal</h4>
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
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                        <a href="{{$model['base_url']}}create" id="btn_add_data" class="btn btn-primary btn-round ml-2">
                            <i class="fa fa-plus"></i>
                            Tambah Soal
                        </a> 
                </div>
                
                <br></br>
                @if($model['assignments']->isEmpty())
                <div class="card">
                <div> Tidak ada data </div>
                
                @else
                @foreach($model['assignments'] as $assignment)
                <div class="card">
                    <div class="card-header">
                        <div class="d-grid align-items-center">
                            <h4 class="card-title">Soal {{$loop->iteration}}</h4>
                        </div>

                        <div class="d-grid justify-content-md-end">
                            <!-- <a class="btn btn-secondary" 
                            href="{{$model['base_url']}}{{$assignment->id}}" role="button">
                                <i class="far fa-edit"></i>
                                Edit Soal
                            </a> -->
                            <a href="{{ route('assignment.show', $assignment->id) }}" role="button">
                                <i class="fas fa-edit  fa-lg"></i>

                            </a>

                            <!-- <a class="btn btn-warning" data-toggle="modal" id="smallButton" data-target="#smallModal" data-attr="{{ route('delete', $assignment->id) }}"  title="Delete Project">
                                <i class="far fa-edit"></i>
                                Hapus Soal
                            </a> -->
                            <a data-toggle="modal" id="smallButton" data-target="#smallModal" data-attr="{{ route('delete', $assignment->id) }}" role="button">
                                <i class="fas fa-trash text-danger  fa-lg"></i>
                            </a>
                        </div>
                        
                        <div class="card-body">
                            <h4 class="card-title">
                            {{$assignment->question}}
                            </h4>
                            <br>
                            @foreach($assignment->answers as $answer)         
                                <h5 class="card-title">
                                    @if($answer->correctness == $assignment->correct_answer)
                                        <b>
                                        {{chr(64+ $loop->iteration)}}.
                                                    {{$answer->answer}}
                                        <b>
                                    @else
                                        {{chr(64+ $loop->iteration)}}.
                                                    {{$answer->answer}}
                                    @endif
                                </h5>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                <!-- small modal -->
                <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h3 class="modal-title">Konfirmasi Penghapusan</h3>
                            <button type="button" data-dismiss="modal" class="close">&times;</button>
                        </div>
                                <div class="modal-body" id="smallBody">
                                    <div>
                                        <!-- delete.blade.php will show here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>



            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // display a modal (small modal)
    $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href
            , beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#smallModal').modal("show");
                $('#smallBody').html(result).show();
            }
            , complete: function() {
                $('#loader').hide();
            }
            , error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            }
            , timeout: 8000
        })
    });

</script>
@endsection