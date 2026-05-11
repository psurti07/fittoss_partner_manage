<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
@include('partials.site.head')

<body class="counter-scroll">
    <div id="wrapper">
        <!-- <div class="relative"> -->
            @include('partials.site.header')
        <!-- </div> -->
        @yield('content')
        @include('partials.site.footer')
        @include('stacks.js.site.scripts')
    </div>
    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;">
            </path>
        </svg>
    </div>
</body>

</html>