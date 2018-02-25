<?php
/**
 * сообщения, имена полей, правила заполнения, связанные с
 * регистрацией, входом, профилем
 */
use app\models\UserRegistration;
use app\service\PageItems ;
$loginForm = [
    'title' => [
            'ru' => 'ВОЙТИ',
            'en' => 'LOGIN'
    ],
    'rules' => [
        'title' => [
                'ru' => 'заполните следующие поля для входа, используя правила:',
                'en' => 'fill out the following fields to login using the rules:'
        ],
        'content' => [
                'ru' => '- Обязательные поля отмечены символом <span style="color:red">"*"</span><br>' .
                        '- если впервые заходите на наш сайт, используйте пункт меню "регистрация" '
                ,
                'en' => '- Required fields are marked with <span style="color:red">"*"</span> symbol>br>'.
                        '- if first visit our website, use the menu item "registration"'
        ]
    ],
    'messages' => [
        'username' => [
                'ru' => 'Неправильное имя пользователя',
                'en' => 'Incorrect user name'
        ],
        'password' => [
                'ru' => 'Неправильный пароль',
                'en' => 'Incorrect password'
        ],
    ]
];
$nameMin = UserRegistration::NAME_MIN_LENGTH;
$nameMax = UserRegistration::NAME_MAX_LENGTH;
$passwMin = UserRegistration::PASSW_MIN_LENGTH;
$passwMax = UserRegistration::PASSW_MAX_LENGTH;

$registrationForm = [
    'title' => [
            'ru' => 'РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ',
            'en' => 'USER REGISTRATION'
    ],
    'rules' => [
        'title' => [
                'ru' => 'заполните следующие поля для регистрации, используя правила:',
                'en' => 'fill out the following fields to registration using the rules:'
        ],
        'content' => [
                'ru' =>
                    '- Обязательные поля отмечены символом <span style="color:red">"*"</span>' . '<br>' .
                    '- Для заполнения полей: "имя пользователя", "пароль" использовать следующие символы:<br>
                    строчные буквы латинского алфавита (a,..,z), десятичные цифры (0,...,9), подчёркивание (_),
                    знак минус (-). Пробелы не допускаются.' . '<br>' .
                    '- Длина поля "имя пользователя" от ' . $nameMin . ' до ' . $nameMax . ' символов ' . '<br>' .
                    '- Длина поля "пароль" от ' . $passwMin . ' до ' . $passwMax . ' символов ' . '<br>' .
                    '',
                'en' =>
                    '- Required fields are marked with <span style="color:red">"*"</span> symbol<br>' .
                    '- Fields: "username", "password" use the following symbols:<br>' .
                    'lowercase Latin letters (a..z), decimal digits (0,...,9), underscore (_),' .
                    'a minus sign (-). Spaces are not allowed.<br>' .
                    '- The length of the field "user name" from ' . $nameMin . ' to' . $nameMax . ' characters.<br>' .
                    '- The length of the "password" field from ' . $passwMin . ' to ' . $passwMax . ' characters.<br>' .
                    ''
        ],
        'messages' => [
            'success' => [
                    'ru' => 'Регистрация пользователя выполнена. Другие реквизиты можно редактировать через
                         пункт меню "профиль" ',
                    'en' => 'User registration is performed. Other props can be edited via
                         the menu item "profile"'
            ],
            'error' => [
                    'ru' => 'Регистрация пользователя не выполнена.',
                    'en' => 'User registration is not performed.'
            ]

        ]
    ]
];

$profileForm = [
    'title' => [
            'ru' => 'РЕДАКТИРОВАНИЕ ПРОФИЛЯ ПОЛЬЗОВАТЕЛЯ',
            'en' => 'EDIT THE USER PROFILE'
    ],
    'rules' => [
        'title' => [
                'ru' => 'можете изменить поля профиля, используя правила:',
                'en' => 'can change the profile fields using the rules:'
        ],
        'content' => [
                'ru' =>
                    '-Обязательные поля отмечены символом <span style="color:red">"*"</span>' . '<br>' .
                    '-Поле "электронная почта" должно иметь вид: qwerty@mail.ru' . '<br>' .
                    '-Поле "сайт" - это полный url-адрес вида: http://mysite.ru' . '<br>' .
                    '-Кнопкой "восстановить" можно вернуть последние сохранённые значения' . '<br>' .
                    '-Если нажата кнопка "сохранить", то предшествующие значения будут заменены текущими'
                ,
                'en' =>
                    '-Required fields are marked with <span style="color:red"> "*"</span> symbol<br>' .
                    '-The field "email" should be: myname@mail.ru.' . '<br>' .
                    '-The field "website" is the full url of the form: http://mysite.ru.' . '<br>' .
                    '-Click "restore" to return to the last saved values' . '<br>' .
                    '-If you press "save", the previous values are replaced by the current'

        ],
        'messages' => [
            'success' => [
                    'ru' => 'Профиль сохранён',
                    'en' => 'The profile is saved.'
            ],
            'error' => [
                    'ru' => 'Профиль не сохранён.',
                    'en' => 'The profile is not saved.'
            ],
            'confirmation' => [
                    'ru' => 'Изменён адрес email. На новый адрес получите ссылку для подтверждения корректности адреса.',
                    'en' => 'Changed email address. The new address will receive a link to confirm the correctness.'
            ],

        ]

    ]
];
$fields = [
    'imageFile' => [
            'ru' => 'файл-изображение',
            'en' => 'image file'
    ],
    'username' => [
            'ru' => 'имя пользователя',
            'en' => 'username'
    ],
    'password' => [
            'ru' => 'пароль',
            'en' => 'password'
    ],
    'password_repeat' => [
            'ru' => 'повторить пароль',
            'en' => 'password repeat'
    ],
    'email' => [
            'ru' => 'эл-почта',
            'en' => 'email'
    ],
    'tel' => [
            'ru' => 'телефон',
            'en' => 'phone'
    ],
    'site' => [
            'ru' => 'сайт',
            'en' => 'web site'
    ],
    'company' => [
            'ru' => 'компания',
            'en' => 'company'
    ],
    'info' => [
            'ru' => 'характеристика компании',
            'en' => 'company description'
    ],
    'rememberMe' => [
            'ru' => 'запомнить меня',
            'en' => 'remember me'
    ],

];
$buttons = [
    'upload' => [
            'ru' => 'загрузить изображение',
            'en' => 'upload image'
    ],
    'login' => [
            'ru' => 'войти',
            'en' => 'login'
    ],
    'logout' => [
            'ru' => 'отключиться',
            'en' => 'logout'
    ],
    'registration' => [
            'ru' => 'регистрироваться',
            'en' => 'registration'
    ],
    'saveExpress' => [
            'ru' => 'продолжить',
            'en' => 'continue'
    ],

    'saveProfile' => [
            'ru' => 'сохранить профиль',
            'en' => 'save profile'
    ],
    'restoreProfile' => [
            'ru' => 'восстановить прежние значения',
            'en' => 'restore previous values'
    ],


];
$dir = PageItems::getPageItemPath() ;
include $dir.'/expressRegistration.php' ;
return [
    'forms' => [
        'loginForm' => $loginForm,
        'registrationForm' => $registrationForm,
        'profileForm' => $profileForm,
        'expressForm' => $expressForm,
    ],
    'fields' => $fields,
    'buttons' => $buttons
];