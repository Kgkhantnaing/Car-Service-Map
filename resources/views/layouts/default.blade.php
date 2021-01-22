<!doctype html>
<html>

<head>
    @include('includes.head')
   
</head>

<body id="page-top">
    <div id="wrapper">

        @include('includes.header')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('includes.navbar')
                
                @yield('content')
            </div>
        </div>
        <!-- <div id="main">
            
        </div> -->
        <!-- <footer>
            @include('includes.footer')
        </footer> -->
    </div>
    @include('includes.footer-scripts')
</body>
</html>