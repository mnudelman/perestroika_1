-- SELECT city.*,region.name as region_name from city,country,region
-- WHERE city.country_id = country.id AND city.region_id = region.id AND
-- country.name = 'Россия' AND region.name LIKE 'Свердловск%'
-- order by city.name;
-- SELECT * FROM country where country.name = 'Ливан' order by country.name ;
-- SELECT region.*,country.name as country_name from region,country where region.country_id = country.id AND
-- country.name = 'Израиль'
-- order by region.name ;
-- SELECT city.*,country.name as country_name from city,country where city.country_id = country.id AND
-- country.name = 'Израиль'
-- order by city.name ;

SELECT * FROM region where country_id = 3159 ;
SELECT * FROM country where country.name = 'Россия' order by country.name ;
SELECT city.* FROM city where region_id = '4593' ;