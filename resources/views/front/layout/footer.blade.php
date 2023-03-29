</div>

<footer id="footer" class="light narrow">
    <div class="footer-copyright">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p><strong class="text-uppercase">Casthost Podcast</strong> - &copy; Copyright 2023 - All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>

<script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6423373431ebfa0fe7f53380/1gskov9ne';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>

    
<!-- Vendor -->
<script src="{{asset('front_assets/vendor/plugins/js/plugins.min.js')}}"></script>
<script src="{{asset('front_assets/vendor/jquery-mousewheel/jquery.mousewheel.min.js')}}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{asset('front_assets/js/theme.js')}}"></script>

<!-- Revolution Slider Scripts -->
<script src="{{asset('front_assets/vendor/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('front_assets/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>

<!-- Current Page Vendor and Views -->
<script src="{{asset('front_assets/js/views/view.contact.js')}}"></script>

<!-- Demo -->
<script src="{{asset('front_assets/js/demos/demo-photography.js')}}"></script>

<!-- Theme Custom -->
<script src="{{asset('front_assets/js/custom.js')}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset('front_assets/js/theme.init.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

<script>
    <?php
    if (Session::has('message')) { ?>
        var type = "{{Session::get('alert-type','info')}}";
        switch (type) {
            case 'info':
                toastr.info(" {{Session::get('message')}} ");
                break;
            case 'success':
                toastr.success(" {{Session::get('message')}} ");
                break;
            case 'warning':
                toastr.warning(" {{Session::get('message')}} ");
                break;
            case 'error':
                toastr.error(" {{Session::get('message')}} ");
                break;
        }
    <?php } ?>
</script>



</body>

</html>