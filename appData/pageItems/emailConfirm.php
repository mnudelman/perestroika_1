<?php
/**
 * подтверждение правильности адреса email
 * Time: 11:10
 */
$messageOk_ru = <<<TEXT
Для завершения нажмите "oK!" внизу формы.<br>
Ваши реквизиты: <br>
TEXT;
$messageOk_en = <<<TEXT
To finish, click "oK!" at the bottom of the form.<br>
Your details: <br>
TEXT;

$messageError_ru = <<<TEXT
<b>Ошибка идентификации в базе данных</b>.<br>
      Для повторения процедуры выполните следущее: <br>
      &nbsp;&nbsp;-Войдите на сайт под своим именем  <br>
      &nbsp;&nbsp;-зайдите в "профиль"<br>
      &nbsp;&nbsp;-на вкладке "основное" нажмите "сохранить"<br>
TEXT;
$messageError_en = <<<TEXT
Error identification in the database</b>.<br>
To repeat the procedure, perform the following: <br>
&nbsp;&nbsp;-Login to website under your name. <br>
&nbsp;&nbsp;-go to "profile"<br>
&nbsp;&nbsp;-on the General tab, click save<br>
TEXT;

$fields = [
    'name' => [
            'ru' => 'имя',
            'en' => 'name'
    ],
];


return [
    'title' => [
            'ru' => 'Подтверждение правильности адреса email',
            'en' => 'Validation email'
    ],
    'messageOk' => [
                'ru' => $messageOk_ru,
                'en' => $messageOk_en,
    ],
    'messageError' => [
            'ru' => $messageError_ru,
            'en' => $messageError_en,
    ],
    'fields' => $fields
];
