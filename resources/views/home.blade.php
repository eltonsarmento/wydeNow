@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">
    <div class="gn">
      <div class="qv rc aog alu">
        <div class="qx" style="background-image: url(assets/img/iceland.jpg);"></div>
        <div class="qw dj">
          <a href="profile/index.html">
            <img
              class="aoh"
              src="/uploads/avatars/{{ Auth::user()->avatar }}">
          </a>

          <h5 class="qy">
            <a class="aku" href="profile/index.html">{{ Auth::user()->name }}</a>
          </h5>

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

      <div class="qv rc sm sp">
        <div class="qw">
          <h5 class="ald">About <small>· <a href="#">Edit</a></small></h5>
          <ul class="eb tb">
            <li><span class="dp h xh all"></span>Went to <a href="#">Oh, Canada</a>
            <li><span class="dp h ajw all"></span>Became friends with <a href="#">Obama</a>
            <li><span class="dp h abu all"></span>Worked at <a href="#">Github</a>
            <li><span class="dp h ack all"></span>Lives in <a href="#">San Francisco, CA</a>
            <li><span class="dp h adt all"></span>From <a href="#">Seattle, WA</a>
          </ul>
        </div>
      </div>

       <div class="qv rc sm sp">
        <div class="qw">
          <h5 class="ald">Photos <small>· <a href="#">Edit</a></small></h5>
          <div data-grid="images" data-target-height="150">
            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="assets/img/instagram_5.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="assets/img/instagram_6.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="assets/img/instagram_7.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="assets/img/instagram_8.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="assets/img/instagram_9.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="assets/img/instagram_10.jpg">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="gz">
      <ul class="ca qo anx">

        <li class="qf b aml">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Message">
            <div class="fj">
              <button type="button" class="cg fm">
                <span class="h xi"></span>
              </button>
            </div>
          </div>
        </li>

        <li class="qf b aml">
          <a class="qj" href="#">
            <img
              class="qh cu"
              src="/uploads/avatars/{{ Auth::user()->avatar }}">
          </a>
          <div class="qg">
            <div class="qn">
              <small class="eg dp">4 min</small>
              <h5>{{ Auth::user()->name }}</h5>
            </div>

            <p>
              Aenean lacinia bibendum nulla sed consectetur. Vestibulum id ligula porta felis euismod semper. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </p>

            <div class="any" data-grid="images">
              <div style="display: none">
                <img data-action="zoom" data-width="1050" data-height="700" src="assets/img/unsplash_1.jpg">
              </div>

              <div style="display: none">
                <img data-action="zoom" data-width="640" data-height="640" src="assets/img/instagram_1.jpg">
              </div>

              <div style="display: none">
                <img data-action="zoom" data-width="640" data-height="640" src="assets/img/instagram_13.jpg">
              </div>

              <div style="display: none">
                <img data-action="zoom" data-width="1048" data-height="700" src="assets/img/unsplash_2.jpg">
              </div>
            </div>

            <ul class="qo alm">
              <li class="qf">
                <a class="qj" href="#">
                  <img
                    class="qh cu"
                    src="assets/img/avatar-fat.jpg">
                </a>
                <div class="qg">
                  <strong>Jacon Thornton: </strong>
                  Donec id elit non mi porta gravida at eget metus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Donec ullamcorper nulla non metus auctor fringilla. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis.
                </div>
              </li>
              <li class="qf">
                <a class="qj" href="#">
                  <img
                    class="qh cu"
                    src="assets/img/avatar-mdo.png">
                </a>
                <div class="qg">
                  <strong>Mark Otto: </strong>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                </div>
              </li>
            </ul>
          </div>
        </li>

        <li class="qf b aml">
          <a class="qj" href="#">
            <img
              class="qh cu"
              src="assets/img/avatar-fat.jpg">
          </a>
          <div class="qg">
            <div class="aoc">
              <div class="qn">
                <small class="eg dp">12 min</small>
                <h5>Jacob Thornton</h5>
              </div>
              <p>
                Donec id elit non mi porta gravida at eget metus. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              </p>
            </div>
          </div>
        </li>

        <li class="qf b aml">
          <a class="qj" href="#">
            <img
              class="qh cu"
              src="assets/img/avatar-mdo.png">
          </a>
          <div class="qg">
            <div class="qn">
              <small class="eg dp">34 min</small>
              <h5>Mark Otto</h5>
            </div>

            <p>
              Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
            </p>

            <div class="any" data-grid="images">
              <img style="display: none" data-width="640" data-height="640" data-action="zoom" src="assets/img/instagram_3.jpg">
            </div>

            <ul class="qo">
              <li class="qf">
                <a class="qj" href="#">
                  <img
                    class="qh cu"
                    src="/uploads/avatars/{{ Auth::user()->avatar }}">
                </a>
                <div class="qg">
                  <strong>{{ Auth::user()->name }}: </strong>
                  Donec id elit non mi porta gravida at eget metus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Donec ullamcorper nulla non metus auctor fringilla. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis.
                </div>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
    <div class="gn">
      <div class="alert pv alert-dismissible ss" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <a class="pr" href="profile/index.html">Visit your profile!</a> Check your self, you aren't looking too good.
      </div>

      <div class="qv rc alu ss">
        <div class="qw">
          <h5 class="ald">Sponsored</h5>
          <div data-grid="images" data-target-height="150">
            <img class="qh" data-width="640" data-height="640" data-action="zoom" src="assets/img/instagram_2.jpg">
          </div>
          <p><strong>It might be time to visit Iceland.</strong> Iceland is so chill, and everything looks cool here. Also, we heard the people are pretty nice. What are you waiting for?</p>
          <button class="cg ts fx">Buy a ticket</button>
        </div>
      </div>

      <div class="qv rc alu ss">
        <div class="qw">
        <h5 class="ald">Likes <small>· <a href="#">View All</a></small></h5>
        <ul class="qo anx">
          <li class="qf alm">
            <a class="qj" href="#">
              <img
                class="qh cu"
                src="assets/img/avatar-fat.jpg">
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
                src="assets/img/avatar-mdo.png">
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

      <div class="qv rc aok">
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
