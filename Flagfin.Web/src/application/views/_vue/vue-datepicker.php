<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/17/2019
 * Time: 9:18 AM
 */
?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/datepicker/css/datepicker.css"/>
<script src="<?php echo base_url();?>assets/libs/datepicker/js/bootstrap-datepicker.js"></script>

<script>
    /*  $(document).ready(function () {
        $('.datePicker').datepicker({format:'yyyy-mm-dd'});
    });*/

    Vue.directive('datePicker', {
        // When the bound element is inserted into the DOM...
        inserted: function (el,binding) {
            var format = (binding.value && binding.value.format) || "yyyy-mm-dd";
            $(el).datepicker({format:format})
                .on("changeDate",function (ev) {
                    //console.log(ev);
                    var event = new Event('input', {bubbles: true});
                    el.dispatchEvent(event);
                });
        }
    });

</script>
