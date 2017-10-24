-- Заказы
-- order - заказы
--drop table order_work ;
CREATE TABLE IF NOT EXISTS order_work (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  userid INTEGER REFERENCES user(id)
             ON DELETE CASCADE,
  order_name VARCHAR (255),
  description TEXT,
  city_id INTEGER REFERENCES city(id),                // отсылка к таблице city - города
  per_beg TIMESTAMP DEFAULT NOW(),
  per_end TIMESTAMP DEFAULT NOW(),
  time_create TIMESTAMP DEFAULT NOW()
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- -- таблица order_additional - доп материалы
--drop table order_additional ;
CREATE TABLE IF NOT EXISTS order_additional (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  order_id INTEGER REFERENCES order_work (id)
  ON DELETE CASCADE ,
  image  VARCHAR (250),
  title_ru VARCHAR (255),
  title_en VARCHAR (255),
  order_n INTEGER DEFAULT  0,      // пор N при выводе
  bin_flag TINYINT DEFAULT 0     // 1 - в корзине 0 - в работе
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- таблица order_mailing - рассылка
-- drop table order_mailing ;
CREATE TABLE IF NOT EXISTS order_mailing (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  order_id INTEGER REFERENCES work_order (id)
             ON DELETE CASCADE ,
  developer_id INTEGER REFERENCES user (id),
  time_send TIMESTAMP DEFAULT '2017-01-01',
  time_answer TIMESTAMP  DEFAULT '2017-01-01',
  stat TINYINT DEFAULT 0     // 1 - выбран исполнителем
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- таблица order_work - предполагаемые работы
--drop table order_work_item ;
-- order_work_direction - направления работ в заказе
--drop TABLE order_work_direction ;
CREATE TABLE IF NOT EXISTS order_work_direction (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  order_id INTEGER REFERENCES order_work (id)
  ON DELETE CASCADE ,
  work_direction_id INTEGER
    REFERENCES work_direction (id)
    ON DELETE CASCADE ,
  fully_flag  TINYINT DEFAULT 0               // все работы напрввления
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- order_work_item - работы, выполняемые прозводителем
--drop TABLE order_work_item ;
CREATE TABLE IF NOT EXISTS order_work_item (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  order_work_direction_id INTEGER
    REFERENCES order_work_direction(id)
    ON DELETE CASCADE,
  work_item_id INTEGER
    REFERENCES work_item (id)
    ON DELETE CASCADE
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
