-- подсхема - галерея изображений
--drop TABLE work_gallery ;
CREATE TABLE IF NOT EXISTS work_gallery (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  userid INTEGER REFERENCES user (id)
             ON DELETE CASCADE ,
  image  VARCHAR (250),
  title_ru VARCHAR (255),
  title_en VARCHAR (255),
  order_n INTEGER DEFAULT  0,      // пор N при выводе
  bin_flag TINYINT DEFAULT 0     // 1 - в корзине 0 - в работе
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
