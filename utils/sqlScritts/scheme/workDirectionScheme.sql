-- таблицы подсхемы - направления работ - справочник
--drop TABLE work_direction ;
CREATE TABLE IF NOT EXISTS work_direction (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR (255),
  name_en VARCHAR (255),
  name_ru VARCHAR (255),
  image VARCHAR (100)
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- work_item - работы - справочник
--drop TABLE work_item ;
CREATE TABLE IF NOT EXISTS work_item (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  work_direction_id INTEGER
             REFERENCES work_direction (id)
             ON DELETE CASCADE ,
  name VARCHAR (255),
  name_en VARCHAR (255),
  name_ru VARCHAR (255)
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- developer_work_direction - направления работ, выполняемые прозводителем
--drop TABLE developer_work_direction ;
CREATE TABLE IF NOT EXISTS developer_work_direction (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  userid INTEGER REFERENCES user (id)
             ON DELETE CASCADE ,
  work_direction_id INTEGER
             REFERENCES work_direction (id)
             ON DELETE CASCADE ,
  fully_flag  TINYINT DEFAULT 0               // все работы напрввления
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- developer_work_item - работы, выполняемые прозводителем
--drop TABLE developer_work_item ;
CREATE TABLE IF NOT EXISTS developer_work_item (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  userid INTEGER REFERENCES user (id)
             ON DELETE CASCADE ,
  developer_work_direction_id INTEGER
             REFERENCES developer_work_direction(id)
             ON DELETE CASCADE,
 work_item_id INTEGER
             REFERENCES work_item (id)
             ON DELETE CASCADE
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
