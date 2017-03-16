<!DOCTYPE html>
<html lang="en">
  <head>
    @include('partials._head')
  </head>

  <body>
    

    <div class="container">
      @yield('body')
    </div>

    @include('partials._footer')
    @include('partials._javascript')
    @yield('scripts')
  </body>
</html>
