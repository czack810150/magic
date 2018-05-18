<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Magic Noodle Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="{{ url('css/floating-labels.css')}}" rel="stylesheet">
  </head>

  <body>
  <div class="container">
  <div class="row justify-content-md-center">
    
    <div class="col-md-auto">
    <div class="text-center">
        <img class="" src="{{ url('img/logo.png') }}" alt="logo" width="750">  
    </div>
    </div>
    
  </div>


 

    <form class="form-signin" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
     

      <div class="form-label-group">
        
         <input class="form-control" type="email" placeholder="Email address" name="email" value="{{ old('email') }}" required id="inputEmail" autofocus>
         <label for="inputEmail">Email address</label>
              @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif


      </div>

      <div class="form-label-group">
       
        <input class="form-control" type="password" placeholder="Password" name="password" required id="inputPassword">
            @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
        <label for="inputPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted text-center">&copy; {{Carbon\Carbon::now()->year}} Magic Noodle</p>
    </form>
    </div>
  </body>
</html>