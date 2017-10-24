-- таблицы подсхемы - направления работ - справочник
-- CREATE TABLE IF NOT EXISTS work_direction (
--   id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
--   name VARCHAR (100),
--   image VARCHAR (100)
--   )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
--DELETE FROM work_direction ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('diamondCutting','Алмазная резка и бурение','Diamond cutting and drilling','алмазная резка и бурение.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('demolition','Демонтажные работы','Demolition work','Демонтажные работы.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('dismantling','Демонтаж зданий и сооружений','Dismantling of buildings and structures','Демонтаж зданий и сооружений. 2.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('construction','Строительные работы','Construction work','Строительные работы.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('protection','Защита и восстановление строительных конструкций',
 'Protection and restoration of building structures','Защита и восстановление строительных конструкций.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('redevelopment','Перепланировка помещений','Redevelopment of premises','Перепланировка помещений.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('reconstruction' ,'Реконструкция зданий и сооружений','Reconstruction of buildings and structures','Реконструкция зданий и сооружений.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('design','Проектные работы','Design work','Проектные работы.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('diamondSuppliers','Поставщики оборудования и расходных материалов для алмазной резки и бурения',
'Suppliers of equipment and consumables for diamond cutting and drilling',
'Поставщики оборудования и расходных материалов для алмазной резки и бурения.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('materialsSuppliers','Поставщики специализированных строительных материалов','Suppliers of specialised building materials',
'Поставщики специализированных строит. материалов.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('specialRent' ,'Аренда спец автотранспорта','Rent special vehicles','Аренда спец автотранспорта 2.jpg') ;
INSERT INTO work_direction (name,name_ru,name_en,image) VALUES
('removal','Вывоз и утилизация строительного мусора','Removal and disposal of construction debris',
'Вывоз и утилизация строительного мусора.jpg') ;
SELECT * FROM work_direction ;
