SELECT `title` AS 'Title', `summary` AS 'Summary', `prod_year` FROM `db_vlevko`.`film`
INNER JOIN `db_vlevko`.`genre` ON `db_vlevko`.`film`.`id_genre` = `db_vlevko`.`genre`.`id_genre`
WHERE `db_vlevko`.`genre`.`name` = 'erotic'
ORDER BY `prod_year` DESC;
