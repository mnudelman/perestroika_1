--CREATE DATABASE IF NOT EXISTS perestroika ;


drop table user ;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT ,
  `username` varchar(255) NOT NULL UNIQUE ,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  role INTEGER DEFAULT 0,
  ip VARCHAR (255),
  date_first TIMESTAMP DEFAULT '2016-12-01',                    -- момент регистрации
  date_last TIMESTAMP DEFAULT '2016-12-01',                      -- последнее соединение
  login_count INTEGER DEFAULT 0,                   -- количество входов
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- userprofile - Профиль пользователя
--drop table userprofile ;
CREATE TABLE IF NOT EXISTS userprofile (
  id         INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  userid     INTEGER
             REFERENCES user (id)
             ON DELETE CASCADE,
  company VARCHAR (255) DEFAULT '',
  avatar  VARCHAR(100) DEFAULT '', -- файл с изображением
  tel     VARCHAR(20) DEFAULT '',
  email   VARCHAR(255) DEFAULT '',
  site    VARCHAR (255) DEFAULT '',
  info    VARCHAR(255) DEFAULT '',
  KEY (email)
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- --------------------------------------
--строка в userprofile появляется вместе с users
CREATE TRIGGER  insert_user AFTER INSERT ON user
FOR EACH ROW
  INSERT INTO userprofile (userid) VALUES (new.id);
-- --------------------------------------
-- География
-- country - страны
--drop table country ;
CREATE TABLE IF NOT EXISTS country (
  id         INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  name    VARCHAR (255) DEFAULT ''
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- География
-- region - регионы
--drop table region ;
CREATE TABLE IF NOT EXISTS region (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  country_id INTEGER
             REFERENCES country (id)
             ON DELETE CASCADE,
  name    VARCHAR (255) DEFAULT ''
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1  ;

-- География
-- city - города
--drop table city ;
CREATE TABLE IF NOT EXISTS city (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  country_id INTEGER
             REFERENCES country (id),
  region_id INTEGER
             REFERENCES region (id),
  name    VARCHAR (255) DEFAULT ''
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1  COLLATE=utf8_unicode_ci;
