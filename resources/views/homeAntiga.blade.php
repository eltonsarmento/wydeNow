@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 ">
            <div class="panel panel-default">
                <div class="panel-heading">Perfil</div>

                <div class="panel-body">                    
                    <ul>
                        <li>{{ Auth::user()->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">Feed</div>

                <div class="panel-body">
                    nothing task until moment!
                </div>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="panel panel-default">
                <div class="panel-heading">News</div>

                <div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
