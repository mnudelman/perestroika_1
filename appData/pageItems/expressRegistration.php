<?php
/**
 * Быстрая регистрация
 * Time: 15:34
 */
$text_ru = <<<TEXT
<b>Экспресс регистрация (ЭР)</b> рассматривается как инструмент пробной работы на сайте.<br>
&nbsp;&nbsp;-Пройдя процедуру <b>ЭР</b>, пользователь получит в качестве имени свой email и сгенерированный
пароль. Этой информации достаточно для разового размещения заказа.<br>
&nbsp;&nbsp;-В дальнейшем можно заполнить свой профиль и стать полноценным пользователем сайта.<br>
<b>Замечание 1.</b> Для проверки подлинности email, пользователь <br>
&nbsp;&nbsp;получит на указанный адрес сообщение со ссылкой для подтверждения регистрации.<br>
<b>Замечание 2.</b> Рассылка потенциальным исполнителям заказа будет выполнена только после подтверждения
 регистрации.<br>
<b>Замечание 3.</b> <b>ЭР</b> может быть использована для уточнения email в случае, когда пользователь,
пройдя обычную регистрацию, указал неверный email или по какой-то причине не сделал
подтверждение .<br>
<b>Правила заполнения полей: </b><br>
&nbsp;&nbsp;-Обязательные поля отмечены символом <span style="color:red">"*"</span>. <br>
&nbsp;&nbsp;-Поле "электронная почта" должно иметь вид: qwerty@mail.ru' . <br>
TEXT;
$text_en = <<<TEXT
<b>Express registration (ER)</b> is seen as a tool of pilot work on the site.<br>
&nbsp;&nbsp;-the procedure of Passing the <b>ER</b>, the user will receive as the name your email and the generated
password. This information is sufficient for a single order.<br>
&nbsp;&nbsp; In the future, you can complete your profile and become a full user of the site.<br>
<b>Note 1.</b> To authenticate the email user <br>
&nbsp;&nbsp;get to the address a message with a link to confirm your registration.<br>
<b>Note 2.</b> Sending to potential executors of the order will be executed only after confirmation
registration.<br>
<b>Note 3.</b> <b>ER</b> can be used to specify the email in the case when the user
after normal registration, have an incorrect email or for some reason did not
confirmation .<br>
<b>Rules of filling: </b><br>
&nbsp;&nbsp; are required fields marked with <span style="color:red">"*"</span>. <br>
&nbsp;&nbsp;-the Field "email" should be: qwerty@mail.ru' . <br>
TEXT;
$impersonation_ru = <<<TEXT
<b>Ошибка.</b>В базе данных есть пользователь с указанным email.<br>
<b>Возможны следующие действия:</b><br>
&nbsp;&nbsp;- Если это ваш email, то войдите на сайт по стандартной схеме(через login)<br>
&nbsp;&nbsp;- Иначе используйте другой email.
TEXT;
$impersonation_en = <<<TEXT
<b>Error.</b>In the database there is a user with the specified email.<br>
<b>Possible action:</b><br>
&nbsp;&nbsp;- If this is your email, log on to the website according to the standard scheme(via login)<br>
&nbsp;&nbsp;- Or use another email.
TEXT;
$expressForm = [
    'title' => [
        'text' => [
            'ru' => 'ЭКСПРЕСС РЕГИСТРАЦИЯ',
            'en' => 'EXPRESS REGISTRATION'
        ],
    ],
    'rules' => [
        'title' => [
            'text' => [
                'ru' => 'Для экспресс регистрации используйте правила:',
                'en' => 'To fill use the rules:'
            ]
        ],
        'content' => [
            'text' => [
                'ru' => $text_ru,
                'en' => $text_en
            ]
        ],
        'messages' => [
            'success' => [
                'text' => [
                    'ru' => 'oK!',
                    'en' => 'oK!.'
                ]
            ],
            'error' => [
                'text' => [
                    'ru' => 'Регистрация не выполнена.',
                    'en' => 'The profile is not saved.'
                ]
            ],
            'orNormalLogin'  => [
                'text' => [
                    'ru' => 'или использовать обычный "login"',
                    'en' => 'or use the normal "login"'
                ]
            ],
            'impersonation' => [                // подмена пользователя
                'text' => [
                    'ru' => $impersonation_ru,
                    'en' => $impersonation_en
                ]
            ]
        ]

    ]
];
