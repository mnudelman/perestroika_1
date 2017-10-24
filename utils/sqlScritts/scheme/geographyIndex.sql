ALTER TABLE country ADD PRIMARY KEY (id);
ALTER TABLE region ADD PRIMARY KEY (id);
ALTER TABLE city ADD PRIMARY KEY (id);
ALTER TABLE region ADD index country_id (country_id);
ALTER TABLE city ADD index country_id (country_id);
ALTER TABLE city ADD index region_id (region_id);
-- ALTER TABLE имя_таблицы ADD INDEX имя_индекса (список_столбцов);
ALTER TABLE region ADD index name (name);
ALTER TABLE city ADD index name (name);