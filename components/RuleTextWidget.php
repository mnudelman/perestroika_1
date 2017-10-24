<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 28.07.17
 * Time: 19:58
 */

namespace app\components;
use yii\base\Widget;
use Yii;

class RuleTextWidget extends Widget {
    public $htmlPrefix = '' ;
    public $ruleTitle = 'Подсказка.';
    public $ruleItems = [] ;
    private $currentId = 0 ;
    private $ruleBlockId ;
//---------------------------------------------//
    public function init() {
        $this->ruleBlockId = $this->getBlockId() ;
    }
    public function run() {
        ob_start();
        $ruleHead = $this->getRuleHead() ;
        echo $ruleHead ;
        $title = $this->ruleTitle ;
        $htmlPrefix = $this->htmlPrefix ;
        include __DIR__ . '/tpl/closePanel.php' ;

        foreach ($this->ruleItems as $itemId => $ruleItem) {
            $this->currentId++ ;
            $this->itemInclude($ruleItem) ;
        }
        echo '</div>' ;
        return ob_get_clean();

    }
    private function getRuleHead() {
        $blockHead = '<div class="panel-group" id="' .$this->ruleBlockId .
            '" role="tablist" aria-multiselectable="true" style="display:none">' ;
        return $blockHead ;
    }
    private function getBlockId() {
        return $this->htmlPrefix . '-rule-accordion' ;
    }
    private function getContentId() {
        $ruleId = $this->htmlPrefix . '-ruleContent-' . $this->currentId ;
        return $ruleId ;
    }
    private function getHeadingId() {
        $headingId = $this->htmlPrefix . '-ruleHeading-' . $this->currentId ;
        return $headingId ;
    }
    /**
     *  * Элемент блока подсказок (1 accordion)
     * @var $ruleBlockId
     * @var $headingId
     * @var $contentId
     * @var $ruleTitle
     * @var $ruleContent
     * @param $ruleItem
     */
    private function itemInclude($ruleItem) {
        $ruleTitle = $ruleItem['ruleTitle'] ;
        $ruleContent = $ruleItem['ruleContent'] ;
        $ruleBlockId = $this->ruleBlockId ;
        $contentId = $this->getContentId() ;
        $headingId = $this->getHeadingId() ;
        include __DIR__ . '/tpl/ruleTextItem.php' ;
    }

}