<?php
/**
 * сообщение об ошибке
 * @var $errorContent
 */
use yii\helpers\Html ;
?>
<div class="modal fade" id="errorShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="errorShowTitle">         </h4>
            </div>
            <div class="modal-body"  style="overflow-x: auto">
               <div  id="errorShowContent">

                </div>
            </div>
            <div class="modal-footer">
                <p>
                    <!--                    <a class="btn btn-default" href="#" role="button" data-dismiss="modal" id="modal-exit">exit</a>-->
                </p>
            </div>
        </div>
    </div>
</div>
