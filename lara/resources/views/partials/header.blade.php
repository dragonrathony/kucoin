<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand"
            href="{{url('/')}}">Demo KuCoin</a>
        @if ($session === null)
        @else
        <a href="{{ url('/logout') }}"
            type="button"
            class="btn btn-secondary">Log out</a>
        @endif

    </div>
</nav>