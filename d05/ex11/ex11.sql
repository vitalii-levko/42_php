SELECT UPPER(`last_name`) AS 'NAME', `first_name`, `price` FROM `db_vlevko`.`user_card`
INNER JOIN `db_vlevko`.`member` ON `db_vlevko`.`user_card`.`id_user` = `db_vlevko`.`member`.`id_user_card`
INNER JOIN `db_vlevko`.`subscription` ON `db_vlevko`.`member`.`id_sub` = `db_vlevko`.`subscription`.`id_sub`
WHERE `db_vlevko`.`subscription`.`price` > 42
ORDER BY `last_name` ASC, `first_name` ASC;
