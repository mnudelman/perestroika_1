<?php
/**
 * Личный кабинет
 * Time: 12:37
 */
$PART_DEFAULT = "overview";

$currentPart = (isset($_GET['part'])) ? $_GET['part'] : $PART_DEFAULT;

$descriptionParts = [
    'overview' => 'обзор',
    'registration' => 'регистрация',
    'quickRegistration' => 'быстрая регистрация',
    'order' => 'заказ',
    'developer' => 'исполнитель работ',
    'worksDirections' => 'направления работ',
    'geography' => 'география',
   'privateOffice' => 'личный кабинет',
    'orderExecute' => 'схема прохождения заказа'
];
$currentName = $descriptionParts[$currentPart] ;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 block">
            <ul class="nav nav-pills nav-stacked">
                <?php
                $liList = '';
                foreach ($descriptionParts as $desc => $descName) {
                    $liItem = '<li>';
                    $liItem .= '<a href="index.php?page=about&part=' . $desc . '" class="list-group-item">' . $descName . '</a>';
                    $liItem .= '</li>';
                    $liList .= $liItem;
                }
                echo $liList . '<br>';
                ?>
            </ul>


        </div>
        <div class="col-md-10 block">
            <div class="row">
                <?php
                  if (empty($currentPart)) {
                    echo '<br> Не выбран раздел описания ';
                  }else {

                      echo  '<h3>'.$currentName.'</h3>';
                      include __DIR__ . '/viewParts/about/' . $currentPart. '.php' ;
                  }
                ?>
            </div>
        </div>
    </div>
</div>