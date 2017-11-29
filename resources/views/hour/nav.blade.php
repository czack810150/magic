<nav class="navbar navbar-expand navbar-dark bg-primary">
  <a class="navbar-brand" href="/hours">Hours</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/hours">Home</span></a>
      </li>
      @can('calculate-hours')
      <li class="nav-item">
        <a class="nav-link" href="/hours/compute">Compute</a>
      </li>
      @endcan
    
     
    </ul>
  
  </div>
</nav>

