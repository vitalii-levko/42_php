SELECT `genre`.`id_genre` AS 'id_genre',
`genre`.`name` AS 'name_genre',
`distrib`.`id_distrib` AS 'id_distrib',
`distrib`.`name` AS 'name_distrib',
`film`.`title` AS 'title_film'
FROM `db_vlevko`.`film`
LEFT JOIN `db_vlevko`.`genre` ON `db_vlevko`.`film`.`id_genre` = `db_vlevko`.`genre`.`id_genre`
LEFT JOIN `db_vlevko`.`distrib` ON `db_vlevko`.`film`.`id_distrib` = `db_vlevko`.`distrib`.`id_distrib`
WHERE `db_vlevko`.`film`.`id_genre` BETWEEN 4 AND 8;
