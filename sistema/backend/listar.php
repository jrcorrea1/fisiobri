<?php
session_start();
include('../../conexion.php');

include('../core/config.php');
$dbconn = getConnection();



if ($_SESSION['idUser']) {
	// Check if the form was sent and the action is listarciudad
	if (isset($_POST['accion']) and $_POST['accion'] == "listarCiudad" and $_POST['departamento']) {
		$departamento = $_POST['departamento'];
		// prepare statement for select
		$stmt = $dbconn->prepare('SELECT ciudad as cod, ciudad as nombre FROM ciudad WHERE departamento = :departamento  ORDER BY ciudad ASC');
		// bind value to the :id parameter
		$stmt->bindValue(':departamento', $departamento);
		// execute the statement
		$stmt->execute();
		// return the result set as an object
		$ciudad = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if ($ciudad == FALSE) {
			$result = FALSE;
		} else {
			$result = TRUE;
		}
		$message = $result ? "success" : "Ocurrio un error intentado resolver la solicitud, por favor complete todos los campos o recargue de vuelta la pagina";

		$status = $result ? "success" : "error";
		print json_encode(array("status" => $status, "message" => $message, "ciudad" => $ciudad));
	} // Check if the form was sent and the action is listarciudad
	else if (isset($_POST['accion']) and $_POST['accion'] == "listarBarrios" and $_POST['ciudad']) {
		//Parametros
		$ciudad = $_POST['ciudad'];
		$departamento = $_POST['departamento'];
		if (!empty($ciudad) && !empty($departamento)) {
			try {

				//SQL
				$querySQL = "SELECT barrio as cod, barrio as nombre FROM barrio
				WHERE ciudad=:ciudad AND departamento=:departamento ORDER BY barrio ASC";
				// prepare statement for select
				$stmt = $dbconn->prepare($querySQL);
				// bind value to the :id parameter
				$stmt->bindValue(':ciudad', $ciudad);
				$stmt->bindValue(':departamento', $departamento);
				// execute the statement
				$stmt->execute();
				// return the result set as an object
				$barrios = $stmt->fetchAll();

				if ($barrios == FALSE) {
					$result = FALSE;
				} else {
					$result = TRUE;
				}
				$message = $result ? "success" : "Ocurrio un error intentado resolver la solicitud, por favor complete todos los campos o recargue de vuelta la pagina";

				$status = $result ? "success" : "error";
				print json_encode(array("status" => $status, "message" => $message, "barrios" => $barrios));
			} catch (Exception $e) {
				echo "Error al buscar $e";
			}
		}
	} else // FORM NOT SENT
	{
		print json_encode(array("status" => "error", "message" => "Formulario no enviado"));
	}
} else // NOT LOGGED
{
	print json_encode(array("status" => "error", "message" => "No autorizado"));
}
