-- добавление полей в order_work
ALTER TABLE order_work add COLUMN lock_flag TINYINT DEFAULT 0, -- закрыть заказ для изменений
ADD COLUMN lock_time TIMESTAMP DEFAULT '2017-01-01',
ADD COLUMN deadline_answer TIMESTAMP  DEFAULT '2017-01-01', -- deadline для ответа на предложение
ADD COLUMN deadline_select TIMESTAMP  DEFAULT '2017-01-01', -- deadline при выборе исполнителя
ADD COLUMN message_id INTEGER REFERENCES message_caption(id)
             ON DELETE CASCADE;