@extends('layouts.help')
@section('title', 'Account Vrijgeven')
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <form method="post" action="{{url('/helper/unlock/' . $user->id)}}" class="form-horizontal">
                <h1>@yield('title')</h1>
                <div class="well">
                    @csrf
                    <div>
                        <dl>
                            <dt>Helper</dt><dd>{{$user->name}}</dd>
                            <dt>Weergavemaam</dt><dd>{{$user->display_name}}</dd>
                        </dl>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="chat_name">Discord nickname *</label>
                        <div class="col-sm-5">
                        <input id="chat_name" name="chat_name" type="text"
                               class="form-control @error('chat_name') is-invalid @enderror"
                               value="{{ input($user, 'chat_name') }}"/>
                        </div>
                        @error('chat_name')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="well">
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="unlock" value="Account vrijgeven"> <input type="submit" class="btn btn-danger" name="block" value="Account geblokkeerd houden">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
