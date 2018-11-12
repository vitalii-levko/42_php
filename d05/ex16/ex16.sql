SELECT COUNT(*) AS 'movies' FROM `db_vlevko`.`member_history`
WHERE `date` BETWEEN '2006-10-30' AND '2007-07-27'
OR DATE_FORMAT(`date`, '%m-%d') = '12-24';
