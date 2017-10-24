--ALTER TABLE userprofile drop COLUMN  reg_confirmation  ; // факт подтверждения
ALTER TABLE userprofile add COLUMN  confirmation_date TIMESTAMP ; // момент времени
ALTER TABLE userprofile add COLUMN  confirmation_flag TINYINT DEFAULT 0 ; // факт подтверждения
ALTER TABLE userprofile add COLUMN  confirmation_key VARCHAR (10) ; // ключ для рассылки
SELECT * FROM userprofile ;