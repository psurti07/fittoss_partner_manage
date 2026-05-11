<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<style>
    #header_main .header-inner {
        background-color: var(--bg-4) !important;
    }
</style>
@include('partials.site.head')

<body class="counter-scroll">
    <div id="wrapper">
        <!-- <div class="relative"> -->
        <!-- </div> -->
        <header id="header_main" class="header bg-4 py-0 py-lg-4 border-0">
            <div class="header-inner bg-4">
                <div class="header-inner-wrap">
                    <div class="header-left flex-grow">
                        <div id="site-logo">
                            <a href="{{ route('get.index') }}" rel="home">
                                <img id="logo-header" src="{{ asset('assets/images/logo/fittoss-logo.png') }}" alt="" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        @yield('content')
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
