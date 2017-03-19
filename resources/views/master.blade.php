<!DOCTYPE html>
<html lang="en">
<head>
  @include('partials._head')
</head>

<body>
  @include('partials._nav')

  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        @include('partials._sidebar')
      </div>
      <div class="col-sm-9">
        @yield('content')
      </div>
    </div>
  </div>

  @include('partials._footer')
  @include('partials._javascript')
  @yield('scripts')
</body>
</html>
