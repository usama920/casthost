<!-- BEGIN: Footer-->
<footer id="footer" class="border-0 bg-transparent mt-0">
    <div class="footer-copyright bg-transparent">
        <div class="row">
            <div class="col mb-5">
                <p class="text-center text-3 mb-0">Copyright © 2022. All rights reserved by Casthost Podcasts</p>
            </div>
        </div>
    </div>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="{{ asset('admin_assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/core/app-menu.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/core/app.js') }}"></script>
<script src="{{ asset('admin_assets/js/custom.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

<script>
    var currency = "<?php echo Session::get('currency'); ?>";
    <?php
        if (Session::has('message')) { ?>
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    <?php } ?>
</script>

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
