CREATE TABLE `resultados` (
  `idusu` int(11) NOT NULL,
  `jo_codigo` int(11) NOT NULL,
  `Acerto` varchar(50) DEFAULT NULL,
  `pontos` int(11) DEFAULT NULL,
  PRIMARY KEY (`jo_codigo`,`idusu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;