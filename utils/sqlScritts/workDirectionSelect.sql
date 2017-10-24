SELECT * FROM work_direction ;
SELECT * FROM work_item ;
--DELETE FROM developer_work_direction WHERE id = 8 ;
SELECT * FROM developer_work_direction ;
DELETE FROM developer_work_item
       WHERE developer_work_direction_id NOT IN (SELECT id FROM developer_work_direction) ;
SELECT * FROM developer_work_item ;