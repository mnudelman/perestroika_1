-- добавление полей в order_work
ALTER TABLE order_mailing
ADD COLUMN time_deadline TIMESTAMP DEFAULT '2017-01-01' ;
SELECT * FROM order_mailing ;