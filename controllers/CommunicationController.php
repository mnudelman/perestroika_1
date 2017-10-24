<?php
/**
 * контроллер Коммуникации между пользователями
 */

namespace app\controllers;
use app\controllers\PaginationController ;

class CommunicationController extends PaginationController {
    protected $FILTER_FORM_NAME = 'app\models\CommunicationFilterForm' ;
    protected $EXT_FUNC = 'app\controllers\CommunicationFunc' ;
    protected $VIEW_PREPARE_FUNC = 'app\views\viewParts\CommunicationViewPrepare' ;

}