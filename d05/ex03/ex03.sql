INSERT INTO `db_vlevko`.`ft_table` (`login`, `group`, `creation_date`)
SELECT `last_name`, 'other', `birthdate` FROM `db_vlevko`.`user_card`
WHERE `last_name` LIKE '%a%'
AND LENGTH(`last_name`) < 9
ORDER BY `last_name` ASC LIMIT 10;
