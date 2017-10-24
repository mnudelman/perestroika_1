-- таблицы подсхемы - георгафия работ
--drop TABLE work_country ;
CREATE TABLE IF NOT EXISTS work_country (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  userid INTEGER REFERENCES user(id)
            ON DELETE CASCADE,
  country_id INTEGER
             REFERENCES country (id),
  fully_flag TINYINT DEFAULT 0,                       // флаг - выполнение работ по всей стране
  last_change TIMESTAMP DEFAULT NOW()
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1  COLLATE=utf8_unicode_ci;
-- work_region - регионы работ
--drop TABLE work_region ;
CREATE TABLE IF NOT EXISTS work_region (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  work_country_id INTEGER
             REFERENCES work_country (id),
  region_id INTEGER REFERENCES region (id),
  fully_flag TINYINT DEFAULT 0,                        // флаг - выполнение работ по всему региону
  last_change TIMESTAMP DEFAULT NOW()
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- work_city - города работ
--drop TABLE work_city ;
CREATE TABLE IF NOT EXISTS work_city (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  work_region_id INTEGER
             REFERENCES work_region (id)
             ON DELETE CASCADE ,
  city_id INTEGER REFERENCES city (id),                // отсылка к таблице city - города
  last_change TIMESTAMP DEFAULT NOW()
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
