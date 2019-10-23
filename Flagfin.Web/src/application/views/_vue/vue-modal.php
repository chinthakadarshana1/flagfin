<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/27/2019
 * Time: 5:48 PM
 */
?>

<script type="text/x-template" id="vue-modal-template">
    <div :class="['modal',modalClass]">
        <div class="modal-dialog" :class="modalDialogClass">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">{{modalTitle}}</h4>
                </div>
                <component v-bind:is="modalTemplate" ref="modalComponent">
                </component>
            </div>
        </div>
    </div>
</script>

<script type="application/javascript">

    function vueModal() {
        let modal =  Vue.component('vue-modal', {
            template: '#vue-modal-template',
            props: {
                modalTemplate : {required:true},
                modalClass : {
                    type: String,
                    default: 'modal-default'
                },
                modalTitle : {
                    type:String,
                    required:true
                },
                modalDialogClass : {
                    type: String,
                    default: ''
                }
            },
            data :function () {
                return {
                };
            },
            computed :{
            },
            watch:{
            },
            methods:{
                show : function () {
                    $(this.$el).modal("show");
                },
                hide : function () {
                    $(this.$el).modal("hide");
                }
            },
            mounted: function () {
            }
        });
        return modal;
    }

</script>

