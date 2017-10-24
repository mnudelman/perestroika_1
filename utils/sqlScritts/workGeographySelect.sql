--DELETE FROM work_region where id = 1 ;
SELECT work_region.* from work_region order by work_country_id;
SELECT work_country.*,country.name FROM work_country,country
 WHERE work_country.country_id = country.id ORDER BY work_country.userid;
SELECT work_region.*,region.name FROM work_region,region
WHERE work_region.region_id = region.id ORDER BY work_region.work_country_id  ;
SELECT work_city.*,city.name FROM work_city,city
WHERE work_city.city_id = city.id ORDER BY work_city.work_region_id;
SELECT work_city.* FROM work_city ;