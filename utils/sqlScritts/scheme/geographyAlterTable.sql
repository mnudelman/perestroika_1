ALTER TABLE userprofile ADD COLUMN city_id INTEGER
 REFERENCES city (id) ON DELETE CASCADE ;