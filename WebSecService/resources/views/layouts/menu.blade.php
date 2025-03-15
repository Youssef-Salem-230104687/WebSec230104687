<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light">
    
 <div class="container-fluid">

<ul class="navbar-nav">

 <li class="nav-item">
 <a class="nav-link" href="./">Home</a>
 </li>
 
 <!-- <li class="nav-item">
 <a class="nav-link" href="./even">Even Numbers</a>
 </li>

 <li class="nav-item">
 <a class="nav-link" href="./prime">Prime Numbers</a>
 </li>

 <li class="nav-item">
 <a class="nav-link" href="./multable">Multiplication Table</a>
 </li> -->

 <!-- <li class="nav-item">
 <a class="nav-link" href="./MiniTest"> MiniTest</a>
 </li>

 <li class="nav-item">
 <a class="nav-link" href="./Transcript">Transcript</a>
 </li>

 <li class="nav-item">
 <a class="nav-link" href="./Products"> Products Page</a>
 </li> -->

 <!-- <li class="nav-item">
 <a class="nav-link" href="./Calculator">Calculator </a>
 </li> -->

 <!-- <li class="nav-item">
 <a class="nav-link" href="./products"> Products </a>
 </li> -->

 <li class="nav-item">
 <a class="nav-link" href="./users"> Users </a>
 </li>

 <li class="nav-item">
    <a class="nav-link" href="./grades">Grades</a>
 </li>
        
 <li class="nav-item">
    <a class="nav-link" href="./questions">MCQ Exam</a>
 </li>

    <!-- @auth
    <li class="nav-item"><a class="nav-link">{{auth()->user()->name}}</a></li>

    <li class="nav-item"><a class="nav-link" href="{{route('do_logout')}}">Logout</a></li>
    @else
    <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('register')}}">Register</a></li>
    @endauth -->

            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile') }}">{{ auth()->user()->name }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('do_logout') }}">Logout</a>
                </li>

            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @endauth

            
    
</ul>



</div>

</nav>


</body>
</html>