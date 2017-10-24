drop table order_work ;
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
