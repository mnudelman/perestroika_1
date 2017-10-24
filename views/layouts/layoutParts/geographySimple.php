<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 09.01.17
 * Time: 21:39
 */
use yii\bootstrap\ButtonDropdown ;

?>
<?php
$styleDropdown = 'overflow-y:auto;max-height:400px' ;
?>
<div class="col-lg-4">
                        <div class="btn-group dropup">
                        <?php
                        $liList = [] ;
                        for ($i = 0; $i < 100; $i++) {
                            $liList[] = [
                                'label' =>  $i . '_country' ,
                                'url' => '#',
                                'options' => [
                                    'class' => 'list-group-item' . (($i == 75) ? ' active' : ''),
                                    'name' => 'country_' . $i,
                                    'onclick' => 'i_am("country_' . $i .'")'
                                ]
                            ] ;
                        }
                        echo ButtonDropdown::widget([
                            'label' => 'страна',
                            'id' => 'country',

                            'dropdown' =>[
                                'options' => [
                                    'class' => 'list-group',
                                    'style' => $styleDropdown,
                                ],
                                'items' => $liList ]
                        ]);
                        ?>
</div>
</div>

<div class="col-lg-4">
    <div class="btn-group dropup">
        <?php
        $liList = [] ;
        for ($i = 0; $i < 100; $i++) {
            $liList[] = [
                'label' =>  $i . '_region' ,
                'url' => '#',
                'options' => [
                    'name' => 'region_' . $i,
                    'onclick' => 'i_am("region_' . $i .'")'
                ]
            ] ;
        }
        echo ButtonDropdown::widget([
            'label' => 'region',
            'id' => 'region',

            'dropdown' =>[
                'options' => [
                    'style' => $styleDropdown,
                ],
                'items' => $liList ]
        ]);
        ?>
    </div>
</div>
<div class="col-lg-4">
    <div class="btn-group dropup">
        <?php
        $liList = [] ;
        for ($i = 0; $i < 100; $i++) {
            $liList[] = [
                'label' =>  $i . '_city' ,
                'url' => '#',
                'options' => [
                    'name' => 'city_' . $i,
                    'onclick' => 'i_am("city_' . $i .'")'
                ]
            ] ;
        }
        echo ButtonDropdown::widget([
            'label' => 'city',
            'id' => 'city',

            'dropdown' =>[
                'options' => [
                    'style' => $styleDropdown,
                ],
                'items' => $liList ]
        ]);
        ?>
    </div>
</div>
