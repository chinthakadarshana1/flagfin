<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/17/2019
 * Time: 9:18 AM
 */
?>

<script>
    Vue.directive('validator', {
        // When the bound element is inserted into the DOM...
        inserted: function (el,binding) {
            let element =  $(el);
            element.addClass("vue-validator-field");

            element.on( "vue:validate-field", function( event ) {
                let alreadyValid = !(typeof element.attr('data-is-invalid') !== 'undefined');
                let regexString = binding.value && binding.value.regex;
                let formatRegex = null;

                if(regexString === "email")
                    formatRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                else
                    formatRegex = new RegExp((binding.value && binding.value.regex));

                if(!formatRegex.test($(el).val()) || !alreadyValid){
                    element.addClass("vue-invalid");
                    element.tooltip("show");
                }else{
                    element.removeClass("vue-invalid");
                    element.tooltip("hide");
                }
            });
        }
    });

</script>
