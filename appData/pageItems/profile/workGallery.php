<?php
/**
 * Языковое оформление "Направления работ"
 */
$title = [
        'ru' => 'Галлерея',
        'en' => 'Gallery'
];
$text_ru = <<<TEXT
<b>1. Загрузка нового изображения.</b><br>
&nbsp;&nbsp;-Новое изображение можно получить кликнув кноку "Выберите файл", затем "загрузить". <br>
 &nbsp;&nbsp;-Изображение появится в рамочке. Далее, захватив её мышкой, можно перетащить
  в любой из разделов.<br>
<b>2.Когда начинается движение,</b> все клетки, доступные для размещения картинки получают
 <span style="color:green"><b>зелёную рамку</b></span>.<br>
&nbsp;&nbsp;-Таким образом можно переместить картинку в любую клетку любого раздела.<br>
&nbsp;&nbsp;-Если отпустить мышку раньше, чем достигнута область клетки,
она вернётся в прежнее положение.<br>
&nbsp;&nbsp;-Событие <b>"достижения клетки"</b> определяется, когда она(клетка)
получит<span style="color:yellow"><b> рамку жёлтого цвета</b></span>.
Если в это время отпустить мышку, картинка прилипнет к этой клетке.<br>
&nbsp;&nbsp;-Если  <b>на этом месте была другая картинка</b>, то произойдёт сдвиг влево или вправо,
 в зависимости от  наличия свободных клеток в разделе.<br>
<b>3. Назначение разделов:</b><br>
&nbsp;&nbsp;-<b>"пополнение галереи"</b>.В этот раздел картинка попадает только извне. <br>
&nbsp;&nbsp;-<b>"редактировать подпись"</b>. Если поместить картинку в этот раздел
(здесь едиственная клетка для приёма, новую картинку поверх находящейся здесь поместить не удастся),
 то в текстовом поле можно изменеть подпись. После этого перетащить изображение в нужное место.<br>
&nbsp;&nbsp;-<b>"Корзина удалённых"</b>. Можно использовать как хранилище незадействованных, но отобранных изображений.
  Корзина расчитана на сохранение <b>18</b> элементов.<br>
&nbsp;&nbsp;-<b>"порядок просмотра"</b>. Это то что увидят  прочие пользователи,
когда войдут в профиль, например, при выборе исполнителя заказа. Объём ограничен <b>24</b> элементами.<br>
<b>4.Если раздел ("корзина...." или "порядок просмотра") заполнены полностью</b> (нет свободных клеток),
 то попытка размещения нового изображения, приведут к удалению текущего, находившегося в рамке.<br>
<b>4.кнопка "сохранить" </b> - сохраняет разделы "порядок..." и "корзина".
TEXT;
$text_en = <<<TEXT
<b>1. Loading a new image.</b><br>
&nbsp;&nbsp; a New image can be obtained by clicking knokw "Choose file", then "upload". <br / >
&nbsp;&nbsp;-Picture will appear in the frame. Then, capturing it with the mouse, you can drag
in any of the sections.<br>
<b>2.When the traffic starts,</b> all cells available for placing the pictures get
<span style="color:green"><b>green frame</b></span>.<br>
&nbsp;&nbsp;-Thus it is possible to move the picture in any cell of any partition.<br>
&nbsp;&nbsp;-If you release the mouse earlier than the reached region of the cell,
it will return to its previous position.<br>
&nbsp;&nbsp; Event <b>"advances in cell"</b> is defined when it(the cage)
get<span style="color:yellow"><b> the yellow frame</b></span>.
If at this time you release the mouse, the picture will stick to the cage.<br>
&nbsp;&nbsp; If <b>this place was another picture</b>, there will be a shift to the left or right
depending on the availability of cells in the section.<br>
<b>3. The purpose of the following sections:</b><br>
&nbsp;&nbsp;<b>"added to the gallery"</b>.In this section of the picture only from the outside. <br / >
&nbsp;&nbsp;<b>"title edit"</b>. If you put a picture in this section
(here only one cage for receiving a new picture on top here place will fail),
then in the text box change signature. Then drag the image to the desired location.<br>
&nbsp;&nbsp;<b>"Bin"</b>. Can be used as a repository for untapped, but selected images.
Bin is designed for the preservation of <b>18</b> elements.<br>
&nbsp;&nbsp;<b>"view"</b>.  what can see other users
when you enter the profile, for example, when choosing a contractor. The volume is limited to <b>24</b> elements.<br>
<b>4.If a section ("bin" or "view") is filled completely</b> (no free cells),
try placing a new image deletes the current present in the frame.<br>
<b>4.the "save" button </b> - keeps the sections "view" and "bin".
TEXT;
$rules = [
    'title' => [
            'ru' => 'При формировании галереи изображений, используйте правила:',
            'en' => 'In the formation of areas of work, use rules:'
    ],
    'content' => [
            'ru' => $text_ru,
            'en' => $text_en
    ]
];
$parts = [
    'add' => [
            'ru' => 'Пополнение галереи',
            'en' => 'Added to the gallery'
    ],
    'titleEdit' => [
            'ru' => 'Редактировать полпись',
            'en' => ' Title edit'
    ],
    'bin' => [
            'ru' => 'Корзина удалённых',
            'en' => 'Bin'
    ],
    'order' => [
            'ru' => 'Порядок просмотра',
            'en' => 'to view'
    ],

] ;
$buttons = [
    'save' => [
            'ru' => 'сохранить',
            'en' => 'save'
    ]
] ;

return [
    'title' => $title,
    'rules' => $rules,
    'partsTitle' => $parts,
    'buttons' => $buttons
];