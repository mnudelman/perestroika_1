-- подсхема обмена сообщениями
ALTER TABLE order_work
  ADD COLUMN deadline TIMESTAMP ,                                   // текущее время ответа
  ADD COLUMN message_id INTEGER REFERENCES message_caption(id)      // переписка по ЗАКАЗУ
             ON DELETE CASCADE;
ALTER TABLE message_body
ADD COLUMN sender_id INTEGER REFERENCES  user(id)                         // отправитель сообщения
             ON DELETE CASCADE;
