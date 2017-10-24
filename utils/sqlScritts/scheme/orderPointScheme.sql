-- оценка (бал) исполнению заказа
--drop table order_point ;
CREATE TABLE IF NOT EXISTS order_point (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INTEGER REFERENCES order_work(id)
             ON DELETE CASCADE,
  developer_id INTEGER REFERENCES user(id)
             ON DELETE CASCADE,
  customer_point TINYINT,         --  оценка заказчика, поставлена исполнителем
  developer_point TINYINT,        --  оценка испонителя, поставлена заказчиком
  customer_comment VARCHAR(255),  --  комментарий к оценке заказчика, поставленной исполнителем
  developer_comment VARCHAR(255)  --  комментарий к оценке исполнителя, поставленной заказчиком
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
  SELECT * FROM order_point ;
