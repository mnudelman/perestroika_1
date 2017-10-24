-- подсхема обмена сообщениями
-- message_caption - заказы
--drop table message_caption ;
CREATE TABLE IF NOT EXISTS message_caption (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id_from INTEGER REFERENCES user(id)
             ON DELETE CASCADE,
  user_id_to INTEGER REFERENCES user(id)
             ON DELETE CASCADE,
  subject VARCHAR (255),         --  тема сообщения
  message_time TIMESTAMP DEFAULT NOW()
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- message_body - текст сообщения
--drop table message_body ;
CREATE TABLE IF NOT EXISTS message_body (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  caption_id INTEGER REFERENCES message_caption(id)  -- заголовок(тема)
             ON DELETE CASCADE,
  text TEXT,
  time_create TIMESTAMP DEFAULT NOW()
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
