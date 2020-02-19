CREATE TABLE `despedido` (
  `id` int(7) NOT NULL auto_increment,
  `nombre_despedido` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) type=MyISAM;


INSERT INTO `despedido` VALUES (1, 'Juan Perez');
INSERT INTO `despedido` VALUES (2, 'Miguel Hernandez');
INSERT INTO `despedido` VALUES (3, 'Maria Sanchez');

CREATE TABLE `contratado` (
  `id` int(7) NOT NULL auto_increment,
  `nombre_contratado` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) type=MyISAM;


INSERT INTO `contratado` VALUES (1, 'Vicente Fernandez');
INSERT INTO `contratado` VALUES (2, 'Julio Mendez');
INSERT INTO `contratado` VALUES (3, 'Teresa Ravello');
INSERT INTO `contratado` VALUES (4, 'Javier Moreno');
INSERT INTO `contratado` VALUES (5, 'Claudia Perez');