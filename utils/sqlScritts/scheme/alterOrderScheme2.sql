ALTER TABLE order_work add COLUMN alias_id varchar(10) ;
ALTER TABLE order_work add INDEX alias_id (alias_id) ;
SELECT * FROM order_work ;