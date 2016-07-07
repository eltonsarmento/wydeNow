@extends('layouts.social_limpo')

@section('content')

<div class="gb ut">
  <div class="uv">
    <form role="form" class="alq dj j" method="POST" action="{{ url('/register') }}">        

      <a href="{{ url('/login') }}" class="l amb">
        <img src="assets/img/brand.png" alt="brand">
      </a>
       

	    {{ csrf_field() }}

        <div class="et">
            <label for="name" class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="et">
            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="et">
            <label for="password" class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="et">
            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>

      <div class="amb">
        <button class="cg fp" type="submit">
        	<i class="fa fa-btn fa-user"></i> Register
        </button>        
      </div>

      <footer class="apd">
        <a href="{{ url('/password/reset') }}" class="dp">Forgot Your Password?</a>
      </footer>
    </form>
  </div>
</div>
@endsection
