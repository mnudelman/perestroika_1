<?php
/**
 * форма - фильтр рассылки  заказов
 * @var $htmlPrefix
 * @var $filterForm
 */
use yii\widgets\ActiveForm;
use yii\bootstrap\ButtonDropdown ;
?>
<div id="<?= $htmlPrefix ?>-filter"
     title="подготовка и сохранение фильтра для рассылки исполнителям"
     style="display:none;border:1px solid blue;border-radius:3px;">
    <?php
    $form = ActiveForm::begin([
        'id' => $htmlPrefix .'-filter-form',
        'action' => '#',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-2 control-label'],
        ],
    ]);
    ?>
    <!---->
    <?php echo ButtonDropdown::widget(
            [
                'label' => 'соответствие работ -100%' ,
                'id' => $htmlPrefix .'-' .'workRank-bt',     // geography-country-bt
                'options' => [
                    'name' => $htmlPrefix .'-workRank-100',
                    'class' => 'btn btn-default',
                    'style' => 'white-space: pre-wrap;',
//                                'disabled' => $disabled
                ],
                'dropdown' => [
                    'options' => [
                        'class' => 'list-group',
//                                    'style' => $styleDropdown,
                        'id' => $htmlPrefix . '-workRank-ul',     // geography-country-ul
                        'name' => 'workRank-75',
                    ],
                    'items' => [
                        [
                            'label' => 'соответствие работ -50%',
                            'url' => '#',
                            'options' => [
                                'class' => 'list-group-item',
                                'name' => $htmlPrefix .'-' .'workRank-50',
                                'onclick' => "dropDownSelect('" .$htmlPrefix .'-' .'workRank-50' ."')"
                            ],
                        ],
                        [
                            'label' => 'соответствие работ -75%',
                            'url' => '#',
                            'options' => [
                                'class' => 'list-group-item',
                                'name' => $htmlPrefix .'-' .'workRank-75',
                                'onclick' => "dropDownSelect('" .$htmlPrefix .'-' .'workRank-75' ."')"
                            ],
                        ],
                        [
                            'label' => 'соответствие работ -100%',
                            'url' => '#',
                            'options' => [
                                'class' => 'list-group-item active',
                                'name' => $htmlPrefix .'-' .'workRank-100',
                                'onclick' => "dropDownSelect('" .$htmlPrefix .'-' .'workRank-100' ."')"
                            ],


                        ]
                    ]
                ]
            ]) ?>

    <?php echo ButtonDropdown::widget(
        [
            'label' => 'соответствие места (город)-100%' ,
            'id' => $htmlPrefix .'-' .'geographyRank-bt',     // geography-country-bt
            'options' => [
                'name' => $htmlPrefix .'-geographyRank-100',
                'class' => 'btn btn-default',
                'style' => 'white-space: pre-wrap;',
//                                'disabled' => $disabled
            ],
            'dropdown' => [
                'options' => [
                    'class' => 'list-group',
//                                    'style' => $styleDropdown,
                    'id' => $htmlPrefix . '-geographyRank-ul',     // geography-country-ul
                    'name' => 'workRank-75',
                ],
                'items' => [
                    [
                        'label' => 'соответствие места (регион)-50%',
                        'url' => '#',
                        'options' => [
                            'class' => 'list-group-item',
                            'name' => $htmlPrefix . '-geographyRank-50',
                            'onclick' => "dropDownSelect('" .$htmlPrefix .'-' .'geographyRank-50' ."')"
                        ],
                    ],
                    [
                        'label' => 'соответствие места (город)-100%',
                        'url' => '#',
                        'options' => [
                            'class' => 'list-group-item active',
                            'name' => $htmlPrefix . '-geographyRank-100',
                            'onclick' => "dropDownSelect('" .$htmlPrefix .'-' .'geographyRank-100' ."')"
                        ],
                    ],
                ]
            ]
        ]) ?>








    <div class="form-messages-success" name="form-messages-success">

    </div>
    <div class="form-messages-error" name="form-messages-error">

    </div>

    <?php
    ActiveForm::end();
    ?>
    <br>
    <div style="margin-bottom: 5px">
        &nbsp;
        <button class="btn btn-primary" title="filter"
                onclick="dataFilter('<?=$htmlPrefix?>-save')">
            установить фильтр
        </button>
    </div>
</div>