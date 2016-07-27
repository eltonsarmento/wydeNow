<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
    <title>WydeNow</title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="/assets/css/toolkit.css" rel="stylesheet">
    
    <link href="/assets/css/application.css" rel="stylesheet">

    <style>
      /* note: this is a hack for ios iframe for bootstrap themes shopify page */
      /* this chunk of css is not part of the toolkit :) */
      body {
        width: 1px;
        min-width: 100%;
        *width: 100%;
      }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
 	<script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/chart.js"></script>
    <script src="/assets/js/toolkit.js"></script>
    <script src="/assets/js/application.js"></script>
    
    <script>
      // execute/clear BS loaders for docs
      $(function(){
        if (window.BS&&window.BS.loader&&window.BS.loader.length) {
          while(BS.loader.length){(BS.loader.pop())()}
        }
      })
    </script>

    

  </head>


<body class="ang">

	<nav class="ck pc os app-navbar">
	  <div class="by">
	    <div class="or">
	      <button type="button" class="ou collapsed" data-toggle="collapse" data-target="#navbar-collapse-main">
	        <span class="cv">Toggle navigation</span>
	        <span class="ov"></span>
	        <span class="ov"></span>
	        <span class="ov"></span>
	      </button>
	      <a class="e" href="{{ url('/home') }}">
	        <img src="/assets/img/brand-white.png" alt="brand">
	      </a>
	    </div>
	    <div class="f collapse" id="navbar-collapse-main">

	        <ul class="nav navbar-nav ss">
	          <li class="active">
	            <a href="{{ url('/home') }}">Home</a>
	          </li>
	          <li>
	            <a href="{{ url('/tarefa') }}">Tarefas</a>
	          </li>
	          <li>
	            <a href="{{ url('/profile') }}">Perfil</a>
	          </li>
	          <li>
	            <a >({{Auth::user()->tarefas()->count()}}) tarefas</a>
	          </li>
	          <li>
	            <a data-toggle="modal" href="/tarefa/listar/concluidas">({{Auth::user()->tarefasConcluidas()->count()}}) finish</a>
	          </li>
	          <li>
	            <a data-toggle="modal" href="/tarefa/listar/ativas">({{Auth::user()->tarefasPendentes()->count()}}) waiting</a>
	          </li>
	          
	          <li>
	            <a href="docs/index.html">Docs</a>
	          </li>
	        </ul>

	        <ul class="nav navbar-nav og ale ss">
	          <li >
	            <a class="g" href="notifications/index.html">
	              <span class="h ws"></span>
	            </a>
	          </li>
	          <li>
	            <button class="cg fm ox anl" data-toggle="popover">
	              <img class="cu" src="/uploads/avatars/{{ Auth::user()->avatar }}">
	            </button>
				
	          </li>
	        </ul>

	        <form class="ow og i" role="search">
	          <div class="et">
	            <input type="text" class="form-control" data-action="grow" placeholder="Search">
	          </div>
	        </form>

	        <ul class="nav navbar-nav st su sv">
	          <li><a href="{{ url('/home') }}">Home</a></li>
	          <li><a href="{{ url('/profile') }}">Profile</a></li>
	          <li><a href="#">Notifications</a></li>
	          <li><a data-toggle="modal" href="#msgModal">Messages</a></li>
	          <li><a href="docs/index.html">Docs</a></li>
	          <li><a href="#" data-action="growl">Growl</a></li>
	          <li><a href="{{ url('/logout') }}">Logout</a></li>
	        </ul>

	        <ul class="nav navbar-nav hidden">
	          <li><a href="#" data-action="growl">Growl</a></li>
	          <li><a href="{{ url('/logout') }}">Logout</a></li>
	        </ul>
	      </div>
	  </div>
	</nav>

@yield('content')


	
  </body>
</html>