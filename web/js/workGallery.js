//$(function() {
//    $('[href="#w0-tab3"]').click(function () {
//        (new GalleryController()).init() ;
//    });
//}) ;
$( function() {
    $('[name$="-header"]').click(function() {
        var name = $(this).attr('name') ;
        if ((name.toUpperCase()).indexOf('profileEdit-Gallery'.toUpperCase()) >= 0 ) {
            var arr = name.split('-') ;
            var htmlPrefix = arr[0] + 'Gallery' ;
            paramSet.putObj('phpGalleryController','work-gallery') ;  // доступ
            var gallery = new GalleryController() ;
            gallery.init(htmlPrefix) ;
        }
    }) ;
}) ;

/**
 * Редактирование галереи изображений
 */
$(function() {
     var dropSuccess = false ;
    var img = $('#draggable').find('img') ;
    $('#droppable').append(img) ;
    $('#draggable').draggable({
        start: function() {
            var i = 1 ;
            $('#draggable').draggable('disable') ;
            $('#draggable').css('opacity',0.5) ;
            $('#draggable').css('z-index',10) ;
        },
        stop: function(event,ui) {
            //$('#draggable').css('top',0) ;
            //$('#draggable').css('left',0) ;
        },
        drag: function() {
            //var x = $('#draggable').css('left') ;
            //var y = $('#draggable').css('top') ;
            //$('#draggable').text('x:' + x + '; y:' + y) ;
        }

    });
    $('#droppable').droppable({
        drop: function(event, ui) {
            dropSuccess = true ;
            var i = 1 ;
            var img = ui.draggable.find('img') ;
            $('#droppable').empty() ;
            $('#droppable').append(img) ;
            ui.draggable.remove() ;

        },
        activate: function() {
            $('#droppable').css({
                border: "medium double green",
                backgroundColor: "lightGreen"
            });
        },
        over: function() {
            $('#droppable').css({
                border: "medium double yellow",
                backgroundColor: "lightGreen"
            });
        },
        out: function() {
            $('#droppable').css({
                border: "medium double green",
                backgroundColor: "lightGreen"
            });
        },

        deactivate : function() {
            $('#droppable').css("border", "").css("background-color", "");
            if (!dropSuccess) {
                $('#draggable').css('top',0) ;
                $('#draggable').css('left',0) ;
            }
        }
//        accept: '#drag1'
    });

});
function GalleryController() {
    var htmlPrefix = 'workGalleryEdit' ;

    var dragDroContainers = {
        orderContainer: {          //  упорядоченные картинки
            parentDiv: $('#' + htmlPrefix + '-order'),
            items: [],
            maxNum: 100,
            type: {drag: true, drop: true},
            imgSize: {unit: 'col-sm', width:2},
            textShow: true,
            noReplace: false,
            rows:{n:4, v:6},   // количество строк и число элементов
            textAreaNode : []
        },
        newContainer: {          //  пополнение галереи
            parentDiv: $('#' + htmlPrefix + '-new'),
            items: [],
            maxNum: 4,
            type: {drag: true, drop: false},
            // imgSize: {unit: 'px', width:75, height:50},
            imgSize: {unit: 'col-sm', width:3},
            textShow: false,
            noReplace: true,
            rows:{n:1, v:4},   // количество строк и число элементов
            textAreaNode : []
        },
        editContainer: {          //  редактирование заголовка
            parentDiv: $('#' + htmlPrefix + '-edit'),
            items: [],
            maxNum: 1,
            type: {drag: true, drop: true},
            imgSize: {unit: 'px', width:100,height:75},
            textShow: false,
            noReplace: true,
            rows:{n:0, v:0},   // количество строк и число элементов
            textAreaNode : $('#' + htmlPrefix + '-edit-textArea')
        },
        binContainer: {          //  корзина удалённых
            parentDiv: $('#' + htmlPrefix + '-bin'),
            items: [],
            maxNum: 100,
            type: {drag: true, drop: true},
            imgSize: {unit: 'col-sm', width:2},
            textShow: false,
            noReplace: false,
            rows:{n:3, v:6},   // количество строк и число элементов
            textAreaNode : []
        }
        //heapContainer: {          //  неупорядоченные картинки
        //    parentDiv: $('#' + htmlPrefix + '-heap'),
        //    items: [],
        //    maxNum: 100,
        //    type: {drag: true, drop: true},
        //    imgSize: {unit: 'col-sm', width:2},
        //    textShow: true,
        //    noReplace: false,
        //    rows:{n:3, v:6}
        //}
    } ;
    var containerMap = {} ;
    var _this = this ;
    //----------------------------------------//
    this.init = function(htmlpref) {
        if (htmlpref !== undefined) {
            htmlPrefix = htmlpref ;
            parentDivInit() ;
        }
        for (var key in dragDroContainers) {
            var cont = new DnDContainer() ;
            cont.init(dragDroContainers[key]) ;
            containerMap[key] = cont;
        }
        paramSet.putObj('galleryContainerMap',containerMap) ;  // доступ
        galleryGet() ;
    };
    /**
     * переопределить теги div, в которых располагаются контейнеры
     */
    var parentDivInit = function() {
        dragDroContainers.orderContainer.parentDiv = $('#' + htmlPrefix + '-order') ;
        dragDroContainers.newContainer.parentDiv = $('#' + htmlPrefix + '-new') ;
        dragDroContainers.editContainer.parentDiv = $('#' + htmlPrefix + '-edit') ;
        dragDroContainers.binContainer.parentDiv = $('#' + htmlPrefix + '-bin') ;
        dragDroContainers.editContainer.textAreaNode = $('#' + htmlPrefix + '-edit-textArea') ;
    }
}
function DnDContainer() {
    var htmlPrefix;
    var currentDnDName;
    var parentDiv;
    var pdfIcon = 'images/pdfIcons/pdf.png' ;
    var type = {drag: false, drop: false};
    var imgSize = {};
    var textShow = true;
    var noReplace = false;  // запрет на замену картинки в ячейке
    var rows = {n: 0, v: 0};   // строк n по v элементов
    var textAreaNode ;
    var placeItems = [];
    var removedItems = [] ;         // удалённые из-за  replace
    var maxNum = 1;
    var lastNumber = 1;   // для уникальности ключей
    var borderNormal = '2px solid blue';       // обычное состояние
    var borderOver = '3px solid yellow';         // сотояние перекрытия

    var borderActivate = '3px solid green';     // состояние приёмника
    var imgIsPlaced = false;
    var noReadyForDrop = false;
    var _this = this;
//-----------------------------------------------------//
    this.init = function (contDescript) {
        parentDiv = contDescript.parentDiv;
        maxNum = contDescript.maxNum;
        type = contDescript.type;
        imgSize = contDescript.imgSize;
        textShow = contDescript.textShow;
        noReplace = contDescript.noReplace;
        rows = contDescript.rows;
        textAreaNode = contDescript.textAreaNode;
        htmlPrefix = parentDiv.attr('id');
        var arr = htmlPrefix.split('-');
        currentDnDName = arr[arr.length - 1];
        if (rows.n == 0) {
            var firstItem = newPlaceItem();
            placeItems.push(firstItem);
            divMake(firstItem);
        } else {
            _this.makeRows();
        }
        //var tmpTimer = setTimeout(function () {
        //    $('.' + htmlPrefix + '-innerDiv').on( "mousedown", function(){
        //
        //        var cl = $(this).attr('class') ;
        //        if (cl.indexOf('ui-draggable') <0 ) {
        //            $(this).css('border','3px solid red') ;
        //        }else {
        //            $(this).css('border',borderNormal) ;
        //        }
        //    }) ;
        //    clearTimeout(tmpTimer) ;
        //}, 50);

    };
    this.getDataForSave = function() {
        return {
            placeItems: placeItems,
            removedItems: removedItems
        } ;
    } ;
    /**
     * данные извне(при загрузке или поступлении нового
     * зазмещение в первом свободном месте
     * @param img
     * @param title
     */
    this.dataInsert = function (img, title) {
        var ind = findEmptyPlaceIndex();
        var placeItem = placeItems[ind];
        placeItem.img = img;
         var arr = img.split('.') ;
         var ext = arr[arr.length - 1] ;
         if (ext.toLowerCase() === 'pdf') {
             placeItem.ico = pdfIcon ;
         }








        placeItem.title_ru = (title !== undefined) ? title : '';
        divMake(placeItem);
    };
    var newPlaceItem = function () {
        var item = {
            id: '',
            img: '',
            ico: '',
            title_ru: '',
            title_en: ''
        };
        item.id = htmlPrefix + '-' + lastNumber++;
        return item;
    };
    this.makeRows = function () {
        var nRows = rows.n;
        var nElems = rows.v;
        if (!nRows) {
            return;
        }
        parentDiv.empty();
        lastNumber = 1 ;
        placeItems = [];
        for (var i = 0; i < nRows; i++) {
            var row = $('<div class="row"></div>');
            row.attr('name', "row-" + i);
            for (var j = 0; j < nElems; j++) {
                var placeItem = newPlaceItem();
                placeItems.push(placeItem);
                divMake(placeItem, row);
            }
            parentDiv.append(row);
        }
    };
    var divMake = function (item, row) {
        var div = $('#' + item.id);
        if (div.length === 0) {
            div = $('<div></div>');
            div.attr('id', item.id);
            if (row === undefined) {
                parentDiv.append(div);
            } else {
                row.append(div);
            }

        }
        var unit = imgSize.unit;
        var unitPix = (unit === 'px');
        var unitCol = (unit.indexOf('col-') >= 0);
        if (unitPix) {
            div.css('width', imgSize.width);
            if (imgSize.height !== undefined) {
                div.css('height', imgSize.height);
            }

        }
        if (unitCol) {
            div.attr('class', imgSize.unit + '-' + imgSize.width + ' block');
            div.css('min-height', 20);
            if (imgSize.height !== undefined) {
                div.css('height', imgSize.height);
            }
        }
        var innerDivId = item.id + '-img';
        var innerDiv = $('#' + innerDivId);
        if (innerDiv.length === 0) {
            innerDiv = $('<div class="innerDiv"></div>');
            innerDiv.attr('id', item.id + '-img');
            innerDiv.css('width', '100%');
            innerDiv.attr('class',htmlPrefix + '-innerDiv') ;
        }
        innerDiv.empty();
        div.css('border', borderNormal);
        var img = item.img;
        var ico = item.ico ;
        if (ico.length > 0 ) {
            img = ico ;
        }


        if (img.length > 0) {
            var htmlImg = $('<img class="img-responsive img-thumbnail">');
            htmlImg.attr('src', img);
            htmlImg.css('width', '100%');
            innerDiv.append(htmlImg);

        }
        var title = item.title_ru;
        if (title.length > 0) {
            innerDiv.append('<p>' + title + '</p>');
            if (!textShow) {
                (innerDiv.children('p')).attr('hidden', 'hidden');
            }
        }
        div.empty();
        div.append(innerDiv);
        innerDiv.css('height', 'auto');
        if (type.drop) {
            $(div).droppable({
                drop: function (event, ui) {
                    var drag = ui.draggable;
                    $(drag).css('opacity', 1);
                    takeNewPlace($(this), $(drag));  // на новое место
                    noReadyForDrop = true;
                },
                activate: function () {
                    $(this).css('border', borderActivate);
//                    noReadyForDrop = false ;
                },
                over: function () {
                    $(this).css('border', borderOver);
                },
                out: function () {
                    $(this).css('border', borderActivate);
                },

                deactivate: function () {
                    $(this).css('border', borderNormal);
                    //   закроем доступ
                    if (noReadyForDrop && noReplace) {
                        $(this).droppable('option', 'disabled', true)
                    }
                }

            });
        }

        if (type.drag && img.length > 0) {
            $(innerDiv).draggable({
                start: function (event,ui) {
                    $(this).css('opacity', 0.5);
                    $(this).css('min-width', 40);
                    $(this).css('width', 60);
                    ($(this).find('p')).attr('hidden', 'hidden');
// переменные не сохраняются в контексте
                    var arr = ($(event.currentTarget).attr('id')).split('-') ;
                    var dnDName = arr[0] + '-' + arr[1] ;
                    var textArea = $('#' + dnDName + '-textArea') ;
                    if (textArea.length > 0) {
                        var pText = $(this).find('p');
                        pText.text(textArea.val()) ;
                        textArea.val('здесь редактирование подписи');
                    }

                    imgIsPlaced = false;
                    noReadyForDrop = false;
                },
                stop: function () {
                    if (!imgIsPlaced) {               // вернуть назад
                        var sendItem = $(this);
                        sendItem.css('opacity', 1);
                        sendItem.css('top', 0);
                        sendItem.css('left', 0);
                        sendItem.css('min-width', 20);
                        sendItem.css('width', '100%');
                        sendItem.css('height', 'auto');
                        var pText = sendItem.children('p');
                    }
                },
                scroll: true,
                zIndex: 10
            }) ;
            //if (img.length == 0) {                 // без картинки нечего перетаскивать
            //    //$(div).draggable('deactivate') ;
            //    $(innerDiv).draggable("option", "disabled", true);
            //} else {
            //    $(innerDiv).draggable("option", "disabled", false);
            //}
        }

    };
    /**
     * зафиксировать на новом месте
     * @param place
     * @param sendItem
     */
    var takeNewPlace = function (place, sendItem) {
        var idPlace = place.attr('id');
        var sendItemId = sendItem.attr('id');
        var res = parseSendItemId(sendItemId);
        // нужно для очистки места в старом контейнере
        var oldDnDName = res.DnDName;
        var oldPlaceItemId = res.placeItemId;
//   если в одном контейнере, то освободить для возможности сдвига
        var sendItemClone = sendItem.clone() ;

        var oldPlaceItem = {} ;
        if (oldDnDName == currentDnDName) {
            var oldPlaceInd = _this.findPlaceIndex(oldPlaceItemId);
            var oldPlaceItemPro = placeItems[oldPlaceInd] ;
            for (var key in oldPlaceItemPro) {
                oldPlaceItem[key] = oldPlaceItemPro[key] ;
            }
            placeItemClear(oldPlaceInd);      // чистить клетку
        }else {    // посмотреть что было на старом месте
            var map = paramSet.getObj('galleryContainerMap') ;  // доступ
            var oldContainer = map[oldDnDName + 'Container'] ;
            var oldData = oldContainer.getDataForSave() ;
            var oldPlaceItems = oldData.placeItems ;
            oldPlaceInd =  oldContainer.findPlaceIndex(oldPlaceItemId);
            oldPlaceItem = oldData.placeItems[oldPlaceInd] ;
        }
//-----------------------------------------------
        res = parsePlaceId(idPlace);
        var placeItemId = res.placeItemId;
        var placeInd = _this.findPlaceIndex(placeItemId);    // определить индекс места
        freePlaceByIndex(placeInd);           // освободить от прежнего
        //-------------------------------
        //if (oldDnDName == currentDnDName && placeInd == oldPlaceInd) {
        //
        //} else {
            place.empty();
            place.append(sendItemClone);

        //}
        var placeItem = placeItems[placeInd];
        sendItemClone.attr('id', placeItem.id + '-img');
        sendItemClone.css('top', 0);
        sendItemClone.css('left', 0);
        sendItemClone.css('min-width', 20);
        sendItemClone.css('width', '100%');
        sendItemClone.css('height', 'auto');
        sendItemClone.css('z-index','auto') ;
        var pText = sendItemClone.children('p');
        if (textShow) {
            pText.removeAttr('hidden');
        } else {
            pText.attr('hidden', 'hidden');
        }

        // - текст в область редактирования ---
        if (textAreaNode.length > 0) {
            textAreaNode.val(pText.text());
        }
        //-------------------------
        makeDraggable(sendItemClone) ;

        //var img = sendItemClone.find('img');
        //placeItem.img = img.attr('src');
        //placeItem.title_ru = sendItemClone.text();

        placeItem.img = oldPlaceItem.img ;
        placeItem.ico = oldPlaceItem.ico ;
        //placeItem.title_ru = oldPlaceItem.title_ru ;
        placeItem.title_ru = sendItemClone.text();    // это правильно

//
        if (oldDnDName == currentDnDName) {
//            makeDraggable(sendItem) ;
        }
        //----  передать привет на старое место ----//
        oldPlaceFreeFromPicture(oldDnDName, oldPlaceItemId);


    };
    var makeDraggable = function(innerDiv) {
        if (type.drag) {
            $(innerDiv).draggable({
                start: function (event,ui) {
                    $(this).css('opacity', 0.5);
                    $(this).css('min-width', 40);
                    $(this).css('width', 60);
                    $(this).css('z-index', 10);
                    ($(this).find('p')).attr('hidden', 'hidden');
// переменные не сохраняются в контексте
                    var arr = ($(event.currentTarget).attr('id')).split('-') ;
                    var dnDName = arr[0] + '-' + arr[1] ;
                    var textArea = $('#' + dnDName + '-textArea') ;
                    if (textArea.length > 0) {
                        var pText = $(this).find('p');
                        pText.text(textArea.val()) ;
                        textArea.val('здесь редактирование подписи');
                    }

                    imgIsPlaced = false;
                    noReadyForDrop = false;
                },
                stop: function () {
                    if (!imgIsPlaced) {               // вернуть назад
                        var sendItem = $(this);
                        sendItem.css('opacity', 1);
                        sendItem.css('top', 0);
                        sendItem.css('left', 0);
                        sendItem.css('min-width', 20);
                        sendItem.css('width', '100%');
                        sendItem.css('height', 'auto');
                        var pText = sendItem.children('p');
                    }
                },
                scroll: true,
                zIndex: 10
            }) ;
            //if (img.length == 0) {                 // без картинки нечего перетаскивать
            //    //$(div).draggable('deactivate') ;
            //    $(innerDiv).draggable("option", "disabled", true);
            //} else {
            //    $(innerDiv).draggable("option", "disabled", false);
            //}
        }
    } ;

    var oldPlaceFreeFromPicture = function (oldDnDName, oldPlaceItemId) {
        var map = paramSet.getObj('galleryContainerMap');  // доступ

        if (oldDnDName !== currentDnDName) {
            var oldContainer = map[oldDnDName + 'Container'];
            oldContainer.freeFromPicture(oldPlaceItemId);
        }
    };
    /**
     * освободить блок, картинку из которого забрали
     * @param oldPlaceItemId
     */
    this.freeFromPicture = function (oldPlaceItemId) {
        imgIsPlaced = true;
        var placeInd = _this.findPlaceIndex(oldPlaceItemId);
        placeItemClear(placeInd);      // чистить клетку
    };
    var parseSendItemId = function (sendItemId) {
        var arr = sendItemId.split('-');
        return {parentPrefix: arr[0], DnDName: arr[1], placeItemId: arr[2], suffix: 'img'};
    };
    var parsePlaceId = function (placeId) {
        var arr = placeId.split('-');
        return {parentPrefix: arr[0], DnDName: arr[1], placeItemId: arr[2]};
    };
    /**
     * определить индекс места
     */
    this.findPlaceIndex = function (placeItemId) {
        var index = null;
        for (var i = 0; i < placeItems.length; i++) {
            var placeItem = placeItems[i];
            var res = parsePlaceId(placeItem.id);
            if (res.placeItemId == placeItemId) {
                index = i;
                break;
            }
        }
        return index;
    };
    /**
     *
     * @param baseInd  - базовый индекс(по отношению к которому искать)      -
     * @param findDirection - направление поиска (+1 - влево от базового; -1 - вправо)
     * @returns {*}
     */
    var findEmptyPlaceIndex = function (baseInd, findDirection) {
        baseInd = (baseInd === undefined) ? 0 : baseInd;
        findDirection = (findDirection === undefined) ? +1 : findDirection;
        var basePlace = placeItems[baseInd];
        if ((basePlace.img).length === 0) {
            return baseInd;
        }
        var index = null;
        if (findDirection > 0) {
            for (var i = baseInd; i < placeItems.length; i++) {
                var placeItem = placeItems[i];
                if ((placeItem.img).length === 0) {
                    index = i;
                    break;
                }
            }
        } else {
            for (i = baseInd; i >= 0; i--) {
                placeItem = placeItems[i];
                if ((placeItem.img).length === 0) {
                    index = i;
                    break;
                }
            }
        }
        return index;
    };
    /**
     * очистить клетку
     * @param itemInd
     */
    var placeItemClear = function (itemInd) {
        var placeItem = placeItems[itemInd];
        var img = placeItem.img ;
        var id = placeItem.id;
        placeItem.img = '';
        placeItem.ico = '';
        placeItem.title_ru = '';
        placeItem.title_en = '';
        $('#' + id).empty();
        if (type.drop) {
            $('#' + id).droppable('option', 'disabled', false);
        }
        noReadyForDrop = false;

    };
    /**
     *  освободить от прежнего ячейку с номером placeIndex
     *  сдвинуть все элементы, начиная с placeIndex вправо на 1
     *  если нельзя добавить новый элемент справа, то последний пропадает
     * @param placeInd
     */
    var freePlaceByIndex = function (placeInd) {
        var currentPlace = placeItems[placeInd];
        var currentImg = currentPlace.img;
        if (currentImg.length == 0) {       // уже свободна
            return true;
        }
        var direction = +1;
        var emptyInd = findEmptyPlaceIndex(placeInd, direction);
        if (!emptyInd) {
            direction = -1;
            emptyInd = findEmptyPlaceIndex(placeInd, direction);
        }
        if (!emptyInd) {       //  нет свободных => надо удалять текущую клетку
            var removePlace = {} ;
            for (var key in currentPlace) {
                removePlace[key] = currentPlace[key] ;
            }
            removedItems.push(removePlace) ;
            placeItemClear(placeInd);
            return placeInd;
        }
        // -- сдвигаем
        if (direction > 0) {
            for (var i = emptyInd; i > placeInd; i--) {
                currentPlace = placeItems[i];
                var prevPlace = placeItems[i - 1];
                copyPlace(prevPlace, currentPlace);
            }
        } else {
            for (i = emptyInd; i < placeInd; i++) {
                currentPlace = placeItems[i];
                var nextPlace = placeItems[i + 1];
                copyPlace(nextPlace, currentPlace);
            }

        }

    };

    var copyPlace = function (placeFrom, placeTo) {
        var toId = placeTo.id;
        var fromId = placeFrom.id;
        var fromInnerDiv = $('#' + fromId + '-img');
        var toDiv = $('#' + toId);
        toDiv.empty();
        toDiv.append(fromInnerDiv);
        if (textShow) {
            (fromInnerDiv.children('p')).removeAttr('hidden');
        } else {
            (fromInnerDiv.children('p')).attr('hidden', 'hidden');
        }
        fromInnerDiv.attr('id', toId + '-img');
        placeTo.img = placeFrom.img;
        placeTo.title_ru = placeFrom.title_ru;
        placeTo.title_en = placeFrom.title_en;

    };
}
/**
 * добавить новую картинку
 */
function newGalleryItemUpload(uploadFormId,urlUpload,galleryNewImgId ) {
   uploadOnClick(uploadFormId,urlUpload,galleryNewImgId,newGalleryItemUploadDo) ;
//        newContainer.freeFromPicture(oldPlaceItemId) ;

}
function newGalleryItemUploadDo(imgUrl) {
    var containerName = 'newContainer' ;
    var map = paramSet.getObj('galleryContainerMap') ;  // доступ
    var container = map[containerName] ;
    container.makeRows() ;
    for (var i = 0; i < imgUrl.length ; i++) {
        container.dataInsert(imgUrl[i],'new picture_' + i) ;
    }

}
/**
 *
 */
function gallerySave() {
    var map = paramSet.getObj('galleryContainerMap') ;  // доступ
    var orderContainer = map['orderContainer'] ;
    var binContainer = map['binContainer'] ;
    var orderData = orderContainer.getDataForSave() ;
    var binData = binContainer.getDataForSave() ;
    var orderPlace = orderData.placeItems ;
    var orderRemoved = orderData.removedItems ;
    var binPlace = binData.placeItems ;
    var binRemoved = binData.removedItems ;

        var sendData = {
            opCod : 'saveGallery',
            orderData: {
                placeItems : galleryOnlyNameImgFile(orderPlace),
                removedItems: galleryOnlyNameImgFile(orderRemoved)
            },
            binData: {
                placeItems : galleryOnlyNameImgFile(binPlace),
                removedItems: galleryOnlyNameImgFile(binRemoved)
            }
    } ;
    var ajax = new AjaxExecutor() ;
    ajax.setData(sendData) ;
//    url = 'index.php?r=work-direction%2Fsave-work-direction' ;
//    ajax.setUrl('index.php?r=work-gallery%2Fsave-gallery') ;

    var phpController = paramSet.getObj('phpGalleryController') ;
    //ajax.setUrl('index.php?r=work-gallery%2Fget-gallery') ;
    ajax.setUrl('index.php?r=' + phpController + '%2Fsave-gallery') ;



    ajax.setCallback(gallerySaveResult,null) ;
    ajax.go() ;


}
function galleryGet() {
    var sendData = {
        opCod : 'getGallery'
    } ;
    var ajax = new AjaxExecutor() ;
    ajax.setData(sendData) ;
//    url = 'index.php?r=work-direction%2Fsave-work-direction' ;
    var phpController = paramSet.getObj('phpGalleryController') ;
    //ajax.setUrl('index.php?r=work-gallery%2Fget-gallery') ;
    ajax.setUrl('index.php?r=' + phpController + '%2Fget-gallery') ;

    ajax.setCallback(gallerySaveResult,null) ;
    ajax.go() ;


}

/**
 * результат сохранения
 * @param rr
 * $answ = [
 'success' => true,
 'galleryUrl' => $this->_galleryUrl,
 'orderList' => $orderList,
 'binList' => $binList,
 'z_end' => 'z_end'
 ] ;
 */
function gallerySaveResult(rr) {
    var success = rr['success'] ;
    var galleryUrl = rr['galleryUrl'] ;
    var orderList = rr['orderList'] ;
    var binList =  rr['binList'] ;
    var map = paramSet.getObj('galleryContainerMap') ;  // доступ
    var orderContainer = map['orderContainer'] ;
    var binContainer = map['binContainer'] ;
    var containers = [orderContainer,binContainer] ;
    var send = {
        order: {container:orderContainer, data: orderList},
        bin: {container:binContainer, data: binList}
    } ;
    for(var key in send) {
        var container = send[key]['container'] ;
        var list = send[key]['data'] ;
        container.makeRows() ;
        for (var i = 0; i < list.length; i++) {
            var item = list[i] ;
            var img = galleryUrl + '/' + item['image'] ;
            var title = item['title_ru'] ;
            container.dataInsert(img, title);
        }
    }



}
/**
 * к пересылке только имя файла
 * @param placeItems
 * @returns {Array}
 */
function galleryOnlyNameImgFile(placeItems) {
    var result = [] ;
    for (var i = 0; i < placeItems.length; i++) {
        var item = placeItems[i] ;
        var img = item.img ;
        if (img.length == 0) {
            continue ;
        }
        var arr = img.split('/') ;
        var imgName = arr[arr.length -1] ;   // имя файла
        var newItem = {
            img: imgName,
            title_ru: item.title_ru,
            title_en: item.title_en
        } ;
        result.push(newItem) ;
    }
    return result ;
}
function showImageInWindow(urlPdfShow) {
    var map = paramSet.getObj('galleryContainerMap') ;  // доступ
    var editContainer = map['editContainer'] ;
    var editData = editContainer.getDataForSave() ;
    var editPlace = editData.placeItems ;
    if  (editPlace.length > 0) {
        var img = editPlace[0].img ;
        var url = urlPdfShow + '?fn=' + img ;
        var win = window.open (url, '_blank');
//        win.document.write ('<img src="' + img + '">');

    }

    //var adres_foto = 'http://www.cyberforum.ru/images/cyberforum_logo.jpg';
    //var win = window.open ('', 'qwerty');
    //win.document.write ('<img src="' + adres_foto + '">');
}
function galleryEditFullScreen(elem) {
    imgToFullScreen(elem) ;
}