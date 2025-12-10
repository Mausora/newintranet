seBEGIN
	IF(NEW.estado <> OLD.estado) THEN
		IF(NEW.estado = "00 sin solicitar") THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "mauricio@tnagroup.cl",
				`subject` = CONCAT( "Alerta nueva Factibilidad FAC",NEW.fac),
				`message` = CONCAT( "Alerta nueva Factibilidad FAC",NEW.fac, " 
				Verifique datos ingresados y si se envió solicitud a proveedor.
				Http://fac.tnasolutions.cl" );
		END IF;
		IF(NEW.estado = "01 solicitado") THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "mauricio@tnagroup.cl, romina@tnasolutions.cl",
				`subject` = CONCAT( "Alerta Factibilidad FAC",NEW.fac, "Solicitada."),
				`message` = CONCAT( "Alerta Factibilidad FAC",NEW.fac, " 
				Solicitada a Proveedores, en espera de presupuestos.
				Http://fac.tnasolutions.cl" );
		END IF;
		IF(NEW.estado = "04 solicitar instalación") THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "mauricio@tnagroup.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, " a Solicitar Instalación"),
				`message` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, ", a Solicitar Instalación. 
				Debe solicitar el enlace al proveedor.
				Http://fac.tnasolutions.cl" );
		END IF;
		IF(NEW.estado = "05 instalación") THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "m@tnagroup.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, " a En Instalación"),
				`message` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, ", a En Instalación. 
				Favor coordinar la Instalación con el proveedor y con el cliente.
				Http://fac.tnasolutions.cl" );
		END IF;
		IF(NEW.estado = "06 en provisión") THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "imera@tnasolutions.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, " a En Provisión"),
				`message` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, ", a En Provisión. 
				Favor provisionar enlace y terminar instalación para pasar a producción.
				Http://fac.tnasolutions.cl" );
		END IF;
		IF(NEW.estado = "07 en producción") THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "mauricio@tnagroup.cl,m@tnagroup.cl, sac@tnasolutions.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, " a En Producción"),
				`message` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, ", a En Producción. 
				Debe facturar la proporcionalidad.
				Http://fac.tnasolutions.cl" );
		END IF;
		IF(NEW.estado = "08 dado de baja") THEN
			INSERT INTO emails SET 
				`enviado` = 0,
			 	`fecha`   = NOW(),
			 	`to`		  = "mauricio@tnagroup.cl,m@tnagroup.cl, imera@tnasolutions.cl,sac@tnasolutions.cl",
				`subject` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, " a Dado de Baja"),
				`message` = CONCAT( "Alerta Cambio de estado FAC",NEW.fac, ", a Dado de Baja. 
				Debe detener la facturación y mover el enlace a otra dirección. (Retirar equipamiento si procede)
				Http://fac.tnasolutions.cl" );
		END IF;
	END IF;
END