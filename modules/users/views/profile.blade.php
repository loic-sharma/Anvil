<h3>Welcome back, {{ $user->displayName() }}!</h3>

<p><a href="{{ $url->to('users/logout') }} ">Logout</a>