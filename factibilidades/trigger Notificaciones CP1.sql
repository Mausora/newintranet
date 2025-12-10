DROP TRIGGER IF EXISTS `Notificaciones`|
CREATE DEFINER=`root`@`localhost` TRIGGER `Notificaciones` BEFORE UPDATE ON `enlaces_cabecera` FOR EACH ROW BEGIN
	IF(NEW.estado <> OLD.estado) THEN
		IF(NEW.estado = 1) THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "mauricio@pitchile.cl",
				`subject` = CONCAT( "Alerta nueva Factibilidad FAC Nº ",NEW.fac),
				`message` = CONCAT( "Alerta nueva Factibilidad FAC Nº ",NEW.fac, " 
				Verifique datos ingresados y si se envió solicitud a proveedor.
				
				Http://enlaces.pitchile.cl" );
		END IF;
		IF(NEW.estado = 4) THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "daniel@pitchile.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, "a Solicitar Instalación"),
				`message` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, ", a Solicitar Instalación. 
				Debe solicitar el enlace al proveedor.
				
				Http://enlaces.pitchile.cl" );
		END IF;
		IF(NEW.estado = 5) THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "m@tnagroup.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, " a En Instalación"),
				`message` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, ", a En Instalación. 
				Favor coordinar la Instalación con el proveedor y con el cliente.
				
				Http://enlaces.pitchile.cl" );
		END IF;
		IF(NEW.estado = 6) THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "jaime@tnagroup.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, " a En Provisión"),
				`message` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, ", a En Provisión. 
				Favor provisionar enlace y terminar instalación para pasar a producción.
				
				Http://enlaces.pitchile.cl" );
		END IF;
		IF(NEW.estado = 7) THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "daniel@pitchile.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, " a En Producción"),
				`message` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, ", a En Producción. 
				Debe facturar la proporcionalidad.
				
				Http://enlaces.pitchile.cl" );
		END IF;
		IF(NEW.estado = 8) THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "daniel@pitchile.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, " a Dado de Baja"),
				`message` = CONCAT( "Alerta Cambio de estado FAC Nº ",NEW.fac, ", a Dado de Baja. 
				Debe detener la facturación y mover el enlace a otra dirección. (Retirar equipamiento si procede)
				
				Http://enlaces.pitchile.cl" );
		END IF;
	END IF;
END
