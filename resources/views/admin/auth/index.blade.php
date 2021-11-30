@extends('layouts.base')
@section('title', 'Welcome')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Welcome</h4></div>
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
                <div class="card card-info card-annoucement bg-danger card-round">
                    <div class="card-body text-center">
                        <div class="card-opening">Selamat datang {{Auth::user()->name}},</div>
                        <div class="card-desc">
                            Anda login sebagai
                        </div>
                        <div class="card-detail">
                            @php
                            $menu = App\Http\Controllers\AuthCT::menuNavigation();
                            @endphp
                            <div class="btn btn-light col-red btn-rounded">{{$menu['role']->name}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
