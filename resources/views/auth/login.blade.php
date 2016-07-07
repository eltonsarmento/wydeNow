@extends('layouts.social_limpo')

@section('content')

<div class="gb ut">
  <div class="uv">
    <form role="form" class="alq dj j" method="POST" action="{{ url('/login') }}">    

      <a href="{{ url('/login') }}" class="l amb">
        <img src="assets/img/brand.png" alt="brand">
      </a>
      
      {{ csrf_field() }}

      <div class="et">	        
	        <div class="col-md-6">
	            <input id="email" type="email" class="form-control" placeholder="E-Mail Address" name="email" value="{{ old('email') }}">	            
	            @if ($errors->has('email'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('email') }}</strong>
	                </span>
	            @endif
	        </div>
	  </div>

      <div class="et alu">        
        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>

      <div class="amb">
        <button class="cg fp">Log In</button>
        <a class="cg fm" href="{{ url('/register') }}">Sign up</a>
      </div>

      <footer class="apd">
        <a href="{{ url('/password/reset') }}" class="dp">Forgot Your Password?</a>
      </footer>
    </form>
  </div>
</div>
@endsection
