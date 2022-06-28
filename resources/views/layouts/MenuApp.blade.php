<link rel="stylesheet" href="/home/css/app.css">
<link rel="icon" type="image/png" href="/storage/logo/log.png"/>
<header class="menu_home">
    <nav class="nav_home">
        <ul>
            @foreach ($app as $apps)
            <li class="name_app" id_app="{{$apps->id}}" name_app="{{$apps->app_name}} ">{{$apps->app_name}}</li>
            @endforeach
        </ul>
    </nav>
</header>
<script type="text/javascript" src="csss/jquery.min.js"></script>
<script src="/home/js/app.js"></script>
