<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Magic Noodle Login</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  </head>

  <body>
    <section class="section">
       <div class="container">

<div class="columns">
  <div class="column"></div>
  <div class="column">
        <figure class="image">
  <img src="{{ url('img/logo.png') }}" width="643" height="228">
        </figure>
  </div>
  <div class="column"></div>
</div>

<div class="columns">
<div class="column"></div>
  <div class="column">
    <form class="form-signin" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
     
      <div class="field">
        <label for="inputEmail" class="label">Email address</label>
              @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
        <div class="control">
          <input class="input" type="email" placeholder="Email address" name="email" value="{{ old('email') }}" required id="inputEmail" autofocus>
        </div>
      </div>
   
      <div class="field">
        <label for="inputPassword" class="label">Password</label>
      <div class="control">
       
        <input class="input" type="password" placeholder="Password" name="password" required id="inputPassword">
            @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
        
      </div>
    </div>

     
        <label class="checkbox">
          
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
        </label>
      <div class=" has-text-centered">
      <button class="button is-primary" type="submit">Sign in</button>
      </div>
    </form>
  </div>
  <div class="column"></div>
</div>
    </div>
    </section>

    <footer class="footer">
  <div class="content has-text-centered">
    <p>&copy; {{Carbon\Carbon::now()->year}} Magic Noodle
      <strong>Powered</strong> by Hiro Su. 
    </p>
  </div>
</footer>
 
  </body>
</html>