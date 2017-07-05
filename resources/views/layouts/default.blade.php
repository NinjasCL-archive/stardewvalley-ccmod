<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Community Center Modifier - Ninjas.cl</title>
  <link rel="stylesheet" type="text/css" href="{{asset('bower_components/bulma/css/bulma.css')}}">
  <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
  
  @yield('scripts')

  <style>
    .bg-black {
      background-color: #000;
    }
    .padding-top-20px {
      padding-top: 20px;
    }
    .padding-bottom-20px {
      padding-bottom: 20px;
    }

    .margin-top-20px {
      margin-top: 20px;
    }
    .margin-bottom-20px {
      margin-bottom: 20px;
    }
  </style>
  
  @yield('styles')

</head>
<body>
  <div class="container is-fluid">
    <div class="tile is-ancestor">
      <div class="tile is-parent">
        <div class="tile is-child"></div>
        <div class="tile is-child padding-top-20px has-text-centered">
          <a href="{{URL::to('/')}}">
            <img src="{{asset('img/sdv_logo.png')}}">
            <h1 class="title is-2">{{__('Community Center Modifier')}}</h1>
          </a>          
          <p>{{__('Create your Own Community Center Arc!')}}</p>
        </div>
        <div class="tile is-child"></div>
      </div>
    </div>
  </div>
  @yield('content')
</body>
</html>