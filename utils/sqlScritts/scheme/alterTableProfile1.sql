--ALTER TABLE userprofile drop COLUMN  reg_confirmation  ; // факт подтверждения
ALTER TABLE userprofile add INDEX  confirmation_key (confirmation_key) ; // ключ для рассылки
SELECT * FROM userprofile ;