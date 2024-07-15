@extends('layouts.base')
@section('title', 'Laporan Assessment')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Laporan Assessment</h4>
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
            @foreach($model['assignment'] as $item)
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                <img src="/consultation/consul-closed.png" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">{{ $item->title }}</p>
                                    <h4 class="card-title">{{ $item->jumlah }} Assignment</h4>
                                    <a href="{{$model['base_url']}}?id={{ $item->id }}">LIHAT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="{{$model['base_url']}}download/excel">
                                <button class="btn btn-success btn-round ml-auto">
                                    <i class="fa fa-download"></i>
                                    Download Data
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_view" class="display table table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th style="width: 10%">Assignment</th>
                                        <th>Nilai</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Assignment</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Assignment</th>
                                        <th>Nilai</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Assignment</th>
                                    </tr>
                                </tfoot>
                            </table>
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

    var base_endpoint = "{{$model['base_url']}}";
    var table_id = '#table_view';
    var table = null;


    $(document).ready( function() {
        var columnsData = [{
            data: 'id',
            name: 'id',
            render : function(data, type, row) {
                return '<strong class=" col-red" style="font-size: 12px">'+row['id']+'</strong>';
            }
        },
        {
            data: 'id',
            name: 'id',
            render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['assignment'].title+'</strong>';
            }
        },
        {
            data: 'id',
            name: 'id',
            render : function(data, type, row) {
                return '<strong class=" col-red" style="font-size: 12px">'+row['result']+'</strong>';
            }
        },
        { 
            data: 'id',
            name: 'id',
            render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['user'].nama_lengkap+'</strong><br><span class=" col-red" style="font-size: 9px">'+row['user'].provinsi_ket+'</span><br><span class=" col-red" style="font-size: 9px">'+row['user'].kabupaten_ket+'</span>';
            }
        },
        {
            data: 'id',
            name: 'id',
            render : function(data, type, row) {
            return '<strong class=" col-red" style="font-size: 12px">'+row['created_at']+'</strong>';
            }
        },];
        var columns = createColumnsAny(columnsData) ;
            <?php
            if(isset($_GET['id'])){
                ?>
                table = initDataTableLoad(table_id, base_endpoint+'datatable/list?id=<?php echo $_GET['id'] ?>', columns);
                <?php
            }else {
                ?>
                table = initDataTableLoad(table_id, base_endpoint+'datatable/list', columns);
                <?php
            }
        ?>
    });

</script>
@endsection
