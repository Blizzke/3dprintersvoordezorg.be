@extends('layouts.help')
@section('title', 'Mijn profiel')
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <form method="post" action="{{route('profile')}}" class="form-horizontal">
                <h2>Profiel:</h2>
                <div class="well">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="display_name">Weergavenaam *</label>
                        <div class="col-sm-5">
                        <input id="display_name" name="display_name" type="text"
                               class="form-control @error('display_name') is-invalid @enderror"
                               value="{{ input($user, 'display_name') }}"/>
                        </div>
                        @error('display_name')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="street">Straat</label>
                        <div class="col-sm-9">
                            <input id="street" name="street" type="text"
                                   class="form-control @error('street') is-invalid @enderror"
                                   value="{{ input($user, 'street') }}"/>
                        </div>
                        @error('street')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="number">Nummer</label>
                        <div class="col-sm-2">
                            <input id="number" name="number" type="text"
                                   class="form-control @error('number') is-invalid @enderror"
                                   value="{{ input($user, 'number') }}"/>
                        </div>
                        @error('street')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="zip">Postcode *</label>
                        <div class="col-sm-2">
                            <input id="zip" name="zip" type="text"
                                   class="form-control @error('zip') is-invalid @enderror"
                                   value="{{ input($user, 'zip') }}"/>
                        </div>
                        @error('zip')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="city">Gemeente</label>
                        <div class="col-sm-5">
                            <input id="city" name="city" type="text"
                                   class="form-control @error('city') is-invalid @enderror"
                                   value="{{ input($user, 'city') }}"/>
                        </div>
                        @error('city')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="email">E-mail</label>
                        <div class="col-sm-5">
                            <input id="email" name="email" type="text"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ input($user, 'email') }}"/>
                        </div>
                        @error('email')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="phone">Telefoon</label>
                        <div class="col-sm-5">
                            <input id="phone" name="phone" type="text"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ input($user, 'phone') }}"/>
                        </div>
                        @error('phone')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="mobile">GSM</label>
                        <div class="col-sm-5">
                            <input id="mobile" name="mobile" type="text"
                                   class="form-control @error('mobile') is-invalid @enderror"
                                   value="{{ input($user, 'mobile') }}"/>
                        </div>
                        @error('mobile')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
                <h2>Features:</h2>
                <div class="well">
                    @foreach(\App\Feature::select()->modifiable()->get() as $feature)
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="1" name="feature[{{$feature->id}}]" {{$user->hasFeature($feature->id) ? 'checked' : ''}}>
                              {{$feature->name}}
                          </label>
                        </div>
                    @endforeach
                </div>
                <div class="well">
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Update">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
