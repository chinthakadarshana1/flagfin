<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/17/2019
 * Time: 9:18 AM
 */
 //https://vuejs.org/v2/examples/select2.html
?>


<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/select2-4.0.3/dist/css/select2.min.css"/>
<script src="<?php echo base_url();?>assets/libs/select2-4.0.3/dist/js/select2.min.js"></script>


<script type="text/x-template" id="vue-select2-template">
    <select>
        <slot></slot>
    </select>
</script>


<script>
    Vue.component('select2', {
        props: ['options', 'value'],
        template: '#vue-select2-template',
        mounted: function () {
            let select2Options = this.options || {};
            let vm = this;
            $(this.$el)
            // init select2
                .select2(select2Options)
                .val(this.value)
                .trigger('change')
                // emit event on change.
                .on('change', function () {
                    vm.$emit('input', $(this).val())
                })
        },
        watch: {
            value: function (value,oldValue) {
                // update value
                if(JSON.stringify(value) !== JSON.stringify(oldValue)){
                    $(this.$el)
                        .val(value)
                        .trigger('change')
                }
            },
            options: function (options) {
                // update options
                $(this.$el).empty().select2(options)
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    })

</script>
