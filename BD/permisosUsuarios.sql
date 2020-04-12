CREATE USER IF NOT EXISTS 'usuario'@'localhost' IDENTIFIED WITH mysql_native_password USING PASSWORD('abc123.');
CREATE USER IF NOT EXISTS 'dbadministrator'@'localhost' IDENTIFIED WITH mysql_native_password USING PASSWORD('abc123.');
GRANT SELECT ON mundo_balonmano.historico_fichajes_jugadores TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.jugadores TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.clubs TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.equipos TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.tipos_equipo TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.puestos TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.jugadores_puestos TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.paises TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.cuerpo_tecnico TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.puestos_cuerpo_tecnico TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.historico_fichajes_cuerpo_tecnico TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.noticias TO 'dbadministrator'@'localhost';
GRANT SELECT ON mundo_balonmano.competiciones TO 'dbadministrator'@'localhost';