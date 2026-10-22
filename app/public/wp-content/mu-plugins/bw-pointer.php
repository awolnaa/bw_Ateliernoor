<?php
/** Plugin Name: BW Consistent Pointer */
defined('ABSPATH') || exit;
add_action('wp_head', static function () { ?>
<style id="bw-consistent-pointer">
a[href],button,[role="button"],summary,input[type="submit"],input[type="button"],input[type="reset"],select,label[for],input[type="checkbox"],input[type="radio"]{cursor:pointer!important}
button:disabled,input:disabled,select:disabled,[aria-disabled="true"]{cursor:not-allowed!important}
</style>
<?php }, 99);
