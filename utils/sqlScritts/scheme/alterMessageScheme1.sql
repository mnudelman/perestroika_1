-- подсхема обмена сообщениями
ALTER TABLE message_body
DROP ban_stat ;                      // 0 - переписка,1-закрыть,2-открыть
--
ALTER TABLE message_body
ADD stat TINYINT DEFAULT 0 ;                      // 0 - переписка,1-закрыть,2-открыть



ALTER TABLE message_body
ADD sender_id INTEGER REFERENCES  user(id)         // отправитель сообщения
             ON DELETE CASCADE ;


SELECT * FROM message_body ;