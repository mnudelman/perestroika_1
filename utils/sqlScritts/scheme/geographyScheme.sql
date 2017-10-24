-- География
-- city - города
drop table city ;
CREATE TABLE IF NOT EXISTS city (
  id INTEGER NOT NULL,
  country_id INTEGER,
  region_id INTEGER,
  name    VARCHAR (255) DEFAULT ''
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- География. схема под загрузку без связи полей.
-- География
-- region - регионы
--drop table region ;
CREATE TABLE IF NOT EXISTS region (
  id INTEGER NOT NULL,
  country_id INTEGER,
  name    VARCHAR (255) DEFAULT ''
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
--  country - страны
--drop table country ;
CREATE TABLE IF NOT EXISTS country (
  id   INTEGER NOT NULL,
  name VARCHAR (255) DEFAULT ''
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


