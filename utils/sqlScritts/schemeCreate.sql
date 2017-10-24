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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COLLATE=utf8_unicode_ci;

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
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1  COLLATE=utf8_unicode_ci;
-- --------------------------------------
--строка в userprofile появляется вместе с users
CREATE TRIGGER  insert_user AFTER INSERT ON user
FOR EACH ROW
  INSERT INTO userprofile (userid) VALUES (new.id);
-- --------------------------------------
