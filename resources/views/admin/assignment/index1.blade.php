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
                <div class="d-flex">
                    <strong> Total soal = {{$model['assignments']->total()}} <strong>
                </div>

                @if($model['assignments']->isEmpty())
                <div class="container square-box d-flex  justify-content-center align-items-center"> Tidak ada data </div>
                <div class="d-flex justify-content-center">
                        <a href="{{$model['base_url']}}create" id="btn_add_data" class="btn btn-primary btn-round ml-2">
                            <i class="fa fa-plus"></i>
                            Tambah Soal
                        </a> 
                </div>

                @else
                <div class="d-flex justify-content-end">
                        <a href="{{$model['base_url']}}create" id="btn_add_data" class="btn btn-primary btn-round ml-2">
                            <i class="fa fa-plus"></i>
                            Tambah Soal
                        </a> 
                </div>
                
                <br></br>
                
                
                @foreach($model['assignments'] as $assignment)
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end">
                            
                            <a href="{{ route('assignment.show', $assignment->id) }}">
                                <button type="button" class=" p-2 btn btn-link btn-success btn-lg">
                                    <i class="fa fa-edit fa-lg"> </i>
                                </button>
                            </a>

                            <!-- <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Edit"><i class="fa fa-eye"></i></button> -->


                            <a href="#" data-toggle="modal" id="smallButton" data-target="#smallModal" data-attr="{{ route('delete', $assignment->id) }}">
                                <button type="button" class=" p-2 btn btn-link btn-danger btn-lg">
                                    <i class="fas fa-trash fa-lg"> </i>
                                </button>
                            </a>
                        </div>
                        <div class="d-flex">
                            <h4 class="card-title">
                                <strong>Soal {{$model['i']++}}</strong>
                            </h4>
                        </div>

                        <div class="card-body">
                            <h3 class="card-title">
                            {{$assignment->question}}
                            </h3>
                            <br>
                            @foreach($assignment->answers as $answer)         
                                <div class="card-title">
                                    @if($answer->correctness == $assignment->correct_answer)
                                        <b style="background-color:yellow;">
                                        {{chr(64+ $loop->iteration)}}.
                                                    {{$answer->answer}}
                                        </b>
                                    @else
                                        {{chr(64+ $loop->iteration)}}.
                                                    {{$answer->answer}}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>    
                </div>

                
                @endforeach
                <div class="d-flex">
                    {!! $model['assignments']->links() !!}
                </div>
                <div>
                Showing {{($model['assignments']->currentpage()-1)*$model['assignments']->perpage()+1}} to {{$model['assignments']->currentpage()*$model['assignments']->perpage()}}
                    of  {{$model['assignments']->total()}} entries
                </div>
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