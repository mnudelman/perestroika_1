-- таблица order_evaluation - оценка взаимодействия заказчик-мсполнитель
-- drop table order_evaluation ;
CREATE TABLE IF NOT EXISTS order_evaluation (
  id INTEGER NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  order_id INTEGER REFERENCES work_order (id)
             ON DELETE CASCADE ,
  developer_id INTEGER REFERENCES user (id),
  developer_evaluation TINYINT,      // оценка, поставленная исполнителем
  customer_evaluation TINYINT,       // оценка, поставленная заказчиком
  developer_comment TEXT,
  customer_comment TEXT,
  customer_time TIMESTAMP DEFAULT NOW(),
  developer_time TIMESTAMP DEFAULT NOW(),
  INDEX developer_id (developer_id)
  )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
  SELECT * FROM order_evaluation ;

