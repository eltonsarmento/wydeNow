@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">

    <div class="gn">

       <div class="qv rc aog alu">
          <div class="qx" style="background-image: url(assets/img/iceland.jpg);"></div>
          <div class="qw dj">
            <a href="profile/index.html">
              <img class="aoh" src="/uploads/avatars/{{ Auth::user()->avatar }}">
            </a>

            <h5 class="qy">{{ Auth::user()->name }} </h5>
            <p id="imageEdit">edit image</p>
            <div style="display:none" id="divImage">
              <form enctype="multipart/form-data" action="/profile" method="post">                
                  <input type="file" name="avatar">
                  
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                  <button type="submit" class="cg fm"><span class="h xi"></span></button>
                  <!-- <input type="submit" class="pull-right btn btn-sm btn-primary" value="Update Image"> -->
              </form> 
            </div>


            <p class="alu">I wish i was a little bit taller, wish i was a baller, wish i had a girl… also.</p>

            <ul class="aoi">
              <li class="aoj">
                <a href="#userModal" class="aku" data-toggle="modal">
                  Friends
                  <h5 class="ali">0</h5>
                </a>
              </li>

              <li class="aoj">
                <a href="#userModal" class="aku" data-toggle="modal">
                  Task
                  <h5 class="ali">0</h5>
                </a>
              </li>
            </ul>
          </div>
      </div>

      <div class="ca alu">
        <a href="#" class="b">
          <span class="h uy eg"></span>
          Notifications
        </a>
        <a href="#" class="b">
          <span class="h uy eg"></span>
          Mentions
        </a>
      </div>

       <div class="qv rc sm sp">
        
      </div>

      <div class="qv rc sm sp">
        <div class="qw">
          <h5 class="ald">Trending Searches <small>· <a href="#">Change</a></small></h5>
          <ul class="eb tb">
            <li><a href="#">#Bootstrap</a>
            <li><a href="#">Mdo for pres</a>
            <li><a href="#">#fatsux</a>
            <li><a href="#">#buyme</a>
            <li><a href="#">#designishard</a>
            <li><a href="#">#helpawesomepeople</a>
            <li><a href="#">#doawesomestuff</a>
            <li><a href="#">Tom Brady</a>
            <li><a href="#">Magna Carta</a>
            <li><a href="#">Mark Otto</a>
            <li><a href="#">Dave Gamache</a>
            <li><a href="#">Jacob Thornton</a>
          </ul>
        </div>
      </div>

    </div>

    <div class="gz">
      <ul class="nav ol">
        <li class="active"><a data-toggle="tab" href="#home">Pessoal</a></li>
        <li><a data-toggle="tab" href="#menu1">+</a></li>        
      </ul>      

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">        

          <ul class="ca qo anx">
            <li class="b aml">
              <h3 class="alc">Suas Tarefas</h3>
            </li>

            <li class="qf b aml">                          
                <form enctype="multipart/form-data" action="/tarefa/adiciona" method="post">                
                  <input type="text" class="form-control" id="texto" name="texto" placeholder="Escreva sua tarefa">
                  <input type="hidden" id="isPrivado" value="0">
                  <button class="cg ts fx" type="button" id="privado">
                    <span class="h vc"></span> 
                    Privado
                  </button>               
                  
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                  <button type="submit" class="cg fm">Salvar</button>                
                </form> 
                <script type="text/javascript">
                    $('#privado').click(function(){                      
                      if($('#isPrivado').val() == '1'){
                        var texto = $('#texto').val();
                        var textoSemPrivado = texto.replace("#privado", "");
                        $('#texto').val(textoSemPrivado); 
                        $('#isPrivado').val('0');
                      }else{
                        $('#texto').val($('#texto').val() + " #privado");
                        $('#isPrivado').val('1');
                      }
                    });
                </script>
            </li>

            <li class="b qf aml">
              <div class="qj">
                <span class="h abv dp"></span>
              </div>

              <div class="qg">
                <small class="eg dp">1 min</small>
                <div class="qn">
                  <a href="#"><strong>Dave Gamache</strong></a> went traveling
                </div>

              </div>
            </li>

            <li class="b qf aml">
              <div class="qj">
                <span class="h abr dp"></span>
              </div>

              <div class="qg">
                <small class="eg dp">3 min</small>
                <div class="qn">
                  <a href="#"><strong>Mark Otto</strong></a> played destiny
                </div>

              </div>
            </li>

            <li class="b qf aml">
              <div class="qj">
                <span class="h ajv dp"></span>
              </div>

              <div class="qg">
                <small class="eg dp">34 min</small>
                <div class="qn">
                  <a href="#"><strong>Fat</strong></a> and <a href="#"><strong>1 other</strong></a> followed you
                </div>
                <ul class="ano">
                  <li class="anp"><img class="cu" src="../assets/img/avatar-fat.jpg">
                  <li class="anp"><img class="cu" src="../assets/img/avatar-dhg.png">
                </ul>
              </div>
            </li>
          </ul>
          
        </div>
        <div id="menu1" class="tab-pane fade">
          <h3>Nova Categoria</h3>          
           <form  action="/profile/novaCategoria" method="post">                
                <input type="text" name="categoria" placehold="Nova categoria">
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                <button type="submit" class="cg fm">Salvar</button>
                <!-- <input type="submit" class="pull-right btn btn-sm btn-primary" value="Update Image"> -->
            </form> 
        </div>
      </div>

      


    </div>

    <div class="gn">
      <div class="qv rc alu ss">
        <div class="qw">
        <h5 class="ald">Active Users <small>· <a href="#">View All</a></small></h5>
        <ul class="qo anx">
          <li class="qf alm">
            <a class="qj" href="#">
              <img
                class="qh cu"
                src="../assets/img/avatar-fat.jpg">
            </a>
            <div class="qg">
              <strong>Jacob Thornton</strong> @fat
              <div class="aoa">
                <button class="cg ts fx">
                  <span class="h vc"></span> Follow</button>
              </div>
            </div>
          </li>
           <li class="qf">
            <a class="qj" href="#">
              <img
                class="qh cu"
                src="../assets/img/avatar-mdo.png">
            </a>
            <div class="qg">
              <strong>Mark Otto</strong> @mdo
              <div class="aoa">
                <button class="cg ts fx">
                  <span class="h vc"></span> Follow</button></button>
              </div>
            </div>
          </li>
        </ul>
        </div>
        <div class="qz">
          Dave really likes these nerds, no one knows why though.
        </div>
      </div>


        <div class="qv rc">
          <div class="qw">
          © 2015 Bootstrap

          <a href="#">About</a>
          <a href="#">Help</a>
          <a href="#">Terms</a>
          <a href="#">Privacy</a>
          <a href="#">Cookies</a>
          <a href="#">Ads </a>

          <a href="#">info</a>
          <a href="#">Brand</a>
          <a href="#">Blog</a>
          <a href="#">Status</a>
          <a href="#">Apps</a>
          <a href="#">Jobs</a>
          <a href="#">Advertise</a>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
