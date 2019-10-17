@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>You are logged in with {{ (Auth::user()->provider != "") ? Auth::user()->provider : 'Web' }}!</p>
                    <p>My name: {{Auth::user()->name}} {{ (Auth::user()->nickname != "") ? '('.Auth::user()->nickname.')' : '' }}</p>
                    <p>My Email: {{Auth::user()->email}}</p>
                    <img alt="{{Auth::user()->name}}" src="{{Auth::user()->image}}"/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
