<script type="text/javascript" src="{{ asset('site/assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/mmenu.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/swiper-bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/swiper.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/rangle-slider.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/countto.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/lazysize.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/assets/js/main.js') }}"></script>
<script>
    new Mmenu(document.querySelector("#menu"));
</script>
@stack('script-src')
@stack('script-tag')