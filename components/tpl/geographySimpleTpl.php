<?php
/**
 * шаблон вывода кнопки - элемента географии(страна | регион | город)
 * @var $typeName = { 'country' | 'region' | 'city'} - тип элемента географии
 * @var $currentName - имя элемента
 * @var $currentId
 * @var $itemList - список возможных значений item = ['id' => ..,'name' => ..]
 */
//use yii\bootstrap\ButtonDropdown;

?>


<?php
$styleDropdown = 'overflow-y:auto;max-height:400px;white-space: pre-wrap;';
/**
 * @var $htmlPrefix - обеспечивает уникальность
 * @var $onClickFunction -
 * @var $disabled
 *
 */
?>
<!--<div class="col-md-4">-->
<!--    <div class="btn-group dropup">-->
        <?php
        $liList = [];
//        $currentName = (isset($this->currentCountry['name'])) ? $this->currentCountry['name'] : false;
        for ($i = 0; $i < sizeof($itemList); $i++) {
            $item = $itemList[$i];
            $elName =$htmlPrefix .'-' .$typeName . '-' . $item['id'];
            $name = $item['name'];
            $activeFlag = ($currentName === $name);     // текущий элемент в списке
            $liList[] = [
                'label' => $name,
                'url' => '#',
                'options' => [
                    'class' => 'list-group-item' . (($activeFlag) ? ' active' : ''),
                    'name' => $elName,
                    'onclick' => $onClickFunction .'("' . $elName . '")'
                ]
            ];
        }
//        echo ButtonDropdown::widget([
//            'label' => (false === $currentName) ? 'страна' : $currentName,
//            'id' => $htmlPrefix . '-' . $typeName . '-bt',     // geography-country-bt
//            'options' => [
//                'name' => $typeName . '-' .$currentId,
//                'class' => 'btn btn-primary',
//                'style' => 'white-space: pre-wrap;',
//                'disabled' => $disabled
//            ],
//            'dropdown' => [
//                'options' => [
//                    'class' => 'list-group',
//                    'style' => $styleDropdown,
//                    'id' => $htmlPrefix . '-' . $typeName . '-ul',     // geography-country-ul
//                    'name' => $typeName . '-' .$currentId,
//                ],
//                'items' => $liList]
//        ]);

        $widgetPar = [
            'label' => (false === $currentName) ? 'страна' : $currentName,
            'id' => $htmlPrefix . '-' . $typeName . '-bt',     // geography-country-bt
            'options' => [
                'name' => $typeName . '-' .$currentId,
                'class' => 'btn btn-primary',
                'style' => 'white-space: pre-wrap;',
                'disabled' => $disabled
            ],
            'dropdown' => [
                'options' => [
                    'class' => 'list-group',
                    'style' => $styleDropdown,
                    'id' => $htmlPrefix . '-' . $typeName . '-ul',     // geography-country-ul
                    'name' => $typeName . '-' .$currentId,
                ],
                'items' => $liList]
        ] ;
        $widgetName = 'ButtonDropdown' ;
        include  __DIR__ . '/variableWidget.php' ;
        ?>
<!--    </div>-->
<!--</div>-->

