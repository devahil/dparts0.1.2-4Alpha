CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` tinytext NOT NULL,
  `pass` tinytext NOT NULL,
  `nivel_acceso` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `usuarios` (`ID`, `usuario`, `pass`, `nivel_acceso`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0);