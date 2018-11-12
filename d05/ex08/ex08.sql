SELECT `last_name`, `first_name`, CONVERT(`birthdate`, DATE) FROM `db_vlevko`.`user_card`
WHERE YEAR(`birthdate`) = '1989'
ORDER BY `last_name` ASC;
