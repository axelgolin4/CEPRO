<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../vendor/autoload.php';

include('../database.php');





function sanearUtf8(?string $valor): ?string
{
    if ($valor === null) {
        return null;
    }

    return mb_convert_encoding($valor, 'UTF-8', 'UTF-8') === $valor ? $valor : @iconv('UTF-8', 'UTF-8//IGNORE', $valor);
}



function BoletaToner($IDATENC, $CONEXION, $TIPO)
{
    $IDU = $_SESSION['IDU'];
    if ($TIPO == 0) {
        $SQL = sqlsrv_query($CONEXION, "SELECT TOP(1) A.IDATENCION,CONCAT(TB.CAMPOSTR,C.CAMPOSTR) LICIT, VEN.COMPANY CLIENTE, B.CAMPOSTR BOLETA,
     IMG.IMGCLIENTE,LCLI.IMGCLIENTE IMGLOGO, O.CAMPOINT COMPANY,CSEC.NOMSEC,CSEC.CODPRE,A.ASUNTO,A.DESCRI,UBIC.CAMPOSTR DIRECCION,
     CASE
    WHEN ATEREL.CAMPOINT = 0 THEN NULL
    WHEN ATEREL.CAMPOINT IS NOT NULL THEN CONCAT('Relacionado a: AT-',ATEREL.CAMPOINT)
    ELSE NULL
    END ATEREL,OFI.CAMPOSTR OFICINA,DEP.CAMPOSTR DEPARTAMENTO,TEL.CAMPOSTR TELEFONO,
	CASE
	WHEN USUARIO.UNAME IS NOT NULL THEN USUARIO.UNAME
	WHEN NEWUSER1.CAMPOSTR IS NOT NULL THEN NEWUSER1.CAMPOSTR
	END USUARIO,BOLETA.HTMLBOL BOL,A.FREGISTRO,D.CAMPOSTR USER_RECEIVE,M.CAMPOSTR CEDULA,FIRM.SRCFIRMA FIRMA,FIRM.FECHA FECHAFIRMA
    FROM ATENCIONES A WITH(NOLOCK)
    INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
    INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
    INNER JOIN DATOS_ADICIONALES UBIC WITH(NOLOCK) ON UBIC.TREGISTRO = '2' AND UBIC.IDREGISTRO = A.IDATENCION AND UBIC.IDCAMPO = 3  --Ubicacion
    INNER JOIN DATOS_ADICIONALES OFI WITH(NOLOCK) ON OFI.TREGISTRO = '2' AND OFI.IDREGISTRO = A.IDATENCION AND OFI.IDCAMPO = 191  --Oficina
    INNER JOIN DATOS_ADICIONALES DEP WITH(NOLOCK) ON DEP.TREGISTRO = '2' AND DEP.IDREGISTRO = A.IDATENCION AND DEP.IDCAMPO = 54 --Oficina
    INNER JOIN DATOS_ADICIONALES TEL WITH(NOLOCK) ON TEL.TREGISTRO = '2' AND TEL.IDREGISTRO = A.IDATENCION AND TEL.IDCAMPO = 120 --TELEFONO
    LEFT JOIN USUARIOS USUARIO WITH(NOLOCK) ON USUARIO.CODUSUARIO=A.IDUSR
    INNER JOIN DATOS_ADICIONALES ATEREL WITH(NOLOCK) ON ATEREL.TREGISTRO = '2' AND ATEREL.IDREGISTRO = A.IDATENCION AND ATEREL.IDCAMPO = 193  --Atencion Relacionada
    LEFT JOIN DATOS_ADICIONALES TB WITH(NOLOCK) ON TB.TREGISTRO = '2' AND TB.IDREGISTRO = A.IDATENCION AND TB.IDCAMPO = 68  --Tipo de Boleta
    INNER JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
    LEFT JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
    LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
    LEFT JOIN DATOS_ADICIONALES Q WITH(NOLOCK) ON Q.TREGISTRO = '2' AND Q.IDREGISTRO = A.IDATENCION AND Q.IDCAMPO = 43  --Cuenta Secundaria
    LEFT JOIN SECUNDARIAS CSEC WITH(NOLOCK) ON CSEC.IDU = Q.CAMPOINT
    INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
    INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
    LEFT JOIN BOLETASHTML BOLETA WITH(NOLOCK) ON BOLETA.IDBOL=8
	LEFT JOIN DATOS_ADICIONALES NEWUSER1 WITH (NOLOCK) ON NEWUSER1.TREGISTRO = '2' AND NEWUSER1.IDREGISTRO = A.IDATENCION AND NEWUSER1.IDCAMPO = 198 -- Nuevo Usuario 1
	INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
	INNER JOIN DATOS_ADICIONALES M WITH(NOLOCK) ON M.TREGISTRO = '2' AND M.IDREGISTRO = A.IDATENCION AND M.IDCAMPO = 40  --Cedula
	LEFT JOIN FIRMAS FIRM WITH(NOLOCK) ON FIRM.IDATEN = A.IDATENCION -- FIRMA
  WHERE ATEREL.CAMPOINT = '$IDATENC' ORDER BY ATEREL.IDDATA DESC");
    } else {
        $SQL = sqlsrv_query($CONEXION, "SELECT TOP(1) A.IDATENCION,CONCAT(TB.CAMPOSTR,C.CAMPOSTR) LICIT, VEN.COMPANY CLIENTE, B.CAMPOSTR BOLETA,
     IMG.IMGCLIENTE,LCLI.IMGCLIENTE IMGLOGO, O.CAMPOINT COMPANY,CSEC.NOMSEC,CSEC.CODPRE,A.ASUNTO,A.DESCRI,UBIC.CAMPOSTR DIRECCION,
     CASE
    WHEN ATEREL.CAMPOINT = 0 THEN NULL
    WHEN ATEREL.CAMPOINT IS NOT NULL THEN CONCAT('Relacionado a: AT-',ATEREL.CAMPOINT)
    ELSE NULL
    END ATEREL,OFI.CAMPOSTR OFICINA,DEP.CAMPOSTR DEPARTAMENTO,TEL.CAMPOSTR TELEFONO,
	CASE
	WHEN USUARIO.UNAME IS NOT NULL THEN USUARIO.UNAME
	WHEN NEWUSER1.CAMPOSTR IS NOT NULL THEN NEWUSER1.CAMPOSTR
	END USUARIO,BOLETA.HTMLBOL BOL,A.FREGISTRO,D.CAMPOSTR USER_RECEIVE,M.CAMPOSTR CEDULA,FIRM.SRCFIRMA FIRMA,FIRM.FECHA FECHAFIRMA
    FROM ATENCIONES A WITH(NOLOCK)
    INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
    INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
    INNER JOIN DATOS_ADICIONALES UBIC WITH(NOLOCK) ON UBIC.TREGISTRO = '2' AND UBIC.IDREGISTRO = A.IDATENCION AND UBIC.IDCAMPO = 3  --Ubicacion
    INNER JOIN DATOS_ADICIONALES OFI WITH(NOLOCK) ON OFI.TREGISTRO = '2' AND OFI.IDREGISTRO = A.IDATENCION AND OFI.IDCAMPO = 191  --Oficina
    INNER JOIN DATOS_ADICIONALES DEP WITH(NOLOCK) ON DEP.TREGISTRO = '2' AND DEP.IDREGISTRO = A.IDATENCION AND DEP.IDCAMPO = 54 --Oficina
    INNER JOIN DATOS_ADICIONALES TEL WITH(NOLOCK) ON TEL.TREGISTRO = '2' AND TEL.IDREGISTRO = A.IDATENCION AND TEL.IDCAMPO = 120 --TELEFONO
    LEFT JOIN USUARIOS USUARIO WITH(NOLOCK) ON USUARIO.CODUSUARIO=A.IDUSR
    LEFT JOIN DATOS_ADICIONALES ATEREL WITH(NOLOCK) ON ATEREL.TREGISTRO = '2' AND ATEREL.IDREGISTRO = A.IDATENCION AND ATEREL.IDCAMPO = 193  --Atencion Relacionada
    LEFT JOIN DATOS_ADICIONALES TB WITH(NOLOCK) ON TB.TREGISTRO = '2' AND TB.IDREGISTRO = A.IDATENCION AND TB.IDCAMPO = 68  --Tipo de Boleta
    INNER JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
    LEFT JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
    LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
    LEFT JOIN DATOS_ADICIONALES Q WITH(NOLOCK) ON Q.TREGISTRO = '2' AND Q.IDREGISTRO = A.IDATENCION AND Q.IDCAMPO = 43  --Cuenta Secundaria
    LEFT JOIN SECUNDARIAS CSEC WITH(NOLOCK) ON CSEC.IDU = Q.CAMPOINT
    INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
    INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
    LEFT JOIN BOLETASHTML BOLETA WITH(NOLOCK) ON BOLETA.IDBOL=8
	LEFT JOIN DATOS_ADICIONALES NEWUSER1 WITH (NOLOCK) ON NEWUSER1.TREGISTRO = '2' AND NEWUSER1.IDREGISTRO = A.IDATENCION AND NEWUSER1.IDCAMPO = 198 -- Nuevo Usuario 1
	INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
	INNER JOIN DATOS_ADICIONALES M WITH(NOLOCK) ON M.TREGISTRO = '2' AND M.IDREGISTRO = A.IDATENCION AND M.IDCAMPO = 40  --Cedula
	LEFT JOIN FIRMAS FIRM WITH(NOLOCK) ON FIRM.IDATEN = A.IDATENCION -- FIRMA
  WHERE A.IDATENCION = '$IDATENC' ORDER BY ATEREL.IDDATA DESC");
    }

    $A = sqlsrv_fetch_array($SQL);

    $FIRMA = $A['FIRMA'];
    $USER_RECEIVE = utf8_encode($A['USER_RECEIVE']);
    $CEDULA = $A['CEDULA'];
    $FECHAFIRMA = $A['FECHAFIRMA'];
    if ($FECHAFIRMA != '') {
        $FECHAFIRMA = $FECHAFIRMA->format('d/m/Y H:i');
    }
    if ($A['FREGISTRO'] != '') {
        $FREGISTRO = $A['FREGISTRO']->format('d/m/Y');
    }

    $HTMLBOL = utf8_encode($A['BOL']);
    $HTMLBOL = str_replace('%ASUNTO%', utf8_encode($A['ASUNTO']), $HTMLBOL);
    $HTMLBOL = str_replace('%TIPOBOL%', utf8_encode($A['LICIT']), $HTMLBOL);
    $HTMLBOL = str_replace('%boleta%', $A['BOLETA'], $HTMLBOL);
    $HTMLBOL = str_replace('%Cliente%', utf8_encode($A['CLIENTE']), $HTMLBOL);
    $HTMLBOL = str_replace('%NUsuario%', utf8_encode($A['USUARIO']), $HTMLBOL);
    $HTMLBOL = str_replace('%fecha%', $FREGISTRO, $HTMLBOL); //POR EL MOMENTO QUE ES FISICA
    $HTMLBOL = str_replace('%reporte%', 'AT-' . $A['IDATENCION'], $HTMLBOL);
    $HTMLBOL = str_replace('%dep%', utf8_encode($A['DEPARTAMENTO']), $HTMLBOL);
    $HTMLBOL = str_replace('%oficina%', utf8_encode($A['OFICINA']), $HTMLBOL);
    $HTMLBOL = str_replace('%dir%', utf8_encode($A['DIRECCION']), $HTMLBOL);
    $HTMLBOL = str_replace('%tel%', $A['TELEFONO'], $HTMLBOL);
    $HTMLBOL = str_replace('%usuario%', 'Componentes El Orbe S.A.', $HTMLBOL); //POR EL MOMENTO QUE ES FISICA
    $DESCRI = $A['DESCRI'];
    $DESCRI = str_replace('\n', '<br>', $DESCRI);
    $DESCRI = utf8_encode($DESCRI);
    $HTMLBOL = str_replace('%Obser%', $DESCRI . '<br><b>' . $A['ATEREL'] . '</b>', $HTMLBOL);
    $HTMLBOL = str_replace('%NBOLETA%', $A['BOLETA'] . ' - ' . utf8_encode($A['CLIENTE']), $HTMLBOL);
    $HTMLBOL = str_replace('%LOGOUNINEG%', $A['IMGLOGO'], $HTMLBOL);
    if ($A['IMGCLIENTE'] != '') {
        $HTMLBOL = str_replace('%LOGOCLIENTE%', $A['IMGCLIENTE'], $HTMLBOL);
    } else {
        $HTMLBOL = str_replace('src="%LOGOCLIENTE%"', 'src="%LOGOCLIENTE%" style="display:none;"', $HTMLBOL);
    }
    $HTMLBOL = str_replace('%Ncompleto%', $USER_RECEIVE, $HTMLBOL);
    $HTMLBOL = str_replace('%cedula%', $CEDULA, $HTMLBOL);
    $HTMLBOL = str_replace('%firma%', $FIRMA, $HTMLBOL);
    $HTMLBOL = str_replace('%fechafirma%', $FECHAFIRMA, $HTMLBOL);

    if ($A['CLIENTE'] == '') {
        trigger_error("Error", E_USER_ERROR);
    }

    $TONER = '<style>
  .Tablatoner {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
    text-align: left;
  }
  </style><table class="Tablatoner" style="width:100%;">
    <tr class="Tablatoner">
      <th class="Tablatoner">Activo</th>
      <th class="Tablatoner">Modelo Impresora</th>
      <th class="Tablatoner">Serie</th>
      <th class="Tablatoner">Descripción</th>
      <th class="Tablatoner">Modelo tóner</th>
    </tr>';
    $IDATONER = $A['IDATENCION'];

    $SQL = sqlsrv_query($CONEXION, "SELECT ACTIVO,MODELOIMP,SERIE,DESCRIPCION,MODELOTONER FROM ENTREGA_TONER WHERE IDATENCION='$IDATONER'");
    $VALTONER = '';
    while ($B = sqlsrv_fetch_array($SQL)) {
        $VALTONER .= '<tr class="Tablatoner">
      <td class="Tablatoner">' . $B['ACTIVO'] . '</td>
      <td class="Tablatoner">' . $B['MODELOIMP'] . '</td>
      <td class="Tablatoner">' . $B['SERIE'] . '</td>
      <td class="Tablatoner">' . str_replace('\n', '<br>', $B['DESCRIPCION']) . '</td>
      <td class="Tablatoner">' . $B['MODELOTONER'] . '</td>
    </tr>';
    }

    if ($VALTONER != '') {
        $TONER .= $VALTONER . '</table>';
    } else {
        trigger_error("Error toner", E_USER_ERROR);
    }
    $HTMLBOL = str_replace('%tablatoner%', $TONER, $HTMLBOL);

    $fh = fopen("D:/SpeedyFiles/Boletas/TNR/" . $A['IDATENCION'] . " - " . $A['BOLETA'] . ".html", 'w+') or die("Se produjo un error al crear el archivo");
    fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
    fclose($fh);

    $VALUERETURN = $A['IDATENCION'] . '/' . $A['BOLETA'];
    return $VALUERETURN;
}
//HASTA AQUI
function EnviarNotif($NOMBARCHIVO, $RUTA, $ARCHIVO, $IDATENCION, $CONTACTO, $ENCARGADO, $CONEXION, $SERVICIO)
{
    $mail = new PHPMailer();

    //Server settings
    $mail->SMTPDebug = 1;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'outlook.office365.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'obarandanotif@corporacionob.com';                     // SMTP username
    $mail->Password   = 'P@55w0rDOB*';                               // SMTP password
    $mail->SMTPSecure = 'TLS';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('obarandanotif@corporacionob.com', 'OBARANDA');
    if ($IDATENCION != '0') {

        $USCORREO = sqlsrv_query($CONEXION, "SELECT A.UNAME, A.EMAIL FROM USUARIOS A WITH(NOLOCK)
      INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.IDCAMPO=123 AND B.CAMPOINT=A.CODUSUARIO
      WHERE B.IDREGISTRO='$IDATENCION'");
        $A = sqlsrv_fetch_array($USCORREO);
        $UNAME = utf8_encode($A['UNAME']);
        $EMAIL = $A['EMAIL'];
        $mail->addAddress($EMAIL, $UNAME);

        $ARCHIVO = str_replace('%UNAMEIDU%', $UNAME, $ARCHIVO);

        if ($ENCARGADO != '' || $ENCARGADO != '0') {
            $SQL = sqlsrv_query($CONEXION, "SELECT UNAME,EMAIL FROM USUARIOS WITH(NOLOCK) WHERE CODUSUARIO='$ENCARGADO'");
            $A = sqlsrv_fetch_array($SQL);
            $UNAME2 = utf8_encode($A['UNAME']);
            $EMAIL2 = $A['EMAIL'];
            $mail->addAddress($EMAIL2, $UNAME2);
        }


        if ($CONTACTO != '' || $CONTACTO != '0') {
            $SQL = sqlsrv_query($CONEXION, "SELECT UNAME,EMAIL FROM USUARIOS WITH(NOLOCK) WHERE CODUSUARIO='$CONTACTO'");
            $C = sqlsrv_fetch_array($SQL);
            $UNAME3 = utf8_encode($C['UNAME']);
            $EMAIL3 = $C['EMAIL'];
            $mail->addAddress($EMAIL3, $UNAME3);
            $ARCHIVO = str_replace('%TRANSPORTISTA%', $UNAME3, $ARCHIVO);
        }



        $subject = $NOMBARCHIVO;
    } else {
        if ($CONTACTO != '' || $CONTACTO != '0') {
            $SQL = sqlsrv_query($CONEXION, "SELECT UNAME,EMAIL FROM USUARIOS WITH(NOLOCK) WHERE CODUSUARIO='$CONTACTO'");
            $A = sqlsrv_fetch_array($SQL);
            $UNAME = utf8_encode($A['UNAME']);
            $EMAIL = $A['EMAIL'];
            $mail->addAddress($EMAIL, $UNAME);
        }
        if ($ENCARGADO != '' || $ENCARGADO != '0') {
            $SQL = sqlsrv_query($CONEXION, "SELECT UNAME,EMAIL FROM USUARIOS WITH(NOLOCK) WHERE CODUSUARIO='$ENCARGADO'");
            $A = sqlsrv_fetch_array($SQL);
            $UNAME2 = utf8_encode($A['UNAME']);
            $EMAIL2 = $A['EMAIL'];

            $mail->addAddress($EMAIL2, $UNAME2);
        }
        if ($SERVICIO == '') {
            $subject = $UNAME . ' ' . $NOMBARCHIVO;
        } else if ($SERVICIO == 8) {
            $subject = $NOMBARCHIVO;
            $ARCHIVO = str_replace('%UNAMEIDU%', $UNAME, $ARCHIVO);
        }
    }

    // Add a recipient


    // Content

    $mail->isHTML(true);                                 // Set email format to HTML
    if ($RUTA != '0') {
        $UNAME = eliminar_tildes($UNAME);
        $NOMBARCHIVO = eliminar_tildes($NOMBARCHIVO);
        $mail->addAttachment($RUTA, $UNAME . ' ' . $NOMBARCHIVO . '.html');
    }
    $mail->Subject = utf8_decode($subject);
    $mail->Body   = utf8_decode($ARCHIVO);

    if (!$mail->Send()) {
        $ESTADO = 0;
        $f = fopen(__DIR__ . '/ErrorMailLogs.txt', 'a');
        fwrite($f, date("d m Y H:i:s") . " = Error en $UNAME" . "/ $EMAIL");
        fclose($f);
    } else {
        $ESTADO = $mail->ErrorInfo;
        $f = fopen(__DIR__ . '/MailLogs.txt', 'a');
        fwrite($f, date("d m Y H:i:s") . "$UNAME" . "/ $EMAIL");
        fclose($f);
    }
    return $ESTADO;
}

function EnviarEncuesta($IDATENCION, $CONEXION)
{
    require_once('../Encriptar.php');
    $SQL = sqlsrv_query($CONEXION, "EXEC SP_INFO_ENCUESTA_ATEN $IDATENCION");

    $ENCRYPT_ATE = encrypt($IDATENCION, '1');

    while ($A = sqlsrv_fetch_array($SQL)) {
        $unineg = $A['UNINEG'];
        $image = '../IMG/' . $unineg . '.png';
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $Archivo = fopen(__DIR__ . "/../CORREOS/Encuesta_cliente.html", "r");
        $RArchivo =  fread($Archivo, filesize("../CORREOS/Encuesta_cliente.html"));
        $RArchivo = str_replace('%ncliente%', utf8_encode($A['USUARIO']), $RArchivo);
        $RArchivo = str_replace('%LOGO%', $dataUri, $RArchivo);
        $RArchivo = str_replace('%ENCUESTA%', utf8_encode($A['NOMBRE']), $RArchivo);
        $RArchivo = str_replace('%DESCRIPCION%', "Encuesta de atencion de caso AT-$IDATENCION <br>" . utf8_encode($A['DESCRIPCION']), $RArchivo);
        $RArchivo = str_replace('%Enlace%', $A['Enlace'] . '&' . $ENCRYPT_ATE, $RArchivo);
        $IDENCUESTA = $A['IDENC'];

        if ($A['CORREO'] != '' && $A['ENVIADO'] == '0') {
            $COMPROBAR = encuesta_enviada($RArchivo, 'Encuesta ' . $A['NOMBRE'], $A['USUARIO'], $A['CORREO']);
        } else if ($A['CORREO'] == '') {
            $COMPROBAR = 'No posee un correo registrado para enviar la encuesta';
        } else if ($A['ENVIADO'] == '1') {
            $COMPROBAR = 'Ya se ha mandado la encuesta anteriormente';
        }

        if ($COMPROBAR != '0') {
            $f = fopen(__DIR__ . '/ErrorLogEncuesta.txt', 'a');
            fwrite($f, date("d m Y H:i:s") . " = AT-" . $IDATENCION . " Error al enviar encuesta " . utf8_encode($A['NOMBRE']) . ' ERROR: ' . $COMPROBAR . " Usuario:" . utf8_encode($A['USUARIO']) . " Correo:" . $A['CORREO'] . PHP_EOL);
            fclose($f);
        } else {
            $f = fopen(__DIR__ . '/LogEncuesta.txt', 'a');
            fwrite($f, date("d m Y H:i:s") . " = AT-" . $IDATENCION . " Encuesta enviada: " . utf8_encode($A['NOMBRE']) . " Usuario:" . utf8_encode($A['USUARIO']) . " Correo:" . $A['CORREO'] . PHP_EOL);
            fclose($f);
            sqlsrv_query($CONEXION, "INSERT INTO SEND_ENC VALUES('$IDENCUESTA','$IDATENCION')");
        }
    }
}

function encuesta_enviada($RArchivo, $ASUNTO, $USUARIO, $CORREO)
{
    $mail = new PHPMailer();

    //Server settings
    $mail->SMTPDebug = 1;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'outlook.office365.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'obarandanotif@corporacionob.com';                     // SMTP username
    $mail->Password   = 'P@55w0rDOB*';                               // SMTP password
    $mail->SMTPSecure = 'TLS';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom("obarandanotif@corporacionob.com");
    if ($CORREO != 'N/A' && $CORREO != '') {
        $CORREO = explode(";", $CORREO);
        $mail->addAddress($CORREO[0], $USUARIO);
    }

    // Add a recipient
    $mail->addBCC("jquesada@corporacionob.com");
    //bjimenez@corporacionob.com

    // Content

    $mail->isHTML(true);                                 // Set email format to HTML
    $mail->Subject = $ASUNTO;
    $mail->Body   = utf8_decode($RArchivo);

    if (!$mail->Send()) {
        $ESTADO = $mail->ErrorInfo;
    } else {
        $ESTADO = 0;
    }

    return $ESTADO;
}

function SONICReeqFod($IDATEN, $connARANDABD)
{

    $SQL = sqlsrv_query($connARANDABD, "SELECT CONCAT(B.IDL,' - ',B.IDC) IDR,E.NOMSEC, IM.add_str_5 PNOMSEC,ISNULL(A.EQENT,0) EQENT,
  B.NPRODU, E.CODPRE, H.UNAME,B.IDL, B.IDC
FROM EQREEQ A WITH(NOLOCK)
INNER JOIN RETIROEQUIPOS B WITH(NOLOCK) ON CONCAT (B.IDL,' - ',B.IDC) =  A.IDR
LEFT JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = 2 AND D.IDREGISTRO = A.IDATENC AND D.IDCAMPO = 43
LEFT JOIN SECUNDARIAS E WITH(NOLOCK) ON E.IDU = D.CAMPOINT
LEFT JOIN ASDK_INCIDENT IM WITH(NOLOCK) ON IM.inci_id = B.IDC
LEFT JOIN ATENCIONES F WITH(NOLOCK) ON F.IDATENCION = A.IDATENC
LEFT JOIN CASOS G WITH(NOLOCK) ON G.IDCASO = F.IDCASO
LEFT JOIN USUARIOS H WITH(NOLOCK) ON H.CODUSUARIO = G.IDTECNICO
WHERE A.IDATENC = '$IDATEN'");

    while ($fila = sqlsrv_fetch_array($SQL)) {
        $IDR = $fila['IDR'];
        $NOMSEC = $fila['NOMSEC'];
        $PNOMSEC = $fila['PNOMSEC'];
        $IDRESP = $_SESSION['IDU'];
        $EQENT = $fila['EQENT'];
        $NPRODU = $fila['NPRODU'];
        $CODPRE = $fila['CODPRE'];
        $UNAME = $fila['UNAME'];
        $IDL = $fila['IDL'];
        $IDC = $fila['IDC'];

        if ($EQENT == 1) {
            sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_STR_SONIC '$IDR',1,'$NOMSEC',8,$IDRESP");
        } else if ($EQENT == 0) {
            sqlsrv_query($connARANDABD, "EXEC SP_CRT_UBIC_DEV '$UNAME', '$CODPRE', '$NPRODU', '$IDR','$IDRESP'");
            sqlsrv_query($connARANDABD, "EXEC SP_INS_ADDDATA_EQ_INT '$IDL' , '$IDC' , '9' , '0'");
            sqlsrv_query($connARANDABD, "EXEC SP_INS_ADDDATA_EQ_INT '$IDL' , '$IDC' , '10' , '0'");
            sqlsrv_query($connARANDABD, "EXEC SP_INS_ADDDATA_EQ_INT '$IDL' , '$IDC' , '13' , '0'");
            sqlsrv_query($connARANDABD, "EXEC SP_INS_ADDDATA_EQ_INT '$IDL' , '$IDC' , '14' , '0'");
        }
    }
}

function MntPrevCISol($connARANDABD, $IDATEN)
{

    $SQLMPCI = sqlsrv_query($connARANDABD, "SELECT ID_CI FROM MNT_PREVENTIVO_AT_X_CI WITH (NOLOCK) WHERE IDAT = '$IDATEN'");
    $IDU = $_SESSION['IDU'];
    while ($RMPCI = sqlsrv_fetch_array($SQLMPCI)) {
        $IDCI = $RMPCI['ID_CI'];
        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDCI','12','173','255','$IDU'");
        sqlsrv_query($connARANDABD, "UPDATE SONIC_CI SET ID_ESTADO=255 WHERE ID_CI='$IDCI'");
    }
}

function EnviarCorreo($HTMLBOL, $LINKBOL, $IDATEN, $connARANDABD, $TYPE)
{

    require_once '../Tildes.php';


    sqlsrv_query($connARANDABD, "DECLARE @FECHAHOY DATETIME=GETDATE() EXEC SP_INS_DATA_DATE '$IDATEN','2','176',@FECHAHOY,'1'");


    $SQL = sqlsrv_query($connARANDABD, "EXEC SP_INFOBOLETA_ATEN $IDATEN , 0");
    $fila = sqlsrv_fetch_array($SQL);
    $NBOLETA = $fila['BOLETA'];
    $NOMUSR = $fila['NOMUSR'];
    $NOMUSR2 = $fila['NOMUSR2'];
    $CORREOU = $fila['CORREOU'];
    $CORREOS = $fila['CORREOS'];
    $CORREOT = $fila['CORREOT'];
    $IDCLIENTE = $fila['IDCLIENTE'];
    $IDCSEC = $fila['IDCSEC'];
    $NSERV = utf8_encode($fila['NSERV']);
    $AUTOR = utf8_encode($fila['AUTOR']);
    $EMAILA = $fila['EMAILA'];
    $NTATENCION = utf8_encode($fila['NATENCION']);
    $VCHECKENV = $fila['VCHECKENV'];
    $NOMBRECLI = $fila['NOMBRECLI'];
    $NOMBRECLI = explode('/', $NOMBRECLI);
    $NOMBRECLI = $NOMBRECLI[0];
    $TIPOATENCION = $fila['TIPOATENCION'];
    $CODPRE = $fila['CODPRE'];
    $LISTA = $fila['LISTA'];
    $IDCASO = $fila['IDCASO'];
    $ATPEN = $fila['ATPEN'];
    $CASOCLI = $fila['CASOCLI'];
    $CASOCOMP = $fila['CASOCOMP'];
    $LICIT = $fila['LICIT'];
    $CORREOS2 = $fila['CORREOS2'];
    $CORREORESP = $fila['CORREORESP'];
    $BOLADDMEP = $fila['BOLADDMEP'];
    $CORREOSEC = $fila['CORREOSEC'];
    $CORREOUSRREAL = $fila['CORREOUSRREAL'];

    $SQL2 = sqlsrv_query($connARANDABD, "SELECT COUNT(*) EX FROM STO_BOLETAS WITH(NOLOCK) WHERE IDATEN = $IDATEN AND IDBOL = '$NBOLETA'");
    $fila2 = sqlsrv_fetch_array($SQL2);
    $EX = $fila2['EX'];
    $EX = 0; //FORZAR ENVIO DE CORREO SI EXISTE BOLETA, PORQUE SE ESTÁ PRESENTANDO UN ERROR QUE NO RECONOCE LA EXISTENCIA DE LA BOLETA Y NO ENVÍA EL CORREO, SE DEBE INVESTIGAR EL PORQUÉ DE ESTE ERROR






    if ($EX == 0) {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 1;                                       // Enable verbose debug output
            $mail->isSMTP();
            $mail->Mailer = "smtp";                                           // Set mailer to use SMTP
            $mail->Host       = 'outlook.office365.com';  // Specify main and backup SMTP servers
            $mail->Port       = 587;                                    // TCP port to connect to
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'obarandanotif@corporacionob.com';                     // SMTP username
            $mail->Password   = 'P@55w0rDOB*';                               // SMTP password
            $mail->SMTPSecure = 'TLS';                           // Enable TLS encryption, `ssl` also accepted

            //Recipients
            $mail->setFrom('obarandanotif@corporacionob.com', 'OBSPEEDY');
            //$mail->addAddress('jquesada@orbe.co.cr', 'Josue Quesada');    // Add a recipient
            if ($VCHECKENV == '0') {

                if ($TIPOATENCION == 4 || $TIPOATENCION == 5) {
                    $mail->addAddress("jsalazarm@orbe.co.cr", "dcordero@corporacionob.com");
                }

                if ($TIPOATENCION == 1 || $TIPOATENCION == 3 || $TIPOATENCION == 4 || $TIPOATENCION == 5) {

                    $SQL_SUPERVISOR = sqlsrv_prepare($connARANDABD, "
                    SELECT D.UNAME, D.EMAIL
                    FROM GROUPHD A WITH(NOLOCK)
                    INNER JOIN CASOS B WITH(NOLOCK) ON B.IDZONA = A.GRP_ID
                    INNER JOIN ATENCIONES C WITH(NOLOCK) ON C.IDCASO = B.IDCASO
                    INNER JOIN USUARIOS D WITH(NOLOCK) ON D.CODUSUARIO = A.GRP_USER
                    WHERE IDATENCION = ?
                ", array($IDATEN));

                    $name_supervisor = null;
                    $correo_supervisor = null;

                    if (sqlsrv_execute($SQL_SUPERVISOR)) {
                        if ($row = sqlsrv_fetch_array($SQL_SUPERVISOR, SQLSRV_FETCH_ASSOC)) {
                            $name_supervisor   = utf8_encode($row['UNAME']);
                            $correo_supervisor = $row['EMAIL'];
                        }
                    }

                    $HTMLBOL = "
                  <div style=\"font-family: Calibri, sans-serif; font-size: 14px; color: #000000; line-height: 1.6;\">
                    <p>
                      Buenas, estimados:
                    </p>
                    <p>
                      Reciban un cordial saludo, seguidamente por este medio les informo que se genera la boleta de atención del tiquete número <strong>AT-$IDATEN</strong>.
                    </p>
                    <p>
                      Cualquier duda o consulta no duden en contactarnos.
                    </p>
                    <p>
                      Saludos cordiales.
                    </p>
                    <p style=\"font-weight: bold; margin-top: 20px;\">
                      Nota importante:
                    </p>
                    <p>
                      Si usted responde a este correo por favor siempre tener en copia a el correo <a href=\"mailto:soporte@elorbe.la\" style=\"color: #184E94;\">soporte@elorbe.la</a> para que todo nuestro equipo de Plataforma de Servicios CC360 pueda visualizar la respuesta y de esta manera ofrecer una pronta y mejor atención.
                    </p>
                  </div>
                " . $HTMLBOL;

                    $CORREOSU = explode(";", $CORREOU);

                    $mail->addAddress($CORREOSU[0]);

                    if (count($CORREOSU) > 1) {
                        for ($i = 1; $i < count($CORREOSU); $i++) {
                            if ($CORREOSU[$i] != '') {
                                $mail->addCC($CORREOSU[$i]);
                            }
                        }
                    }

                    if ($CORREORESP != '') {
                        $mail->addCC($CORREORESP);
                    }
                } else if ($TIPOATENCION == 2) {


                    $CORREOSU = explode(";", $CORREOU);

                    if ($CORREOSU[0] != "arandaceonotif@orbe.co.cr" && $CORREOSU[0] != "admin@orbe.co.cr") {
                        $mail->addAddress($CORREOSU[0], $NOMUSR2);
                    }

                    if (count($CORREOSU) > 1) {
                        for ($i = 1; $i < count($CORREOSU); $i++) {
                            if ($CORREOSU[$i] != '') {
                                $mail->addCC($CORREOSU[$i]);
                            }
                        }
                    }
                } //COPIAR A PRODUCTIVO
                else if ($TIPOATENCION == 8 || $TIPOATENCION == 9 || $TIPOATENCION == 15) {
                    if ($CORREOU != "arandaceonotif@orbe.co.cr" && $CORREOU != "admin@orbe.co.cr") {
                        if ($CORREOU != '' && $CORREOU != 'N/A') {
                            if ($IDCLIENTE != '2066') {
                                $mail->addAddress($CORREOU, $NOMUSR2);
                            } else {

                                if ($LICIT == '2014LN-000002-5500' || $LICIT == '2016LN-000002-0007300001') {
                                    $mail->addAddress('arrendamientoimpresora@mep.go.cr');
                                }

                                if ($LICIT == '2021CD-000001-000730000' || $LICIT == '2016-LN-000002-0007300001') {
                                    $mail->addAddress('jacqueline.montero.guillen@mep.go.cr');
                                }

                                if ($TIPOATENCION == 15) {
                                    $mail->addAddress('jose.guerrero.ortiz@mep.go.cr');
                                    $mail->addAddress('arrendamientoimpresora@mep.go.cr');
                                    $mail->addAddress('jacqueline.montero.guillen@mep.go.cr');
                                }

                                $mail->addAddress('Contratosmps@orbe.co.cr');
                                $mail->addAddress('rrequenes@corporacionob.com', 'Rosa Evelina Requenes Zepeda');
                                $mail->addAddress('crodriguezs@corporacionob.com');
                            }
                        }
                    }
                }
                //hasta aqui
                else {
                    if ($CORREOU != "arandaceonotif@orbe.co.cr" && $CORREOU != "admin@orbe.co.cr") {
                        $mail->addAddress($CORREOU, $NOMUSR);
                    }
                }
            }

            if ($TIPOATENCION == 3) {
                $mail->addCC('dcordero@corporacionob.com');

                if ($IDCLIENTE == '2066') {
                    $mail->addCC('eesquivel@corporacionob.com');
                }
            }
            // Name is optional
            #$mail->addReplyTo('info@example.com', 'Information');
            if ($TYPE == 'TRANSPORTE' || $TYPE == 'MENSAJERIA' || $TYPE == 'TNR') {
                #$mail->addAddress('ellen@example.com');    ENCARGADO
                if ($TIPOATENCION == 8 || $TIPOATENCION == 9) {
                    $mail->addAddress($EMAILA, $AUTOR);
                    $mail->addCC($CORREOUSRREAL);
                }
                if ($TIPOATENCION == 8) {
                    $mail->addAddress('aordenana@corporacionob.com', 'Alberto Ordenana');
                } else if ($TIPOATENCION == 9) {
                    $mail->addAddress('aordenana@corporacionob.com', 'Alberto Ordenana');
                } else if ($TIPOATENCION == 15) {
                    $mail->addAddress('vsandi@orbe.co.cr', 'Viviana Sandi Serrano');
                    $mail->addAddress('Plataforma@corporacionob.com');
                }
                //
                //HASTA AQUI
            } else {
                $mail->addCC($CORREOT);
                $mail->addCC($CORREOS);

                if ($TIPOATENCION == 1) {


                    $SQLCC = sqlsrv_query($connARANDABD, "SELECT CORREO FROM CORREOS_CLIENTES WITH(NOLOCK) WHERE IDCLIENTE = '$IDCLIENTE'");

                    $CORREOSCLI = "";

                    while ($RCC = sqlsrv_fetch_array($SQLCC)) {
                        $CORREOSCLI .= $RCC['CORREO'] . ";";
                        $mail->addCC($RCC['CORREO']);
                    }

                    $mail->addCC('Plataforma@corporacionob.com');
                    $mail->addCC('entregadocumentosst@corporacionob.com');
                    $mail->addCC('garantiasob@orbe.co.cr');

                    if ($CORREOS2 != '') {
                        $mail->addCC($CORREOS2);
                    }

                    if ($IDCLIENTE == 2066) {

                        if ($LICIT == '2021CD-000001-000730000' || $LICIT == '2016-LN-000002-0007300001' || $LICIT == '2022CD-000004-0007300001' || $LICIT == '2016LN-000002-0007300001') {
                            $mail->addAddress('jacqueline.montero.guillen@mep.go.cr');
                        }

                        if ($LICIT == '2022CD-000004-0007300001') {
                            $mail->addAddress('arrendamientoecdig@mep.go.cr');
                        } else if ($LICIT == '2016LN-000002-0007300001') {
                            $mail->addAddress('arrendamientoimpresora@mep.go.cr');
                            $mail->addAddress('jose.guerrero.ortiz@mep.go.cr');
                        }
                        $mail->addAddress('carlos.rodriguez.benavides@mep.go.cr');
                    }
                } else if ($TIPOATENCION == 2) {
                    if ($CORREOS2 != '') {
                        $mail->addCC($CORREOS2);
                    }
                } else if ($TIPOATENCION == 18) {

                    $mail->addCC('Plataforma@corporacionob.com');
                    $mail->addCC('garantiasob@orbe.co.cr');
                }
            }

            $mail->addBCC("jquesada@corporacionob.com");



            // Attachments
            $NOMBREBOL = '';
            if ($TIPOATENCION == 2 || $TIPOATENCION == 3 || $TIPOATENCION == 16) {                                  // Set email format to HTML
                $NOMBREBOL = $NOMBRECLI . ' - ' . $IDATEN . ' - ' . $NBOLETA;
            } else if ($TIPOATENCION == 5 || $TIPOATENCION == 6) {
                $NOMBREBOL = $CODPRE . ' , ' . $NBOLETA . ' , ' . "CS-$IDCASO-AT-$IDATEN" . ' , ' . $LISTA;
            } else if ($TIPOATENCION == 1) {
                $PENDIENTE = "";
                if ($ATPEN == 1) {
                    $PENDIENTE = "- Pendiente";
                }

                $SQLREL = sqlsrv_query($connARANDABD, "SELECT
                                            TRIM(STUFF((SELECT ' - ' + CAST(RELACIONADOS AS VARCHAR(50)) [text()]
                                                    FROM (
                                            SELECT B.CAMPOSTR RELACIONADOS FROM ATENCIONES_RELACION A WITH(NOLOCK)
                                            INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = 2 AND B.IDREGISTRO = A.IDAS AND B.IDCAMPO = 75
                                            WHERE IDAP = $IDATEN AND '1340' = '$IDCLIENTE'
                                            UNION ALL
                                            SELECT CONCAT('CS-',B.IDCASO,'-AT-',A.IDAS) RELACIONADOS FROM ATENCIONES_RELACION A WITH(NOLOCK)
                                            INNER JOIN ATENCIONES B WITH(NOLOCK) ON B.IDATENCION = A.IDAS
                                            WHERE IDAP = $IDATEN AND '1340' != '$IDCLIENTE'
                                            )
                                            TMP FOR XML PATH(''), TYPE).value('.','NVARCHAR(MAX)'),1,2,'')) AS RELACIONADOS");
                $RREL = sqlsrv_fetch_array($SQLREL);
                $RELACIONADOS = $RREL['RELACIONADOS'];

                if ($IDCLIENTE == 1340) {
                    $NOMBREBOL = "$CASOCLI - $RELACIONADOS - $NBOLETA - $LICIT $PENDIENTE";
                } else {
                    $NOMBREBOL = "$CASOCOMP - $RELACIONADOS - $NBOLETA $PENDIENTE";
                }
            } else {
                $NOMBREBOL = $NOMBRECLI . ' AT-' . $IDATEN . ' - ' . $NBOLETA;
            }
            $NOMBREBOL = eliminar_tildes($NOMBREBOL);
            $mail->addAttachment($LINKBOL, $NOMBREBOL . '.html');         // Add attachments




            // ENVIAR BOLETA ARANDA
            try {
                $BoletaIdAranda = sqlsrv_query($connARANDABD, "
             SELECT * FROM DATOS_ADICIONALES 
             WHERE IDREGISTRO = '$IDATEN' 
               AND IDCAMPO = 502
            ");
                $BoletaIdAranda = sqlsrv_fetch_array($BoletaIdAranda);

                if ($BoletaIdAranda) {
                    $idAranda = $BoletaIdAranda['CAMPOINT'];

                    $filePath = $LINKBOL;
                    $fileName = $NOMBREBOL . '.html';

                    if (file_exists($filePath)) {
                        $data = [
                            'Data0' => new CURLFile($filePath, 'text/html', $fileName),
                            'FileItemId' => $idAranda,
                            'FileItemType' => '6',
                            'UploadType' => '0',
                            'Concept' => '0',
                            'Description' => 'Archivo adjunto desde sistema',
                            'IsPublic' => 'true'
                        ];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://ob-one.obgroup.systems/ASMSAPI/api/v9/file/");
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            "X-Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJBdWRpZW5jZSI6IkludGVncmF0aW9uIiwiQXV0aGVudGljYXRpb25Db250ZXh0Q2xhc3MiOm51bGwsIkF1dGhlbnRpY2F0aW9uTWV0aG9kcyI6bnVsbCwiQXV0aGVudGljYXRpb25UaW1lIjoiXC9EYXRlKC02MjEzNTU3NTIwMDAwMClcLyIsIkF1dGhvcml6ZWRQYXJ0eSI6bnVsbCwiRXhwaXJhdGlvblRpbWUiOiJcL0RhdGUoMTc5ODc4MzIwMDAwMClcLyIsIklzc3VlZFRpbWUiOiJcL0RhdGUoMTc2MjgxNTUwMTM5NSlcLyIsIklzc3VlcklkZW50aWZpZXIiOiJhc21zLmFyYW5kYXNvZnQuY29tIiwiTm9uY2UiOm51bGwsIlN1YmplY3QiOm51bGwsIlN1YmplY3RJZGVudGlmaWVyIjoiMSIsIlVzZXJOYW1lIjpudWxsfQ.GrryPNaanFXjrep2FqWnJTREsT_16ByQ00DCuL9y6ZY"
                        ]);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                        $response = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                        if (curl_errno($ch)) {
                            echo 'Error cURL: ' . curl_error($ch);
                        } else {
                            echo "HTTP CODE: $httpCode\n";
                            echo "RESPUESTA: $response\n";
                        }

                        curl_close($ch);
                    }
                }
            } catch (Exception $e) {
                return ["MensajeError" => $e->getMessage()];
            }

            if (($IDCLIENTE == 2066 || $IDCLIENTE == 448) && $TIPOATENCION == 1 && $BOLADDMEP != '') {
                $mail->addAttachment($BOLADDMEP);
            }

            // Content
            $mail->isHTML(true);
            //COPIAR A PRODUCTIVO
            if ($TYPE == 'TRANSPORTE' || $TYPE == 'MENSAJERIA' || $TYPE == 'TNR') {
                //HASTA aqui
                $NTATENCION = $NTATENCION;
                $mail->Subject = 'Boleta de ' . $NTATENCION . ' ' . $NOMBREBOL;

                $Archivo = fopen(__DIR__ . "/../CORREOS/Transportes_cerrado.html", "r");
                $RArchivo =  fread($Archivo, filesize("../CORREOS/Transportes_cerrado.html"));
                $RArchivo = str_replace('%NumAte%', $IDATEN, $RArchivo);
                $RArchivo = str_replace('%TIPOATE%', $NTATENCION, $RArchivo);
                $RArchivo = str_replace('%TATE%', strtolower($NTATENCION), $RArchivo);

                $mail->Body   = utf8_decode($RArchivo);
            } else {
                $mail->Subject = 'Boleta ' . $NOMBREBOL;
                $mail->Body   = utf8_decode($HTMLBOL);
            }                               // Set email format to HTML

            #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


            if ($mail->send()) {

                $f = fopen(__DIR__ . '/MailLogs.txt', 'a');
                fwrite($f, date("d m Y H:i:s") . ' / ' . $CORREOU . ' / ' . $NOMUSR . ' / Especialista: ' . $CORREOT . ' / Supervisor: ' . $CORREOS . ' / Correos Extras: ' . $CORREOSCLI . ' /Caso: ' . $IDATEN . ',' . "\n");
                fclose($f);
                $log = 'Correo Enviado';

                sqlsrv_query($connARANDABD, "INSERT INTO STO_BOLETAS VALUES ((SELECT ISNULL(MAX(IDU),0)+1 FROM STO_BOLETAS),'$IDATEN','$IDCLIENTE','$IDCSEC','$NBOLETA','https://ti-obgroup.app:5557/SpeedyFiles/Boletas/$TYPE/$IDATEN - $NBOLETA.html','0')");

                if ($TYPE == 'REEQFOD') {
                    SONICReeqFod($IDATEN, $connARANDABD);
                }

                if ($TIPOATENCION == 2) {
                    MntPrevCISol($connARANDABD, $IDATEN);
                }
            }
        } catch (Exception $e) {
            $log =  "El Correo no se pudo enviar error: {$mail->ErrorInfo}";
            $f = fopen(__DIR__ . '/ErrorMailLogs.txt', 'a');
            fwrite($f, date("d m Y H:i:s") . " = Error en Atencion $IDATEN: $CORREOU" . "/ $CORREOT" . "/ $CORREOS" . "\n");
            fclose($f);
        }
    } else {

        $log =  "El Correo no se pudo enviar: ya existe este numero de boleta";
        $f = fopen(__DIR__ . '/ErrorMailLogs.txt', 'a');
        fwrite($f, date("d m Y H:i:s") . " = Error en Atencion $IDATEN: $CORREOU" . "/ $CORREOT" . "/ $CORREOS" . "\n");
        fclose($f);
    }


    return $log;
}





error_log("DESCARGANDO BOLETA");

if (isset($_POST['IDATEN']) && isset($_POST['OP'])) {

    error_log("DESCARGANDO BOLETA 2");

    $OP = $_POST['OP'];
    $IDATEN = $_POST['IDATEN'];
    $SEND = $_POST['SEND'];

    if ($OP == 1) {
        $SQLIDAP_EX = sqlsrv_query($connARANDABD, "SELECT IDAP IDAP_EX FROM ATENCIONES_RELACION WITH(NOLOCK)
		WHERE IDAS='$IDATEN'");
        $A_EX = sqlsrv_fetch_array($SQLIDAP_EX);
        $IDAP_EX = $A_EX['IDAP_EX'];

        if ($IDAP_EX != '' || $IDAP_EX != NULL) {
            $IDATEN = $IDAP_EX;
        }

        $SQL = sqlsrv_query($connARANDABD, "SELECT B.NOMBRESERVICIO NSERV,A.IDSERV,C.NOMBREATENCION NATENCION,A.TIPOATENCION,D.CAMPOINT SUBTIPOATENCION
                                            FROM ATENCIONES A WITH(NOLOCK)
                                            INNER JOIN SERVICIOS B WITH(NOLOCK) ON B.IDSERVICIOS=A.IDSERV
                                            INNER JOIN TIPO_ATENCION C WITH(NOLOCK) ON C.IDTATENCION=A.TIPOATENCION
                                            LEFT JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 132  --Sub tipo atencion
                                            WHERE IDATENCION = '$IDATEN'");

        $fila1 = sqlsrv_fetch_array($SQL);
        $NSERV = utf8_encode($fila1['NSERV']);
        $IDSERV = $fila1['IDSERV'];
        $NTATENCION = utf8_encode($fila1['NATENCION']);
        $TIPOATENCION = $fila1['TIPOATENCION'];
        $SUBTIPOATENCION = $fila1['SUBTIPOATENCION'];




        if ($IDSERV == 4 && $TIPOATENCION == 2) {

            $SQL = sqlsrv_query($connARANDABD, "EXEC SP_INFOBOLETA_ATEN $IDATEN, 2");
            $fila3 = sqlsrv_fetch_array($SQL);


            if ($fila3['IDCLIENTE'] == 2066 || $fila3['IDCLIENTE'] == 448) {
                $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '15'");
                $fila2 = sqlsrv_fetch_array($SQL);
                $HTMLBOL = utf8_encode($fila2['HTMLBOL']);
            } else {
                $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '2'");
                $fila2 = sqlsrv_fetch_array($SQL);
                $HTMLBOL = utf8_encode($fila2['HTMLBOL']);
            }

            if (($fila3['IDCLIENTE'] == 2066 || $fila3['IDCLIENTE'] == 448) && $SEND == 1 && $fila3['FIRMATEC'] == '') {
                trigger_error("Falta la firma del técnico", E_USER_ERROR);
            }

            $TBOLETA = $fila3['TBOLETA'];
            $LICIT = $fila3['LICIT'];
            $LICIT = utf8_encode($TBOLETA . $LICIT);
            $CLIENTE = utf8_encode($fila3['CLIENTE']);
            $BOLETA = $fila3['BOLETA'];
            $NUSUARIO = utf8_encode($fila3['NUSUARIO']);
            $UBIC = utf8_encode($fila3['UBIC']);
            $TECNICO = utf8_encode($fila3['TECNICO']);
            $HINICIO = $fila3['HINICIO'];
            $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            $HFIN = $fila3['HFIN'];
            $HFIN = $HFIN->format('d/m/Y H:i:s');
            $FECHAF = $fila3['FECHAF'];
            $FECHAF = $FECHAF->format('d/m/Y H:i:s');
            $MARCAE = $fila3['MARCAE'];
            $MODELOE = $fila3['MODELOE'];
            $NOMSEC = utf8_encode($fila3['NOMSEC']);
            if ($NOMSEC != '') {
                $NOMSEC = '<br>' . $NOMSEC;
            }
            $SERIEE = $fila3['SERIEE'];
            $TIPOE = utf8_encode($fila3['TIPOE']);
            $ACTIVOE = $fila3['ACTIVOE'];
            $PRODUE = $fila3['PRODUE'];
            $OBSERV = utf8_encode($fila3['OBSERV']);
            $OBSERV = str_replace('\n', '<br>', $OBSERV);
            $CEDULA = $fila3['CEDULA'];
            $FIRMAUSR = $fila3['FIRMAUSR'];
            $IMGCLIENTE = $fila3['IMGCLIENTE'];
            $IMGLOGO = $fila3['IMGLOGO'];
            $EDIFICIO = $fila3['EDIFICIO'];
            $TELEFONO = $fila3['TELEFONO'];
            $DEPART = utf8_encode($fila3['DEPART']);
            $IDCLIENTE = $fila3['IDCLIENTE'];
            $FIRMATEC = $fila3['FIRMATEC'];
            $FFIRMATEC = $fila3['FFIRMATEC'];
            if ($FIRMATEC != '' && $FIRMATEC != 'NULL') {
                $FFIRMATEC = $FFIRMATEC->format('d/m/Y H:i:s');
            }

            $HTMLBOL = str_replace('%NLICIT%', $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace('%Cliente%', $CLIENTE . $NOMSEC, $HTMLBOL);
            $HTMLBOL = str_replace('%LOGOCLIENTE%', $IMGCLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace('%LOGOORBE%', $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace('%NBoleta%', $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace('%NUsuario%', $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace('%ubica%', $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace('%Ntecnico%', $TECNICO, $HTMLBOL);
            $HTMLBOL = str_replace('%hfinicio%', $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace('%hffin%', $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace('%marcaE%', $MARCAE, $HTMLBOL);
            $HTMLBOL = str_replace('%modeloE%', $MODELOE, $HTMLBOL);
            $HTMLBOL = str_replace('%serieE%', $SERIEE, $HTMLBOL);
            $HTMLBOL = str_replace('%tipoE%', $TIPOE, $HTMLBOL);
            $HTMLBOL = str_replace('%activoE%', $ACTIVOE, $HTMLBOL);
            $HTMLBOL = str_replace('%prodE%', $PRODUE, $HTMLBOL);
            $HTMLBOL = str_replace('%OBSERV%', $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace('%Cedula%', $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace('%FIRMAUSR%', $FIRMAUSR, $HTMLBOL);
            $HTMLBOL = str_replace('%DEPART%', $DEPART, $HTMLBOL);
            $HTMLBOL = str_replace('%edificio%', $EDIFICIO, $HTMLBOL);
            $HTMLBOL = str_replace('%Telefono%', $TELEFONO, $HTMLBOL);
            $HTMLBOL = str_replace('%FFIRMA%', $FECHAF, $HTMLBOL);
            $HTMLBOL = str_replace('%FFIRMATEC%', $FFIRMATEC, $HTMLBOL);
            $HTMLBOL = str_replace('%FIRMATEC%', $FIRMATEC, $HTMLBOL);

            $DATOSACC = '';
            /*if($IDCLIENTE == 23 || $IDCLIENTE == 1826 || $IDCLIENTE == 797 || $IDCLIENTE == 4172 || $IDCLIENTE == 1279 || $IDCLIENTE == 2066 || $IDCLIENTE == 2160 || $IDCLIENTE == 1480 || $IDCLIENTE == 2783 || $IDCLIENTE == 3633 || $IDCLIENTE == 145 || $IDCLIENTE == 1045 || $IDCLIENTE == 214 || $IDCLIENTE == 2118 || $IDCLIENTE == 2078 || $IDCLIENTE == 2158 || $IDCLIENTE == 217 || $IDCLIENTE == 2075 || $IDCLIENTE == 816 || $IDCLIENTE == 2069 || $IDCLIENTE == 3202 || $IDCLIENTE == 884 || $IDCLIENTE == 1262 || $IDCLIENTE == 2149 || $IDCLIENTE == 2227 || $IDCLIENTE == 1583 || $IDCLIENTE == 2567 || $IDCLIENTE == 656 || $IDCLIENTE == 925 || $IDCLIENTE == 2089 || $IDCLIENTE == 1532 || $IDCLIENTE == 2568 || $IDCLIENTE == 1551){*/
            $SQL2 = sqlsrv_query($connARANDABD, "SELECT A.N_TIPOCI TIPO, A.N_MARCA MARCA, A.N_MODELO MODELO, A.SERIE N_SERIE, A.ACTIVO ,A.NPRODUCTO PRODUC
			FROM MNT_PREVENTIVO_AT_X_CI ACC
			INNER JOIN V_SONIC_CI A WITH(NOLOCK) ON A.ID_CI = ACC.ID_CI
			INNER JOIN PROJECT_CI B WITH(NOLOCK) ON B.ID_CI = A.ID_CI
			INNER JOIN PROJECTS_SONIC C WITH(NOLOCK) ON C.IDP = B.IDPROY
			WHERE ACC.IDAT = '$IDATEN' AND ACC.TIPO_REL = '2'");


            while ($fila4 = sqlsrv_fetch_array($SQL2)) {
                $TIPO = utf8_encode($fila4['TIPO']);
                $MARCA = $fila4['MARCA'];
                $MODELO = $fila4['MODELO'];
                $NSERIE = $fila4['N_SERIE'];
                $ACTIVO = $fila4['ACTIVO'];
                $PRODUC = $fila4['PRODUC'];

                $DATOSACC .= '<tr>
 <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="17" align="center" valign=top bgcolor="#A6A6A6"><i><font face="Calibri">Datos de ' . $TIPO . '</font></i></td>
</tr>
<tr>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=middle><font face="Calibri">Marca: ' . $MARCA . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="left" valign=middle><font face="Calibri">Modelo: ' . $MODELO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><font face="Calibri">Serie: ' . $NSERIE . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="left" valign=middle><font face="Calibri">Activo: ' . $ACTIVO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><font face="Calibri">#Producto: ' . $PRODUC . '</font></td>
</tr>';
            }

            $HTMLBOL = str_replace('%DATAACCESORIOS%', $DATOSACC, $HTMLBOL);




            if ($IDCLIENTE != 2067 && $IDCLIENTE != 2066 && $IDCLIENTE != 448) {
                $SQL3 = sqlsrv_query($connARANDABD, "SELECT A.IDCAMPO, CAMPOINT, CAMPOSTR, B.DESCCAMPO
    FROM DATOS_ADICIONALES A WITH(NOLOCK)
    INNER JOIN CAMPOS_ADICIONALES B WITH(NOLOCK) ON B.IDCAMPO = A.IDCAMPO
    WHERE ((A.IDCAMPO > 10 AND A.IDCAMPO < 39) OR A.IDCAMPO=77)
    AND (CAMPOINT = '1' OR (CAMPOINT IS NULL AND CAMPOSTR != ''))
    AND TREGISTRO = 2 AND IDREGISTRO = '$IDATEN'
    ORDER BY A.IDCAMPO");

                $DATAPROC = '';
                while ($fila5 = sqlsrv_fetch_array($SQL3)) {
                    $IDCAMPO = $fila5['IDCAMPO'];
                    $DESCCAMPO = utf8_encode($fila5['DESCCAMPO']);
                    $CAMPOSTR = utf8_encode($fila5['CAMPOSTR']);

                    if ($IDCAMPO == 37) {
                        $DATAPROC = str_replace('%SOFTACTESP%', $CAMPOSTR, $DATAPROC);
                    } else if ($IDCAMPO == 36) {
                        $DATAPROC .= '<tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17"  align="center" valign=middle><font face="Calibri"><b>X</b></font></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="left" valign=middle><font face="Calibri">' . $DESCCAMPO . ' Especifique: %SOFTACTESP%</font></td>
              </tr>';
                    } else {
                        $DATAPROC .= '<tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17"  align="center" valign=middle><font face="Calibri"><b>X</b></font></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="left" valign=middle><font face="Calibri">' . $DESCCAMPO . '</font></td>
              </tr>';
                    }
                }
            }


            if ($IDCLIENTE == 2067 || (int)$IDCLIENTE === 2066 || (int)$IDCLIENTE === 448) {

                $SQL5 = sqlsrv_query($connARANDABD, "SELECT A.IDCAMPO, CAMPOINT, CAMPOSTR, B.DESCCAMPO
                                        FROM DATOS_ADICIONALES A WITH(NOLOCK)
                                        INNER JOIN CAMPOS_ADICIONALES B WITH(NOLOCK) ON B.IDCAMPO = A.IDCAMPO
                                        WHERE (A.IDCAMPO > 505 AND A.IDCAMPO < 560)
                                        AND TREGISTRO = 2 AND IDREGISTRO = '$IDATEN'
                                        ORDER BY A.IDCAMPO");


                while ($fila6 = sqlsrv_fetch_array($SQL5)) {

                    $IDCAMPO = $fila6['IDCAMPO'];
                    $DESCCAMPO = utf8_encode($fila6['DESCCAMPO']);
                    $CAMPOINT = utf8_encode($fila6['CAMPOINT']);
                    $CAMPOSTR = utf8_encode($fila6['CAMPOSTR']);

                    if ($IDCAMPO == 36) {
                        $DATAPROC .= '<tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17"  align="center" valign=middle><font face="Calibri"><b>X</b></font></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="left" valign=middle><font face="Calibri">' . $DESCCAMPO . ' Especifique: %SOFTACTESP%</font></td>
              </tr>';
                    } elseif ($IDCAMPO < 554 && $IDCAMPO > 549) {
                        $DATAPROC .= '<tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17"  align="center" valign=middle><font face="Calibri"><b>' . $CAMPOINT . ' %</b></font></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="left" valign=middle><font face="Calibri">' . $DESCCAMPO . '</font></td>
        </tr>';
                    } elseif ($IDCAMPO < 558 && $IDCAMPO > 553) {
                        $DATAPROC .= '<tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17"  align="center" valign=middle><font face="Calibri"><b>' . $CAMPOINT . ' </b></font></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="left" valign=middle><font face="Calibri">' . $DESCCAMPO . '</font></td>
        </tr>';
                    } elseif ($IDCAMPO == 558) {
                        $DATAPROC .= '<tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17"  align="center" valign=middle><font face="Calibri"><b>' . $CAMPOINT . ' %</b></font></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="left" valign=middle><font face="Calibri">' . $DESCCAMPO . '</font></td>
        </tr>';
                    } elseif ($IDCAMPO == 559) {
                        $DATAPROC .= '<tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17"  align="center" valign=middle><font face="Calibri"><b>' . $CAMPOSTR . ' </b></font></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="left" valign=middle><font face="Calibri">' . $DESCCAMPO . '</font></td>
        </tr>';
                    } else {
                        $Si_No = "No";
                        if ($CAMPOINT == 1) {
                            $Si_No = "Si";
                        }
                        $DATAPROC .= '<tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17"  align="center" valign=middle><font face="Calibri"><b>' . $Si_No . '</b></font></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="left" valign=middle><font face="Calibri">' . $DESCCAMPO . '</font></td>
              </tr>';
                    }
                }
            }


            $HTMLBOL = str_replace('%DATAPROCEDIMIENTOS%', $DATAPROC, $HTMLBOL);


            $SQL_BOLETAS = sqlsrv_query($connARANDABD, "EXEC SP_INFODATA_ATENSUP $IDATEN");
            if ($SQL_BOLETAS && $DATA = sqlsrv_fetch_array($SQL_BOLETAS)) {
                $USUARIOVISOR = $DATA['USUARIOVISOR'];
                $Piso = $DATA['Piso'];
            }

            $HTMLBOL = str_replace('%VUsuario%', $USUARIOVISOR, $HTMLBOL);
            $HTMLBOL = str_replace('%Piso%', $Piso, $HTMLBOL);


            $fh = fopen("D:/SpeedyFiles/Boletas/MNT/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {
                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/MNT/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'MNT');
                //SE ENVIA UNA ENCUESTA, CUANDO SE CIERRA EL CASO PADRE
                sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                $IDUSR = $_SESSION['IDU'];
                sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
            }

?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/MNT/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php

        } else if ($IDSERV == 1 && $TIPOATENCION == 3) {


            $SQL = sqlsrv_query($connARANDABD, "EXEC SP_INFOBOLETA_ATEN $IDATEN , 3");
            $fila3 = sqlsrv_fetch_array($SQL);
            $IDCLIENTE = $fila3['IDCLIENTE'];

            if ($IDCLIENTE != 448) {
                $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WITH(NOLOCK) WHERE IDBOL = '1'");
                $fila2 = sqlsrv_fetch_array($SQL);
            } else {
                $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WITH(NOLOCK) WHERE IDBOL = '14'");
                $fila2 = sqlsrv_fetch_array($SQL);
            }
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);

            $TIPOBOL = $fila3['TIPOBOL'];
            $LICIT = $fila3['LICIT'];
            $LICIT = utf8_encode($TIPOBOL . $LICIT);
            $CLIENTE = utf8_encode($fila3['CLIENTE']);
            $IDCLIENTE = $fila3['IDCLIENTE'];
            $BOLETA = $fila3['BOLETA'];
            $NUSUARIO = utf8_encode($fila3['NUSUARIO']);
            $UBIC = utf8_encode($fila3['UBIC']);
            $TECNICO = utf8_encode($fila3['TECNICO']);
            $HINICIO = $fila3['HINICIO'];
            $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            $HFIN = $fila3['HFIN'];
            $HFIN = $HFIN->format('d/m/Y H:i:s');
            $OBSERV = utf8_encode($fila3['OBSERV']);
            $OBSERV = str_replace('\n', '<br>', $OBSERV);
            $CORREOUSR = $fila3['CORREOUSR'];
            $CEDULA = $fila3['CEDULA'];
            $FIRMAUSR = $fila3['FIRMAUSR'];
            $IMGCLIENTE = $fila3['IMGCLIENTE'];
            $IMGLOGO = $fila3['IMGLOGO'];
            $FECHAFIRM = $fila3['FECHAFIRM'];
            $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');
            $DEPART = utf8_encode($fila3['DEPART']);

            if ($IDCLIENTE == 448) {

                $IMGFIRMAIMP = $fila3['IMGFIRMAIMP'];
                $FECHAFIRMAIMP = $fila3['FECHAFIRMAIMP'];
                $FECHAFIRMAIMP = $FECHAFIRMAIMP->format('d/m/Y H:i:s');
                $CEDULAIMP = $fila3['CEDULAIMP'];
                $DIROFFIBCR = utf8_encode($fila3['DIROFFIBCR']);
                $UEBCR = utf8_encode($fila3['UEBCR']);
                $PERFEQ = $fila3['PERFEQ'];
                $UB = $fila3['UB'];
            }

            $HTMLBOL = str_replace('%NLICIT%', $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace('%CLIENTE%', $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace('%IMGCLIENTE%', $IMGCLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace('%IMGORBE%', $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace('%NBOLETA%', $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace('%NOMUSR%', $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace('%NOMUSRAUT%', $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace('%UBIC%', $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace('%TECNICO%', $TECNICO, $HTMLBOL);
            $HTMLBOL = str_replace('%FHINICIO%', $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace('%FHFINAL%', $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace('%OBSERV%', $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace('%CEDULA%', $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace('%CORREOUSR%', $CORREOUSR, $HTMLBOL);
            $HTMLBOL = str_replace('%IMGFIRMA%', $FIRMAUSR, $HTMLBOL);
            $HTMLBOL = str_replace('%FECHAFIRMA%', $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace('%DEPART%', $DEPART, $HTMLBOL);

            if ($IDCLIENTE == 448) {

                $HTMLBOL = str_replace('%CEDULAIMP%', $CEDULAIMP, $HTMLBOL);
                $HTMLBOL = str_replace('%IMGFIRMAIMP%', $IMGFIRMAIMP, $HTMLBOL);
                $HTMLBOL = str_replace('%FECHAFIRMAIMP%', $FECHAFIRMAIMP, $HTMLBOL);
                $HTMLBOL = str_replace('%OFICINA%', $DEPART, $HTMLBOL);
                $HTMLBOL = str_replace('%DIROFI%', $DIROFFIBCR, $HTMLBOL);
                $HTMLBOL = str_replace('%UE%', $UEBCR, $HTMLBOL);
                $HTMLBOL = str_replace('%PERFEQ%', $PERFEQ, $HTMLBOL);
                $HTMLBOL = str_replace('%UB%', $UB, $HTMLBOL);
            }

            $HTMLBOL = str_replace('<colgroup width="115"></colgroup> <colgroup width="83"></colgroup> <colgroup span="2" width="49"></colgroup> <colgroup width="88"></colgroup> <colgroup width="70"></colgroup> <colgroup width="17"></colgroup> <colgroup width="9"></colgroup> <colgroup width="68"></colgroup> <colgroup width="123"></colgroup> <colgroup width="12"></colgroup> <colgroup width="74"></colgroup> <colgroup width="59"></colgroup> <colgroup width="99"></colgroup> <colgroup width="84"></colgroup>', '', $HTMLBOL);

            $EQUIPOENTRE = '';

            $SQL2 = sqlsrv_query($connARANDABD, "EXEC SP_CONS_AT_X_CI_INSTALACION 1,2,$IDCLIENTE,$IDATEN");

            while ($fila4 = sqlsrv_fetch_array($SQL2)) {
                $IDU = $fila4['ID_CI'];
                $TIPO = utf8_encode($fila4['N_TIPOCI']);
                $MARCA = $fila4['N_MARCA'];
                $NOMBRE = $fila4['NPRODUCTO'];
                $MODELO = $fila4['N_MODELO'];
                $ACTIVO = $fila4['ACTIVO'];
                $ACTIVOCLIENT = $fila4['ACTIVOCLIENT'];
                $IDUNICO = $fila4['IDUNICO'];

                $SERIE = $fila4['SERIE'];
                $NEQUIPO = $fila4['NombreEq'];
                $MAC = $fila4['MAC'];
                $NIC = $fila4['NIC'];
                $RESPO = $fila4['RESPO'];
                $IP = $fila4['IP'];
                $RESPD = $fila4['RESPD'];
                $ESTADO = $fila4['VB'];
                if ($ESTADO == 1) {
                    $ESTADO = 'SI';
                } else {
                    $ESTADO = 'NO';
                }
                $RESPD_C = $fila4['RESPD_C'];
                $RESPD_D = $fila4['RESPD_D'];

                if ($IDCLIENTE != 448) {

                    $EQUIPOENTRE .= '
            <tr>
                <td style="border-top: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Se realiza la entrega del siguiente equipo</font></i></b></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Tipo de Equipo: ' . $TIPO . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Marca:' . $MARCA . ' </font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Modelo:' . $MODELO . '</font></b></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Producto: ' . $NOMBRE . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Activo del Equipo: ' . $ACTIVO . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Serie del Equipo: ' . $SERIE . '</font></b></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Nombre del equipo:  ' . $NEQUIPO . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Mac:  ' . $MAC . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Dirección IP: ' . $IP . '</font></b></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Activo Cliente: ' . $ACTIVOCLIENT . '</font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">ID Unico: ' . $IDUNICO . '</font></b></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Tamaño del respaldo origen: ' . $RESPO . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">Tamaño del respaldo destino: ' . $RESPD . '</font></b></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" height="29" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Calibri">Usuario verifica que el equipo no tenga ningun tipo de daño fisico: ' . $ESTADO . '</font></b></td>
            </tr>
           <tr>
                <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="14" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Accesorios</font></i></b></td>
</tr>
			%ACCENTREGADO%';
                } else {

                    $EQUIPOENTRE .= '
                  <tr>
                      <td style="border-top: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Se realiza la entrega del siguiente equipo</font></i></b></td>
                  </tr>
                  <tr>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Tipo de Equipo: ' . $TIPO . '</font></b></td>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Marca:' . $MARCA . ' </font></b></td>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Modelo:' . $MODELO . '</font></b></td>
                  </tr>
                  <tr>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Producto: ' . $NOMBRE . '</font></b></td>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Activo del Equipo: ' . $ACTIVO . '</font></b></td>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Serie del Equipo: ' . $SERIE . '</font></b></td>
                  </tr>
                  <tr>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Nombre del equipo:  ' . $NEQUIPO . '</font></b></td>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="29" align="left" valign="middle"><b><font face="Calibri">Mac:  ' . $MAC . '</font></b></td>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="29" align="left" valign="middle"><b><font face="Calibri">NIC:  ' . $NIC . '</font></b></td>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Dirección IP: ' . $IP . '</font></b></td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Activo Cliente: ' . $ACTIVOCLIENT . '</font></b></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">ID Unico: ' . $IDUNICO . '</font></b></td>
                  </tr>
                  <tr>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Tamaño del respaldo destino C : ' . $RESPD_C . '</font></b></td>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">Tamaño del respaldo destino D : ' . $RESPD_D . '</font></b></td>
                  </tr>
                  <tr>
                      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" height="29" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Calibri">Usuario verifica que el equipo no tenga ningun tipo de daño fisico: ' . $ESTADO . '</font></b></td>
                  </tr>
                 <tr>
                      <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="14" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Accesorios</font></i></b></td>
      </tr>
      			%ACCENTREGADO%';
                }

                $ACCENTREGADO = '';

                $SQL2_1 = sqlsrv_query($connARANDABD, "
SELECT  
    B.ID_CI, 
    F.N_TIPOCI AS TIPO,
    B.SERIE AS N_SERIE, 
    D.N_MODELO AS MODELO, 
    E.N_MARCA AS MARCA, 
    B.ACTIVO, 
    B.NPRODUCTO AS PRODUC, 
    B2.SERIE AS SERIEP,

    SA.CAMPOSTR AS ACTIVOCLIENT,
    SB.CAMPOSTR AS IDUNICO,

    CASE 
        WHEN G.TIPO_REL = 3 THEN 'RETIRO'
        WHEN G.TIPO_REL = 4 THEN 'INSTALACION'
    END AS Tipo2,

    SCI.ID_CI_P,
    G.TIPO_REL

FROM PROJECTS_SONIC PS WITH(NOLOCK)
INNER JOIN PROJECT_CI A WITH(NOLOCK) ON A.IDPROY = PS.IDP
INNER JOIN SONIC_CI B WITH(NOLOCK) ON B.ID_CI = A.ID_CI
INNER JOIN SONIC_MODELO D WITH(NOLOCK) ON D.ID_MODELO = B.ID_MODELO
INNER JOIN SONIC_MARCA E WITH(NOLOCK) ON E.ID_MARCA = B.ID_MARCA
INNER JOIN SONIC_TIPOCI F WITH(NOLOCK) ON F.ID_TIPOCI = B.ID_TIPOCI
INNER JOIN INSTALACIONES_AT_X_CI G WITH(NOLOCK) ON G.TIPO_REL IN (4) AND G.ID_CI = B.ID_CI
INNER JOIN SONIC_REL_CI SCI WITH(NOLOCK) ON SCI.ID_CI_S = B.ID_CI
INNER JOIN SONIC_CI B2 WITH(NOLOCK) ON B2.ID_CI = SCI.ID_CI_P

LEFT JOIN DATOS_ADICIONALES SA WITH(NOLOCK) 
    ON SA.TREGISTRO = 12 
    AND SA.IDREGISTRO = B.ID_CI 
    AND SA.IDCAMPO = 503   -- ACTIVOCLIENT

LEFT JOIN DATOS_ADICIONALES SB WITH(NOLOCK) 
    ON SB.TREGISTRO = 12 
    AND SB.IDREGISTRO = B.ID_CI 
    AND SB.IDCAMPO = 504   -- IDUNICO

WHERE G.IDAT = $IDATEN
ORDER BY B.ID_CI
");



                while ($fila4_1 = sqlsrv_fetch_array($SQL2_1)) {
                    $TIPO = $fila4_1['TIPO'];
                    $MARCA = $fila4_1['MARCA'];
                    $MODELO = $fila4_1['MODELO'];
                    $NSERIE = $fila4_1['N_SERIE'];
                    $ACTIVO = $fila4_1['ACTIVO'];
                    $ACTIVOCLIENT = $fila4_1['ACTIVOCLIENT'];
                    $IDUNICO = $fila4_1['IDUNICO'];
                    $PRODUC = $fila4_1['PRODUC'];

                    $ACCENTREGADO .= '<tr>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" height="21" align="left" valign="middle"><font face="Calibri">Tipo: ' . $TIPO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="21" align="left" valign="middle"><font face="Calibri">Marca: ' . $MARCA . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><font face="Calibri">Modelo: ' . $MODELO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Serie: ' . $NSERIE . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Activo: ' . $ACTIVO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Activo Cliente: ' . $ACTIVOCLIENT . '</font></td>
</tr>
<tr>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">ID Unico: ' . $IDUNICO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">#Producto: ' . $PRODUC . '</font></td>
</tr>';
                }

                $EQUIPOENTRE = str_replace('%ACCENTREGADO%', $ACCENTREGADO, $EQUIPOENTRE);
            }
            $HTMLBOL = str_replace('%EQUIPOENTREGADO%', $EQUIPOENTRE, $HTMLBOL);


            $EQUIPORETI = '';

            $SQL3 = sqlsrv_query($connARANDABD, "EXEC SP_CONS_AT_X_CI_INSTALACION 1,1,$IDCLIENTE,$IDATEN");

            while ($fila5 = sqlsrv_fetch_array($SQL3)) {
                $IDU = $fila5['ID_CI'];
                $TIPO = utf8_encode($fila5['N_TIPOCI']);
                $MARCA = $fila5['N_MARCA'];
                $NOMBRE = $fila5['NPRODUCTO'];
                $MODELO = $fila5['N_MODELO'];
                $ACTIVO = $fila5['ACTIVO'];
                $ACTIVOCLIENT = $fila5['ACTIVOCLIENT'];
                $IDUNICO = $fila5['IDUNICO'];
                $SERIE = $fila5['SERIE'];
                $NEQUIPO = $fila5['NombreEq'];
                $MAC = $fila5['MAC'];
                $NIC = $fila5['NIC'];
                $RESPO = $fila5['RESPO'];
                $IP = $fila5['IP'];
                $RESPD = $fila5['RESPD'];
                $ESTADO = $fila5['VB'];
                if ($ESTADO == 1) {
                    $ESTADO = 'SI';
                } else {
                    $ESTADO = 'NO';
                }
                $RESPO_C = $fila5['RESPO_C'];
                $RESPO_D = $fila5['RESPO_D'];

                if ($IDCLIENTE != 448) {
                    $EQUIPORETI .= '<tr>
    <td style="border-top: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Se realiza el retiro del siguiente equipo</font></i></b></td>
</tr>
<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Tipo de Equipo: ' . $TIPO . '</font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Marca:' . $MARCA . ' </font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Modelo:' . $MODELO . '</font></b></td>
</tr>
<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Producto: ' . $NOMBRE . '</font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Activo del Equipo: ' . $ACTIVO . '</font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Serie del Equipo: ' . $SERIE . '</font></b></td>
</tr>
<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Nombre del equipo:  ' . $NEQUIPO . '</font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Mac:  ' . $MAC . '</font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Dirección IP: ' . $IP . '</font></b></td>
</tr>
<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Activo Cliente: ' . $ACTIVOCLIENT . '</font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">ID Unico: ' . $IDUNICO . '</font></b></td>
</tr>
<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Tamaño del respaldo origen: ' . $RESPO . '</font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">Tamaño del respaldo destino: ' . $RESPD . '</font></b></td>
</tr>
<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" height="29" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Calibri">Usuario verifica que el equipo no tenga ningun tipo de daño fisico: ' . $ESTADO . '</font></b></td>
</tr>
<tr>
    <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Accesorios</font></i></b></td>
</tr>
			%ACCRETIRADO%';
                } else {
                    $EQUIPORETI .= '<tr>
          <td style="border-top: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Se realiza el retiro del siguiente equipo</font></i></b></td>
      </tr>
      <tr>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Tipo de Equipo: ' . $TIPO . '</font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Marca:' . $MARCA . ' </font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Modelo:' . $MODELO . '</font></b></td>
      </tr>
      <tr>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Producto: ' . $NOMBRE . '</font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Activo del Equipo: ' . $ACTIVO . '</font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Serie del Equipo: ' . $SERIE . '</font></b></td>
      </tr>
      <tr>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Nombre del equipo:  ' . $NEQUIPO . '</font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="29" align="left" valign="middle"><b><font face="Calibri">Mac:  ' . $MAC . '</font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="29" align="left" valign="middle"><b><font face="Calibri">NIC:  ' . $NIC . '</font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Dirección IP: ' . $IP . '</font></b></td>
      </tr>
      <tr>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Activo Cliente: ' . $ACTIVOCLIENT . '</font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">ID Unico: ' . $IDUNICO . '</font></b></td>
      </tr>
      <tr>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Tamaño del respaldo origen C : ' . $RESPO_C . '</font></b></td>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">Tamaño del respaldo origen D : ' . $RESPO_D . '</font></b></td>
      </tr>
      <tr>
          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" height="29" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Calibri">Usuario verifica que el equipo no tenga ningun tipo de daño fisico: ' . $ESTADO . '</font></b></td>
      </tr>
      <tr>
          <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Accesorios</font></i></b></td>
      </tr>
      			%ACCRETIRADO%';
                }

                $ACCRETIRADO = '';

                $SQL3_1 = sqlsrv_query($connARANDABD, "
SELECT  
    B.ID_CI, 
    F.N_TIPOCI AS TIPO,
    B.SERIE AS N_SERIE, 
    D.N_MODELO AS MODELO, 
    E.N_MARCA AS MARCA, 
    B.ACTIVO, 
    B.NPRODUCTO AS PRODUC, 
    B2.SERIE AS SERIEP,

    SA.CAMPOSTR AS ACTIVOCLIENT,
    SB.CAMPOSTR AS IDUNICO,

    CASE 
        WHEN G.TIPO_REL = 3 THEN 'RETIRO'
        WHEN G.TIPO_REL = 4 THEN 'INSTALACION'
    END AS Tipo2,

    SCI.ID_CI_P,
    G.TIPO_REL

FROM PROJECTS_SONIC PS WITH(NOLOCK)
INNER JOIN PROJECT_CI A WITH(NOLOCK) ON A.IDPROY = PS.IDP
INNER JOIN SONIC_CI B WITH(NOLOCK) ON B.ID_CI = A.ID_CI
INNER JOIN AFW_STATUS C WITH(NOLOCK) ON C.stat_id = B.ID_ESTADO
INNER JOIN SONIC_MODELO D WITH(NOLOCK) ON D.ID_MODELO = B.ID_MODELO
INNER JOIN SONIC_MARCA E WITH(NOLOCK) ON E.ID_MARCA = B.ID_MARCA
INNER JOIN SONIC_TIPOCI F WITH(NOLOCK) ON F.ID_TIPOCI = B.ID_TIPOCI
INNER JOIN INSTALACIONES_AT_X_CI G WITH(NOLOCK) ON G.TIPO_REL IN (3) AND G.ID_CI = B.ID_CI
INNER JOIN SONIC_REL_CI SCI WITH(NOLOCK) ON SCI.ID_CI_S = B.ID_CI
INNER JOIN SONIC_CI B2 WITH(NOLOCK) ON B2.ID_CI = SCI.ID_CI_P

LEFT JOIN DATOS_ADICIONALES SA WITH(NOLOCK)
    ON SA.TREGISTRO = 12 
   AND SA.IDREGISTRO = B.ID_CI 
   AND SA.IDCAMPO = 503   -- ACTIVOCLIENT

LEFT JOIN DATOS_ADICIONALES SB WITH(NOLOCK)
    ON SB.TREGISTRO = 12 
   AND SB.IDREGISTRO = B.ID_CI 
   AND SB.IDCAMPO = 504   -- IDUNICO

WHERE 
    G.IDAT = $IDATEN 
    AND SCI.ID_CI_P = $IDU
ORDER BY B.ID_CI
");



                while ($fila5_1 = sqlsrv_fetch_array($SQL3_1)) {
                    $TIPO = $fila5_1['TIPO'];
                    $MARCA = $fila5_1['MARCA'];
                    $MODELO = $fila5_1['MODELO'];
                    $NSERIE = $fila5_1['N_SERIE'];
                    $ACTIVO = $fila5_1['ACTIVO'];
                    $ACTIVOCLIENT = $fila5_1['ACTIVOCLIENT'];
                    $IDUNICO = $fila5_1['IDUNICO'];
                    $PRODUC = $fila5_1['PRODUC'];

                    $ACCRETIRADO .= '<tr>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" height="21" align="left" valign="middle"><font face="Calibri">Tipo: ' . $TIPO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="21" align="left" valign="middle"><font face="Calibri">Marca: ' . $MARCA . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><font face="Calibri">Modelo: ' . $MODELO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Serie: ' . $NSERIE . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Activo: ' . $ACTIVO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Activo Cliente: ' . $ACTIVOCLIENT . '</font></td>
  </tr>
<tr>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">ID UNICO: ' . $IDUNICO . '</font></td>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">#Producto: ' . $PRODUC . '</font></td>
</tr>';
                }

                $EQUIPORETI = str_replace('%ACCRETIRADO%', $ACCRETIRADO, $EQUIPORETI);
            }

            $SQLLEYENDA = sqlsrv_query(
                $connARANDABD,
                "SELECT CAMPOSTR 
   FROM DATOS_ADICIONALES 
   WHERE IDREGISTRO = $IDATEN 
     AND IDCAMPO = 505"
            );

            $LEYENDA = '';

            if ($SQLLEYENDA && $rowLeyenda = sqlsrv_fetch_array($SQLLEYENDA, SQLSRV_FETCH_ASSOC)) {
                $LEYENDA = $rowLeyenda['CAMPOSTR'];
            }


            if ($IDCLIENTE == 448) {

                $LEYENDA = trim((string)$LEYENDA);
                $LEYENDA = sanearUtf8($LEYENDA);
                $HTMLBOL = str_replace('%LEYENDA%', "$LEYENDA", $HTMLBOL);
            } else {

                if (!empty($LEYENDA)) {
                    $EQUIPORETI .= '
    <tr>
      <td style="
        border: 2px solid #000000;
        padding-top: 6px;
        padding-bottom: 6px;
        border-left: 2px solid #000000;
        border-right: 2px solid #000000;
      " colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6">
        <b><i><font face="Calibri">LEYENDA</font></i></b>
      </td>
    </tr>

    <tr>
      <td style="
        border-top: 1px solid #000; 
        border-bottom: 1px solid #000; 
        border-left: 2px solid #000; 
        border-right: 2px solid #000;
        word-wrap: break-word;
        white-space: normal;
      " colspan="14" height="21" align="left" valign="top">
        <b><font face="Calibri">' . $LEYENDA . '</font></b>
      </td>
    </tr>
      ';
                }
            }


            $HTMLBOL = str_replace('%EQUIPORETIRADO%', $EQUIPORETI, $HTMLBOL);


            if ($IDCLIENTE == 448) {

                $PERFRESPAL = '';

                $SQL4 = sqlsrv_query($connARANDABD, "SELECT NOMBRE,CEDULA,TAMESCRITORIO,CORREOAD,UBICACION FROM SPEEDY_PERFXRESP_BCR WITH(NOLOCK) WHERE IDAT=$IDATEN");

                while ($fila4 = sqlsrv_fetch_array($SQL4)) {
                    $NOMBRE = utf8_encode($fila4['NOMBRE']);
                    $CEDULA = utf8_encode($fila4['CEDULA']);
                    $TAMESCRITORIO = utf8_encode($fila4['TAMESCRITORIO']);
                    $CORREOAD = utf8_encode($fila4['CORREOAD']);
                    $UBICACION = utf8_encode($fila4['UBICACION']);

                    $PERFRESPAL .= '<tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" height="29" valign="middle"><b><font face="Calibri">' . $NOMBRE . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri">' . $CEDULA . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri" color="#000000">' . $TAMESCRITORIO . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri" color="#000000">' . $CORREOAD . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri" color="#000000">' . sanearUtf8($UBICACION) . '</font></b></td>
            </tr>';
                }

                if ($PERFRESPAL != '') {
                    $PERFRESPAL = '<tr>
              <td style="border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000;" colspan="10" height="20" align="center" valign="top" bgcolor="#A6A6A6">
                <b>
                  <i><font face="Calibri">Perfiles x respaldar</font></i>
                </b>
              </td>
            </tr>
            <tr>
                <td bgcolor="#A6A6A6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" height="29" valign="middle"><b><font face="Calibri">Nombre</font></b></td>
                <td bgcolor="#A6A6A6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri">Cédula</font></b></td>
                <td bgcolor="#A6A6A6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri" color="#000000">Escritorio Tamaño</font></b></td>
                <td bgcolor="#A6A6A6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri" color="#000000">Correo (Archivos de Datos):</font></b></td>
                <td bgcolor="#A6A6A6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri" color="#000000">Ubicación</font></b></td>
            </tr>' . $PERFRESPAL;
                }

                $HTMLBOL = str_replace('%PERFRESPAL%', $PERFRESPAL, $HTMLBOL);



                $IMPRESORAS = '';

                $SQL5 = sqlsrv_query($connARANDABD, "SELECT PREDETERMINADA,DESCRIPCION,IP_PUERTO FROM SPEEDY_IMPRESORAS_BCR WHERE IDAT=$IDATEN");

                while ($fila5 = sqlsrv_fetch_array($SQL5)) {
                    $PREDETERMINADA = utf8_encode($fila5['PREDETERMINADA']);
                    $DESCRIPCION = utf8_encode($fila5['DESCRIPCION']);
                    $IP_PUERTO = utf8_encode($fila5['IP_PUERTO']);

                    $IMPRESORAS .= '<tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" height="29" valign="middle"><b><font face="Calibri">' . $PREDETERMINADA . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri">' . $DESCRIPCION . '</font></b></td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri" color="#000000">' . $IP_PUERTO . '</font></b></td>
            </tr>';
                }

                if ($IMPRESORAS != '') {
                    $IMPRESORAS = '<tr>
              <td style="border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000;" colspan="10" height="20" align="center" valign="top" bgcolor="#A6A6A6">
                <b>
                  <i><font face="Calibri">Impresoras</font></i>
                </b>
              </td>
            </tr>
            <tr>
                <td bgcolor="#A6A6A6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" height="29" valign="middle"><b><font face="Calibri">Predeterminada</font></b></td>
                <td bgcolor="#A6A6A6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri">Descripción</font></b></td>
                <td bgcolor="#A6A6A6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><b><font face="Calibri" color="#000000">IP / Puerto</font></b></td>
            </tr>' . $IMPRESORAS;
                }
                $HTMLBOL = str_replace('%IMPRESORAS%', $IMPRESORAS, $HTMLBOL);
            }




            $fh = fopen("D:/SpeedyFiles/Boletas/INS/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {
                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/INS/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'INS');


                sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                $IDUSR = $_SESSION['IDU'];
                sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
            }





            echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/INS/$IDATEN - $BOLETA.html";

        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/INS/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                        if ($RESP == 'Correo Enviado') {
                            $sqle = sqlsrv_query($connARANDABD, "SELECT ID_CI,TIPO_REL FROM INSTALACIONES_AT_X_CI WHERE IDAT='$IDATEN'--1 y 3 Retiro:260 2 y 4 Instalacion:255");
                            while ($EINS = sqlsrv_fetch_array($sqle)) {
                                $TIPO_REL = $EINS['TIPO_REL'];
                                $ID_CI_INS = $EINS['ID_CI'];
                                if ($TIPO_REL == 1 || $TIPO_REL == 3) {
                                    sqlsrv_query($connARANDABD, "UPDATE SONIC_CI SET ID_ESTADO='260' WHERE ID_CI='$ID_CI_INS'--RETIRO");
                                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$ID_CI_INS','12','173','260','$IDU'");
                                } else if ($TIPO_REL == 2 || $TIPO_REL == 4) {
                                    sqlsrv_query($connARANDABD, "UPDATE SONIC_CI SET ID_ESTADO='255' WHERE ID_CI='$ID_CI_INS'--INSTALACION");
                                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$ID_CI_INS','12','173','255','$IDU'");
                                }
                            }
                        } //ESTADOS FINALES CI

                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php

        } else if ($IDSERV == 1 && $TIPOATENCION == 16) {

            $SQL = sqlsrv_query($connARANDABD, "SELECT C.CAMPOSTR LICIT, VEN.COMPANY CLIENTE, B.CAMPOSTR BOLETA, D.CAMPOSTR NUSUARIO, E.CAMPOSTR UBIC,
    TEC.UNAME TECNICO, F.CAMPODATE HINICIO, G.CAMPODATE HFIN, I.CAMPOSTR OBSERV, H.CAMPOSTR CEDULA, FIRM.SRCFIRMA FIRMAUSR,
     IMG.IMGCLIENTE,LCLI.IMGCLIENTE IMGLOGO, FIRM.FECHA FECHAFIRM, P.CAMPOSTR DEPART, T.CAMPOSTR TIPOBOL,A.IDCLIENTE
    FROM ATENCIONES A WITH(NOLOCK)
    INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
    INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
    INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
    INNER JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.TREGISTRO = '2' AND E.IDREGISTRO = A.IDATENCION AND E.IDCAMPO = 3   --Ubicacion
    INNER JOIN DATOS_ADICIONALES F WITH(NOLOCK) ON F.TREGISTRO = '2' AND F.IDREGISTRO = A.IDATENCION AND F.IDCAMPO = 4  --HINICIO
    INNER JOIN DATOS_ADICIONALES G WITH(NOLOCK) ON G.TREGISTRO = '2' AND G.IDREGISTRO = A.IDATENCION AND G.IDCAMPO = 5  --HFIN
    INNER JOIN DATOS_ADICIONALES H WITH(NOLOCK) ON H.TREGISTRO = '2' AND H.IDREGISTRO = A.IDATENCION AND H.IDCAMPO = 40  --Cedula
    INNER JOIN DATOS_ADICIONALES I WITH(NOLOCK) ON I.TREGISTRO = '2' AND I.IDREGISTRO = A.IDATENCION AND I.IDCAMPO = 42  --Observaciones
    INNER JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
    INNER JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
    INNER JOIN USUARIOS TEC WITH(NOLOCK) ON TEC.CODUSUARIO = CASO.IDTECNICO -- Tecnico
    INNER JOIN FIRMAS FIRM WITH(NOLOCK) ON FIRM.IDATEN = A.IDATENCION -- FIRMA
    LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
    INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
    INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
    INNER JOIN DATOS_ADICIONALES P WITH(NOLOCK) ON P.TREGISTRO = '2' AND P.IDREGISTRO = A.IDATENCION AND P.IDCAMPO = 54  --Departamento
    LEFT JOIN DATOS_ADICIONALES T WITH(NOLOCK) ON T.TREGISTRO = '2' AND T.IDREGISTRO = A.IDATENCION AND T.IDCAMPO = 68  --Tipo de Boleta
    WHERE A.IDATENCION = '$IDATEN'");

            $fila3 = sqlsrv_fetch_array($SQL);
            $TIPOBOL = $fila3['TIPOBOL'];
            $LICIT = $fila3['LICIT'];
            $LICIT = utf8_encode($TIPOBOL . $LICIT);
            $CLIENTE = utf8_encode($fila3['CLIENTE']);
            $IDCLIENTE = $fila3['IDCLIENTE'];
            $BOLETA = $fila3['BOLETA'];
            $NUSUARIO = utf8_encode($fila3['NUSUARIO']);
            $UBIC = utf8_encode($fila3['UBIC']);
            $TECNICO = utf8_encode($fila3['TECNICO']);
            $HINICIO = $fila3['HINICIO'];
            $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            $HFIN = $fila3['HFIN'];
            $HFIN = $HFIN->format('d/m/Y H:i:s');
            $OBSERV = utf8_encode($fila3['OBSERV']);
            $OBSERV = str_replace('\n', '<br>', $OBSERV);
            $CEDULA = $fila3['CEDULA'];
            $FIRMAUSR = $fila3['FIRMAUSR'];
            $IMGCLIENTE = $fila3['IMGCLIENTE'];
            $IMGLOGO = $fila3['IMGLOGO'];
            $FECHAFIRM = $fila3['FECHAFIRM'];
            $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');
            $DEPART = utf8_encode($fila3['DEPART']);

            /*if($IDCLIENTE != 1807){
    $SQL = sqlsrv_query($connARANDABD,"SELECT HTMLBOL FROM BOLETASHTML WITH(NOLOCK) WHERE IDBOL = '1'");
}else{
    $SQL = sqlsrv_query($connARANDABD,"SELECT HTMLBOL FROM BOLETASHTML WITH(NOLOCK) WHERE IDBOL = '13'");
}*/

            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WITH(NOLOCK) WHERE IDBOL = '1'");
            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);

            $HTMLBOL = str_replace('%NLICIT%', $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace('%CLIENTE%', $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace('%IMGCLIENTE%', $IMGCLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace('%IMGORBE%', $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace('%NBOLETA%', $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace('%NOMUSR%', $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace('%NOMUSRAUT%', $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace('%UBIC%', $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace('%TECNICO%', $TECNICO, $HTMLBOL);
            $HTMLBOL = str_replace('%FHINICIO%', $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace('%FHFINAL%', $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace('%OBSERV%', $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace('%CEDULA%', $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace('%IMGFIRMA%', $FIRMAUSR, $HTMLBOL);
            $HTMLBOL = str_replace('%FECHAFIRMA%', $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace('%DEPART%', $DEPART, $HTMLBOL);
            $HTMLBOL = str_replace('<colgroup width="115"></colgroup> <colgroup width="83"></colgroup> <colgroup span="2" width="49"></colgroup> <colgroup width="88"></colgroup> <colgroup width="70"></colgroup> <colgroup width="17"></colgroup> <colgroup width="9"></colgroup> <colgroup width="68"></colgroup> <colgroup width="123"></colgroup> <colgroup width="12"></colgroup> <colgroup width="74"></colgroup> <colgroup width="59"></colgroup> <colgroup width="99"></colgroup> <colgroup width="84"></colgroup>', '', $HTMLBOL);

            $EQUIPOENTRE = '';

            $SQL2 = sqlsrv_query($connARANDABD, "SELECT B.ID_CI IDU, F.N_TIPOCI TIPO,
       B.SERIE, D.N_MODELO MODELO, E.N_MARCA MARCA, B.ACTIVO ACTIVO, B.NPRODUCTO NOMBRE,dbo.Get_AddValueSTR('12',B.ID_CI,240) SO,dbo.Get_AddValueSTR('12',B.ID_CI,219) IP
  	 ,dbo.Get_AddValueSTR('12',B.ID_CI,220) RESPO,dbo.Get_AddValueSTR('12',B.ID_CI,221) RESPD,dbo.Get_AddValueSTR('12',B.ID_CI,45) NEQUIPO,dbo.Get_AddValueINT('12',B.ID_CI,222) ESTADO
      FROM PROJECTS_SONIC PS WITH(NOLOCK)
  	INNER JOIN PROJECT_CI A WITH(NOLOCK) ON A.IDPROY=PS.IDP
      INNER JOIN SONIC_CI B WITH(NOLOCK) ON B.ID_CI = A.ID_CI
      INNER JOIN AFW_STATUS C WITH(NOLOCK) ON C.stat_id = B.ID_ESTADO
      INNER JOIN SONIC_MODELO D WITH(NOLOCK) ON D.ID_MODELO = B.ID_MODELO
      INNER JOIN SONIC_MARCA E WITH(NOLOCK) ON E.ID_MARCA = B.ID_MARCA
      INNER JOIN SONIC_TIPOCI F WITH(NOLOCK) ON F.ID_TIPOCI = B.ID_TIPOCI
  	INNER JOIN INSTALACIONES_AT_X_CI G WITH(NOLOCK) ON G.TIPO_REL='2' AND G.ID_CI=B.ID_CI
    WHERE PS.IDV = '$IDCLIENTE' AND G.IDAT='$IDATEN' ORDER BY B.ID_CI");

            while ($fila4 = sqlsrv_fetch_array($SQL2)) {
                $IDU = $fila4['IDU'];
                $TIPO = utf8_encode($fila4['TIPO']);
                $MARCA = $fila4['MARCA'];
                $NOMBRE = $fila4['NOMBRE'];
                $MODELO = $fila4['MODELO'];
                $ACTIVO = $fila4['ACTIVO'];
                $SERIE = $fila4['SERIE'];
                $NEQUIPO = $fila4['NEQUIPO'];
                $SO = $fila4['SO'];
                $RESPO = $fila4['RESPO'];
                $IP = $fila4['IP'];
                $RESPD = $fila4['RESPD'];
                $ESTADO = $fila4['ESTADO'];
                if ($ESTADO == 1) {
                    $ESTADO = 'SI';
                } else {
                    $ESTADO = 'NO';
                }

                $EQUIPOENTRE .= '
              <tr>
                  <td style="border-top: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Se realiza la entrega del siguiente equipo</font></i></b></td>
              </tr>
              <tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Tipo de Equipo: ' . $TIPO . '</font></b></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Marca:' . $MARCA . ' </font></b></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Modelo:' . $MODELO . '</font></b></td>
              </tr>
              <tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Producto: ' . $NOMBRE . '</font></b></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Activo del Equipo: ' . $ACTIVO . '</font></b></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Serie del Equipo: ' . $SERIE . '</font></b></td>
              </tr>
              <tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Nombre del equipo:  ' . $NEQUIPO . '</font></b></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">S.O:  ' . $SO . '</font></b></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Dirección IP: ' . $IP . '</font></b></td>
              </tr>
              <tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Tamaño del respaldo origen: ' . $RESPO . '</font></b></td>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">Tamaño del respaldo destino: ' . $RESPD . '</font></b></td>
              </tr>
              <tr>
                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" height="29" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Calibri">Usuario verifica que el equipo no tenga ningun tipo de daño fisico: ' . $ESTADO . '</font></b></td>
              </tr>
             <tr>
                  <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="14" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Accesorios</font></i></b></td>
  </tr>
  			%ACCENTREGADO%';

                $ACCENTREGADO = '';

                $SQL2_1 = sqlsrv_query($connARANDABD, "SELECT B.ID_CI, F.N_TIPOCI TIPO,
      B.SERIE N_SERIE, D.N_MODELO MODELO, E.N_MARCA MARCA, B.ACTIVO, B.NPRODUCTO PRODUC, B2.SERIE as SERIEP,
  	case when G.TIPO_REL = 3 then 'RETIRO'
  	when G.TIPO_REL = 4 then 'INSTALACION'
  	end Tipo2,SCI.ID_CI_P,G.TIPO_REL
      FROM PROJECTS_SONIC PS WITH(NOLOCK)
  	INNER JOIN PROJECT_CI A WITH(NOLOCK) ON A.IDPROY=PS.IDP
      INNER JOIN SONIC_CI B WITH(NOLOCK) ON B.ID_CI = A.ID_CI
      INNER JOIN AFW_STATUS C WITH(NOLOCK) ON C.stat_id = B.ID_ESTADO
      INNER JOIN SONIC_MODELO D WITH(NOLOCK) ON D.ID_MODELO = B.ID_MODELO
      INNER JOIN SONIC_MARCA E WITH(NOLOCK) ON E.ID_MARCA = B.ID_MARCA
      INNER JOIN SONIC_TIPOCI F WITH(NOLOCK) ON F.ID_TIPOCI = B.ID_TIPOCI
  	INNER JOIN INSTALACIONES_AT_X_CI G WITH(NOLOCK) ON G.TIPO_REL in (4) AND G.ID_CI=B.ID_CI
  	INNER JOIN SONIC_REL_CI SCI WITH(NOLOCK) on SCI.ID_CI_S = B.ID_CI
  	INNER JOIN SONIC_CI B2 WITH(NOLOCK) ON B2.ID_CI = SCI.ID_CI_P
   WHERE G.IDAT = $IDATEN ORDER BY B.ID_CI");
                while ($fila4_1 = sqlsrv_fetch_array($SQL2_1)) {
                    $TIPO = $fila4_1['TIPO'];
                    $MARCA = $fila4_1['MARCA'];
                    $MODELO = $fila4_1['MODELO'];
                    $NSERIE = $fila4_1['N_SERIE'];
                    $ACTIVO = $fila4_1['ACTIVO'];
                    $PRODUC = $fila4_1['PRODUC'];

                    $ACCENTREGADO .= '<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" height="21" align="left" valign="middle"><font face="Calibri">Tipo: ' . $TIPO . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="21" align="left" valign="middle"><font face="Calibri">Marca: ' . $MARCA . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><font face="Calibri">Modelo: ' . $MODELO . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Serie: ' . $NSERIE . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Activo: ' . $ACTIVO . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">#Producto: ' . $PRODUC . '</font></td>
  </tr>';
                }

                $EQUIPOENTRE = str_replace('%ACCENTREGADO%', $ACCENTREGADO, $EQUIPOENTRE);
            }
            $HTMLBOL = str_replace('%EQUIPOENTREGADO%', $EQUIPOENTRE, $HTMLBOL);


            $EQUIPORETI = '';

            $SQL3 = sqlsrv_query($connARANDABD, "SELECT B.ID_CI IDU, F.N_TIPOCI TIPO,
       B.SERIE, D.N_MODELO MODELO, E.N_MARCA MARCA, B.ACTIVO ACTIVO, B.NPRODUCTO NOMBRE,dbo.Get_AddValueSTR('12',B.ID_CI,240) SO,dbo.Get_AddValueSTR('12',B.ID_CI,219) IP
  	 ,dbo.Get_AddValueSTR('12',B.ID_CI,220) RESPO,dbo.Get_AddValueSTR('12',B.ID_CI,221) RESPD,dbo.Get_AddValueSTR('12',B.ID_CI,45) NEQUIPO,dbo.Get_AddValueINT('12',B.ID_CI,222) ESTADO
      FROM PROJECTS_SONIC PS WITH(NOLOCK)
  	INNER JOIN PROJECT_CI A WITH(NOLOCK) ON A.IDPROY=PS.IDP
      INNER JOIN SONIC_CI B WITH(NOLOCK) ON B.ID_CI = A.ID_CI
      INNER JOIN AFW_STATUS C WITH(NOLOCK) ON C.stat_id = B.ID_ESTADO
      INNER JOIN SONIC_MODELO D WITH(NOLOCK) ON D.ID_MODELO = B.ID_MODELO
      INNER JOIN SONIC_MARCA E WITH(NOLOCK) ON E.ID_MARCA = B.ID_MARCA
      INNER JOIN SONIC_TIPOCI F WITH(NOLOCK) ON F.ID_TIPOCI = B.ID_TIPOCI
  	INNER JOIN INSTALACIONES_AT_X_CI G WITH(NOLOCK) ON G.TIPO_REL='1' AND G.ID_CI=B.ID_CI
    WHERE PS.IDV = '$IDCLIENTE' AND G.IDAT='$IDATEN' ORDER BY B.ID_CI");

            while ($fila5 = sqlsrv_fetch_array($SQL3)) {
                $IDU = $fila5['IDU'];
                $TIPO = $fila5['TIPO'];
                $NOMBRE = $fila5['NOMBRE'];
                $MODELO = $fila5['MODELO'];
                $ACTIVO = $fila5['ACTIVO'];
                $SERIE = $fila5['SERIE'];
                $NEQUIPO = $fila5['NEQUIPO'];
                $SO = $fila5['SO'];
                $RESPO = $fila5['RESPO'];
                $IP = $fila5['IP'];
                $RESPD = $fila5['RESPD'];
                $ESTADO = $fila5['ESTADO'];
                if ($ESTADO == 1) {
                    $ESTADO = 'SI';
                } else {
                    $ESTADO = 'NO';
                }

                $EQUIPORETI .= '<tr>
      <td style="border-top: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Se realiza el retiro del siguiente equipo</font></i></b></td>
  </tr>
  <tr>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Tipo de Equipo: ' . $TIPO . '</font></b></td>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Marca:' . $MARCA . ' </font></b></td>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Modelo:' . $MODELO . '</font></b></td>
  </tr>
  <tr>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" height="29" valign="middle"><b><font face="Calibri">Producto: ' . $NOMBRE . '</font></b></td>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri">Activo del Equipo: ' . $ACTIVO . '</font></b></td>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign="middle"><b><font face="Calibri" color="#000000">Serie del Equipo: ' . $SERIE . '</font></b></td>
  </tr>
  <tr>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Nombre del equipo:  ' . $NEQUIPO . '</font></b></td>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">S.O:  ' . $SO . '</font></b></td>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" height="29" align="left" valign="middle"><b><font face="Calibri">Dirección IP: ' . $IP . '</font></b></td>
  </tr>
  <tr>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri" color="#000000">Tamaño del respaldo origen: ' . $RESPO . '</font></b></td>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="6" height="29"  align="left" valign="middle"><b><font face="Calibri">Tamaño del respaldo destino: ' . $RESPD . '</font></b></td>
  </tr>
  <tr>
      <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" height="29" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Calibri">Usuario verifica que el equipo no tenga ningun tipo de daño fisico: ' . $ESTADO . '</font></b></td>
  </tr>
  <tr>
      <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;" colspan="12" height="22" align="center" valign="top" bgcolor="#A6A6A6"><b><i><font face="Calibri">Accesorios</font></i></b></td>
  </tr>
  			%ACCRETIRADO%';

                $ACCRETIRADO = '';

                $SQL3_1 = sqlsrv_query($connARANDABD, "SELECT B.ID_CI, F.N_TIPOCI TIPO,
      B.SERIE N_SERIE, D.N_MODELO MODELO, E.N_MARCA MARCA, B.ACTIVO, B.NPRODUCTO PRODUC, B2.SERIE as SERIEP,
  	case when G.TIPO_REL = 3 then 'RETIRO'
  	when G.TIPO_REL = 4 then 'INSTALACION'
  	end Tipo2,SCI.ID_CI_P,G.TIPO_REL
      FROM PROJECTS_SONIC PS WITH(NOLOCK)
  	INNER JOIN PROJECT_CI A WITH(NOLOCK) ON A.IDPROY=PS.IDP
      INNER JOIN SONIC_CI B WITH(NOLOCK) ON B.ID_CI = A.ID_CI
      INNER JOIN AFW_STATUS C WITH(NOLOCK) ON C.stat_id = B.ID_ESTADO
      INNER JOIN SONIC_MODELO D WITH(NOLOCK) ON D.ID_MODELO = B.ID_MODELO
      INNER JOIN SONIC_MARCA E WITH(NOLOCK) ON E.ID_MARCA = B.ID_MARCA
      INNER JOIN SONIC_TIPOCI F WITH(NOLOCK) ON F.ID_TIPOCI = B.ID_TIPOCI
  	INNER JOIN INSTALACIONES_AT_X_CI G WITH(NOLOCK) ON G.TIPO_REL in (3) AND G.ID_CI=B.ID_CI
  	INNER JOIN SONIC_REL_CI SCI WITH(NOLOCK) on SCI.ID_CI_S = B.ID_CI
  	INNER JOIN SONIC_CI B2 WITH(NOLOCK) ON B2.ID_CI = SCI.ID_CI_P
   WHERE G.IDAT = $IDATEN ORDER BY B.ID_CI");
                while ($fila5_1 = sqlsrv_fetch_array($SQL3_1)) {
                    $TIPO = $fila5_1['TIPO'];
                    $MARCA = $fila5_1['MARCA'];
                    $MODELO = $fila5_1['MODELO'];
                    $NSERIE = $fila5_1['N_SERIE'];
                    $ACTIVO = $fila5_1['ACTIVO'];
                    $PRODUC = $fila5_1['PRODUC'];

                    $ACCRETIRADO .= '<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" height="21" align="left" valign="middle"><font face="Calibri">Tipo: ' . $TIPO . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="21" align="left" valign="middle"><font face="Calibri">Marca: ' . $MARCA . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign="middle"><font face="Calibri">Modelo: ' . $MODELO . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Serie: ' . $NSERIE . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">Activo: ' . $ACTIVO . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle"><font face="Calibri">#Producto: ' . $PRODUC . '</font></td>
  </tr>';
                }

                $EQUIPORETI = str_replace('%ACCRETIRADO%', $ACCRETIRADO, $EQUIPORETI);
            }
            $HTMLBOL = str_replace('%EQUIPORETIRADO%', $EQUIPORETI, $HTMLBOL);


            $fh = fopen("D:/SpeedyFiles/Boletas/INSBAM/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {
                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/INSBAM/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'INSBAM');
                //SE MANDA UNA ENCUESTA CUANDO SE CIERRA EL CASO PADRE
                sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                $IDUSR = $_SESSION['IDU'];
                sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
            }

            echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/INSBAM/$IDATEN - $BOLETA.html";

        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/INSBAM/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php

        } else if ($IDSERV == 10 && $TIPOATENCION == 5) {

            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WITH(NOLOCK) WHERE IDBOL = '3'");
            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);

            $SQL = sqlsrv_query($connARANDABD, "SELECT C.CAMPOSTR LICIT, VEN.COMPANY CLIENTE, B.CAMPOSTR BOLETA, D.CAMPOSTR NUSUARIO, E.CAMPOSTR UBIC,
  TEC.UNAME TECNICO, F.CAMPODATE HINICIO, G.CAMPODATE HFIN, I.CAMPOSTR OBSERV, H.CAMPOSTR CEDULA, FIRM.SRCFIRMA FIRMAUSR,
   IMG.IMGCLIENTE,LCLI.IMGCLIENTE IMGLOGO, FIRM.FECHA FECHAFIRM, CSEC.NOMSEC, CSEC.CODPRE,
   CONCAT('CS-',CASO.IDCASO,'-AT-',A.IDATENCION) REPORTE, R.CAMPOINT OP1, S.CAMPOSTR PQOP1, T.CAMPOINT OP2, U.CAMPOSTR PQOP2,
   V.CAMPOINT OP3, W.CAMPOSTR PQOP3, X.CAMPOINT OP4, Y.CAMPOSTR PQOP4, Z.CAMPOSTR TELEF, AA2.NOMUBIC LISTA,TB.CAMPOSTR TIPOBOLETA
  FROM ATENCIONES A WITH(NOLOCK)
  INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
  INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
  LEFT JOIN DATOS_ADICIONALES TB WITH(NOLOCK) ON TB.TREGISTRO = '2' AND TB.IDREGISTRO = A.IDATENCION AND TB.IDCAMPO = 68  --Tipo de Boleta
  INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
  INNER JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.TREGISTRO = '2' AND E.IDREGISTRO = A.IDATENCION AND E.IDCAMPO = 3   --Ubicacion
  INNER JOIN DATOS_ADICIONALES F WITH(NOLOCK) ON F.TREGISTRO = '2' AND F.IDREGISTRO = A.IDATENCION AND F.IDCAMPO = 4  --HINICIO
  INNER JOIN DATOS_ADICIONALES G WITH(NOLOCK) ON G.TREGISTRO = '2' AND G.IDREGISTRO = A.IDATENCION AND G.IDCAMPO = 5  --HFIN
  INNER JOIN DATOS_ADICIONALES H WITH(NOLOCK) ON H.TREGISTRO = '2' AND H.IDREGISTRO = A.IDATENCION AND H.IDCAMPO = 40  --Cedula
  INNER JOIN DATOS_ADICIONALES I WITH(NOLOCK) ON I.TREGISTRO = '2' AND I.IDREGISTRO = A.IDATENCION AND I.IDCAMPO = 42  --Observaciones
  INNER JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
  INNER JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
  INNER JOIN USUARIOS TEC WITH(NOLOCK) ON TEC.CODUSUARIO = CASO.IDTECNICO -- Tecnico
  INNER JOIN FIRMAS FIRM WITH(NOLOCK) ON FIRM.IDATEN = A.IDATENCION -- FIRMA
  LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
  INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
  INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
  LEFT JOIN DATOS_ADICIONALES Q WITH(NOLOCK) ON Q.TREGISTRO = '2' AND Q.IDREGISTRO = A.IDATENCION AND Q.IDCAMPO = 43  --Cuenta Secundaria
  LEFT JOIN SECUNDARIAS CSEC WITH(NOLOCK) ON CSEC.IDU = Q.CAMPOINT
  LEFT JOIN DATOS_ADICIONALES R WITH(NOLOCK) ON R.TREGISTRO = '2' AND R.IDREGISTRO = A.IDATENCION AND R.IDCAMPO = 57  --Aceptacion del Equipo 1
  LEFT JOIN DATOS_ADICIONALES S WITH(NOLOCK) ON S.TREGISTRO = '2' AND S.IDREGISTRO = A.IDATENCION AND S.IDCAMPO = 61  --Aceptacion del Equipo-TXT 1
  LEFT JOIN DATOS_ADICIONALES T WITH(NOLOCK) ON T.TREGISTRO = '2' AND T.IDREGISTRO = A.IDATENCION AND T.IDCAMPO = 58  --Aceptacion del Equipo 2
  LEFT JOIN DATOS_ADICIONALES U WITH(NOLOCK) ON U.TREGISTRO = '2' AND U.IDREGISTRO = A.IDATENCION AND U.IDCAMPO = 62  --Aceptacion del Equipo-TXT 2
  LEFT JOIN DATOS_ADICIONALES V WITH(NOLOCK) ON V.TREGISTRO = '2' AND V.IDREGISTRO = A.IDATENCION AND V.IDCAMPO = 59  --Aceptacion del Equipo 3
  LEFT JOIN DATOS_ADICIONALES W WITH(NOLOCK) ON W.TREGISTRO = '2' AND W.IDREGISTRO = A.IDATENCION AND W.IDCAMPO = 63  --Aceptacion del Equipo-TXT 3
  LEFT JOIN DATOS_ADICIONALES X WITH(NOLOCK) ON X.TREGISTRO = '2' AND X.IDREGISTRO = A.IDATENCION AND X.IDCAMPO = 60  --Aceptacion del Equipo 4
  LEFT JOIN DATOS_ADICIONALES Y WITH(NOLOCK) ON Y.TREGISTRO = '2' AND Y.IDREGISTRO = A.IDATENCION AND Y.IDCAMPO = 64  --Aceptacion del Equipo-TXT 4
  LEFT JOIN DATOS_ADICIONALES Z WITH(NOLOCK) ON Z.TREGISTRO = '2' AND Z.IDREGISTRO = A.IDATENCION AND Z.IDCAMPO = 65  --Telefono
  LEFT JOIN DATOS_ADICIONALES AA WITH(NOLOCK) ON AA.TREGISTRO = '2' AND AA.IDREGISTRO = A.IDATENCION AND AA.IDCAMPO = 66  --Lista FOD
  LEFT JOIN RETIROUBICACIONES AA2 WITH(NOLOCK) ON AA2.IDUBIC = AA.CAMPOINT
  WHERE A.IDATENCION = '$IDATEN'");
            $fila3 = sqlsrv_fetch_array($SQL);
            $LICIT = $fila3['LICIT'];
            $LICIT = utf8_encode($LICIT);
            $CLIENTE = utf8_encode($fila3['CLIENTE']);
            $BOLETA = $fila3['BOLETA'];
            $NUSUARIO = utf8_encode($fila3['NUSUARIO']);
            $UBIC = utf8_encode($fila3['UBIC']);
            $TECNICO = utf8_encode($fila3['TECNICO']);
            $HINICIO = $fila3['HINICIO'];
            $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            $HFIN = $fila3['HFIN'];
            $HFIN = $HFIN->format('d/m/Y H:i:s');
            $OBSERV = utf8_encode($fila3['OBSERV']);
            $OBSERV = str_replace('\n', '<br>', $OBSERV);
            $CEDULA = $fila3['CEDULA'];
            $FIRMAUSR = $fila3['FIRMAUSR'];
            $IMGCLIENTE = $fila3['IMGCLIENTE'];
            $IMGLOGO = $fila3['IMGLOGO'];
            $FECHAFIRM = $fila3['FECHAFIRM'];
            $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');
            $NOMSEC = utf8_encode($fila3['NOMSEC']);
            $CODPRE = $fila3['CODPRE'];
            $REPORTE = $fila3['REPORTE'];
            $OP1 = $fila3['OP1'];
            $PQOP1 = $fila3['PQOP1'];
            $OP2 = $fila3['OP2'];
            $PQOP2 = $fila3['PQOP2'];
            $OP3 = $fila3['OP3'];
            $PQOP3 = $fila3['PQOP3'];
            $OP4 = $fila3['OP4'];
            $PQOP4 = $fila3['PQOP4'];
            $TELEF = $fila3['TELEF'];
            $LISTA = $fila3['LISTA'];

            $HTMLBOL = str_replace('%logoorbe%', $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace('%logocliente%', $IMGCLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace('%Bol%', $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace('%Rep%', $REPORTE, $HTMLBOL);
            $HTMLBOL = str_replace('%CLIENTE%', $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace('%LISTADO%', $LISTA, $HTMLBOL);
            $HTMLBOL = str_replace('%CENTRO_E%', $NOMSEC, $HTMLBOL);
            $HTMLBOL = str_replace('%CODIGO%', $CODPRE, $HTMLBOL);
            $HTMLBOL = str_replace('%UBIC%', $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace('%TELEFONO%', $TELEF, $HTMLBOL);
            $HTMLBOL = str_replace('%FINICIO%', $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace('%FFIN%', $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace('%TECNICO%', $TECNICO, $HTMLBOL);
            $HTMLBOL = str_replace('%LICI%', $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace('%OBSERV%', $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace('%NOMUSRAUT%', $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace('%CEDULA%', $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace('%FECHAFIRMA%', $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace('%firma%', $FIRMAUSR, $HTMLBOL);

            if ($OP1 == 1) {
                $OP1 = '&nbsp; SI (X) &nbsp;';
                $HTMLBOL = str_replace('%OP1%', $OP1, $HTMLBOL);
                $HTMLBOL = str_replace('%PQOP1%', '', $HTMLBOL);
            } else {
                $HTMLBOL = str_replace('%PQOP1%', '¿Por qué no?: ' . $PQOP1, $HTMLBOL);
                $OP1 = '&nbsp; NO (X) &nbsp;';
                $HTMLBOL = str_replace('%OP1%', $OP1, $HTMLBOL);
            }

            if ($OP2 == 1) {
                $OP2 = '&nbsp; SI (X) &nbsp;';
                $HTMLBOL = str_replace('%OP2%', $OP2, $HTMLBOL);
                $HTMLBOL = str_replace('%PQOP2%', '', $HTMLBOL);
            } else {
                $HTMLBOL = str_replace('%PQOP2%', '¿Por qué no?: ' . $PQOP2, $HTMLBOL);
                $OP2 = '&nbsp; NO (X) &nbsp;';
                $HTMLBOL = str_replace('%OP2%', $OP2, $HTMLBOL);
            }

            if ($OP3 == 1) {
                $OP3 = '&nbsp; SI (X) &nbsp;';
                $HTMLBOL = str_replace('%OP3%', $OP3, $HTMLBOL);
                $HTMLBOL = str_replace('%PQOP3%', '', $HTMLBOL);
            } else {
                $HTMLBOL = str_replace('%PQOP3%', '¿Por qué no?: ' . $PQOP3, $HTMLBOL);
                $OP3 = '&nbsp; NO (X) &nbsp;';
                $HTMLBOL = str_replace('%OP3%', $OP3, $HTMLBOL);
            }

            if ($OP4 == 1) {
                $OP4 = '&nbsp; SI (X) &nbsp;';
                $HTMLBOL = str_replace('%OP4%', $OP4, $HTMLBOL);
                $HTMLBOL = str_replace('%PQOP4%', '', $HTMLBOL);
            } else {
                $HTMLBOL = str_replace('%PQOP4%', '¿Por qué no?: ' . $PQOP4, $HTMLBOL);
                $OP4 = '&nbsp; NO (X) &nbsp;';
                $HTMLBOL = str_replace('%OP4%', $OP4, $HTMLBOL);
            }

            $EQUIPOSREEQ = '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="14" height="22" align="center" valign="middle" bgcolor="#A6A6A6"><b><font face="Calibri">Detalle de los equipos</font></b></td>
	</tr>
  <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center" valign="middle"><b><font face="Calibri" size="1">Modelo</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1"># Producto</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign="middle"><b><font face="Calibri" size="1">Serie</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">Placa</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="center" valign="middle"><b><font face="Calibri" size="1">Responsable del equipo</font></b></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="center" valign="middle"><b><font face="Calibri" size="1">Estetica del equipo</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" align="center" valign="middle"><b><font face="Calibri" size="1"># Estación</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">¿Entregado?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">¿Completo?</font></b></td>
	</tr>';

            // <!-- COPIAR A PRODUCTIVO -->
            $SQL2 = sqlsrv_query($connARANDABD, "  SELECT B.MODELO, ISNULL(D.IDPRODUCAJA,B.NPRODU) NPRODU, B.SERIE, B.PLACA,A.NOMRECIB,A.NESTACION,
CASE WHEN ISNULL(A.EQENT,0) = 0 THEN 'NO' ELSE 'SI' END EQENT,
CASE WHEN ISNULL(A.EQCOMP,0) = 0 THEN 'NO' ELSE 'SI' END EQCOMP,
A.ESTEQ
FROM EQREEQ A WITH(NOLOCK)
INNER JOIN RETIROEQUIPOS B WITH(NOLOCK) ON CONCAT (B.IDL,' - ',B.IDC) =  A.IDR
INNER JOIN CAJA_ATENC C WITH(NOLOCK) ON C.IDATENC = A.IDATENC
INNER JOIN RETIROCAJAS D WITH(NOLOCK) ON D.IDCAJA = C.IDCAJA
WHERE A.IDATENC = '$IDATEN' AND A.TSYSTEM=0
UNION ALL
SELECT B.N_MODELO MODELO, ISNULL(D.IDPRODUCAJA,B.NPRODUCTO) NPRODU, B.SERIE, B.ACTIVO PLACA,A.NOMRECIB,A.NESTACION,
CASE WHEN ISNULL(A.EQENT,0) = 0 THEN 'NO' ELSE 'SI' END EQENT,
CASE WHEN ISNULL(A.EQCOMP,0) = 0 THEN 'NO' ELSE 'SI' END EQCOMP,
A.ESTEQ
FROM EQREEQ A WITH(NOLOCK)
INNER JOIN V_SONIC_CI B WITH(NOLOCK) ON B.ID_CI =  A.IDR
INNER JOIN CAJA_ATENC C WITH(NOLOCK) ON C.IDATENC = A.IDATENC
INNER JOIN RETIROCAJAS D WITH(NOLOCK) ON D.IDCAJA = C.IDCAJA
INNER JOIN VALIDACION_REEQ VALREQ WITH(NOLOCK) ON VALREQ.ID_CI=A.IDR AND VALREQ.IDATENCION=A.IDATENC AND VALREQ.TIPO_VALIDACION=2
WHERE A.IDATENC = '$IDATEN' AND A.TSYSTEM=1");
            // <!-- FIN -->

            while ($fila4 = sqlsrv_fetch_array($SQL2)) {
                $MODELO = $fila4['MODELO'];
                $NPRODU = $fila4['NPRODU'];
                $SERIE = $fila4['SERIE'];
                $PLACA = $fila4['PLACA'];
                $NOMRECIB = utf8_encode($fila4['NOMRECIB']);
                $NESTACION = $fila4['NESTACION'];
                $EQENT = $fila4['EQENT'];
                $EQCOMP = $fila4['EQCOMP'];
                $ESTEQ = utf8_encode($fila4['ESTEQ']);
                if ($ESTEQ == '') {
                    $ESTEQ = 'Buen Estado';
                }

                $EQUIPOSREEQ .= '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="29" align="center" valign="middle"><font face="Calibri" size="1">' . $MODELO . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><font face="Calibri" size="1">' . $NPRODU . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign="middle"><font face="Calibri" size="1">' . $SERIE . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><font face="Calibri" size="1">' . $PLACA . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="center" valign="middle"><font face="Calibri" size="1">' . $NOMRECIB . '</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="center" valign="middle"><font face="Calibri" size="1">' . $ESTEQ . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" align="center" valign="middle"><font face="Calibri" size="1">' . $NESTACION . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><font face="Calibri" size="1">' . $EQENT . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><font face="Calibri" color="#000000">' . $EQCOMP . '</font></td>
	</tr>';
            }

            $HTMLBOL = str_replace('%EQUIPOSREEQ%', $EQUIPOSREEQ, $HTMLBOL);

            $ACCREEQ = '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="14" height="22" align="center" valign="middle" bgcolor="#A6A6A6"><b><font face="Calibri">Detalle de accesorios</font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center" valign="middle"><b><font face="Calibri" size="1"># Producto</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="5" align="center" valign="middle"><b><font face="Calibri" size="1">Descripción de Accesorio</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="center" valign="middle"><b><font face="Calibri" size="1">Cantidad </font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">Entregado</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="center" valign="middle"><b><font face="Calibri" size="1">¿Por qué?</font></b></td>
	</tr>';

            // <!-- COPIAR A PRODUCTIVO -->

            $SQL3 = sqlsrv_query($connARANDABD, "SELECT CODIGOACC, DESCACC, CANTIDAD_VAL_TRS, CANTENT, PQCANT FROM ACCREEQ_ATENC
WHERE IDATENC = '$IDATEN'");

            while ($fila5 = sqlsrv_fetch_array($SQL3)) {
                $CODIGOACC = $fila5['CODIGOACC'];
                $DESCACC = utf8_encode($fila5['DESCACC']);
                $CANTIDAD = $fila5['CANTIDAD_VAL_TRS'];
                $CANTENT = $fila5['CANTENT'];
                $PQCANT = utf8_encode($fila5['PQCANT']);

                $ACCREEQ .= '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="29" align="center" valign="middle"><font face="Calibri" size="1">' . $CODIGOACC . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="5" align="center" valign="middle"><font face="Calibri" size="1">' . $DESCACC . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="center" valign="middle"><font face="Calibri" size="1">' . $CANTIDAD . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><font face="Calibri" size="1">' . $CANTENT . '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="center" valign="middle"><font face="Calibri" size="1">' . $PQCANT . '</font></td>
	</tr>';
            }

            $HTMLBOL = str_replace('%ACCREEQ%', $ACCREEQ, $HTMLBOL);



            $SQL4 = sqlsrv_query($connARANDABD, "SELECT COUNT(IDU) CANTENT,
(SELECT ISNULL(SUM(CANTENT),0) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO = 'Mouse') CANTCOLM,
(SELECT ISNULL(SUM(CANTENT),0) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO like '%Malet%') CANTCOLMA,
(SELECT ISNULL(SUM(CANTENT),0) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO = 'Audifonos') CANTCOLA,
(SELECT ISNULL(SUM(CANTENT),0) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO = 'Convertidor') CANTCOLC,
(SELECT ISNULL(SUM(CANTENT),0) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO = 'Cargador') CANTCOLCA,
(SELECT COUNT(*) CANTNULL FROM(
SELECT TIPO,ISNULL(CANTENT,-1)CANTENT FROM ACCREEQ_ATENC WITH(NOLOCK) WHERE IDATENC='$IDATEN')TMP WHERE TMP.CANTENT=-1) CANTNULL
FROM EQREEQ A WITH(NOLOCK)
INNER JOIN RETIROEQUIPOS B WITH(NOLOCK) ON CONCAT (B.IDL,' - ',B.IDC) = A.IDR
INNER JOIN CAJA_ATENC C WITH(NOLOCK) ON C.IDCAJA = B.CAJA AND C.IDATENC=A.IDATENC
WHERE A.IDATENC = '$IDATEN' AND A.EQENT = 1 AND A.TSYSTEM=0
GROUP BY C.IDATENC
UNION ALL
SELECT COUNT(IDU) CANTENT,
(SELECT ISNULL(SUM(CANTENT),-1) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO = 'Mouse') CANTCOLM,
(SELECT ISNULL(SUM(CANTENT),-1) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO like '%Malet%') CANTCOLMA,
(SELECT ISNULL(SUM(CANTENT),-1) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO = 'Audifonos') CANTCOLA,
(SELECT ISNULL(SUM(CANTENT),-1) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO = 'Convertidor') CANTCOLC,
(SELECT ISNULL(SUM(CANTENT),-1) FROM ACCREEQ_ATENC WHERE IDATENC = C.IDATENC AND TIPO = 'Cargador') CANTCOLCA,
(SELECT COUNT(*) CANTNULL FROM(
SELECT TIPO,ISNULL(CANTENT,-1)CANTENT FROM ACCREEQ_ATENC WITH(NOLOCK) WHERE IDATENC='$IDATEN')TMP WHERE TMP.CANTENT=-1) CANTNULL
FROM EQREEQ A WITH(NOLOCK)
INNER JOIN V_SONIC_CI B WITH(NOLOCK) ON B.ID_CI = A.IDR
INNER JOIN CAJA_ATENC C WITH(NOLOCK) ON C.IDCAJA = A.IDCAJAP AND C.IDATENC=A.IDATENC
WHERE A.IDATENC = '$IDATEN' AND A.EQENT = 1 AND A.TSYSTEM=1
GROUP BY C.IDATENC");

            $fila6 = sqlsrv_fetch_array($SQL4);
            $CANTENT = $fila6['CANTENT'];
            $CANTCOLM = $fila6['CANTCOLM'];
            $CANTCOLMA = $fila6['CANTCOLMA'];
            $CANTCOLA = $fila6['CANTCOLA'];
            $CANTCOLC = $fila6['CANTCOLC'];
            $CANTCOLCA = $fila6['CANTCOLCA'];

            if ($fila6['CANTNULL'] > 0) {
                trigger_error("Debe completar información de los accesorios", E_USER_ERROR);
            }
            // <!-- FIN -->
            $HTMLBOL = str_replace('%CANTENT%', $CANTENT, $HTMLBOL);
            $HTMLBOL = str_replace('%CANTCOLM%', $CANTCOLM, $HTMLBOL);
            $HTMLBOL = str_replace('%CANTCOLMA%', $CANTCOLMA, $HTMLBOL);
            $HTMLBOL = str_replace('%CANTCOLA%', $CANTCOLA, $HTMLBOL);
            $HTMLBOL = str_replace('%CANTCOLC%', $CANTCOLC, $HTMLBOL);
            $HTMLBOL = str_replace('%CANTCOLCA%', $CANTCOLCA, $HTMLBOL);

            $fh = fopen("D:/SpeedyFiles/Boletas/REEQFOD/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {
                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/REEQFOD/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'REEQFOD');
                //Descomentar cuando den el VB
                $IDUSR = $_SESSION['IDU'];

                if ($RESP == 'Correo Enviado') {
                    $SQL_CI = sqlsrv_query($connARANDABD, "SELECT B.ID_CI, ISNULL(A.EQENT,0) EQENT
          FROM EQREEQ A WITH(NOLOCK)
          INNER JOIN V_SONIC_CI B WITH(NOLOCK) ON B.ID_CI =  A.IDR
          INNER JOIN CAJA_ATENC C WITH(NOLOCK) ON C.IDATENC = A.IDATENC
          INNER JOIN RETIROCAJAS D WITH(NOLOCK) ON D.IDCAJA = C.IDCAJA
          INNER JOIN VALIDACION_REEQ VALREQ WITH(NOLOCK) ON VALREQ.ID_CI=A.IDR AND VALREQ.IDATENCION=A.IDATENC
          WHERE A.IDATENC = '$IDATEN' AND A.TSYSTEM=1");

                    while ($A_CI = sqlsrv_fetch_array($SQL_CI)) {

                        $ID_CIS = $A_CI['ID_CI'];
                        if ($A_CI['EQENT'] == '0') {
                            sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$ID_CIS','12','173','279','$IDUSR'"); //Cambia el Estado del CI Historico
                            sqlsrv_query($connARANDABD, "UPDATE SONIC_CI SET ID_ESTADO=279 WHERE ID_CI='$ID_CIS'"); //Cambia el Estado del CI
                        } else {
                            sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$ID_CIS','12','173','255','$IDUSR'"); //Cambia el Estado del CI Historico
                            sqlsrv_query($connARANDABD, "UPDATE SONIC_CI SET ID_ESTADO=255 WHERE ID_CI='$ID_CIS'"); //Cambia el Estado del CI
                        }
                    }
                    sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
                }
            }

            //echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/REEQFOD/$IDATEN - $BOLETA.html";

        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/REEQFOD/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                        //EnviarEncuesta($IDATEN,$connARANDABD);
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php


        } else if ($IDSERV == 9 && $TIPOATENCION == 7) {
            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '4'");
            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);

            $SQL = sqlsrv_query($connARANDABD, "SELECT A.*,RET.CAMPOSTR RETIRAN,RETC.CAMPOSTR RETIROC,C.CAMPOSTR LICIT, VEN.COMPANY CLIENTE, B.CAMPOSTR BOLETA, D.CAMPOSTR NUSUARIO, E.CAMPOSTR UBIC,
  TEC.UNAME TECNICO, F.CAMPODATE HINICIO, G.CAMPODATE HFIN, I.CAMPOSTR OBSERV, H.CAMPOSTR CEDULA, FIRM.SRCFIRMA FIRMAUSR,
   IMG.IMGCLIENTE,LCLI.IMGCLIENTE IMGLOGO, FIRM.FECHA FECHAFIRM, O.CAMPOINT COMPANY,CSEC.NOMSEC,CSEC.CODPRE,Z.CAMPOSTR TELEFONO
  FROM ATENCIONES A WITH(NOLOCK)
  INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
  INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
  LEFT JOIN DATOS_ADICIONALES TB WITH(NOLOCK) ON TB.TREGISTRO = '2' AND TB.IDREGISTRO = A.IDATENCION AND TB.IDCAMPO = 68  --Tipo de Boleta
  INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
  INNER JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.TREGISTRO = '2' AND E.IDREGISTRO = A.IDATENCION AND E.IDCAMPO = 3   --Ubicacion
  INNER JOIN DATOS_ADICIONALES F WITH(NOLOCK) ON F.TREGISTRO = '2' AND F.IDREGISTRO = A.IDATENCION AND F.IDCAMPO = 4  --HINICIO
  INNER JOIN DATOS_ADICIONALES G WITH(NOLOCK) ON G.TREGISTRO = '2' AND G.IDREGISTRO = A.IDATENCION AND G.IDCAMPO = 5  --HFIN
  INNER JOIN DATOS_ADICIONALES H WITH(NOLOCK) ON H.TREGISTRO = '2' AND H.IDREGISTRO = A.IDATENCION AND H.IDCAMPO = 40  --Cedula
  INNER JOIN DATOS_ADICIONALES I WITH(NOLOCK) ON I.TREGISTRO = '2' AND I.IDREGISTRO = A.IDATENCION AND I.IDCAMPO = 42  --Observaciones
  INNER JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
  INNER JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
  INNER JOIN USUARIOS TEC WITH(NOLOCK) ON TEC.CODUSUARIO = CASO.IDTECNICO -- Tecnico
  INNER JOIN FIRMAS FIRM WITH(NOLOCK) ON FIRM.IDATEN = A.IDATENCION -- FIRMA
  LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
  LEFT JOIN DATOS_ADICIONALES Q WITH(NOLOCK) ON Q.TREGISTRO = '2' AND Q.IDREGISTRO = A.IDATENCION AND Q.IDCAMPO = 43  --Cuenta Secundaria
  LEFT JOIN SECUNDARIAS CSEC WITH(NOLOCK) ON CSEC.IDU = Q.CAMPOINT
  INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
  INNER JOIN DATOS_ADICIONALES RET WITH(NOLOCK) ON RET.TREGISTRO = '2' AND RET.IDREGISTRO = A.IDATENCION AND RET.IDCAMPO = 97  --Se retiran todos los equipos
  INNER JOIN DATOS_ADICIONALES RETC WITH(NOLOCK) ON RETC.TREGISTRO = '2' AND RETC.IDREGISTRO = A.IDATENCION AND RETC.IDCAMPO = 98  --Retiro terminado
  INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
  LEFT JOIN DATOS_ADICIONALES Z WITH(NOLOCK) ON Z.TREGISTRO = '2' AND Z.IDREGISTRO = A.IDATENCION AND Z.IDCAMPO = 65  --Telefono
  WHERE A.IDATENCION = '$IDATEN'");

            $A = sqlsrv_fetch_array($SQL);
            $LICIT = $A['LICIT'];
            $RETIRAN = $A['RETIRAN'];
            $RETIROC = $A['RETIROC'];
            $CLIENTE = utf8_encode($A['CLIENTE']);
            $NOMSEC = utf8_encode($A['NOMSEC']);
            $CODPRE = $A['CODPRE'];
            $BOLETA = $A['BOLETA'];
            $NUSUARIO = utf8_encode($A['NUSUARIO']);
            $TELEFONO = $A['TELEFONO'];
            $UBIC = utf8_encode($A['UBIC']);
            $TECNICO = utf8_encode($A['TECNICO']);
            $HINICIO = $A['HINICIO'];
            $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            $HFIN = $A['HFIN'];
            $HFIN = $HFIN->format('d/m/Y H:i:s');
            $OBSERV = utf8_encode($A['OBSERV']);
            $DESCRI = utf8_encode($A['DESCRI']);
            $CEDULA = $A['CEDULA'];
            $FIRMAUSR = $A['FIRMAUSR'];
            $IMGCLIENTE = $A['IMGCLIENTE'];
            $IMGLOGO = $A['IMGLOGO'];
            $FECHAFIRM = $A['FECHAFIRM'];
            $IDCASO = $A['IDCASO'];
            $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');

            $IDCLIENTE = $A['IDCLIENTE'];
            $ASUNTO = $A['ASUNTO'];
            $IDUSRATE = $A['IDUSR'];

            $EQUIPOS = '<table cellspacing="0" border="0">
  	<colgroup width="148"></colgroup><colgroup width="84">
    </colgroup><colgroup width="54"></colgroup>
    <colgroup width="49"></colgroup><colgroup width="88"></colgroup>
    <colgroup width="69"></colgroup><colgroup width="95"></colgroup><colgroup width="180"></colgroup><colgroup width="180"></colgroup><colgroup width="74"></colgroup><colgroup width="300"></colgroup>';

            $SQL = sqlsrv_query($connARANDABD, "SELECT A.ID_CI,TCI.N_TIPOCI TIPO,D.SERIE,H.N_MARCA MARCA,I.N_MODELO MODELO,D.ACTIVO,D.NPRODUCTO PRODUCTO,E.CAMPOSTR RESPONSABLE,
CASE
WHEN F.CAMPOINT=1 THEN 'Dañado'
WHEN F.CAMPOINT=2 THEN 'Funcional'
END ESTADO,
CASE
WHEN G.CAMPOINT=1 THEN 'Si'
WHEN G.CAMPOINT=2 THEN 'No'
END COMPLETO,AB.CAMPOSTR COMPLETO_EXT,EST_EXT.CAMPOSTR EST_EXT
FROM RETIRO_AT_X_CI A WITH(NOLOCK)
LEFT JOIN ATENCIONES B WITH(NOLOCK) ON B.IDATENCION= A.IDAT
LEFT JOIN PROJECTS_SONIC C WITH(NOLOCK) ON C.IDV=B.IDCLIENTE
LEFT JOIN SONIC_CI D WITH(NOLOCK) ON D.ID_CI=A.ID_CI
LEFT JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.IDREGISTRO=A.ID_CI AND E.TREGISTRO='12' AND E.IDCAMPO='166'
LEFT JOIN DATOS_ADICIONALES F WITH(NOLOCK) ON F.IDREGISTRO=A.ID_CI AND F.TREGISTRO='12' AND F.IDCAMPO='167'
LEFT JOIN DATOS_ADICIONALES EST_EXT WITH(NOLOCK) ON EST_EXT.IDREGISTRO=A.ID_CI AND EST_EXT.TREGISTRO='12' AND EST_EXT.IDCAMPO='172'
LEFT JOIN DATOS_ADICIONALES G WITH(NOLOCK) ON G.IDREGISTRO=A.ID_CI AND G.TREGISTRO='12' AND G.IDCAMPO='168'
LEFT JOIN DATOS_ADICIONALES AB WITH(NOLOCK) ON AB.IDREGISTRO=A.ID_CI AND AB.TREGISTRO='12' AND AB.IDCAMPO='169'
LEFT JOIN SONIC_TIPOCI TCI WITH(NOLOCK) ON TCI.ID_TIPOCI = D.ID_TIPOCI
LEFT JOIN SONIC_MARCA H WITH(NOLOCK) ON H.ID_MARCA = D.ID_MARCA
LEFT JOIN SONIC_MODELO I WITH(NOLOCK) ON I.ID_MODELO = D.ID_MODELO
WHERE A.IDAT='$IDATEN' ORDER BY A.ID_CI DESC");

            $EQUIPOS .= '<tr>
<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right:
1px solid #000000" height="22" align="center" valign="middle"><b><font face="Calibri" size="1">Marca</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"
valign="middle"><b><font face="Calibri" size="1">Tipo</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"
valign="middle"><b><font face="Calibri" size="1">Modelo</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;
 border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">Producto</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font
face="Calibri" size="1">Serie</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
 border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">Activo</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
  border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">Estado físico</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
   border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">Descripción del estado físico</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
   border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">Responsable</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
    border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">¿Completo?</font></b></td>';
            $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
     border-right: 2px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">¿Por qué no?</font></b></td></tr>';



            while ($fila = sqlsrv_fetch_array($SQL)) {
                $ID_CI = $fila['ID_CI'];
                $MARCA = $fila['MARCA'];
                $MODELO = $fila['MODELO'];
                $PRODUCTO = $fila['PRODUCTO'];
                $SERIE = $fila['SERIE'];
                $TIPO = utf8_encode($fila['TIPO']);
                $ACTIVO = $fila['ACTIVO'];
                $RESPONSABLE = utf8_encode($fila['RESPONSABLE']);
                $ESTADO = $fila['ESTADO'];
                $COMPLETO = $fila['COMPLETO'];
                $COMPLETO_EXT = utf8_encode($fila['COMPLETO_EXT']);
                $COMPLETO_EXT = str_replace('\n', '<br>', $COMPLETO_EXT);
                $EST_EXT = utf8_encode($fila['EST_EXT']);
                $EST_EXT = str_replace('\n', '<br>', $EST_EXT);


                if ($SEND == 1) {
                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$ID_CI','12','173','258','1'");
                    sqlsrv_query($connARANDABD, "UPDATE SONIC_CI SET ID_ESTADO=258 WHERE ID_CI='$ID_CI'");
                }

                $EQUIPOS .= '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right:
    1px solid #000000" height="22" align="center" valign="middle"><b><font face="Calibri" size="1">' . $MARCA . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"
    valign="middle"><b><font face="Calibri" size="1">' . $TIPO . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"
    valign="middle"><b><font face="Calibri" size="1">' . $MODELO . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;
     border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">' . $PRODUCTO . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font
    face="Calibri" size="1">' . $SERIE . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
     border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">' . $ACTIVO . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
      border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">' . $ESTADO . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
       border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">' . $ESTADO . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
       border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">' . $RESPONSABLE . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
        border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">' . $COMPLETO . '</font></b></td>';
                $EQUIPOS .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;
         border-right: 2px solid #000000" align="center" valign="middle"><b><font face="Calibri" size="1">' . $COMPLETO_EXT . '</font></b></td></tr>';
            }
            $EQUIPOS .= '</table>';
            $HTMLBOL = str_replace("%datos_equipo%", $EQUIPOS, $HTMLBOL);
            $HTMLBOL = str_replace("%img_orbe%", $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace("%img_cliente%", $IMGCLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%cliente%", $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%cuenta_sec%", $NOMSEC, $HTMLBOL);
            $HTMLBOL = str_replace("%codigo_pre%", $CODPRE, $HTMLBOL);
            $HTMLBOL = str_replace("%UBIC%", $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace("%FINICIO%", $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace("%FFIN%", $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace("%telefono%", $TELEFONO, $HTMLBOL);
            $HTMLBOL = str_replace("%TECNICO%", $TECNICO, $HTMLBOL);
            $HTMLBOL = str_replace("%licitacion%", $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace("%descrip%", $DESCRI, $HTMLBOL);
            $HTMLBOL = str_replace("%solucion%", $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace("%NOMUSRAUT%", $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace("%CEDULA%", $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace("%FECHAFIRMA%", $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace("%firma%", $FIRMAUSR, $HTMLBOL);
            $HTMLBOL = str_replace("%opc1%", $RETIRAN, $HTMLBOL);
            $HTMLBOL = str_replace("%opc2%", $RETIROC, $HTMLBOL);
            $HTMLBOL = str_replace("%Bol%", $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%titulo%", $IDATEN . " - " . $BOLETA, $HTMLBOL);
            $BOLETA1 = explode("-", $BOLETA);
            $HTMLBOL = str_replace("%Rep%", 'CS-' . $IDCASO . ' AT-' . $IDATEN, $HTMLBOL);

            $fh = fopen("D:/SpeedyFiles/Boletas/RETIRO/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {
                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/RETIRO/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'RETIRO');
                //Descomentar cuando den el VB
                //EnviarEncuesta($IDATEN,$connARANDABD);
                sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                $IDUSR = $_SESSION['IDU'];
                sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
            }

            //echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/REEQFOD/$IDATEN - $BOLETA.html";

        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/RETIRO/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                        if ($SEND == 1) {
                            $SQL = sqlsrv_query($connARANDABD, "SELECT ISNULL(MAX(IDATENCION),0)+1 IDA FROM ATENCIONES");
                            $A = sqlsrv_fetch_array($SQL);
                            $NEWID = $A['IDA'];
                            $DESCRI = utf8_decode($DESCRI);
                            sqlsrv_query($connARANDABD, "INSERT INTO ATENCIONES VALUES('$NEWID','$IDCLIENTE',NULL,11,10,1,'$ASUNTO','$DESCRI',NULL,GETDATE(),NULL,'$IDUSRATE')");
                            sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$NEWID','2','174','$IDATEN','1'");
                        }
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php

        } else if ($IDSERV == 9 && $TIPOATENCION == 4) {
            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '11'");
            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);

            $SQL = sqlsrv_query($connARANDABD, "SELECT A.*,RET.CAMPOSTR RETIRAN,RETC.CAMPOSTR RETIROC,C.CAMPOSTR LICIT, VEN.COMPANY CLIENTE, B.CAMPOSTR BOLETA, D.CAMPOSTR NUSUARIO, E.CAMPOSTR UBIC,
  TEC.UNAME TECNICO, F.CAMPODATE HINICIO, G.CAMPODATE HFIN, I.CAMPOSTR OBSERV, H.CAMPOSTR CEDULA, FIRM.SRCFIRMA FIRMAUSR,
   IMG.IMGCLIENTE,LCLI.IMGCLIENTE IMGLOGO, FIRM.FECHA FECHAFIRM, O.CAMPOINT COMPANY,CSEC.NOMSEC,CSEC.CODPRE,Z.CAMPOSTR TELEFONO,CORREOS.CAMPOSTR CORREOS
  FROM ATENCIONES A WITH(NOLOCK)
  INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
  INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
  LEFT JOIN DATOS_ADICIONALES TB WITH(NOLOCK) ON TB.TREGISTRO = '2' AND TB.IDREGISTRO = A.IDATENCION AND TB.IDCAMPO = 68  --Tipo de Boleta
  INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
  INNER JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.TREGISTRO = '2' AND E.IDREGISTRO = A.IDATENCION AND E.IDCAMPO = 3   --Ubicacion
  INNER JOIN DATOS_ADICIONALES F WITH(NOLOCK) ON F.TREGISTRO = '2' AND F.IDREGISTRO = A.IDATENCION AND F.IDCAMPO = 4  --HINICIO
  INNER JOIN DATOS_ADICIONALES G WITH(NOLOCK) ON G.TREGISTRO = '2' AND G.IDREGISTRO = A.IDATENCION AND G.IDCAMPO = 5  --HFIN
  INNER JOIN DATOS_ADICIONALES H WITH(NOLOCK) ON H.TREGISTRO = '2' AND H.IDREGISTRO = A.IDATENCION AND H.IDCAMPO = 40  --Cedula
  INNER JOIN DATOS_ADICIONALES I WITH(NOLOCK) ON I.TREGISTRO = '2' AND I.IDREGISTRO = A.IDATENCION AND I.IDCAMPO = 42  --Observaciones
  INNER JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
  INNER JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
  INNER JOIN USUARIOS TEC WITH(NOLOCK) ON TEC.CODUSUARIO = CASO.IDTECNICO -- Tecnico
  INNER JOIN FIRMAS FIRM WITH(NOLOCK) ON FIRM.IDATEN = A.IDATENCION -- FIRMA
  LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
  LEFT JOIN DATOS_ADICIONALES Q WITH(NOLOCK) ON Q.TREGISTRO = '2' AND Q.IDREGISTRO = A.IDATENCION AND Q.IDCAMPO = 43  --Cuenta Secundaria
  LEFT JOIN SECUNDARIAS CSEC WITH(NOLOCK) ON CSEC.IDU = Q.CAMPOINT
  INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
  INNER JOIN DATOS_ADICIONALES RET WITH(NOLOCK) ON RET.TREGISTRO = '2' AND RET.IDREGISTRO = A.IDATENCION AND RET.IDCAMPO = 97  --Se retiran todos los equipos
  INNER JOIN DATOS_ADICIONALES RETC WITH(NOLOCK) ON RETC.TREGISTRO = '2' AND RETC.IDREGISTRO = A.IDATENCION AND RETC.IDCAMPO = 98  --Retiro terminado
  INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
  LEFT JOIN DATOS_ADICIONALES Z WITH(NOLOCK) ON Z.TREGISTRO = '2' AND Z.IDREGISTRO = A.IDATENCION AND Z.IDCAMPO = 65  --Telefono
  LEFT JOIN DATOS_ADICIONALES CORREOS WITH(NOLOCK) ON CORREOS.TREGISTRO = '2' AND CORREOS.IDREGISTRO = A.IDATENCION AND CORREOS.IDCAMPO = 41  --Correos
  WHERE A.IDATENCION = '$IDATEN'");

            $A = sqlsrv_fetch_array($SQL);
            $LICIT = $A['LICIT'];
            $RETIRAN = $A['RETIRAN'];
            if ($RETIRAN == '') {
                $RETIRAN = ' ';
            }
            $RETIROC = $A['RETIROC'];
            if ($RETIROC == '') {
                $RETIROC = ' ';
            }
            $CLIENTE = utf8_encode($A['CLIENTE']);
            $NOMSEC = utf8_encode($A['NOMSEC']);
            $CODPRE = $A['CODPRE'];
            $BOLETA = $A['BOLETA'];
            $NUSUARIO = utf8_encode($A['NUSUARIO']);
            $TELEFONO = $A['TELEFONO'];
            $UBIC = utf8_encode($A['UBIC']);
            $TECNICO = utf8_encode($A['TECNICO']);
            $HINICIO = $A['HINICIO'];
            $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            $HFIN = $A['HFIN'];
            $HFIN = $HFIN->format('d/m/Y H:i:s');
            $OBSERV = utf8_encode($A['OBSERV']);
            $DESCRI = utf8_encode($A['DESCRI']);
            $CEDULAUSR = $A['CEDULA'];
            $FIRMAUSR = $A['FIRMAUSR'];
            $IMGCLIENTE = $A['IMGCLIENTE'];
            $IMGLOGO = $A['IMGLOGO'];
            $FECHAFIRM = $A['FECHAFIRM'];
            $IDCASO = $A['IDCASO'];
            $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');

            $IDCLIENTE = $A['IDCLIENTE'];
            $ASUNTO = $A['ASUNTO'];
            $IDUSRATE = $A['IDUSR'];
            $CORREOS = $A['CORREOS'];

            $COMPANY = $A['COMPANY'];

            if ($COMPANY == -1) {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono : +506 2106-4500 <br> Apartado Postal: 3653-1000 San José, Costa Rica";
                $UNeA = "CEO";
            } else if ($COMPANY == -3) {
                $COMPANY = "ATI CAPITAL SOLUTIONS S.A.";
                $ENCABEZADO = "";
                $UNeA = "ATI";
            } else if ($COMPANY == -4) {
                $COMPANY = "SISTEMAS CONVERGENTES S.A.";
                $ENCABEZADO = "Teléfono : (506) 2280-3355 <br> Apartado Postal: 236-1100 Tibás, San José, Costa Rica";
                $UNeA = "SISCON";
            } else if ($COMPANY == -5) {
                $COMPANY = "NOVA TECHNOLOGIES S.A.";
                $ENCABEZADO = "";
                $UNeA = "NOVA";
            }

            $ENCABEZADO = '<b>' . $COMPANY . '</b><br>' . $ENCABEZADO;

            $EQUIPOS = '<table cellspacing="0" border="0" style="width: 100%;"><tbody>';

            $SQL = sqlsrv_query($connARANDABD, "SELECT DISTINCT A.ID_CI,TCI.N_TIPOCI TIPO,D.SERIE,H.N_MARCA MARCA,I.N_MODELO MODELO,D.ACTIVO,D.NPRODUCTO PRODUCTO,E.CAMPOSTR RESPONSABLE,
F.CAMPOSTR ESTADO,J.CAMPOINT ESTACION,K.CAMPOSTR PERFIL,GRADO.CAMPOSTR GRADO,L.CAMPOSTR CEDULA,
CASE
WHEN G.CAMPOINT=1 THEN 'Si'
WHEN G.CAMPOINT=2 THEN 'No'
END COMPLETO
FROM RETIROFOD_AT_X_CI A WITH(NOLOCK)
LEFT JOIN ATENCIONES B WITH(NOLOCK) ON B.IDATENCION= A.IDAT
--LEFT JOIN PROJECTS_SONIC C WITH(NOLOCK) ON C.IDV=B.IDCLIENTE
LEFT JOIN SONIC_CI D WITH(NOLOCK) ON D.ID_CI=A.ID_CI
LEFT JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.IDREGISTRO=A.ID_CI AND E.TREGISTRO='12' AND E.IDCAMPO='166'
LEFT JOIN DATOS_ADICIONALES F WITH(NOLOCK) ON F.IDREGISTRO=A.ID_CI AND F.TREGISTRO='12' AND F.IDCAMPO='167'
LEFT JOIN DATOS_ADICIONALES G WITH(NOLOCK) ON G.IDREGISTRO=A.ID_CI AND G.TREGISTRO='12' AND G.IDCAMPO='168'
LEFT JOIN DATOS_ADICIONALES J WITH(NOLOCK) ON J.IDREGISTRO=A.ID_CI AND J.TREGISTRO='12' AND J.IDCAMPO='241'
LEFT JOIN DATOS_ADICIONALES K WITH(NOLOCK) ON K.IDREGISTRO=A.ID_CI AND K.TREGISTRO='12' AND K.IDCAMPO='242'
LEFT JOIN DATOS_ADICIONALES L WITH(NOLOCK) ON L.IDREGISTRO=A.ID_CI AND L.TREGISTRO='12' AND L.IDCAMPO='243'
LEFT JOIN DATOS_ADICIONALES GRADO WITH(NOLOCK) ON GRADO.IDREGISTRO=A.ID_CI AND GRADO.TREGISTRO='12' AND GRADO.IDCAMPO='279'
LEFT JOIN SONIC_TIPOCI TCI WITH(NOLOCK) ON TCI.ID_TIPOCI = D.ID_TIPOCI
LEFT JOIN SONIC_MARCA H WITH(NOLOCK) ON H.ID_MARCA = D.ID_MARCA
LEFT JOIN SONIC_MODELO I WITH(NOLOCK) ON I.ID_MODELO = D.ID_MODELO
WHERE A.IDAT='$IDATEN' ORDER BY A.ID_CI DESC");

            $EQUIPOS .= '<tr> <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="16" height="22" align="center" valign="middle" bgcolor="#A6A6A6"> <b><font face="Calibri">Detalle de los equipos</font></b> </td></tr><tr> <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" align="center" valign="middle"> <b><font face="Calibri" size="1">Marca</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" height="21" align="center" valign="middle"> <b><font face="Calibri" size="1">Modelo</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" align="center" valign="middle"> <b><font face="Calibri" size="1"># Producto</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="2" align="center" valign="middle"> <b><font face="Calibri" size="1">Serie</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" align="center" valign="middle"> <b><font face="Calibri" size="1">Placa</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Perfil</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Grado</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="2" align="center" valign="middle"> <b><font face="Calibri" size="1">Responsable del equipo</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Cédula</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="2" align="center" valign="middle"> <b><font face="Calibri" size="1">Estetica del equipo</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1"># Estación</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" align="center" valign="middle"> <b><font face="Calibri" size="1">¿Completo?</font></b> </td></tr>';


            while ($fila = sqlsrv_fetch_array($SQL)) {
                $ID_CI = $fila['ID_CI'];
                $MARCA = $fila['MARCA'];
                $MODELO = $fila['MODELO'];
                $PRODUCTO = $fila['PRODUCTO'];
                $SERIE = $fila['SERIE'];
                $TIPO = utf8_encode($fila['TIPO']);
                $ACTIVO = $fila['ACTIVO'];
                $RESPONSABLE = utf8_encode($fila['RESPONSABLE']);
                $ESTADO = utf8_encode($fila['ESTADO']);
                $COMPLETO = $fila['COMPLETO'];
                $PERFIL = $fila['PERFIL'];
                $GRADO = $fila['GRADO'];
                $CEDULA = $fila['CEDULA'];
                $RESPONSABLE = utf8_encode($fila['RESPONSABLE']);
                $ESTACION = $fila['ESTACION'];


                //     if($SEND == 1){
                //   sqlsrv_query($connARANDABD,"EXEC SP_INS_DATA_INT '$ID_CI','12','173','258','1'");
                //   sqlsrv_query($connARANDABD,"UPDATE SONIC_CI SET ID_ESTADO=258 WHERE ID_CI='$ID_CI'");
                // }

                $EQUIPOS .= '<tr> <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" align="center" valign="middle"> <font face="Calibri" size="1">' . $MARCA . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" height="21" align="center" valign="middle"> <font face="Calibri" size="1">' . $MODELO . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" align="center" valign="middle"> <font face="Calibri" size="1">' . $PRODUCTO . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="2" align="center" valign="middle"> <font face="Calibri" size="1">' . $SERIE . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" align="center" valign="middle"> <font face="Calibri" size="1">' . $ACTIVO . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $PERFIL . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $GRADO . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="2" align="center" valign="middle"> <font face="Calibri" size="1">' . $RESPONSABLE . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $CEDULA . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="2" align="center" valign="middle"> <font face="Calibri" size="1">' . $ESTADO . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $ESTACION . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" align="center" valign="middle"> <font face="Calibri" size="1">' . $COMPLETO . '</font> </td></tr>';
            }
            $EQUIPOS .= '</tbody></table>';

            $ACCESORIOS = '<table cellspacing="0" border="0" style="width: 100%;"><tbody>';

            $SQL = sqlsrv_query($connARANDABD, "SELECT RESP,CARGADOR,CARGADOR_STAT,MOUSE,MOUSE_STAT,AUDIFONO,AUDIFONO_STAT,MALETIN,MALETIN_STAT,CONVERTIDOR,CONVERTIDOR_STAT,ID_CI FROM(
SELECT DISTINCT E.CAMPOSTR RESP,
CARGADOR.CAMPOINT CARGADOR,
CASE
WHEN CARGADOR_STAT.CAMPOINT=1 THEN 'Bueno'
WHEN CARGADOR_STAT.CAMPOINT=2 THEN 'Malo'
WHEN CARGADOR_STAT.CAMPOINT=3 THEN 'No aplica'
END CARGADOR_STAT,
MOUSE.CAMPOINT MOUSE,
CASE
WHEN MOUSE_STAT.CAMPOINT=1 THEN 'Bueno'
WHEN MOUSE_STAT.CAMPOINT=2 THEN 'Malo'
WHEN MOUSE_STAT.CAMPOINT=3 THEN 'No aplica'
END MOUSE_STAT,
AUDIFONO.CAMPOINT AUDIFONO,
CASE
WHEN AUDIFONO_STAT.CAMPOINT=1 THEN 'Bueno'
WHEN AUDIFONO_STAT.CAMPOINT=2 THEN 'Malo'
WHEN AUDIFONO_STAT.CAMPOINT=3 THEN 'No aplica'
END AUDIFONO_STAT,
MALETIN.CAMPOINT MALETIN,
CASE
WHEN MALETIN_STAT.CAMPOINT=1 THEN 'Bueno'
WHEN MALETIN_STAT.CAMPOINT=2 THEN 'Malo'
WHEN MALETIN_STAT.CAMPOINT=3 THEN 'No aplica'
END MALETIN_STAT,
CONVERTIDOR.CAMPOINT CONVERTIDOR,
CASE
WHEN CONVERTIDOR_STAT.CAMPOINT=1 THEN 'Bueno'
WHEN CONVERTIDOR_STAT.CAMPOINT=2 THEN 'Malo'
WHEN CONVERTIDOR_STAT.CAMPOINT=3 THEN 'No aplica'
END CONVERTIDOR_STAT,
A.ID_CI
FROM RETIROFOD_AT_X_CI A WITH(NOLOCK)
LEFT JOIN ATENCIONES B WITH(NOLOCK) ON B.IDATENCION= A.IDAT
LEFT JOIN PROJECTS_SONIC C WITH(NOLOCK) ON C.IDV=B.IDCLIENTE
LEFT JOIN SONIC_CI D WITH(NOLOCK) ON D.ID_CI=A.ID_CI
LEFT JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.IDREGISTRO=A.ID_CI AND E.TREGISTRO='12' AND E.IDCAMPO='166'
LEFT JOIN DATOS_ADICIONALES CARGADOR WITH(NOLOCK) ON CARGADOR.IDREGISTRO=A.ID_CI AND CARGADOR.TREGISTRO='12' AND CARGADOR.IDCAMPO='230'
LEFT JOIN DATOS_ADICIONALES CARGADOR_STAT WITH(NOLOCK) ON CARGADOR_STAT.IDREGISTRO=A.ID_CI AND CARGADOR_STAT.TREGISTRO='12' AND CARGADOR_STAT.IDCAMPO='231'
LEFT JOIN DATOS_ADICIONALES MOUSE WITH(NOLOCK) ON MOUSE.IDREGISTRO=A.ID_CI AND MOUSE.TREGISTRO='12' AND MOUSE.IDCAMPO='232'
LEFT JOIN DATOS_ADICIONALES MOUSE_STAT WITH(NOLOCK) ON MOUSE_STAT.IDREGISTRO=A.ID_CI AND MOUSE_STAT.TREGISTRO='12' AND MOUSE_STAT.IDCAMPO='233'
LEFT JOIN DATOS_ADICIONALES AUDIFONO WITH(NOLOCK) ON AUDIFONO.IDREGISTRO=A.ID_CI AND AUDIFONO.TREGISTRO='12' AND AUDIFONO.IDCAMPO='234'
LEFT JOIN DATOS_ADICIONALES AUDIFONO_STAT WITH(NOLOCK) ON AUDIFONO_STAT.IDREGISTRO=A.ID_CI AND AUDIFONO_STAT.TREGISTRO='12' AND AUDIFONO_STAT.IDCAMPO='235'
LEFT JOIN DATOS_ADICIONALES MALETIN WITH(NOLOCK) ON MALETIN.IDREGISTRO=A.ID_CI AND MALETIN.TREGISTRO='12' AND MALETIN.IDCAMPO='236'
LEFT JOIN DATOS_ADICIONALES MALETIN_STAT WITH(NOLOCK) ON MALETIN_STAT.IDREGISTRO=A.ID_CI AND MALETIN_STAT.TREGISTRO='12' AND MALETIN_STAT.IDCAMPO='237'
LEFT JOIN DATOS_ADICIONALES CONVERTIDOR WITH(NOLOCK) ON CONVERTIDOR.IDREGISTRO=A.ID_CI AND CONVERTIDOR.TREGISTRO='12' AND CONVERTIDOR.IDCAMPO='238'
LEFT JOIN DATOS_ADICIONALES CONVERTIDOR_STAT WITH(NOLOCK) ON CONVERTIDOR_STAT.IDREGISTRO=A.ID_CI AND CONVERTIDOR_STAT.TREGISTRO='12' AND CONVERTIDOR_STAT.IDCAMPO='239'
WHERE A.IDAT='$IDATEN')TMP ORDER BY ID_CI DESC");

            $ACCESORIOS .= '<tbody> <tr> <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="11" height="22" align="center" valign="middle" bgcolor="#A6A6A6"> <b><font face="Calibri">Detalle de accesorios</font></b> </td></tr><tr> <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Responsable</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Cargador</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Estado</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Mouse</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Estado</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Audifono</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Estado</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Maletín</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Estado</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Convertidor</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <b><font face="Calibri" size="1">Estado</font></b> </td></tr>';

            while ($B = sqlsrv_fetch_array($SQL)) {
                $RESP = utf8_encode($B['RESP']);
                $CARGADOR = $B['CARGADOR'];
                $CARGADOR_STAT = $B['CARGADOR_STAT'];
                $MOUSE = $B['MOUSE'];
                $MOUSE_STAT = $B['MOUSE_STAT'];
                $AUDIFONO = $B['AUDIFONO'];
                $AUDIFONO_STAT = $B['AUDIFONO_STAT'];
                $MALETIN = $B['MALETIN'];
                $MALETIN_STAT = $B['MALETIN_STAT'];
                $CONVERTIDOR = $B['CONVERTIDOR'];
                $CONVERTIDOR_STAT = $B['CONVERTIDOR_STAT'];

                $ACCESORIOS .= '<tr> <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $RESP . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $CARGADOR . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $CARGADOR_STAT . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $MOUSE . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $MOUSE_STAT . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $AUDIFONO . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $AUDIFONO_STAT . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $MALETIN . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $MALETIN_STAT . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $CONVERTIDOR . '</font> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="1" align="center" valign="middle"> <font face="Calibri" size="1">' . $CONVERTIDOR_STAT . '</font> </td></tr>';
            }

            $ACCESORIOS .= '</tbody></table>';


            $sql = sqlsrv_query($connARANDABD, "SELECT (SELECT COUNT(*) FROM RETIROFOD_AT_X_CI WHERE IDAT='$IDATEN') N_EQUIPOS,
(SELECT COUNT(*) FROM RETIROFOD_AT_X_CI A
INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO=12 AND B.IDREGISTRO=A.ID_CI AND B.IDCAMPO=232 AND B.CAMPOINT=1--$Mouse
WHERE A.IDAT='$IDATEN') N_MOUSE,
(SELECT COUNT(*) FROM RETIROFOD_AT_X_CI A
INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO=12 AND B.IDREGISTRO=A.ID_CI AND B.IDCAMPO=236 AND B.CAMPOINT=1--$Maletin
WHERE A.IDAT='$IDATEN') N_MALETIN,
(SELECT COUNT(*) FROM RETIROFOD_AT_X_CI A
INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO=12 AND B.IDREGISTRO=A.ID_CI AND B.IDCAMPO=234 AND B.CAMPOINT=1--$Audifono
WHERE A.IDAT='$IDATEN') N_AUDIFONO,
(SELECT COUNT(*) FROM RETIROFOD_AT_X_CI A
INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO=12 AND B.IDREGISTRO=A.ID_CI AND B.IDCAMPO=238 AND B.CAMPOINT=1--$Convertidor
WHERE A.IDAT='$IDATEN') N_CONVERTIDOR,
(SELECT COUNT(*) FROM RETIROFOD_AT_X_CI A
INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO=12 AND B.IDREGISTRO=A.ID_CI AND B.IDCAMPO=230 AND B.CAMPOINT=1--$Cargador
WHERE A.IDAT='$IDATEN') N_CARGADOR");

            $B = sqlsrv_fetch_array($sql);

            $HTMLBOL = str_replace("%datos_equipo%", $EQUIPOS, $HTMLBOL);
            $HTMLBOL = str_replace("%ACCESORIOS%", $ACCESORIOS, $HTMLBOL);
            $HTMLBOL = str_replace("%N_EQUIPO%", $B['N_EQUIPOS'], $HTMLBOL);
            $HTMLBOL = str_replace("%N_MOUSE%", $B['N_MOUSE'], $HTMLBOL);
            $HTMLBOL = str_replace("%N_MALETIN%", $B['N_MALETIN'], $HTMLBOL);
            $HTMLBOL = str_replace("%N_AUDIFONO%", $B['N_AUDIFONO'], $HTMLBOL);
            $HTMLBOL = str_replace("%N_CONVERTIDOR%", $B['N_CONVERTIDOR'], $HTMLBOL);
            $HTMLBOL = str_replace("%N_CARGADOR%", $B['N_CARGADOR'], $HTMLBOL);
            $HTMLBOL = str_replace("%img_orbe%", $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace("%img_cliente%", $IMGCLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%cliente%", $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%cuenta_sec%", $NOMSEC, $HTMLBOL);
            $HTMLBOL = str_replace("%codigo_pre%", $CODPRE, $HTMLBOL);
            $HTMLBOL = str_replace("%UBIC%", $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace("%FINICIO%", $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace("%FFIN%", $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace("%telefono%", $TELEFONO, $HTMLBOL);
            $HTMLBOL = str_replace("%TECNICO%", $TECNICO, $HTMLBOL);
            $HTMLBOL = str_replace("%licitacion%", $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace("%observaciones%", $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace("%NOMUSRAUT%", $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace("%CEDULA%", $CEDULAUSR, $HTMLBOL);
            $HTMLBOL = str_replace("%FECHAFIRMA%", $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace("%firma%", $FIRMAUSR, $HTMLBOL);
            $HTMLBOL = str_replace("%opc1%", $RETIRAN, $HTMLBOL);
            $HTMLBOL = str_replace("%opc2%", $RETIROC, $HTMLBOL);
            $HTMLBOL = str_replace("%Bol%", $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%ENCABEZADO%", $ENCABEZADO, $HTMLBOL);
            $HTMLBOL = str_replace("%destinatarios%", $CORREOS, $HTMLBOL);
            $HTMLBOL = str_replace("%titulo%", $IDATEN . " - " . $BOLETA, $HTMLBOL);
            $BOLETA1 = explode("-", $BOLETA);
            $HTMLBOL = str_replace("%Rep%", 'CS-' . $IDCASO . ' AT-' . $IDATEN, $HTMLBOL);

            $fh = fopen("D:/SpeedyFiles/Boletas/RETIROFOD/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {
                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/RETIROFOD/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'RETIROFOD');
                //Descomentar cuando den el VB
                //EnviarEncuesta($IDATEN,$connARANDABD);
                $IDUSR = $_SESSION['IDU'];
                if ($RESP == 'Correo Enviado') {
                    sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
                }
            }

            //echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/REEQFOD/$IDATEN - $BOLETA.html";

        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/RETIROFOD/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                        // Transportes if ($SEND==1) {
                        //   $SQL=sqlsrv_query($connARANDABD,"SELECT ISNULL(MAX(IDATENCION),0)+1 IDA FROM ATENCIONES");
                        //   $A=sqlsrv_fetch_array($SQL);
                        //   $NEWID=$A['IDA'];
                        //   $DESCRI=utf8_decode($DESCRI);
                        //   sqlsrv_query($connARANDABD,"INSERT INTO ATENCIONES VALUES('$NEWID','$IDCLIENTE',NULL,11,10,1,'$ASUNTO','$DESCRI',NULL,GETDATE(),NULL,'$IDUSRATE')");
                        //   sqlsrv_query($connARANDABD,"EXEC SP_INS_DATA_INT '$NEWID','2','174','$IDATEN','1'");
                        // }
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php

        } else if ($IDSERV == 8 && $TIPOATENCION == 1) {

            $SQL = sqlsrv_query($connARANDABD, "EXEC SP_INFOBOLETA_ATEN $IDATEN , 1");

            $A = sqlsrv_fetch_array($SQL);

            if (($A['IDCLIENTE'] == 2066) && $SEND == 1 && $A['BOLADDMEP'] == '' && $A['DANO_FIS'] == 1) {
                trigger_error("Falta la boleta adicional del MEP", E_USER_ERROR);
            }

            if ($SEND == 1 && $A['FIRMAUSR'] == '') {
                trigger_error("Falta la firma de la boleta", E_USER_ERROR);
            }

            if (($A['IDCLIENTE'] == 2066 || $A['IDCLIENTE'] == 448) && $SEND == 1 && $A['FIRMATEC'] == '') {
                trigger_error("Falta la firma del técnico", E_USER_ERROR);
            }

            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '5'");


            if ($A['IDCLIENTE'] == 2066 || $A['IDCLIENTE'] == 448) {
                $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '13'");
            }

            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);


            $LICIT = $A['LICIT'];
            $CLIENTE = utf8_encode($A['CLIENTE']);
            $NOMSEC = utf8_encode($A['NOMSEC']);
            $CODPRE = $A['CODPRE'];
            $IDCASO = $A['IDCASO'];
            $IDATENCION = $A['IDATENCION'];
            $BOLETA = $A['BOLETA'];
            $REPCLIENTE = $A['REPCLIENTE'];
            $TELEFONO = $A['TELEFONO'];
            $IDCLIENTE = $A['IDCLIENTE'];
            $NUSUARIO = utf8_encode($A['NUSUARIO']);
            $UBIC = utf8_encode($A['UBIC']);
            $TECNICO = utf8_encode($A['TECNICO']);
            $COMPANY = utf8_encode($A['COMPANY']);
            $CEDULATEC = utf8_encode($A['CEDULATEC']);

            $PAIS = $A['PAIS'];
            if ($COMPANY == -1) {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono : +506 2106-4500 <br> Apartado Postal: 3653-1000 San José, Costa Rica";
                $UNeA = "CEO";
            } else if ($COMPANY == -6) {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "PBX (502) 22794000, (502) 54296366 <br> 5 avenida 5-55 zona 14, Europlaza World Business Center, torre 4 nivel 7 oficina 701.";
            } else if ($COMPANY == -7 || $PAIS == 'CAE2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono: +507 387-4158 / 59 <br> Calle Punta Darién, Punta Pacífica, P.H Torre de las Américas, Torre C, Piso 18, Ofic. 1804 C, Corregimiento de San Francisco, Ciudad de Panamá.";
                $UNeA = "CEO";
            } else if ($COMPANY == -8 || $PAIS == 'C2E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +503 $2283-9498 <br> Calle el Mirador entre la 87 y 89 avenida norte, nivel 12 oficina -4 Torre Futura, Colonia Escalón San Salvador.";
                $UNeA = "CEO";
            } else if ($COMPANY == -9 || $PAIS == 'C8E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "CORPORACION EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +505 2231-3127 <br> Edificio Escala Piso # Nueve, modulo G, Pista Jean Paul Genie.";
                $UNeA = "CEO";
            } else if ($COMPANY == -10 || $PAIS == 'C6E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +504 2242-6201 <br> Torre Agalta , piso 11, local 1117, Tegucigalpa, Honduras.";
                $UNeA = "CEO";
            } else if ($COMPANY == -3) {
                $COMPANY = "ATI CAPITAL SOLUTIONS S.A.";
                $ENCABEZADO = "";
                $UNeA = "ATI";
            } else if ($COMPANY == -4) {
                $COMPANY = "SISTEMAS CONVERGENTES S.A.";
                $ENCABEZADO = "Teléfono : (506) 2280-3355 <br> Apartado Postal: 236-1100 Tibás, San José, Costa Rica";
                $UNeA = "SISCON";
            } else if ($COMPANY == -5) {
                $COMPANY = "NOVA TECHNOLOGIES S.A.";
                $ENCABEZADO = "";
                $UNeA = "NOVA";
            } else if ($COMPANY == -6 || $PAIS == 'C4E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "PBX (502) 22794000, (502) 54296366 <br> 5 avenida 5-55 zona 14, Europlaza World Business Center, torre 4 nivel 7 oficina 701.";
                $UNeA = "CEO";
            } else if ($COMPANY == -7 || $PAIS == 'CAE2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono: +507 387-4158 / 59 <br> Calle Punta Darién, Punta Pacífica, P.H Torre de las Américas, Torre C, Piso 18, Ofic. 1804 C, Corregimiento de San Francisco, Ciudad de Panamá.";
                $UNeA = "CEO";
            } else if ($COMPANY == -8 || $PAIS == 'C2E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +503 2283-9498 <br> Calle el Mirador entre la 87 y 89 avenida norte, nivel 12 oficina -4 Torre Futura, Colonia Escalón San Salvador.";
                $UNeA = "CEO";
            } else if ($COMPANY == -9 || $PAIS == 'C8E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "CORPORACION EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +505 2231-3127 <br> Edificio Escala Piso # Nueve, modulo G, Pista Jean Paul Genie.";
                $UNeA = "CEO";
            } else if ($COMPANY == -10 || $PAIS == 'C6E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +504 2242-6201 <br> Torre Agalta , piso 11, local 1117, Tegucigalpa, Honduras.";
                $UNeA = "CEO";
            }
            $HINICIO = $A['HINICIO'];

            if ($HINICIO != '') {
                $HINICIO2 = $HINICIO->format('Y-m-d H:i:s');
                $HINICIO2 = new DateTime($HINICIO2);
                $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            }
            $HFIN = $A['HFIN'];
            $HFIN2 = $HFIN->format('Y-m-d H:i:s');
            $HFIN2 = new DateTime($HFIN2);
            $HFIN = $HFIN->format('d/m/Y H:i:s');

            $FREGISTRO = $A['FREGISTRO'];
            $FREGISTRO = $FREGISTRO->format('d/m/Y H:i:00');

            if ($SEND == 1 && ($A['HINICIO']->format('Y-m-d H:i:s') < $A['FREGISTRO']->format('Y-m-d H:i:00') || $A['HFIN']->format('Y-m-d H:i:s') < $A['FREGISTRO']->format('Y-m-d H:i:00'))) {
                trigger_error("La fecha de inicio o fin es inferior a la del registro del caso", E_USER_ERROR);
            }

            $intervalFechas = date_diff(date_create($A['HINICIO']->format('Y-m-d')), date_create($A['HFIN']->format('Y-m-d')));

            if (($intervalFechas->format('%a') != 0 && $A['CHECKPFDD'] != 1) != 0 || $HFIN2 < $HINICIO2) {
                trigger_error("Las fechas de inicio y fin no son del mismo día o la fecha de fin es menor a la fecha de inicio", E_USER_ERROR);
            }

            $OBSERV = utf8_encode($A['OBSERV']);
            $DESCRI = utf8_encode($A['PROBLEMA_REP']);
            $CEDULA = $A['CEDULA'];
            $FIRMAUSR = $A['FIRMAUSR'];
            $IMGCLIENTE = $A['IMGCLIENTE'];
            $IMGLOGO = $A['IMGLOGO'];

            $FECHAFIRM = $A['FECHAFIRM'];
            if ($FIRMAUSR != '') {
                $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');
            }

            $FIRMATEC = $A['FIRMATEC'];
            $FFIRMATEC = $A['FFIRMATEC'];

            if ($FIRMATEC != '') {
                $FFIRMATEC = $FFIRMATEC->format('d/m/Y H:i:s');
            }

            if ($SEND == 1 && ((strtotime($A['FECHAFIRM']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) < 0) {
                trigger_error("La fecha de la firma del usuario es inferior a la fecha fin", E_USER_ERROR);
            } else if ($A['IDCLIENTE'] == 2066 && $SEND == 1 && ((strtotime($A['FECHAFIRM']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) > 10 && $A['JUSTFFIRMA'] == '') {
                trigger_error("La fecha de la firma del usuario tiene mas de 10 minutos de diferencia de la fecha fin", E_USER_ERROR);
            }

            if ($A['IDCLIENTE'] == 2066 && $SEND == 1 && ((strtotime($A['FFIRMATEC']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) < 0) {
                trigger_error("La fecha de la firma del tecnico es inferior a la fecha fin", E_USER_ERROR);
            } else if ($A['IDCLIENTE'] == 2066 && $SEND == 1 && ((strtotime($A['FFIRMATEC']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) > 10 && $A['JUSTFFIRMA'] == '') {
                trigger_error("La fecha de la firma del tecnico tiene mas de 10 minutos de diferencia de la fecha fin", E_USER_ERROR);
            }


            $SERIE = $A['SERIE'];
            $MODELO = $A['MODELO'];
            $PLACA = $A['PLACA'];
            $PRODUCTO = $A['PRODUCTO'];
            $MARCA = $A['MARCA'];

            $SERIE_CORRESP = $A['SERIE_CORRESP'];
            $REALIZA_UEFI = $A['REALIZA_UEFI'];
            $XQ_UEFI = utf8_encode($A['XQ_UEFI']);
            $COD_ERROR = $A['COD_ERROR'];
            $ACT_BIOS = $A['ACT_BIOS'];
            $VER_BIOS = $A['VER_BIOS'];
            $FIRM_CHIPS = $A['FIRM_CHIPS'];
            $ACT_DRIV = $A['ACT_DRIV'];
            $SOFT_HARD = $A['SOFT_HARD'];
            $DANO_FIS = $A['DANO_FIS'];
            $ATENC_PEND = $A['ATENC_PEND'];
            $RAZON_PEND = utf8_encode($A['RAZON_PEND']);
            $PARTE_PEND = $A['PARTE_PEND'];
            $CAMBIO_COMP = $A['CAMBIO_COMP'];
            $SOLUCION = utf8_encode($A['SOLUCION']);
            $SOLUCION = str_replace('\n', '<br>', $SOLUCION);
            $TELEFONO = $A['TELEFONO'];
            $PROBLEMA_REP = utf8_encode($A['PROBLEMA_REP']);
            $PROBLEMA_REP = str_replace('\n', '<br>', $PROBLEMA_REP);
            $TBOL = utf8_encode($A['TBOL']);
            $IDCLIENTE = $A['IDCLIENTE'];
            $IDUSR = $A['IDUSR'];



            /* DATA HORAS INACTIVAS */

            $SQL_HORAS_INACTIVAS = sqlsrv_prepare($connARANDABD, "
      SELECT IDHORASINC, FINICIO, FFIN, HORASINVERTIDAS, MINUTOSINVERTIDAS, NOTA, APROBADO
      FROM SPEEDE_ACT_ING_HORAS_INC WITH(NOLOCK)
      WHERE IDATENCION = $IDATENCION
  ");

            $exec_result = sqlsrv_execute($SQL_HORAS_INACTIVAS);

            $HORASINCHTML = '';

            if ($exec_result) {
                $hayResultados = false;

                while ($row = sqlsrv_fetch_array($SQL_HORAS_INACTIVAS, SQLSRV_FETCH_ASSOC)) {
                    if (!$hayResultados) {
                        $hayResultados = true;

                        $HORASINCHTML .= '<tr> <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="14" height="22" align="center" valign="middle" bgcolor="#A6A6A6"> <b><font face="Calibri">HORAS INACTIVAS</font></b> </td></tr>';
                        $HORASINCHTML .= '<tr>';
                        $HORASINCHTML .= '<td style="border: 1px solid #000;" colspan="4" align="left" valign="middle"> <font face="Calibri" color="#000000"><b>INICIO</b></font></td>';
                        $HORASINCHTML .= '<td style="border: 1px solid #000;" colspan="4" align="left" valign="middle"> <font face="Calibri" color="#000000"><b>FIN</b></font></td>';
                        $HORASINCHTML .= '<td style="border: 1px solid #000;" colspan="3" align="left" valign="middle"> <font face="Calibri" color="#000000"><b>NOTA</b></font></td>';
                        $HORASINCHTML .= '<td style="border: 1px solid #000;" colspan="3" align="left" valign="middle"> <font face="Calibri" color="#000000"><b>TIEMPO INACTIVO (HH:MM)</b></font></td>';
                        $HORASINCHTML .= '</tr>';
                    }

                    $HORASINCHTML .= '<tr>';
                    $HORASINCHTML .= '<td style="border: 1px solid #000;" colspan="4" align="left" valign="middle"> <font face="Calibri" color="#000000">' . $row['FINICIO']->format('d/m/Y H:i') . '</font></td>';
                    $HORASINCHTML .= '<td style="border: 1px solid #000;" colspan="4" align="left" valign="middle"> <font face="Calibri" color="#000000">' . $row['FFIN']->format('d/m/Y H:i') . '</font></td>';
                    $HORASINCHTML .= '<td style="border: 1px solid #000;" colspan="3" align="left" valign="middle"> <font face="Calibri" color="#000000">' . $row['NOTA'] . '</font></td>';
                    $HORASINCHTML .= '<td style="border: 1px solid #000;" colspan="3" align="left" valign="middle"> <font face="Calibri" color="#000000">' . $row['HORASINVERTIDAS'] . ':' . sprintf('%02d', $row['MINUTOSINVERTIDAS']) . '</font></td>';
                    $HORASINCHTML .= '</tr>';
                }

                if (!$hayResultados) {
                    $HORASINCHTML = '';
                }
            } else {
                fwrite($f, "ERROR en sqlsrv_execute: " . print_r(sqlsrv_errors(), true) . "\n");
            }
            // /* DATA HORAS INACTIVAS */

            //  INFORMACION GENERAL EN VOLETAS 
            $SQL_BOLETAS = sqlsrv_query($connARANDABD, "EXEC SP_INFODATA_ATENSUP $IDATEN");
            if ($SQL_BOLETAS && $DATA = sqlsrv_fetch_array($SQL_BOLETAS)) {

                $TIPOREGMC = $DATA['TIPOREGMC'] ?? null;
                switch ($TIPOREGMC) {
                    case 1:
                        $MEDIO_REPORTADO = 'Correo';
                        break;
                    case 2:
                        $MEDIO_REPORTADO = 'Llamada';
                        break;
                    case 3:
                        $MEDIO_REPORTADO = 'Integración FOD';
                        break;
                    default:
                        $MEDIO_REPORTADO = 'Usuario Speed-e';
                        break;
                }

                if (!empty($DATA['FCRECTONER']) && $DATA['FCRECTONER'] instanceof DateTime) {
                    $FECHA_CREACION = $DATA['FCRECTONER']->format('d/m/Y H:i');
                } else {
                    $FECHA_CREACION = 'Fecha no disponible';
                }

                if (!empty($DATA['fecha_coordinacion'])) {
                    $fechaOriginal = $DATA['fecha_coordinacion'];
                    $fecha = new DateTime($fechaOriginal);
                    $FECHA_COORDINACION = $fecha->format('d/m/Y H:i');
                } else {
                    $FECHA_COORDINACION = 'Fecha no disponible';
                }

                $MEDIO_VISITA = $DATA['medio_visita'] ?? 'No especificado';

                if (!empty($A['FREGISTRO'])) {
                    if ($A['FREGISTRO']) {
                        $FECHA_RECEPCION = $A['FREGISTRO']->format('d/m/Y H:i');
                    } else {
                        $FECHA_RECEPCION = 'Formato de fecha inválido';
                    }
                } else {
                    $FECHA_RECEPCION = 'Fecha no disponible';
                }
            } else {
                $MEDIO_REPORTADO = 'No disponible';
                $FECHA_CREACION = 'No disponible';
                $FECHA_COORDINACION = 'No disponible';
                $MEDIO_VISITA = 'No disponible';
                $FECHA_RECEPCION = 'No disponible';
            }
            //  INFORMACION GENERAL EN BOLETAS END

            $HTMLBOL = str_replace("%HORASINC%", $HORASINCHTML, $HTMLBOL);

            $IDMJPHTML = '';
            if ($IDCLIENTE == 2072) {
                $IDMJP = '';
                $SQLMJP = sqlsrv_query($connARANDABD, "SELECT CAMPOSTR FROM DATOS_ADICIONALES WITH(NOLOCK) WHERE TREGISTRO = 2 AND IDREGISTRO = ? AND IDCAMPO = 570", array($IDATEN));
                if ($SQLMJP !== false && ($RMJP = sqlsrv_fetch_array($SQLMJP))) {
                    $IDMJP = htmlspecialchars(utf8_encode($RMJP['CAMPOSTR']), ENT_QUOTES, 'UTF-8');
                }
                $IDMJPHTML = '<tr> <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" height="22" align="left" valign="middle"> <b><font face="Calibri">ID MJP:</font></b> </td><td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan="13" align="left" valign="middle"> <font face="Calibri" color="#000000">' . $IDMJP . '</font> </td></tr>';
            }
            $HTMLBOL = str_replace("%IDMJP%", $IDMJPHTML, $HTMLBOL);


            $HTMLBOL = str_replace("%MCR%", $MEDIO_REPORTADO, $HTMLBOL);
            $HTMLBOL = str_replace("%MVP%", $MEDIO_VISITA, $HTMLBOL);
            $HTMLBOL = str_replace("%frecepcion%", $FECHA_RECEPCION, $HTMLBOL);
            $HTMLBOL = str_replace("%fcreacion%", $FECHA_CREACION, $HTMLBOL);
            $HTMLBOL = str_replace("%fcoordinacion%", $FECHA_COORDINACION, $HTMLBOL);

            $HTMLBOL = str_replace("%IMGLOGO%", $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace("%Cliente%", $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%Institucion%", $NOMSEC, $HTMLBOL);
            $HTMLBOL = str_replace("%UNINEG%", $COMPANY, $HTMLBOL);
            $HTMLBOL = str_replace("%ENCABEZADO%", $ENCABEZADO, $HTMLBOL);
            $HTMLBOL = str_replace("%UNeA%", $UNeA, $HTMLBOL);
            $HTMLBOL = str_replace("%Codigo%", $CODPRE, $HTMLBOL);
            $HTMLBOL = str_replace("%Ubicacion%", $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace("%fini%", $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace("%ffin%", $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace("%Telefono%", $TELEFONO, $HTMLBOL);
            $HTMLBOL = str_replace("%tecn%", $TECNICO, $HTMLBOL);
            #$HTMLBOL=str_replace("%TIPOBOL%",$TBOL,$HTMLBOL);
            $HTMLBOL = str_replace("%TIPOBOL%", "Licitación:", $HTMLBOL);
            $HTMLBOL = str_replace("%lic%", $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace("%PROBLEMA%", $PROBLEMA_REP, $HTMLBOL);
            $HTMLBOL = str_replace("%CEDULATEC%", $CEDULATEC, $HTMLBOL);

            /*Si tiene atenciones relacionadas se aplica*/
            $SQLREL = sqlsrv_query($connARANDABD, "		SELECT
		CASE
		WHEN B.IDCLIENTE=1340 AND C.CAMPOSTR !='' THEN CONCAT('IDCC-',C.CAMPOSTR)
		ELSE CONCAT('AT-',A.IDAS)
		END RELACION,A.IDAS IDASACT FROM ATENCIONES_RELACION A WITH(NOLOCK)
		INNER JOIN ATENCIONES B WITH(NOLOCK) ON B.IDATENCION=A.IDAS
		LEFT JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = 2 AND C.IDREGISTRO = B.IDATENCION AND C.IDCAMPO = 75
		WHERE A.IDAP='$IDATEN'");
            $ATENCIONES = '';
            while ($sqlf = sqlsrv_fetch_array($SQLREL)) {
                $RELACION = $sqlf['RELACION'];
                $ATENCIONES .= $RELACION . ', ';
                $IDASACT = $sqlf['IDASACT'];

                if ($SEND == 1) {
                    $IDUSR = $_SESSION['IDU'];
                    if ($ATENC_PEND == 1) {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '20' WHERE IDATENCION = '$IDASACT'");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDASACT','2','183','20','$IDUSR'");
                    } else {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDASACT'");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDASACT','2','183','17','$IDUSR'");
                    }
                }
            }
            if ($ATENCIONES != '') {
                $ATENCIONES = rtrim($ATENCIONES, ', ');
                $SOLUCION .= '<br><b>Relaciones:</b> ' . $ATENCIONES;
            }

            if (($A['IDCLIENTE'] == 2066 || $A['IDCLIENTE'] == 448) && $A['FECHAFIRM'] != '' && $A['FFIRMATEC'] != '') {
                if ((((strtotime($A['FFIRMATEC']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) > 10 ||
                    ((strtotime($A['FECHAFIRM']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) > 10)  && $A['JUSTFFIRMA'] != '') {
                    $SOLUCION .= '<br><b>¿Porque la fecha y hora de firma supera los 10 minutos despues de la fecha y hora de salida?: </b> ' . $A['JUSTFFIRMA'];
                }
            }

            $HTMLBOL = str_replace("%SOLUCION%", $SOLUCION, $HTMLBOL);
            $HTMLBOL = str_replace("%NOMUSRAUT%", $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace("%CEDULA%", $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace("%FECHAFIRMA%", $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace("%FIRMA%", $FIRMAUSR, $HTMLBOL);

            $HTMLBOL = str_replace("%FECHAFIRMATEC%", $FFIRMATEC, $HTMLBOL);
            $HTMLBOL = str_replace("%FIRMATEC%", $FIRMATEC, $HTMLBOL);

            $HTMLBOL = str_replace("%Bol%", $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%TITULO%", $IDATEN . " - " . $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%RepCEO%", "AT-" . $IDATENCION, $HTMLBOL);
            $HTMLBOL = str_replace("%Bol%", $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%Marca%", $MARCA, $HTMLBOL);
            $HTMLBOL = str_replace("%Modelo%", $MODELO, $HTMLBOL);
            $HTMLBOL = str_replace("%Prod%", $PRODUCTO, $HTMLBOL);
            $HTMLBOL = str_replace("%Serie%", $SERIE, $HTMLBOL);
            $HTMLBOL = str_replace("%Activo%", $PLACA, $HTMLBOL);
            $HTMLBOL = str_replace("%RepC%", $REPCLIENTE, $HTMLBOL);

            if ($SERIE_CORRESP == 1) {
                $HTMLBOL = str_replace("%SERIER1%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%SERIER2%", "  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%SERIER1%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%SERIER2%", "X", $HTMLBOL);
            }

            if ($REALIZA_UEFI == 1) {
                $HTMLBOL = str_replace("%UEFI1%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%UEFI2%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%NO%", "", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%UEFI1%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%UEFI2%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%NO%", "¿Por qué no? " . $XQ_UEFI, $HTMLBOL);
            }

            $HTMLBOL = str_replace("%Error%", $COD_ERROR, $HTMLBOL);

            if ($ACT_BIOS == 1) {
                $HTMLBOL = str_replace("%BACT%", "X", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%BACT%", "  ", $HTMLBOL);
            }

            $HTMLBOL = str_replace("%ver%", $VER_BIOS, $HTMLBOL);

            if ($FIRM_CHIPS == 1) {
                $HTMLBOL = str_replace("%cfirmact%", "X", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%cfirmact%", "  ", $HTMLBOL);
            }

            if ($ACT_DRIV == 1) {
                $HTMLBOL = str_replace("%dract%", "X", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%dract%", "  ", $HTMLBOL);
            }

            if ($SOFT_HARD == "Software") {
                $HTMLBOL = str_replace("%soft%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%hard%", "  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%soft%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%hard%", "X", $HTMLBOL);
            }

            if ($IDCLIENTE != 1340) {
                if ($DANO_FIS == 1) {
                    $HTMLBOL = str_replace("%daño1%", "X", $HTMLBOL);
                    $HTMLBOL = str_replace("%daño2%", "  ", $HTMLBOL);
                } else {
                    $HTMLBOL = str_replace("%daño1%", "  ", $HTMLBOL);
                    $HTMLBOL = str_replace("%daño2%", "X", $HTMLBOL);
                }
            } else {
                $HTMLBOL = str_replace('%DISDF%', "display:none;", $HTMLBOL);
            }


            if ($ATENC_PEND == 1) {
                $HTMLBOL = str_replace("%Incidente1%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%Incidente2%", "  ", $HTMLBOL);

                $CONSULTAMOTIVO = sqlsrv_query($connARANDABD, "EXEC SP_INFODATA_ATENTEC $IDATENCION,1");
                $datamotivo = sqlsrv_fetch_array($CONSULTAMOTIVO);
                $motivo = $datamotivo['motivo'];

                $HTMLBOL = str_replace("%MOTIVOPENDIENTE%", "
  <tr>
    <td style=\"border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;\" height=\"21\" align=\"left\" valign=\"top\">
      <b><font face=\"Calibri\">Motivo de caso pendiente: </font></b>
    </td>
    <td style=\"border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;\" colspan=\"13\" align=\"left\" valign=\"middle\"> $motivo </td>
  </tr>
  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%Incidente1%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%Incidente2%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%MOTIVOPENDIENTE%", '', $HTMLBOL);
            }

            $SQL = sqlsrv_query($connARANDABD, "SELECT RET_SPARE,RET_CT,RET_DFPRT,RET_ESTPRT,INS_SPARE,INS_CT,B.NOMCAT LVL1,C.NOMCAT LVL2,D.NOMCAT LVL3 FROM SPEEDY_SOLTEC A WITH(NOLOCK)
LEFT JOIN SPEEDE_SOLTEC_CAT1 B WITH(NOLOCK) ON B.IDU = A.CATLVL1
LEFT JOIN SPEEDE_SOLTEC_CAT2 C WITH(NOLOCK) ON C.IDU_CAT1 = B.IDU and C.ESTADO = 1 AND C.IDU = A.CATLVL2
LEFT JOIN SPEEDE_SOLTEC_CAT3 D WITH(NOLOCK) ON D.IDU_CAT2 = C.IDU and D.ESTADO = 1 AND D.IDU = A.CATLVL3
WHERE IDATEN='$IDATEN' AND RET_ESTPRT != 'DOA' AND CATLVL1 != '' AND CATLVL2 != '' AND CATLVL3 != ''");

            $PRTSINS = '
<table cellspacing="0" cellpadding="2" border="0" width="100%">
  <thead>
    <tr>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Parte Instalada Cliente</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Spare</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">CT</font></b></th>
    </tr>
  </thead>
  <tbody>';

            $PRTSRET = '
<table cellspacing="0" cellpadding="2" border="0" width="100%">
  <thead>
    <tr>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Partes a devolver</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Spare</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">CT</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">Estado</font></b></th>
    </tr>
  </thead>
<tbody>';

            while ($A = sqlsrv_fetch_array($SQL)) {
                $LVL1 = utf8_encode($A['LVL1']);
                $LVL2 = utf8_encode($A['LVL2']);
                $LVL3 = utf8_encode($A['LVL3']);
                $RET_SPARE = $A['RET_SPARE'];
                $RET_CT = $A['RET_CT'];
                $RET_DFPRT = $A['RET_DFPRT'];
                $RET_ESTPRT = $A['RET_ESTPRT'];
                $INS_SPARE = $A['INS_SPARE'];
                $INS_CT = $A['INS_CT'];

                $PRTSINS .= '<tr>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $LVL3 . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $INS_SPARE . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $INS_CT . '</font></td>
  </tr>';

                $PRTSRET .= '<tr>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . "$LVL1 / $LVL2 / $LVL3" . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_SPARE . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_CT . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_ESTPRT . '</font></td>
  </tr>';
            }

            $PRTSINS .= '</tbody></table>';
            $PRTSRET .= '</tbody></table>';

            $HTMLBOL = str_replace("%PRTSINS%", $PRTSINS, $HTMLBOL);
            $HTMLBOL = str_replace("%PRTSRET%", $PRTSRET, $HTMLBOL);

            $fh = fopen("D:/SpeedyFiles/Boletas/MNTCOR/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {

                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/MNTCOR/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'MNTCOR');

                if ($RESP == 'Correo Enviado') {
                    if ($IDCLIENTE != 1340) {
                        EnviarEncuesta($IDATEN, $connARANDABD);
                    }
                    if ($ATENC_PEND == 1) {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '20' WHERE IDATENCION = '$IDATEN'");
                        $IDUSR = $_SESSION['IDU'];
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','20','$IDUSR'");
                    } else {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                        $IDUSR = $_SESSION['IDU'];
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
                    }
                }
            }


        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/MNTCOR/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php

        } else if (($IDSERV == 11 && $TIPOATENCION == 8 && $SUBTIPOATENCION == 1) || ($IDSERV == 11 && $TIPOATENCION == 8 && $SUBTIPOATENCION == 2) || ($IDSERV == 11 && $TIPOATENCION == 8 && $SUBTIPOATENCION == 4)) {
            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '6'");
            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);
            // <!-- COPIAR A PRODUCTIVO TRANSPORTES -->
            $SQL = sqlsrv_query($connARANDABD, "SELECT A.IDCLIENTE,Q.CAMPOINT CUENTASEC,CASE
   WHEN USU2N.UNAME IS NOT NULL THEN USU2N.UNAME
   WHEN NUSERP2.new_contactid IS NOT NULL THEN NUSERP2.new_contactid COLLATE SQL_Latin1_General_CP1_CI_AS
   WHEN NEWUSER2.CAMPOSTR IS NOT NULL THEN NEWUSER2.CAMPOSTR
   END CONTACT2,TELE1.CAMPOSTR TELE1,TELE2.CAMPOSTR TELE2,C.CAMPOSTR LICIT,
  CASE
  WHEN VEN.COMPANY IS NOT NULL THEN VEN.COMPANY
  ELSE PROVEEDOR.new_name COLLATE SQL_Latin1_General_CP1_CI_AS
  END CLIENTE, B.CAMPOSTR BOLETA, D.CAMPOSTR NUSUARIO, E.CAMPOSTR UBIC,
    TEC.UNAME TECNICO,FFIN.CAMPODATE FECHAFIN,ATRN.UNAME AUTOR,FECREQ.CAMPODATE FECREQ, I.CAMPOSTR OBSERV, H.CAMPOSTR CEDULA, FIRM.SRCFIRMA FIRMAUSR,
     LCLI.IMGCLIENTE IMGLOGO,A.FREGISTRO,
     CASE
   WHEN USUN.UNAME IS NOT NULL THEN USUN.UNAME
   WHEN NUSERP.new_contactid IS NOT NULL THEN NUSERP.new_contactid COLLATE SQL_Latin1_General_CP1_CI_AS
   WHEN NEWUSER1.CAMPOSTR IS NOT NULL THEN NEWUSER1.CAMPOSTR
   END CONTACT1, PROV.new_name PROV, FIRM.FECHA FECHAFIRM,
   CANT.new_name CANT,
     CASE
     WHEN PRI.CAMPOINT  = 1 THEN 'Alta'
     WHEN PRI.CAMPOINT  = 2 THEN 'Baja'
     END PRIORIDAD, O.CAMPOINT COMPANY,CSEC.NOMSEC,CSEC.CODPRE,A.DESCRI,DOCT.CAMPOSTR DOCT,
     CASE
     WHEN TIPODOC.CAMPOINT  = 1 THEN 'albaran'
     WHEN TIPODOC.CAMPOINT  = 2 THEN 'factura de venta'
     WHEN TIPODOC.CAMPOINT  = 3 THEN 'prestamo'
     END TIPODOC,ISNULL(dbo.Get_AddValueINT('2',ATEREL.IDREGISTRO, '209'),'0') RATE,A.FCIERRE,PAIS.CAMPOSTR as PAIS
    FROM ATENCIONES A WITH(NOLOCK)
    INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
    INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
    LEFT JOIN DATOS_ADICIONALES TB WITH(NOLOCK) ON TB.TREGISTRO = '2' AND TB.IDREGISTRO = A.IDATENCION AND TB.IDCAMPO = 68  --Tipo de Boleta
    INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
    INNER JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.TREGISTRO = '2' AND E.IDREGISTRO = A.IDATENCION AND E.IDCAMPO = 3   --Ubicacion
    INNER JOIN DATOS_ADICIONALES H WITH(NOLOCK) ON H.TREGISTRO = '2' AND H.IDREGISTRO = A.IDATENCION AND H.IDCAMPO = 40  --Cedula
    INNER JOIN DATOS_ADICIONALES I WITH(NOLOCK) ON I.TREGISTRO = '2' AND I.IDREGISTRO = A.IDATENCION AND I.IDCAMPO = 42  --Observaciones
    LEFT JOIN DATOS_ADICIONALES TELE1 WITH (NOLOCK) ON TELE1.TREGISTRO = '2' AND TELE1.IDREGISTRO = A.IDATENCION AND TELE1.IDCAMPO = 120 -- Telefono 1
    LEFT JOIN USUARIOS USUN WITH (NOLOCK) ON USUN.CODUSUARIO = A.IDUSR -- Usuario 1
  LEFT JOIN DATOS_ADICIONALES USU2 WITH (NOLOCK) ON USU2.TREGISTRO = '2' AND USU2.IDREGISTRO = A.IDATENCION AND USU2.IDCAMPO = 121 -- Usuario 2
  LEFT JOIN USUARIOS USU2N WITH (NOLOCK) ON USU2N.CODUSUARIO = USU2.CAMPOINT -- Usuario 2
  LEFT JOIN DATOS_ADICIONALES TELE2 WITH (NOLOCK) ON TELE2.TREGISTRO = '2' AND TELE2.IDREGISTRO = A.IDATENCION AND TELE2.IDCAMPO = 125 -- Telefono 2
    LEFT JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
    INNER JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
    INNER JOIN USUARIOS TEC WITH(NOLOCK) ON TEC.CODUSUARIO = CASO.IDTECNICO -- Tecnico
    LEFT JOIN FIRMAS FIRM WITH(NOLOCK) ON FIRM.IDATEN = A.IDATENCION -- FIRMA
    LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
    LEFT JOIN DATOS_ADICIONALES Q WITH(NOLOCK) ON Q.TREGISTRO = '2' AND Q.IDREGISTRO = A.IDATENCION AND Q.IDCAMPO = 43  --Cuenta Secundaria
    LEFT JOIN SECUNDARIAS CSEC WITH(NOLOCK) ON CSEC.IDU = Q.CAMPOINT
    LEFT JOIN DATOS_ADICIONALES PRI WITH (NOLOCK) ON PRI.TREGISTRO = '2' AND PRI.IDREGISTRO = A.IDATENCION AND PRI.IDCAMPO = 122 -- Prioridad
    LEFT JOIN DATOS_ADICIONALES FECREQ WITH (NOLOCK) ON FECREQ.TREGISTRO = '2' AND FECREQ.IDREGISTRO = A.IDATENCION AND FECREQ.IDCAMPO = 124 -- Fecha REQ
    LEFT JOIN DATOS_ADICIONALES ATR WITH (NOLOCK) ON ATR.TREGISTRO = '2' AND ATR.IDREGISTRO = A.IDATENCION AND ATR.IDCAMPO = 123 -- Autor
    LEFT JOIN DATOS_ADICIONALES TIPODOC WITH (NOLOCK) ON TIPODOC.TREGISTRO = '2' AND TIPODOC.IDREGISTRO = A.IDATENCION AND TIPODOC.IDCAMPO = 133 -- TIPODOC
    LEFT JOIN DATOS_ADICIONALES DOCT WITH (NOLOCK) ON DOCT.TREGISTRO = '2' AND DOCT.IDREGISTRO = A.IDATENCION AND DOCT.IDCAMPO = 134 -- DOCT
    LEFT JOIN USUARIOS ATRN WITH (NOLOCK) ON ATRN.CODUSUARIO = ATR.CAMPOINT
  LEFT JOIN DATOS_ADICIONALES FFIN WITH (NOLOCK) ON FFIN.TREGISTRO = '2' AND FFIN.IDREGISTRO = A.IDATENCION AND FFIN.IDCAMPO = 5 -- Fecha Fin
    INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
    INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
    LEFT JOIN DATOS_ADICIONALES CPROV WITH (NOLOCK) ON CPROV.TREGISTRO = '2' AND CPROV.IDREGISTRO = A.IDATENCION AND CPROV.IDCAMPO = 116 --Codigo Provincia
    LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].[dbo].[new_provinceBase] PROV WITH(NOLOCK) ON PROV.new_provinceId=CPROV.CAMPOSTR -- Provincia
    LEFT JOIN DATOS_ADICIONALES CCANT WITH (NOLOCK) ON CCANT.TREGISTRO = '2' AND CCANT.IDREGISTRO = A.IDATENCION AND CCANT.IDCAMPO = 117 --Codigo Canton
  LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].[dbo].[new_countyBase] CANT WITH(NOLOCK) ON CANT.new_countyId=CCANT.CAMPOSTR -- Canton
    LEFT JOIN DATOS_ADICIONALES CPROVE WITH(NOLOCK) ON CPROVE.IDREGISTRO=A.IDATENCION AND CPROVE.TREGISTRO=2 AND CPROVE.IDCAMPO=178
    LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerBase PROVEEDOR WITH(NOLOCK) ON CONVERT(VARCHAR(100),PROVEEDOR.new_providerId)=CPROVE.CAMPOSTR
    LEFT JOIN DATOS_ADICIONALES USERPROV WITH(NOLOCK) ON USERPROV.IDREGISTRO=A.IDATENCION AND USERPROV.TREGISTRO=2 AND USERPROV.IDCAMPO=180
    LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerbusinessunitBase NUSERP WITH(NOLOCK) ON CONVERT(VARCHAR(100), NUSERP.new_providerbusinessunitId)=USERPROV.CAMPOSTR
      LEFT JOIN DATOS_ADICIONALES USERPROV2 WITH(NOLOCK) ON USERPROV2.IDREGISTRO=A.IDATENCION AND USERPROV2.TREGISTRO=2 AND USERPROV2.IDCAMPO=181
    LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerbusinessunitBase NUSERP2 WITH(NOLOCK) ON CONVERT(VARCHAR(100), NUSERP2.new_providerbusinessunitId)=USERPROV2.CAMPOSTR
  LEFT JOIN DATOS_ADICIONALES NEWUSER1 WITH (NOLOCK) ON NEWUSER1.TREGISTRO = '2' AND NEWUSER1.IDREGISTRO = A.IDATENCION AND NEWUSER1.IDCAMPO = 198 -- Nuevo Usuario 1
  LEFT JOIN DATOS_ADICIONALES NEWUSER2 WITH (NOLOCK) ON NEWUSER2.TREGISTRO = '2' AND NEWUSER2.IDREGISTRO = A.IDATENCION AND NEWUSER2.IDCAMPO = 199 -- Nuevo Usuario 2
  LEFT JOIN DATOS_ADICIONALES ATEREL WITH(NOLOCK) ON ATEREL.TREGISTRO = '2' AND ATEREL.CAMPOINT = A.IDATENCION AND ATEREL.IDCAMPO = 193  --Atencion Relacionada
  LEFT JOIN DATOS_ADICIONALES PAIS WITH(NOLOCK) ON PAIS.TREGISTRO = '2' AND PAIS.IDREGISTRO = A.IDATENCION AND PAIS.IDCAMPO = 115  --PAIS
    WHERE A.IDATENCION = '$IDATEN'");
            // <!-- FIN TRANSPORTES -->

            $A = sqlsrv_fetch_array($SQL);
            $RATE = $A['RATE'];

            $IDCLIENTE = $A['IDCLIENTE'];
            $CONTACTO1 = utf8_encode($A['CONTACT1']);
            $TEL1 = $A['TELE1'];
            $CONTACTO2 = utf8_encode($A['CONTACT2']);
            $TEL2 = $A['TELE2'];
            $CLIENTE = utf8_encode($A['CLIENTE']);
            if ($CLIENTE == '') {
                trigger_error("Debe llenar el cliente", E_USER_ERROR);
            }
            $NOMSEC = utf8_encode($A['NOMSEC']);
            $CLIENTE .= ' ' . $NOMSEC;
            $BOLETA = $A['BOLETA'];
            $DIRECCION = utf8_encode($A['UBIC']);

            $FECHAFIRM = $A['FECHAFIRM'];
            if ($RATE == '1') {
                if ($FECHAFIRM != null) {
                    $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');
                }
            }

            $NUSUARIO = utf8_encode($A['NUSUARIO']);
            $FECREQ = $A['FECREQ'];
            if ($FECREQ != '') {
                $FECREQ = $FECREQ->format('d/m/Y H:i:s');
            }

            $FCIERRE = $A['FCIERRE'];
            if ($FCIERRE != '') {
                $FCIERRE = $FCIERRE->format('d/m/Y H:i:s');
            }

            $FREGISTRO = $A['FREGISTRO'];
            if ($FREGISTRO != '') {
                $FREGISTRO = $FREGISTRO->format('d/m/Y H:i:s');
            }

            $IMGLOGO = $A['IMGLOGO'];
            $PROV = utf8_encode($A['PROV']);
            $CANT = utf8_encode($A['CANT']);
            $PRIORIDAD = $A['PRIORIDAD'];
            $DOCT = $A['DOCT'];

            $SQLD = sqlsrv_query($connARANDABD, "SELECT DOC FROM DOCUMENTOS_TRANSPORTES A WITH(NOLOCK)
WHERE A.IDATENCION='$IDATEN'");
            $DOCUMENTOS = '';
            while ($DOCS = sqlsrv_fetch_array($SQLD)) {
                $DOCUMENTOS .= $DOCS['DOC'] . ', ';
            }
            $DOCUMENTOS = trim($DOCUMENTOS, ', ');

            if ($DOCUMENTOS != '') {
                $DOCT = $DOCUMENTOS;
            }

            $TIPODOC = utf8_encode($A['TIPODOC']);

            $COMPANY = $A['COMPANY'];
            $PAIS = $A['PAIS'];
            if ($COMPANY == -1 && $PAIS == 'C0E2E77E-ABAD-E611-80C4-005056815852' || $PAIS == null) {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono : +506 2106-4500 <br> Apartado Postal: 3653-1000 San José, Costa Rica";
            } else if ($COMPANY == -6 || $PAIS == 'C4E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "PBX (502) 22794000, (502) 54296366 <br> 5 avenida 5-55 zona 14, Europlaza World Business Center, torre 4 nivel 7 oficina 701.";
                $UNeA = "CEO";
            } else if ($COMPANY == -7 || $PAIS == 'CAE2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono: +507 387-4158 / 59 <br> Calle Punta Darién, Punta Pacífica, P.H Torre de las Américas, Torre C, Piso 18, Ofic. 1804 C, Corregimiento de San Francisco, Ciudad de Panamá.";
                $UNeA = "CEO";
            } else if ($COMPANY == -8 || $PAIS == 'C2E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +503 $2283-9498 <br> Calle el Mirador entre la 87 y 89 avenida norte, nivel 12 oficina -4 Torre Futura, Colonia Escalón San Salvador.";
                $UNeA = "CEO";
            } else if ($COMPANY == -9 || $PAIS == 'C8E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "CORPORACION EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +505 2231-3127 <br> Edificio Escala Piso # Nueve, modulo G, Pista Jean Paul Genie.";
                $UNeA = "CEO";
            } else if ($COMPANY == -10 || $PAIS == 'C6E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +504 2242-6201 <br> Torre Agalta , piso 11, local 1117, Tegucigalpa, Honduras.";
                $UNeA = "CEO";
            } else if ($COMPANY == -3) {
                $COMPANY = "ATI CAPITAL SOLUTIONS S.A.";
                $ENCABEZADO = "";
            } else if ($COMPANY == -4) {
                $COMPANY = "SISTEMAS CONVERGENTES S.A.";
                $ENCABEZADO = "Teléfono : (506) 2280-3355 <br> Apartado Postal: 236-1100 Tibás, San José, Costa Rica";
            } else if ($COMPANY == -5) {
                $COMPANY = "NOVA TECHNOLOGIES S.A.";
                $ENCABEZADO = "";
            }
            $DESCRI = utf8_encode($A['DESCRI']);
            $DESCRI = str_replace('\n', "<br>", $DESCRI);
            $OBSERV = utf8_encode($A['OBSERV']);
            $OBSERV = str_replace('\n', "<br>", $OBSERV);

            $AUTOR = utf8_encode($A['AUTOR']);
            $CEDULA = $A['CEDULA'];



            $HTMLBOL = str_replace("Cliente:", 'Cliente / Proveedor:', $HTMLBOL);
            $HTMLBOL = str_replace("%LOGO_ORBE%", $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace("%CLIENTE%", $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%UNINEG%", $COMPANY, $HTMLBOL);
            $HTMLBOL = str_replace("%ENCABEZADO%", $ENCABEZADO . '<br>Boleta No.<font color="red"> ' . $BOLETA . '</font>', $HTMLBOL);
            $HTMLBOL = str_replace("%IDATENC%", 'AT-' . $IDATEN, $HTMLBOL);
            $HTMLBOL = str_replace("%FSOL%", $FREGISTRO, $HTMLBOL);
            $HTMLBOL = str_replace("%PRIO%", $PRIORIDAD, $HTMLBOL);
            $HTMLBOL = str_replace("%SOLIC%", $AUTOR, $HTMLBOL);
            $HTMLBOL = str_replace("%FREQ%", $FECREQ, $HTMLBOL);
            $HTMLBOL = str_replace("%CONT1%", $CONTACTO1, $HTMLBOL);
            $HTMLBOL = str_replace("%CONT2%", $CONTACTO2, $HTMLBOL);
            $HTMLBOL = str_replace("%TEL1%", $TEL1, $HTMLBOL);
            $HTMLBOL = str_replace("%TEL2%", $TEL2, $HTMLBOL);
            //$HTMLBOL=str_replace("%PAIS%",$PAIS,$HTMLBOL);
            $HTMLBOL = str_replace("%PROV%", $PROV, $HTMLBOL);
            $HTMLBOL = str_replace("%CANT%", $CANT, $HTMLBOL);
            $HTMLBOL = str_replace("%DIR%", $DIRECCION, $HTMLBOL);

            if ($FECHAFIRM != '' && $RATE == '1') {
                $HTMLBOL = str_replace("%FECHAFIRMA%", $FECHAFIRM, $HTMLBOL);
            }

            if ($SEND == 1 && $RATE == '0') {
                $IDUSR = $_SESSION['IDU'];
                if ($FCIERRE == '') {
                    sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '312', FCIERRE=GETDATE() WHERE IDATENCION = '$IDATEN'");
                } else {
                    sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '312' WHERE IDATENCION = '$IDATEN'");
                }
                sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','312','$IDUSR'");

                $FCIERRE2 = sqlsrv_query($connARANDABD, "SELECT FCIERRE FROM ATENCIONES WHERE IDATENCION='$IDATEN'");
                $A = sqlsrv_fetch_array($FCIERRE2);
                $FECHACIERRE = $A['FCIERRE'];
                if ($FECHACIERRE != '') {
                    $FECHACIERRE2 = $FECHACIERRE->format("Y-m-d H:i:s");
                    $FECHACIERRE = $FECHACIERRE->format('d/m/Y H:i:s');
                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_DATE '$IDATEN','2','4','$FECHACIERRE2','1'");
                }
                $FCIERRE = $FECHACIERRE;
                $HTMLBOL = str_replace("%FECHAFIRMA%", $FCIERRE, $HTMLBOL);
            }

            if ($FCIERRE == '' && $RATE == '0') {
                $HTMLBOL = str_replace("%FECHAFIRMA%", '<p style="color:red;">Cambiara a la fecha y hora enviada la boleta.</p>', $HTMLBOL);
            } else if ($RATE == '0') {
                $HTMLBOL = str_replace("%FECHAFIRMA%", $FCIERRE, $HTMLBOL);
            }

            //  $HTMLBOL=str_replace("%FIRMA%",$FIRMAUSR,$HTMLBOL);
            $HTMLBOL = str_replace("%NOMUSRAUT%", $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace("%TITULO%", $IDATEN . " - " . $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%SERV%", $NTATENCION, $HTMLBOL);
            $HTMLBOL = str_replace("%TSERV%", $NSERV, $HTMLBOL);
            $HTMLBOL = str_replace("%Observ%", $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace("%FREQ%", $FECREQ, $HTMLBOL);
            $HTMLBOL = str_replace("%DESC%", $DESCRI, $HTMLBOL);
            $HTMLBOL = str_replace("%CEDULA%", $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace("%REF%", $DOCT, $HTMLBOL);
            $HTMLBOL = str_replace("%TIPODOC%", $TIPODOC, $HTMLBOL);



            $fh = fopen("D:/SpeedyFiles/Boletas/TRANSPORTE/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($RATE == '1') {
                $ATENCION_TONER = BoletaToner($IDATEN, $connARANDABD, '0');
                $ATENCION_TONER = explode('/', $ATENCION_TONER);
                $BOLETA_TNR = $ATENCION_TONER[1];
                $IDATENCION_TNR = $ATENCION_TONER[0];
            }
            // IDATENCION/BOLETA

            if ($SEND == 1) {
                if ($IDATENCION_TNR != '' && $RATE == '1') {
                    $Archivo2 = fopen("D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html", "r");
                    $RArchivo2 =  fread($Archivo2, filesize("D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html"));
                    $RESP = EnviarCorreo($RArchivo2, "D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html", $IDATENCION_TNR, $connARANDABD, 'TNR');
                    if ($RESP == 'Correo Enviado') {
                        sqlsrv_query($connARANDABD, "INSERT INTO STO_BOLETAS VALUES ((SELECT ISNULL(MAX(IDU),0)+1 FROM STO_BOLETAS),'$IDATEN','$IDCLIENTE','$CUENTASEC','$BOLETA','https://ti-obgroup.app:5557/SpeedyFiles/Boletas/TRANSPORTE/$IDATEN - $BOLETA.html','0')");
                        sqlsrv_query($connARANDABD, "DECLARE @FECHAHOY DATETIME=GETDATE() EXEC SP_INS_DATA_DATE '$IDATEN','2','176',@FECHAHOY,'1'");
                    }
                } else {
                    $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/TRANSPORTE/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'TRANSPORTE');
                }
                if ($RESP == 'Correo Enviado') {
                    sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '312', FCIERRE=GETDATE() WHERE IDATENCION = '$IDATEN'");
                    $IDUSR = $_SESSION['IDU'];
                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','312','$IDUSR'");
                    $FCIERRE2 = sqlsrv_query($connARANDABD, "SELECT FCIERRE FROM ATENCIONES WHERE IDATENCION='$IDATEN'");
                    $A = sqlsrv_fetch_array($FCIERRE2);
                    $FECHACIERRE = $A['FCIERRE'];
                    if ($FECHACIERRE != '') {
                        $FECHACIERRE2 = $FECHACIERRE->format("Y-m-d H:i:s");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_DATE '$IDATEN','2','4','$FECHACIERRE2','1'");
                    }
                    if ($IDATENCION_TNR != '') {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '312', FCIERRE='$FECHACIERRE2' WHERE IDATENCION = '$IDATENCION_TNR'");
                        if ($FECHACIERRE != '') {
                            sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_DATE '$IDATENCION_TNR','2','4','$FECHACIERRE2','1'");
                        }
                    }
                }
            }
            //echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/REEQFOD/$IDATEN - $BOLETA.html";

        ?>
            <script>
                <?php if ($IDATENCION_TNR != '' && $RATE == '1') {
                ?>
                    $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/TNR/<?php echo $IDATENCION_TNR; ?> - <?php echo $BOLETA_TNR; ?>.html");
                    $('#downBoleta')[0].click();
                <?php
                } else {
                ?>
                    $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/TRANSPORTE/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                    $('#downBoleta')[0].click();
                <?php
                } ?>

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                        if ($SUBTIPOATENCION == 2 || $SUBTIPOATENCION == 4) {
                            if ($IDCLIENTE != 1340 && $RESP == 'Correo Enviado') {
                                EnviarEncuesta($IDATEN, $connARANDABD);
                            }
                        }
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php
        } else if ($IDSERV == 11 && $TIPOATENCION == 9) {
            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '9'");
            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);

            //COPIAR A PRODUCTIVO
            $SQL = sqlsrv_query($connARANDABD, "SELECT A.IDCLIENTE,Q.CAMPOINT CUENTASEC ,CASE
   WHEN USU2N.UNAME IS NOT NULL THEN USU2N.UNAME
   WHEN NUSERP2.new_contactid IS NOT NULL THEN NUSERP2.new_contactid COLLATE SQL_Latin1_General_CP1_CI_AS
   WHEN NEWUSER2.CAMPOSTR IS NOT NULL THEN NEWUSER2.CAMPOSTR
   END CONTACT2,TELE1.CAMPOSTR TELE1,TELE2.CAMPOSTR TELE2,C.CAMPOSTR LICIT,
  CASE
  WHEN VEN.COMPANY IS NOT NULL THEN VEN.COMPANY
  ELSE PROVEEDOR.new_name COLLATE SQL_Latin1_General_CP1_CI_AS
  END CLIENTE, B.CAMPOSTR BOLETA, D.CAMPOSTR NUSUARIO, E.CAMPOSTR UBIC,
    TEC.UNAME TECNICO,FFIN.CAMPODATE FECHAFIN,ATRN.UNAME AUTOR,FECREQ.CAMPODATE FECREQ, I.CAMPOSTR OBSERV, H.CAMPOSTR CEDULA, FIRM.SRCFIRMA FIRMAUSR,
     LCLI.IMGCLIENTE IMGLOGO,A.FREGISTRO,
     CASE
   WHEN USUN.UNAME IS NOT NULL THEN USUN.UNAME
   WHEN NUSERP.new_contactid IS NOT NULL THEN NUSERP.new_contactid COLLATE SQL_Latin1_General_CP1_CI_AS
   WHEN NEWUSER1.CAMPOSTR IS NOT NULL THEN NEWUSER1.CAMPOSTR
   END CONTACT1, PROV.new_name PROV, FIRM.FECHA FECHAFIRM, CANT.new_name CANT,
     CASE
     WHEN PRI.CAMPOINT  = 1 THEN 'Alta'
     WHEN PRI.CAMPOINT  = 2 THEN 'Baja'
     END PRIORIDAD, O.CAMPOINT COMPANY,CSEC.NOMSEC,CSEC.CODPRE,A.DESCRI,ISNULL(dbo.Get_AddValueINT('2',ATEREL.IDREGISTRO, '209'),'0') RATE,PAIS.CAMPOSTR as PAIS
    FROM ATENCIONES A WITH(NOLOCK)
    INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
    INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
    LEFT JOIN DATOS_ADICIONALES TB WITH(NOLOCK) ON TB.TREGISTRO = '2' AND TB.IDREGISTRO = A.IDATENCION AND TB.IDCAMPO = 68  --Tipo de Boleta
    INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
    INNER JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.TREGISTRO = '2' AND E.IDREGISTRO = A.IDATENCION AND E.IDCAMPO = 3   --Ubicacion
    INNER JOIN DATOS_ADICIONALES H WITH(NOLOCK) ON H.TREGISTRO = '2' AND H.IDREGISTRO = A.IDATENCION AND H.IDCAMPO = 40  --Cedula
    INNER JOIN DATOS_ADICIONALES I WITH(NOLOCK) ON I.TREGISTRO = '2' AND I.IDREGISTRO = A.IDATENCION AND I.IDCAMPO = 42  --Observaciones
    LEFT JOIN DATOS_ADICIONALES TELE1 WITH (NOLOCK) ON TELE1.TREGISTRO = '2' AND TELE1.IDREGISTRO = A.IDATENCION AND TELE1.IDCAMPO = 120 -- Telefono 1
    LEFT JOIN USUARIOS USUN WITH (NOLOCK) ON USUN.CODUSUARIO = A.IDUSR -- Usuario 1
  LEFT JOIN DATOS_ADICIONALES USU2 WITH (NOLOCK) ON USU2.TREGISTRO = '2' AND USU2.IDREGISTRO = A.IDATENCION AND USU2.IDCAMPO = 121 -- Usuario 2
  LEFT JOIN USUARIOS USU2N WITH (NOLOCK) ON USU2N.CODUSUARIO = USU2.CAMPOINT -- Usuario 2
  LEFT JOIN DATOS_ADICIONALES TELE2 WITH (NOLOCK) ON TELE2.TREGISTRO = '2' AND TELE2.IDREGISTRO = A.IDATENCION AND TELE2.IDCAMPO = 125 -- Telefono 2
    LEFT JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
    INNER JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
    INNER JOIN USUARIOS TEC WITH(NOLOCK) ON TEC.CODUSUARIO = CASO.IDTECNICO -- Tecnico
    left JOIN FIRMAS FIRM WITH(NOLOCK) ON FIRM.IDATEN = A.IDATENCION -- FIRMA
    LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
    LEFT JOIN DATOS_ADICIONALES Q WITH(NOLOCK) ON Q.TREGISTRO = '2' AND Q.IDREGISTRO = A.IDATENCION AND Q.IDCAMPO = 43  --Cuenta Secundaria
    LEFT JOIN SECUNDARIAS CSEC WITH(NOLOCK) ON CSEC.IDU = Q.CAMPOINT
    LEFT JOIN DATOS_ADICIONALES PRI WITH (NOLOCK) ON PRI.TREGISTRO = '2' AND PRI.IDREGISTRO = A.IDATENCION AND PRI.IDCAMPO = 122 -- Prioridad
    LEFT JOIN DATOS_ADICIONALES FECREQ WITH (NOLOCK) ON FECREQ.TREGISTRO = '2' AND FECREQ.IDREGISTRO = A.IDATENCION AND FECREQ.IDCAMPO = 124 -- Fecha REQ
    LEFT JOIN DATOS_ADICIONALES ATR WITH (NOLOCK) ON ATR.TREGISTRO = '2' AND ATR.IDREGISTRO = A.IDATENCION AND ATR.IDCAMPO = 123 -- Autor
    LEFT JOIN USUARIOS ATRN WITH (NOLOCK) ON ATRN.CODUSUARIO = ATR.CAMPOINT
  LEFT JOIN DATOS_ADICIONALES FFIN WITH (NOLOCK) ON FFIN.TREGISTRO = '2' AND FFIN.IDREGISTRO = A.IDATENCION AND FFIN.IDCAMPO = 5 -- Fecha Fin
    INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
    INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
    LEFT JOIN DATOS_ADICIONALES CPROV WITH (NOLOCK) ON CPROV.TREGISTRO = '2' AND CPROV.IDREGISTRO = A.IDATENCION AND CPROV.IDCAMPO = 116 --Codigo Provincia
    LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].[dbo].[new_provinceBase] PROV WITH(NOLOCK) ON PROV.new_provinceId=CPROV.CAMPOSTR -- Provincia
    LEFT JOIN DATOS_ADICIONALES CCANT WITH (NOLOCK) ON CCANT.TREGISTRO = '2' AND CCANT.IDREGISTRO = A.IDATENCION AND CCANT.IDCAMPO = 117 --Codigo Canton
  LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].[dbo].[new_countyBase] CANT WITH(NOLOCK) ON CANT.new_countyId=CCANT.CAMPOSTR -- Canton
    LEFT JOIN DATOS_ADICIONALES CPROVE WITH(NOLOCK) ON CPROVE.IDREGISTRO=A.IDATENCION AND CPROVE.TREGISTRO=2 AND CPROVE.IDCAMPO=178
    LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerBase PROVEEDOR WITH(NOLOCK) ON CONVERT(VARCHAR(100),PROVEEDOR.new_providerId)=CPROVE.CAMPOSTR
    LEFT JOIN DATOS_ADICIONALES USERPROV WITH(NOLOCK) ON USERPROV.IDREGISTRO=A.IDATENCION AND USERPROV.TREGISTRO=2 AND USERPROV.IDCAMPO=180
    LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerbusinessunitBase NUSERP WITH(NOLOCK) ON CONVERT(VARCHAR(100), NUSERP.new_providerbusinessunitId)=USERPROV.CAMPOSTR
      LEFT JOIN DATOS_ADICIONALES USERPROV2 WITH(NOLOCK) ON USERPROV2.IDREGISTRO=A.IDATENCION AND USERPROV2.TREGISTRO=2 AND USERPROV2.IDCAMPO=181
    LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerbusinessunitBase NUSERP2 WITH(NOLOCK) ON CONVERT(VARCHAR(100), NUSERP2.new_providerbusinessunitId)=USERPROV2.CAMPOSTR
  LEFT JOIN DATOS_ADICIONALES NEWUSER1 WITH (NOLOCK) ON NEWUSER1.TREGISTRO = '2' AND NEWUSER1.IDREGISTRO = A.IDATENCION AND NEWUSER1.IDCAMPO = 198 -- Nuevo Usuario 1
  LEFT JOIN DATOS_ADICIONALES NEWUSER2 WITH (NOLOCK) ON NEWUSER2.TREGISTRO = '2' AND NEWUSER2.IDREGISTRO = A.IDATENCION AND NEWUSER2.IDCAMPO = 199 -- Nuevo Usuario 2
  LEFT JOIN DATOS_ADICIONALES ATEREL WITH(NOLOCK) ON ATEREL.TREGISTRO = '2' AND ATEREL.CAMPOINT = A.IDATENCION AND ATEREL.IDCAMPO = 193  --Atencion Relacionada
    LEFT JOIN DATOS_ADICIONALES PAIS WITH(NOLOCK) ON PAIS.TREGISTRO = '2' AND PAIS.IDREGISTRO = A.IDATENCION AND PAIS.IDCAMPO = 115  --PAIS
    WHERE A.IDATENCION = '$IDATEN'");

            $A = sqlsrv_fetch_array($SQL);

            $RATE = $A['RATE'];

            //HASTA AQUI

            $CONTACTO1 = utf8_encode($A['CONTACT1']);
            $TEL1 = $A['TELE1'];
            $CONTACTO2 = utf8_encode($A['CONTACT2']);
            $TEL2 = $A['TELE2'];
            $CLIENTE = utf8_encode($A['CLIENTE']);
            if ($CLIENTE == '') {
                trigger_error("Debe llenar el cliente", E_USER_ERROR);
            }
            $NOMSEC = utf8_encode($A['NOMSEC']);
            $CLIENTE .= ' ' . $NOMSEC;
            $BOLETA = $A['BOLETA'];
            $DIRECCION = utf8_encode($A['UBIC']);
            $CEDULA = $A['CEDULA'];
            /*if ($CEDULA=='') {
    trigger_error("Debe llenar la cédula", E_USER_ERROR);
  }*/
            $FIRMAUSR = $A['FIRMAUSR'];
            $FECHAFIRM = $A['FECHAFIRM'];

            //  $FECHAFIRM=$FECHAFIRM->format('d/m/Y H:i:s');

            $NUSUARIO = utf8_encode($A['NUSUARIO']);
            $FECREQ = $A['FECREQ'];
            if ($FECREQ != '') {
                $FECREQ = $FECREQ->format('d/m/Y H:i:s');
            }

            $FREGISTRO = $A['FREGISTRO'];
            if ($FREGISTRO != '') {
                $FREGISTRO = $FREGISTRO->format('d/m/Y H:i:s');
            }
            $IMGLOGO = $A['IMGLOGO'];
            $PROV = utf8_encode($A['PROV']);
            $CANT = utf8_encode($A['CANT']);
            $PRIORIDAD = $A['PRIORIDAD'];

            $COMPANY = $A['COMPANY'];
            $PAIS = $A['PAIS'];
            if ($COMPANY == -1 && $PAIS == 'C0E2E77E-ABAD-E611-80C4-005056815852' || $PAIS == null) {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono : +506 2106-4500 <br> Apartado Postal: 3653-1000 San José, Costa Rica";
            } else if ($COMPANY == -6 || $PAIS == 'C4E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "PBX (502) 22794000, (502) 54296366 <br> 5 avenida 5-55 zona 14, Europlaza World Business Center, torre 4 nivel 7 oficina 701.";
                $UNeA = "CEO";
            } else if ($COMPANY == -7 || $PAIS == 'CAE2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono: +507 387-4158 / 59 <br> Calle Punta Darién, Punta Pacífica, P.H Torre de las Américas, Torre C, Piso 18, Ofic. 1804 C, Corregimiento de San Francisco, Ciudad de Panamá.";
                $UNeA = "CEO";
            } else if ($COMPANY == -8 || $PAIS == 'C2E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +503 2283-9498 <br> Calle el Mirador entre la 87 y 89 avenida norte, nivel 12 oficina -4 Torre Futura, Colonia Escalón San Salvador.";
                $UNeA = "CEO";
            } else if ($COMPANY == -9 || $PAIS == 'C8E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "CORPORACION EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +505 2231-3127 <br> Edificio Escala Piso # Nueve, modulo G, Pista Jean Paul Genie.";
                $UNeA = "CEO";
            } else if ($COMPANY == -10 || $PAIS == 'C6E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +504 2242-6201 <br> Torre Agalta , piso 11, local 1117, Tegucigalpa, Honduras.";
                $UNeA = "CEO";
            } else if ($COMPANY == -3) {
                $COMPANY = "ATI CAPITAL SOLUTIONS S.A.";
                $ENCABEZADO = "";
            } else if ($COMPANY == -4) {
                $COMPANY = "SISTEMAS CONVERGENTES S.A.";
                $ENCABEZADO = "Teléfono : (506) 2280-3355 <br> Apartado Postal: 236-1100 Tibás, San José, Costa Rica";
            } else if ($COMPANY == -5) {
                $COMPANY = "NOVA TECHNOLOGIES S.A.";
                $ENCABEZADO = "";
            }
            $DESCRI = utf8_encode($A['DESCRI']);
            $DESCRI = str_replace('\n', "<br>", $DESCRI);
            $OBSERV = utf8_encode($A['OBSERV']);
            $OBSERV = str_replace('\n', "<br>", $OBSERV);
            /*if ($OBSERV=='') {
    trigger_error("Debe llenar las observaciones", E_USER_ERROR);
  }*/

            $AUTOR = utf8_encode($A['AUTOR']);
            $CEDULA = $A['CEDULA'];



            $HTMLBOL = str_replace("Cliente:", 'Cliente / Proveedor:', $HTMLBOL);
            $HTMLBOL = str_replace("%LOGO_ORBE%", $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace("%CLIENTE%", $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%UNINEG%", $COMPANY, $HTMLBOL);
            $HTMLBOL = str_replace("%ENCABEZADO%", $ENCABEZADO . '<br>Boleta No.<font color="red"> ' . $BOLETA . '</font>', $HTMLBOL);
            $HTMLBOL = str_replace("%IDATENC%", 'AT-' . $IDATEN, $HTMLBOL);
            $HTMLBOL = str_replace("%FSOL%", $FREGISTRO, $HTMLBOL);
            $HTMLBOL = str_replace("%PRIO%", $PRIORIDAD, $HTMLBOL);
            $HTMLBOL = str_replace("%SOLIC%", $AUTOR, $HTMLBOL);
            $HTMLBOL = str_replace("%FREQ%", $FECREQ, $HTMLBOL);
            $HTMLBOL = str_replace("%CONT1%", $CONTACTO1, $HTMLBOL);
            $HTMLBOL = str_replace("%CONT2%", $CONTACTO2, $HTMLBOL);
            $HTMLBOL = str_replace("%TEL1%", $TEL1, $HTMLBOL);
            $HTMLBOL = str_replace("%TEL2%", $TEL2, $HTMLBOL);
            $HTMLBOL = str_replace("%PAIS%", $PAIS, $HTMLBOL);
            $HTMLBOL = str_replace("%PROV%", $PROV, $HTMLBOL);
            $HTMLBOL = str_replace("%CANT%", $CANT, $HTMLBOL);
            $HTMLBOL = str_replace("%DIR%", $DIRECCION, $HTMLBOL);
            $HTMLBOL = str_replace("%FECHAFIRMA%", $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace("%FIRMA%", $FIRMAUSR, $HTMLBOL);
            $HTMLBOL = str_replace("%NOMUSRAUT%", $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace("%TITULO%", $IDATEN . " - " . $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%SERV%", $NTATENCION, $HTMLBOL);
            $HTMLBOL = str_replace("%TSERV%", $NSERV, $HTMLBOL);
            $HTMLBOL = str_replace("%Observ%", $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace("%FREQ%", $FECREQ, $HTMLBOL);
            $HTMLBOL = str_replace("%DESC%", $DESCRI, $HTMLBOL);
            $HTMLBOL = str_replace("%CEDULA%", $CEDULA, $HTMLBOL);



            $fh = fopen("D:/SpeedyFiles/Boletas/MENSAJERIA/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);
            //COPIAR A PRODUCTIVO
            if ($RATE == '1') {
                $ATENCION_TONER = BoletaToner($IDATEN, $connARANDABD, '0');
                $ATENCION_TONER = explode('/', $ATENCION_TONER);
                $BOLETA_TNR = $ATENCION_TONER[1];
                $IDATENCION_TNR = $ATENCION_TONER[0];
            }
            // IDATENCION/BOLETA


            //EnviarEncuesta($IDATEN,$connARANDABD);
            if ($SEND == 1) {
                if ($IDATENCION_TNR != '' && $RATE == '1') {
                    $Archivo2 = fopen("D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html", "r");
                    $RArchivo2 =  fread($Archivo2, filesize("D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html"));
                    $RESP = EnviarCorreo($RArchivo2, "D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html", $IDATENCION_TNR, $connARANDABD, 'TNR');
                    if ($RESP == 'Correo Enviado') {
                        sqlsrv_query($connARANDABD, "INSERT INTO STO_BOLETAS VALUES ((SELECT ISNULL(MAX(IDU),0)+1 FROM STO_BOLETAS),'$IDATEN','$IDCLIENTE','$CUENTASEC','$BOLETA','https://ti-obgroup.app:5557/SpeedyFiles/Boletas/MENSAJERIA/$IDATEN - $BOLETA.html','0')");
                        sqlsrv_query($connARANDABD, "DECLARE @FECHAHOY DATETIME=GETDATE() EXEC SP_INS_DATA_DATE '$IDATEN','2','176',@FECHAHOY,'1'");
                    }
                } else {
                    $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/MENSAJERIA/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'MENSAJERIA');
                }
                if ($RESP == 'Correo Enviado') {
                    sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '312', FCIERRE=GETDATE() WHERE IDATENCION = '$IDATEN'");
                    $IDUSR = $_SESSION['IDU'];
                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','5','$IDUSR'");
                    $FCIERRE2 = sqlsrv_query($connARANDABD, "SELECT FCIERRE FROM ATENCIONES WHERE IDATENCION='$IDATEN'");
                    $A = sqlsrv_fetch_array($FCIERRE2);
                    $FECHACIERRE = $A['FCIERRE'];
                    if ($FECHACIERRE != '') {
                        $FECHACIERRE2 = $FECHACIERRE->format("Y-m-d H:i:s");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_DATE '$IDATEN','2','4','$FECHACIERRE2','1'");
                    }
                    if ($IDATENCION_TNR != '' && $RATE == '1') {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '5', FCIERRE='$FECHACIERRE2' WHERE IDATENCION = '$IDATENCION_TNR'");
                        if ($FECHACIERRE != '') {
                            sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_DATE '$IDATENCION_TNR','2','4','$FECHACIERRE2','1'");
                        }
                    }
                }
            }

            //echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/REEQFOD/$IDATEN - $BOLETA.html";

        ?>
            <script>
                //COPIAR A PRODUCTIVO
                <?php if ($IDATENCION_TNR != '' && $RATE == '1') {
                ?>
                    $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/TNR/<?php echo $IDATENCION_TNR; ?> - <?php echo $BOLETA_TNR; ?>.html");
                    $('#downBoleta')[0].click();
                <?php
                } else {
                ?>
                    $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/MENSAJERIA/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                    $('#downBoleta')[0].click();
                <?php
                } ?>
                //HASTA AQUI
                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php
        } else if ($IDSERV == 11 && $TIPOATENCION == 8 && $SUBTIPOATENCION == 3) {
            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '7'");
            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);

            $SQL = sqlsrv_query($connARANDABD, "SELECT CASE
 WHEN USUN.UNAME IS NOT NULL THEN USUN.UNAME
 WHEN NUSERP.new_contactid IS NOT NULL THEN NUSERP.new_contactid COLLATE SQL_Latin1_General_CP1_CI_AS
 WHEN NEWUSER1.CAMPOSTR IS NOT NULL THEN NEWUSER1.CAMPOSTR
 END CONTACT1,TELE1.CAMPOSTR TELE1,TELE2.CAMPOSTR TELE2,C.CAMPOSTR LICIT,
 CASE
WHEN VEN.COMPANY IS NOT NULL THEN VEN.COMPANY
ELSE PROVEEDOR.new_name COLLATE SQL_Latin1_General_CP1_CI_AS
END CLIENTE, B.CAMPOSTR BOLETA, D.CAMPOSTR NUSUARIO, E.CAMPOSTR UBIC,
  TEC.UNAME TECNICO,FFIN.CAMPODATE FECHAFIN,ATRN.UNAME AUTOR,FECREQ.CAMPODATE FECREQ, I.CAMPOSTR OBSERV, H.CAMPOSTR CEDULA,
   LCLI.IMGCLIENTE IMGLOGO,A.FREGISTRO,CASE
 WHEN USU2N.UNAME IS NOT NULL THEN USU2N.UNAME
 WHEN NUSERP2.new_contactid IS NOT NULL THEN NUSERP2.new_contactid COLLATE SQL_Latin1_General_CP1_CI_AS
 WHEN NEWUSER2.CAMPOSTR IS NOT NULL THEN NEWUSER2.CAMPOSTR
 END CONTACT2, PROV.new_name PROV, A.FCIERRE FECHAFIRM,CANT.new_name CANT,
   CASE
   WHEN PRI.CAMPOINT  = 1 THEN 'Alta'
   WHEN PRI.CAMPOINT  = 2 THEN 'Baja'
   END PRIORIDAD, O.CAMPOINT COMPANY,CSEC.NOMSEC,CSEC.CODPRE,A.DESCRI,DOCT.CAMPOSTR DOCT,
   CASE
   WHEN TIPODOC.CAMPOINT  = 1 THEN 'albaran'
   WHEN TIPODOC.CAMPOINT  = 2 THEN 'factura de venta'
   WHEN TIPODOC.CAMPOINT  = 3 THEN 'prestamo'
   END TIPODOC,ENCOM.CAMPOSTR ENCOM, PAIS.CAMPOSTR as PAIS
  FROM ATENCIONES A WITH(NOLOCK)
  INNER JOIN DATOS_ADICIONALES B WITH(NOLOCK) ON B.TREGISTRO = '2' AND B.IDREGISTRO = A.IDATENCION AND B.IDCAMPO = 1 --Boleta
  INNER JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = '2' AND C.IDREGISTRO = A.IDATENCION AND C.IDCAMPO = 2  --Licitacion
  LEFT JOIN DATOS_ADICIONALES TB WITH(NOLOCK) ON TB.TREGISTRO = '2' AND TB.IDREGISTRO = A.IDATENCION AND TB.IDCAMPO = 68  --Tipo de Boleta
  INNER JOIN DATOS_ADICIONALES D WITH(NOLOCK) ON D.TREGISTRO = '2' AND D.IDREGISTRO = A.IDATENCION AND D.IDCAMPO = 39  --Usuario
  INNER JOIN DATOS_ADICIONALES E WITH(NOLOCK) ON E.TREGISTRO = '2' AND E.IDREGISTRO = A.IDATENCION AND E.IDCAMPO = 3   --Ubicacion
  INNER JOIN DATOS_ADICIONALES H WITH(NOLOCK) ON H.TREGISTRO = '2' AND H.IDREGISTRO = A.IDATENCION AND H.IDCAMPO = 40  --Cedula
  INNER JOIN DATOS_ADICIONALES I WITH(NOLOCK) ON I.TREGISTRO = '2' AND I.IDREGISTRO = A.IDATENCION AND I.IDCAMPO = 42  --Observaciones
  LEFT JOIN DATOS_ADICIONALES TELE1 WITH (NOLOCK) ON TELE1.TREGISTRO = '2' AND TELE1.IDREGISTRO = A.IDATENCION AND TELE1.IDCAMPO = 120 -- Telefono 1
  LEFT JOIN USUARIOS USUN WITH (NOLOCK) ON USUN.CODUSUARIO = A.IDUSR -- Usuario 1
LEFT JOIN DATOS_ADICIONALES USU2 WITH (NOLOCK) ON USU2.TREGISTRO = '2' AND USU2.IDREGISTRO = A.IDATENCION AND USU2.IDCAMPO = 121 -- Usuario 2
LEFT JOIN USUARIOS USU2N WITH (NOLOCK) ON USU2N.CODUSUARIO = USU2.CAMPOINT -- Usuario 2
LEFT JOIN DATOS_ADICIONALES TELE2 WITH (NOLOCK) ON TELE2.TREGISTRO = '2' AND TELE2.IDREGISTRO = A.IDATENCION AND TELE2.IDCAMPO = 125 -- Telefono 2
  INNER JOIN VENDOR VEN WITH(NOLOCK) ON VEN.VENDORID = A.IDCLIENTE  -- Company
  INNER JOIN CASOS CASO WITH(NOLOCK) ON CASO.IDCASO = A.IDCASO  -- Caso padre
  INNER JOIN USUARIOS TEC WITH(NOLOCK) ON TEC.CODUSUARIO = CASO.IDTECNICO -- Tecnico
  LEFT JOIN IMGCLIENTE IMG WITH(NOLOCK) ON IMG.IDCLIENTE = VEN.VENDORID -- IMGCLIENTE
  LEFT JOIN DATOS_ADICIONALES Q WITH(NOLOCK) ON Q.TREGISTRO = '2' AND Q.IDREGISTRO = A.IDATENCION AND Q.IDCAMPO = 43  --Cuenta Secundaria
  LEFT JOIN SECUNDARIAS CSEC WITH(NOLOCK) ON CSEC.IDU = Q.CAMPOINT
  LEFT JOIN DATOS_ADICIONALES PRI WITH (NOLOCK) ON PRI.TREGISTRO = '2' AND PRI.IDREGISTRO = A.IDATENCION AND PRI.IDCAMPO = 122 -- Prioridad
  LEFT JOIN DATOS_ADICIONALES FECREQ WITH (NOLOCK) ON FECREQ.TREGISTRO = '2' AND FECREQ.IDREGISTRO = A.IDATENCION AND FECREQ.IDCAMPO = 124 -- Fecha REQ
  LEFT JOIN DATOS_ADICIONALES ATR WITH (NOLOCK) ON ATR.TREGISTRO = '2' AND ATR.IDREGISTRO = A.IDATENCION AND ATR.IDCAMPO = 123 -- Autor
  LEFT JOIN DATOS_ADICIONALES TIPODOC WITH (NOLOCK) ON TIPODOC.TREGISTRO = '2' AND TIPODOC.IDREGISTRO = A.IDATENCION AND TIPODOC.IDCAMPO = 133 -- TIPODOC
  LEFT JOIN DATOS_ADICIONALES DOCT WITH (NOLOCK) ON DOCT.TREGISTRO = '2' AND DOCT.IDREGISTRO = A.IDATENCION AND DOCT.IDCAMPO = 134 -- DOCT
  LEFT JOIN USUARIOS ATRN WITH (NOLOCK) ON ATRN.CODUSUARIO = ATR.CAMPOINT
LEFT JOIN DATOS_ADICIONALES FFIN WITH (NOLOCK) ON FFIN.TREGISTRO = '2' AND FFIN.IDREGISTRO = A.IDATENCION AND FFIN.IDCAMPO = 5 -- Fecha Fin
  INNER JOIN DATOS_ADICIONALES O WITH(NOLOCK) ON O.TREGISTRO = '2' AND O.IDREGISTRO = A.IDATENCION AND O.IDCAMPO = 53  --UNINEG
  INNER JOIN IMGCLIENTE LCLI WITH(NOLOCK) ON LCLI.IDCLIENTE = O.CAMPOINT --IMGLOGO
  LEFT JOIN DATOS_ADICIONALES CPROV WITH (NOLOCK) ON CPROV.TREGISTRO = '2' AND CPROV.IDREGISTRO = A.IDATENCION AND CPROV.IDCAMPO = 116 --Codigo Provincia
    LEFT JOIN DATOS_ADICIONALES CCANT WITH (NOLOCK) ON CCANT.TREGISTRO = '2' AND CCANT.IDREGISTRO = A.IDATENCION AND CCANT.IDCAMPO = 117 --Codigo Canton
  LEFT JOIN DATOS_ADICIONALES ENCOM WITH (NOLOCK) ON ENCOM.TREGISTRO = '2' AND ENCOM.IDREGISTRO = A.IDATENCION AND ENCOM.IDCAMPO = 156 --Empresa encomiendas
    LEFT JOIN DATOS_ADICIONALES USERPROV WITH(NOLOCK) ON USERPROV.IDREGISTRO=A.IDATENCION AND USERPROV.TREGISTRO=2 AND USERPROV.IDCAMPO=180
	  LEFT JOIN DATOS_ADICIONALES CPROVE WITH(NOLOCK) ON CPROVE.IDREGISTRO=A.IDATENCION AND CPROVE.TREGISTRO=2 AND CPROVE.IDCAMPO=178
  LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerBase PROVEEDOR WITH(NOLOCK) ON CONVERT(VARCHAR(100),PROVEEDOR.new_providerId)=CPROVE.CAMPOSTR
  LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerbusinessunitBase NUSERP WITH(NOLOCK) ON CONVERT(VARCHAR(100), NUSERP.new_providerbusinessunitId)=USERPROV.CAMPOSTR
    LEFT JOIN DATOS_ADICIONALES USERPROV2 WITH(NOLOCK) ON USERPROV2.IDREGISTRO=A.IDATENCION AND USERPROV2.TREGISTRO=2 AND USERPROV2.IDCAMPO=181
  LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].dbo.new_providerbusinessunitBase NUSERP2 WITH(NOLOCK) ON CONVERT(VARCHAR(100), NUSERP2.new_providerbusinessunitId)=USERPROV2.CAMPOSTR
  LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].[dbo].[new_provinceBase] PROV WITH(NOLOCK) ON PROV.new_provinceId=CPROV.CAMPOSTR -- Provincia
  LEFT JOIN [10.0.7.13].[OBCRM2013_MSCRM].[dbo].[new_countyBase] CANT WITH(NOLOCK) ON CANT.new_countyId=CCANT.CAMPOSTR -- Canton
  LEFT JOIN DATOS_ADICIONALES NEWUSER1 WITH (NOLOCK) ON NEWUSER1.TREGISTRO = '2' AND NEWUSER1.IDREGISTRO = A.IDATENCION AND NEWUSER1.IDCAMPO = 198 -- Nuevo Usuario 1
LEFT JOIN DATOS_ADICIONALES NEWUSER2 WITH (NOLOCK) ON NEWUSER2.TREGISTRO = '2' AND NEWUSER2.IDREGISTRO = A.IDATENCION AND NEWUSER2.IDCAMPO = 199 -- Nuevo Usuario 2
  LEFT JOIN DATOS_ADICIONALES PAIS WITH(NOLOCK) ON PAIS.TREGISTRO = '2' AND PAIS.IDREGISTRO = A.IDATENCION AND PAIS.IDCAMPO = 115  --PAIS

  WHERE A.IDATENCION = '$IDATEN'");

            $A = sqlsrv_fetch_array($SQL);

            $CONTACTO1 = utf8_encode($A['CONTACT1']);
            $TEL1 = $A['TELE1'];
            $CONTACTO2 = utf8_encode($A['CONTACT2']);
            $TEL2 = $A['TELE2'];
            $CLIENTE = utf8_encode($A['CLIENTE']);
            $NOMSEC = utf8_encode($A['NOMSEC']);
            $CLIENTE .= ' ' . $NOMSEC;
            $BOLETA = $A['BOLETA'];
            $DIRECCION = utf8_encode($A['UBIC']);
            $CEDULA = $A['CEDULA'];

            $FCIERRE = $A['FECHAFIRM'];
            if ($FCIERRE != '') {
                $FCIERRE = $FCIERRE->format('d/m/Y H:i:s');
            }

            $ENCOM = utf8_encode($A['ENCOM']);

            $NUSUARIO = utf8_encode($A['NUSUARIO']);
            $FECREQ = $A['FECREQ'];
            if ($FECREQ != '') {
                $FECREQ = $FECREQ->format('d/m/Y H:i:s');
            }

            $FREGISTRO = $A['FREGISTRO'];
            if ($FREGISTRO != '') {
                $FREGISTRO = $FREGISTRO->format('d/m/Y H:i:s');
            }
            $IMGLOGO = $A['IMGLOGO'];
            $PROV = utf8_encode($A['PROV']);
            $CANT = utf8_encode($A['CANT']);
            $PRIORIDAD = $A['PRIORIDAD'];
            $DOCT = $A['DOCT'];

            $SQLD = sqlsrv_query($connARANDABD, "SELECT DOC FROM DOCUMENTOS_TRANSPORTES A WITH(NOLOCK)
WHERE A.IDATENCION='$IDATEN'");
            $DOCUMENTOS = '';
            while ($DOCS = sqlsrv_fetch_array($SQLD)) {
                $DOCUMENTOS .= $DOCS['DOC'] . ', ';
            }
            $DOCUMENTOS = trim($DOCUMENTOS, ', ');

            if ($DOCUMENTOS != '') {
                $DOCT = $DOCUMENTOS;
            }

            $TIPODOC = $A['TIPODOC'];
            // <!-- COPIAR A PRODUCTIVO TRANSPORTES -->
            $IDESTADO = $A['IDESTADO'];
            // <!-- FIN TRANSPORTES -->

            $COMPANY = $A['COMPANY'];
            $PAIS = $A['PAIS'];
            if ($COMPANY == -1 && $PAIS == 'C0E2E77E-ABAD-E611-80C4-005056815852' || $PAIS == null) {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono : +506 2106-4500 <br> Apartado Postal: 3653-1000 San José, Costa Rica";
            } else if ($COMPANY == -6 || $PAIS == 'C4E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "PBX (502) 22794000, (502) 54296366 <br> 5 avenida 5-55 zona 14, Europlaza World Business Center, torre 4 nivel 7 oficina 701.";
                $UNeA = "CEO";
            } else if ($COMPANY == -7 || $PAIS == 'CAE2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono: +507 387-4158 / 59 <br> Calle Punta Darién, Punta Pacífica, P.H Torre de las Américas, Torre C, Piso 18, Ofic. 1804 C, Corregimiento de San Francisco, Ciudad de Panamá.";
                $UNeA = "CEO";
            } else if ($COMPANY == -8 || $PAIS == 'C2E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +503 2283-9498 <br> Calle el Mirador entre la 87 y 89 avenida norte, nivel 12 oficina -4 Torre Futura, Colonia Escalón San Salvador.";
                $UNeA = "CEO";
            } else if ($COMPANY == -9 || $PAIS == 'C8E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "CORPORACION EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +505 2231-3127 <br> Edificio Escala Piso # Nueve, modulo G, Pista Jean Paul Genie.";
                $UNeA = "CEO";
            } else if ($COMPANY == -10 || $PAIS == 'C6E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +504 2242-6201 <br> Torre Agalta , piso 11, local 1117, Tegucigalpa, Honduras.";
                $UNeA = "CEO";
            } else if ($COMPANY == -3) {
                $COMPANY = "ATI CAPITAL SOLUTIONS S.A.";
                $ENCABEZADO = "";
            } else if ($COMPANY == -4) {
                $COMPANY = "SISTEMAS CONVERGENTES S.A.";
                $ENCABEZADO = "Teléfono : (506) 2280-3355 <br> Apartado Postal: 236-1100 Tibás, San José, Costa Rica";
            } else if ($COMPANY == -5) {
                $COMPANY = "NOVA TECHNOLOGIES S.A.";
                $ENCABEZADO = "";
            }
            $DESCRI = utf8_encode($A['DESCRI']);
            $DESCRI = str_replace("\n", "<br>", $DESCRI);
            $OBSERV = utf8_encode($A['OBSERV']);
            $OBSERV = str_replace("\n", "<br>", $OBSERV);
            if ($OBSERV == '') {
                trigger_error("Debe llenar las observaciones", E_USER_ERROR);
            }

            $AUTOR = utf8_encode($A['AUTOR']);
            $CEDULA = $A['CEDULA'];

            $HTMLBOL = str_replace("%LOGO_ORBE%", $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace("%CLIENTE%", $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%UNINEG%", $COMPANY, $HTMLBOL);
            $HTMLBOL = str_replace("%ENCABEZADO%", $ENCABEZADO . '<br>Boleta No.<font color="red"> ' . $BOLETA . '</font>', $HTMLBOL);
            $HTMLBOL = str_replace("%IDATENC%", 'AT-' . $IDATEN, $HTMLBOL);
            $HTMLBOL = str_replace("%FSOL%", $FREGISTRO, $HTMLBOL);
            $HTMLBOL = str_replace("%PRIO%", $PRIORIDAD, $HTMLBOL);
            $HTMLBOL = str_replace("%SOLIC%", $AUTOR, $HTMLBOL);
            $HTMLBOL = str_replace("%FREQ%", $FECREQ, $HTMLBOL);
            $HTMLBOL = str_replace("%CONT1%", $CONTACTO1, $HTMLBOL);
            $HTMLBOL = str_replace("%CONT2%", $CONTACTO2, $HTMLBOL);
            $HTMLBOL = str_replace("%TEL1%", $TEL1, $HTMLBOL);
            $HTMLBOL = str_replace("%TEL2%", $TEL2, $HTMLBOL);
            $HTMLBOL = str_replace("%PAIS%", $PAIS, $HTMLBOL);
            $HTMLBOL = str_replace("%PROV%", $PROV, $HTMLBOL);
            $HTMLBOL = str_replace("%CANT%", $CANT, $HTMLBOL);
            $HTMLBOL = str_replace("%DISTR%", $DIST, $HTMLBOL);
            $HTMLBOL = str_replace("%DIR%", $DIRECCION, $HTMLBOL);
            $HTMLBOL = str_replace("%TITULO%", $IDATEN . " - " . $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%SERV%", $NTATENCION, $HTMLBOL);
            $HTMLBOL = str_replace("%TSERV%", $NSERV, $HTMLBOL);
            $HTMLBOL = str_replace("%Observ%", $OBSERV, $HTMLBOL);
            $HTMLBOL = str_replace("%FREQ%", $FECREQ, $HTMLBOL);
            $HTMLBOL = str_replace("%DESC%", $DESCRI, $HTMLBOL);
            $HTMLBOL = str_replace("%REF%", $DOCT, $HTMLBOL);
            $HTMLBOL = str_replace("%TIPODOC%", $TIPODOC, $HTMLBOL);
            $HTMLBOL = str_replace("%ENCOM%", $ENCOM, $HTMLBOL);


            if ($SEND == 1 && $FCIERRE == '') {
                sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '312', FCIERRE=GETDATE() WHERE IDATENCION = '$IDATEN'");
                $IDUSR = $_SESSION['IDU'];
                sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','312','$IDUSR'");
                $FCIERRE2 = sqlsrv_query($connARANDABD, "SELECT FCIERRE FROM ATENCIONES WHERE IDATENCION='$IDATEN'");
                $A = sqlsrv_fetch_array($FCIERRE2);
                $FECHACIERRE = $A['FCIERRE'];
                if ($FECHACIERRE != '') {
                    $FECHACIERRE2 = $FECHACIERRE->format("Y-m-d H:i:s");
                    $FECHACIERRE = $FECHACIERRE->format('d/m/Y H:i:s');
                    sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_DATE '$IDATEN','2','4','$FECHACIERRE2','1'");
                }
                $FCIERRE = $FECHACIERRE;
                $HTMLBOL = str_replace("%FECHAFIRMA%", $FCIERRE, $HTMLBOL);
            }
            if ($FCIERRE == '') {
                $HTMLBOL = str_replace("%FECHAFIRMA%", '<p style="color:red;">Cambiara a la fecha y hora enviada la boleta.</p>', $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%FECHAFIRMA%", $FCIERRE, $HTMLBOL);
            }



            $fh = fopen("D:/SpeedyFiles/Boletas/TRANSPORTE/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {
                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/TRANSPORTE/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'TRANSPORTE');
            }

            //echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/REEQFOD/$IDATEN - $BOLETA.html";

        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/TRANSPORTE/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                        //Descomentar cuando den el VB
                        //EnviarEncuesta($IDATEN,$connARANDABD);
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php
        } //COPIAR A PRODUCTIVO
        else if ($IDSERV == 13) {
            $ATENCION_TONER = BoletaToner($IDATEN, $connARANDABD, '1');
            $ATENCION_TONER = explode('/', $ATENCION_TONER);
            $BOLETA_TNR = $ATENCION_TONER[1];
            $IDATENCION_TNR = $ATENCION_TONER[0];

            //// //EnviarEncuesta($IDATENCION_TNR,$connARANDABD);
            if ($SEND == 1) {
                $Archivo2 = fopen("D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html", "r");
                $RArchivo2 =  fread($Archivo2, filesize("D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html"));
                $RESP = EnviarCorreo($RArchivo2, "D:/SpeedyFiles/Boletas/TNR/" . $IDATENCION_TNR . " - " . $BOLETA_TNR . ".html", $IDATENCION_TNR, $connARANDABD, 'TNR');
                if ($RESP == 'Correo Enviado') {
                    sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '312', FCIERRE=GETDATE() WHERE IDATENCION = '$IDATENCION_TNR'");
                    $FCIERRE2 = sqlsrv_query($connARANDABD, "SELECT FCIERRE FROM ATENCIONES WHERE IDATENCION='$IDATENCION_TNR'");
                    $A = sqlsrv_fetch_array($FCIERRE2);
                    $FECHACIERRE = $A['FCIERRE'];
                    if ($FECHACIERRE != '') {
                        $FECHACIERRE = $FECHACIERRE->format("Y-m-d H:i:s");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_DATE '$IDATENCION_TNR','2','4','$FECHACIERRE','1'");
                    }
                }
            }

        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/TNR/<?php echo $IDATENCION_TNR; ?> - <?php echo $BOLETA_TNR; ?>.html");
                $('#downBoleta')[0].click();
                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php
            // <!-- FIN TRANSPORTES -->
        } else if ($IDSERV == 15 && $TIPOATENCION == 18) {

            $SQL = sqlsrv_query($connARANDABD, "EXEC SP_INFOBOLETA_ATEN $IDATEN , 18");

            $A = sqlsrv_fetch_array($SQL);

            if ($A['IDCLIENTE'] == 2066 && $SEND == 1 && $A['BOLADDMEP'] == '' && $A['DANO_FIS'] == 1) {
                trigger_error("Falta la boleta adicional del MEP", E_USER_ERROR);
            }

            if ($SEND == 1 && $A['FIRMAUSR'] == '') {
                trigger_error("Falta la firma de la boleta", E_USER_ERROR);
            }

            if ($A['IDCLIENTE'] == 2066 && $SEND == 1 && $A['FIRMATEC'] == '') {
                trigger_error("Falta la firma del técnico", E_USER_ERROR);
            }


            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '16'");
            if ($A['IDCLIENTE'] == 2066) {
                $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '13'");
            }

            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);


            $LICIT = $A['LICIT'];
            $CLIENTE = utf8_encode($A['CLIENTE']);
            $NOMSEC = utf8_encode($A['NOMSEC']);
            $CODPRE = $A['CODPRE'];
            $IDCASO = $A['IDCASO'];
            $IDATENCION = $A['IDATENCION'];
            $BOLETA = $A['BOLETA'];
            $REPCLIENTE = $A['REPCLIENTE'];
            $TELEFONO = $A['TELEFONO'];
            $IDCLIENTE = $A['IDCLIENTE'];
            $NUSUARIO = utf8_encode($A['NUSUARIO']);
            $UBIC = utf8_encode($A['UBIC']);
            $TECNICO = utf8_encode($A['TECNICO']);
            $COMPANY = utf8_encode($A['COMPANY']);
            $PAIS = $A['PAIS'];
            if ($COMPANY == -1 && $PAIS == 'C0E2E77E-ABAD-E611-80C4-005056815852' || $PAIS == null) {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono : +506 2106-4500 <br> Apartado Postal: 3653-1000 San José, Costa Rica";
                $UNeA = "CEO";
            } else if ($COMPANY == -6 || $PAIS == 'C4E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "PBX (502) 22794000, (502) 54296366 <br> 5 avenida 5-55 zona 14, Europlaza World Business Center, torre 4 nivel 7 oficina 701.";
                $UNeA = "CEO";
            } else if ($COMPANY == -7 || $PAIS == 'CAE2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono: +507 387-4158 / 59 <br> Calle Punta Darién, Punta Pacífica, P.H Torre de las Américas, Torre C, Piso 18, Ofic. 1804 C, Corregimiento de San Francisco, Ciudad de Panamá.";
                $UNeA = "CEO";
            } else if ($COMPANY == -8 || $PAIS == 'C2E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +503 2283-9498 <br> Calle el Mirador entre la 87 y 89 avenida norte, nivel 12 oficina -4 Torre Futura, Colonia Escalón San Salvador.";
                $UNeA = "CEO";
            } else if ($COMPANY == -9 || $PAIS == 'C8E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "CORPORACION EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +505 2231-3127 <br> Edificio Escala Piso # Nueve, modulo G, Pista Jean Paul Genie.";
                $UNeA = "CEO";
            } else if ($COMPANY == -10 || $PAIS == 'C6E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +504 2242-6201 <br> Torre Agalta , piso 11, local 1117, Tegucigalpa, Honduras.";
                $UNeA = "CEO";
            } else if ($COMPANY == -3) {
                $COMPANY = "ATI CAPITAL SOLUTIONS S.A.";
                $ENCABEZADO = "";
                $UNeA = "ATI";
            } else if ($COMPANY == -4) {
                $COMPANY = "SISTEMAS CONVERGENTES S.A.";
                $ENCABEZADO = "Teléfono : (506) 2280-3355 <br> Apartado Postal: 236-1100 Tibás, San José, Costa Rica";
                $UNeA = "SISCON";
            } else if ($COMPANY == -5) {
                $COMPANY = "NOVA TECHNOLOGIES S.A.";
                $ENCABEZADO = "";
                $UNeA = "NOVA";
            }
            $HINICIO = $A['HINICIO'];

            if ($HINICIO != '') {
                $HINICIO2 = $HINICIO->format('Y-m-d H:i:s');
                $HINICIO2 = new DateTime($HINICIO2);
                $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            }
            $HFIN = $A['HFIN'];
            $HFIN2 = $HFIN->format('Y-m-d H:i:s');
            $HFIN2 = new DateTime($HFIN2);
            $HFIN = $HFIN->format('d/m/Y H:i:s');

            $FREGISTRO = $A['FREGISTRO'];
            $FREGISTRO = $FREGISTRO->format('d/m/Y H:i:00');


            if ($SEND == 1 && ($A['HINICIO']->format('Y-m-d H:i:s') < $A['FREGISTRO']->format('Y-m-d H:i:00') || $A['HFIN']->format('Y-m-d H:i:s') < $A['FREGISTRO']->format('Y-m-d H:i:00'))) {
                trigger_error("La fecha de inicio o fin es inferior a la del registro del caso", E_USER_ERROR);
            }

            $intervalFechas = date_diff(date_create($A['HINICIO']->format('Y-m-d')), date_create($A['HFIN']->format('Y-m-d')));

            if (($intervalFechas->format('%a') != 0 && $A['CHECKPFDD'] != 1) || $HFIN2 < $HINICIO2) {
                trigger_error("Las fechas de inicio y fin no son del mismo día o la fecha de fin es menor a la fecha de inicio", E_USER_ERROR);
            }

            $OBSERV = utf8_encode($A['OBSERV']);
            $DESCRI = utf8_encode($A['PROBLEMA_REP']);
            $CEDULA = $A['CEDULA'];
            $FIRMAUSR = $A['FIRMAUSR'];
            $IMGCLIENTE = $A['IMGCLIENTE'];
            $IMGLOGO = $A['IMGLOGO'];

            $FECHAFIRM = $A['FECHAFIRM'];
            if ($FIRMAUSR != '') {
                $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');
            }

            $FIRMATEC = $A['FIRMATEC'];
            $FFIRMATEC = $A['FFIRMATEC'];
            if ($FIRMATEC != '') {
                $FFIRMATEC = $FFIRMATEC->format('d/m/Y H:i:s');
            }

            if ($SEND == 1 && ((strtotime($A['FECHAFIRM']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) < 0) {
                trigger_error("La fecha de la firma del usuario es inferior a la fecha fin", E_USER_ERROR);
            }

            if ($SEND == 1 && ((strtotime($A['FFIRMATEC']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) < 0) {
                trigger_error("La fecha de la firma del técnico es inferior a la fecha fin", E_USER_ERROR);
            }

            $SERIE = $A['SERIE'];
            $MODELO = $A['MODELO'];
            $PLACA = $A['PLACA'];
            $PRODUCTO = $A['PRODUCTO'];
            $MARCA = $A['MARCA'];

            $SERIE_CORRESP = $A['SERIE_CORRESP'];
            $SOFT_HARD = $A['SOFT_HARD'];
            $DANO_FIS = $A['DANO_FIS'];
            $ATENC_PEND = $A['ATENC_PEND'];
            $RAZON_PEND = utf8_encode($A['RAZON_PEND']);
            $PARTE_PEND = $A['PARTE_PEND'];
            $CAMBIO_COMP = $A['CAMBIO_COMP'];
            $SOLUCION = utf8_encode($A['SOLUCION']);
            $SOLUCION = str_replace('\n', '<br>', $SOLUCION);
            $TELEFONO = $A['TELEFONO'];
            $PROBLEMA_REP = utf8_encode($A['PROBLEMA_REP']);
            $PROBLEMA_REP = str_replace('\n', '<br>', $PROBLEMA_REP);
            $TBOL = utf8_encode($A['TBOL']);
            $IDCLIENTE = $A['IDCLIENTE'];
            $IDUSR = $A['IDUSR'];
            $CODHPE = utf8_encode($A['CODHPE']);

            $HTMLBOL = str_replace("%IMGLOGO%", $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace("%Cliente%", $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%Institucion%", $NOMSEC, $HTMLBOL);
            $HTMLBOL = str_replace("%UNINEG%", $COMPANY, $HTMLBOL);
            $HTMLBOL = str_replace("%ENCABEZADO%", $ENCABEZADO, $HTMLBOL);
            $HTMLBOL = str_replace("%UNeA%", $UNeA, $HTMLBOL);
            $HTMLBOL = str_replace("%Codigo%", $CODPRE, $HTMLBOL);
            $HTMLBOL = str_replace("%Ubicacion%", $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace("%fini%", $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace("%ffin%", $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace("%Telefono%", $TELEFONO, $HTMLBOL);
            $HTMLBOL = str_replace("%tecn%", $TECNICO, $HTMLBOL);
            $HTMLBOL = str_replace("%TIPOBOL%", $TBOL, $HTMLBOL);
            $HTMLBOL = str_replace("%lic%", $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace("%PROBLEMA%", $PROBLEMA_REP, $HTMLBOL);
            $HTMLBOL = str_replace("%CodHPE%", $CODHPE, $HTMLBOL);
            /*Si tiene atenciones relacionadas se aplica*/
            $SQLREL = sqlsrv_query($connARANDABD, "		SELECT
		CASE
		WHEN B.IDCLIENTE=1340 AND C.CAMPOSTR !='' THEN CONCAT('IDCC-',C.CAMPOSTR)
		ELSE CONCAT('AT-',A.IDAS)
		END RELACION,A.IDAS IDASACT FROM ATENCIONES_RELACION A WITH(NOLOCK)
		INNER JOIN ATENCIONES B WITH(NOLOCK) ON B.IDATENCION=A.IDAS
		LEFT JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = 2 AND C.IDREGISTRO = B.IDATENCION AND C.IDCAMPO = 75
		WHERE A.IDAP='$IDATEN'");
            $ATENCIONES = '';
            while ($sqlf = sqlsrv_fetch_array($SQLREL)) {
                $RELACION = $sqlf['RELACION'];
                $ATENCIONES .= $RELACION . ', ';
                $IDASACT = $sqlf['IDASACT'];

                if ($SEND == 1) {
                    $IDUSR = $_SESSION['IDU'];
                    if ($ATENC_PEND == 1) {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '20' WHERE IDATENCION = '$IDASACT'");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDASACT','2','183','20','$IDUSR'");
                    } else {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDASACT'");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDASACT','2','183','17','$IDUSR'");
                    }
                }
            }
            if ($ATENCIONES != '') {
                $ATENCIONES = rtrim($ATENCIONES, ', ');
                $SOLUCION .= '<br><b>Relaciones:</b> ' . $ATENCIONES;
            }

            if ($A['IDCLIENTE'] == 2066 && $A['FECHAFIRM'] != '' && $A['FFIRMATEC'] != '') {
                if ((((strtotime($A['FFIRMATEC']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) > 10 ||
                    ((strtotime($A['FECHAFIRM']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) > 10)  && $A['JUSTFFIRMA'] != '') {
                    $SOLUCION .= '<br><b>¿Porque la fecha y hora de firma supera los 10 minutos despues de la fecha y hora de salida?: </b> ' . $A['JUSTFFIRMA'];
                }
            }

            $HTMLBOL = str_replace("%SOLUCION%", $SOLUCION, $HTMLBOL);
            $HTMLBOL = str_replace("%NOMUSRAUT%", $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace("%CEDULA%", $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace("%FECHAFIRMA%", $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace("%FIRMA%", $FIRMAUSR, $HTMLBOL);

            $HTMLBOL = str_replace("%FECHAFIRMATEC%", $FFIRMATEC, $HTMLBOL);
            $HTMLBOL = str_replace("%FIRMATEC%", $FIRMATEC, $HTMLBOL);

            $HTMLBOL = str_replace("%Bol%", $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%TITULO%", $IDATEN . " - " . $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%RepCEO%", "AT-" . $IDATENCION, $HTMLBOL);
            $HTMLBOL = str_replace("%Bol%", $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%Marca%", $MARCA, $HTMLBOL);
            $HTMLBOL = str_replace("%Modelo%", $MODELO, $HTMLBOL);
            $HTMLBOL = str_replace("%Prod%", $PRODUCTO, $HTMLBOL);
            $HTMLBOL = str_replace("%Serie%", $SERIE, $HTMLBOL);
            $HTMLBOL = str_replace("%Activo%", $PLACA, $HTMLBOL);
            $HTMLBOL = str_replace("%RepC%", $REPCLIENTE, $HTMLBOL);

            if ($SERIE_CORRESP == 1) {
                $HTMLBOL = str_replace("%SERIER1%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%SERIER2%", "  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%SERIER1%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%SERIER2%", "X", $HTMLBOL);
            }

            $HTMLBOL = str_replace("%Error%", $COD_ERROR, $HTMLBOL);

            if ($SOFT_HARD == "Software") {
                $HTMLBOL = str_replace("%soft%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%hard%", "  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%soft%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%hard%", "X", $HTMLBOL);
            }

            if ($IDCLIENTE != 1340) {
                if ($DANO_FIS == 1) {
                    $HTMLBOL = str_replace("%daño1%", "X", $HTMLBOL);
                    $HTMLBOL = str_replace("%daño2%", "  ", $HTMLBOL);
                } else {
                    $HTMLBOL = str_replace("%daño1%", "  ", $HTMLBOL);
                    $HTMLBOL = str_replace("%daño2%", "X", $HTMLBOL);
                }
            } else {
                $HTMLBOL = str_replace('%DISDF%', "display:none;", $HTMLBOL);
            }




            if ($ATENC_PEND == 1) {
                $HTMLBOL = str_replace("%Incidente1%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%Incidente2%", "  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%Incidente1%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%Incidente2%", "X", $HTMLBOL);
            }

            $SQL = sqlsrv_query($connARANDABD, "SELECT RET_SPARE,RET_CT,RET_DFPRT,RET_ESTPRT,INS_SPARE,INS_CT,B.NOMCAT LVL1,C.NOMCAT LVL2,D.NOMCAT LVL3 FROM SPEEDY_SOLTEC A WITH(NOLOCK)
LEFT JOIN SPEEDE_SOLTEC_CAT1 B WITH(NOLOCK) ON convert(varchar(36),B.IDU) = A.CATLVL1 AND B.ESTADO = 1
LEFT JOIN SPEEDE_SOLTEC_CAT2 C WITH(NOLOCK) ON convert(varchar(36),C.IDU) = A.CATLVL2 AND C.ESTADO = 1
LEFT JOIN SPEEDE_SOLTEC_CAT3 D WITH(NOLOCK) ON convert(varchar(36),D.IDU) = A.CATLVL3 AND D.ESTADO = 1
WHERE IDATEN='$IDATEN' AND RET_ESTPRT != 'DOA' AND CATLVL1 != '' AND CATLVL2 != '' AND CATLVL3 != ''");

            $PRTSINS = '
<table cellspacing="0" cellpadding="2" border="0" width="100%" style="margin:0;">
  <thead>
    <tr>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Parte Instalada Cliente</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Spare</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">CT</font></b></th>
    </tr>
  </thead>
  <tbody>';

            $PRTSRET = '
<table cellspacing="0" cellpadding="2" border="0" width="100%" style="margin-top:5px;">
  <thead>
    <tr>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Partes a devolver</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Spare</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">CT</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">Estado</font></b></th>
    </tr>
  </thead>
<tbody>';

            while ($A = sqlsrv_fetch_array($SQL)) {
                $LVL1 = utf8_encode($A['LVL1']);
                $LVL2 = utf8_encode($A['LVL2']);
                $LVL3 = utf8_encode($A['LVL3']);
                $RET_SPARE = $A['RET_SPARE'];
                $RET_CT = $A['RET_CT'];
                $RET_DFPRT = $A['RET_DFPRT'];
                $RET_ESTPRT = $A['RET_ESTPRT'];
                $INS_SPARE = $A['INS_SPARE'];
                $INS_CT = $A['INS_CT'];

                $PRTSINS .= '<tr>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $LVL3 . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $INS_SPARE . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $INS_CT . '</font></td>
  </tr>';

                $PRTSRET .= '<tr>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . "$LVL1 / $LVL2 / $LVL3" . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_SPARE . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_CT . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_ESTPRT . '</font></td>
  </tr>';
            }

            $PRTSINS .= '</tbody></table>';
            $PRTSRET .= '</tbody></table>';

            $HTMLBOL = str_replace("%PRTSINS%", $PRTSINS, $HTMLBOL);
            $HTMLBOL = str_replace("%PRTSRET%", $PRTSRET, $HTMLBOL);

            $fh = fopen("D:/SpeedyFiles/Boletas/MNTCORSYA/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {

                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/MNTCORSYA/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'MNTCORSYA');

                if ($RESP == 'Correo Enviado') {
                    if ($IDCLIENTE != 1340) {
                        EnviarEncuesta($IDATEN, $connARANDABD);
                    }
                    if ($ATENC_PEND == 1) {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '20' WHERE IDATENCION = '$IDATEN'");
                        $IDUSR = $_SESSION['IDU'];
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','20','$IDUSR'");
                    } else {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                        $IDUSR = $_SESSION['IDU'];
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
                    }
                    /*
if ($IDCLIENTE!=1340) {
    $Archivo = fopen(__DIR__ . "/../CORREOS/Correctivo_Usuario_Solucionado.html" , "r");
    $RArchivo =  fread($Archivo,filesize("../CORREOS/Correctivo_Usuario_Solucionado.html"));


    $RArchivo = str_replace('%NumAte%',$IDATEN,$RArchivo);
    $RArchivo = str_replace('%DESC%',$PROBLEMA_REP,$RArchivo);

    $subject='Se ha dado solución a la atención AT-'.$IDATEN;

    $ESTADOCORREO=EnviarNotif($subject,'0',$RArchivo,'0',$IDUSR,$_SESSION['IDU'],$connARANDABD,$IDSERV);
}
*/
                }
            }


            //echo "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/REEQFOD/$IDATEN - $BOLETA.html";

        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/MNTCORSYA/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
        <?php

        } else if ($IDSERV == 16 && ($TIPOATENCION == 19 || $TIPOATENCION == 20 || $TIPOATENCION == 21 || $TIPOATENCION == 22)) {

            $SQL = sqlsrv_query($connARANDABD, "EXEC SP_INFOBOLETA_ATEN $IDATEN , 19");

            $A = sqlsrv_fetch_array($SQL);


            if ($SEND == 1 && $A['FIRMAUSR'] == '') {
                trigger_error("Falta la firma de la boleta", E_USER_ERROR);
            }


            $SQL = sqlsrv_query($connARANDABD, "SELECT HTMLBOL FROM BOLETASHTML WHERE IDBOL = '17'");


            $fila2 = sqlsrv_fetch_array($SQL);
            $HTMLBOL = utf8_encode($fila2['HTMLBOL']);


            $LICIT = $A['LICIT'];
            $CLIENTE = utf8_encode($A['CLIENTE']);
            $NOMSEC = utf8_encode($A['NOMSEC']);
            $CODPRE = $A['CODPRE'];
            $IDCASO = $A['IDCASO'];
            $IDATENCION = $A['IDATENCION'];
            $BOLETA = $A['BOLETA'];
            $REPCLIENTE = $A['REPCLIENTE'];
            $TELEFONO = $A['TELEFONO'];
            $IDCLIENTE = $A['IDCLIENTE'];
            $NUSUARIO = utf8_encode($A['NUSUARIO']);
            $UBIC = utf8_encode($A['UBIC']);
            $TECNICO = utf8_encode($A['TECNICO']);
            $COMPANY = utf8_encode($A['COMPANY']);
            $PAIS = $A['PAIS'];
            if ($COMPANY == -1 && $PAIS == 'C0E2E77E-ABAD-E611-80C4-005056815852' || $PAIS == null) {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono : +506 2106-4500 <br> Apartado Postal: 3653-1000 San José, Costa Rica";
                $UNeA = "CEO";
            } else if ($COMPANY == -6 || $PAIS == 'C4E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "PBX (502) 22794000, (502) 54296366 <br> 5 avenida 5-55 zona 14, Europlaza World Business Center, torre 4 nivel 7 oficina 701.";
                $UNeA = "CEO";
            } else if ($COMPANY == -7 || $PAIS == 'CAE2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono: +507 387-4158 / 59 <br> Calle Punta Darién, Punta Pacífica, P.H Torre de las Américas, Torre C, Piso 18, Ofic. 1804 C, Corregimiento de San Francisco, Ciudad de Panamá.";
                $UNeA = "CEO";
            } else if ($COMPANY == -8 || $PAIS == 'C2E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +503 2283-9498 <br> Calle el Mirador entre la 87 y 89 avenida norte, nivel 12 oficina -4 Torre Futura, Colonia Escalón San Salvador.";
                $UNeA = "CEO";
            } else if ($COMPANY == -9 || $PAIS == 'C8E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "CORPORACION EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +505 2299-0801 <br> Edificio Escala Piso # Nueve, modulo G, Pista Jean Paul Genie.";
                $UNeA = "CEO";
            } else if ($COMPANY == -10 || $PAIS == 'C6E2E77E-ABAD-E611-80C4-005056815852') {
                $COMPANY = "COMPONENTES EL ORBE S.A.";
                $ENCABEZADO = "Teléfono:  +504 2242-6201 <br> Torre Agalta , piso 11, local 1117, Tegucigalpa, Honduras.";
                $UNeA = "CEO";
            } else if ($COMPANY == -3) {
                $COMPANY = "ATI CAPITAL SOLUTIONS S.A.";
                $ENCABEZADO = "";
                $UNeA = "ATI";
            } else if ($COMPANY == -4) {
                $COMPANY = "SISTEMAS CONVERGENTES S.A.";
                $ENCABEZADO = "Teléfono : (506) 2280-3355 <br> Apartado Postal: 236-1100 Tibás, San José, Costa Rica";
                $UNeA = "SISCON";
            } else if ($COMPANY == -5) {
                $COMPANY = "NOVA TECHNOLOGIES S.A.";
                $ENCABEZADO = "";
                $UNeA = "NOVA";
            }
            $HINICIO = $A['HINICIO'];

            if ($HINICIO != '') {
                $HINICIO2 = $HINICIO->format('Y-m-d H:i:s');
                $HINICIO2 = new DateTime($HINICIO2);
                $HINICIO = $HINICIO->format('d/m/Y H:i:s');
            }
            $HFIN = $A['HFIN'];
            $HFIN2 = $HFIN->format('Y-m-d H:i:s');
            $HFIN2 = new DateTime($HFIN2);
            $HFIN = $HFIN->format('d/m/Y H:i:s');

            $FREGISTRO = $A['FREGISTRO'];
            $FREGISTRO = $FREGISTRO->format('d/m/Y H:i:00');


            if ($SEND == 1 && ($A['HINICIO']->format('Y-m-d H:i:s') < $A['FREGISTRO']->format('Y-m-d H:i:00') || $A['HFIN']->format('Y-m-d H:i:s') < $A['FREGISTRO']->format('Y-m-d H:i:00'))) {
                trigger_error("La fecha de inicio o fin es inferior a la del registro del caso", E_USER_ERROR);
            }


            $intervalFechas = date_diff(date_create($A['HINICIO']->format('Y-m-d')), date_create($A['HFIN']->format('Y-m-d')));

            if (($intervalFechas->format('%a') != 0 && $A['CHECKPFDD'] != 1) || $HFIN2 < $HINICIO2) {
                trigger_error("Las fechas de inicio y fin no son del mismo día o la fecha de fin es menor a la fecha de inicio", E_USER_ERROR);
            }

            $OBSERV = utf8_encode($A['OBSERV']);
            $DESCRI = utf8_encode($A['PROBLEMA_REP']);
            $CEDULA = $A['CEDULA'];
            $FIRMAUSR = $A['FIRMAUSR'];
            $IMGCLIENTE = $A['IMGCLIENTE'];
            $IMGLOGO = $A['IMGLOGO'];

            $FECHAFIRM = $A['FECHAFIRM'];
            if ($FIRMAUSR != '') {
                $FECHAFIRM = $FECHAFIRM->format('d/m/Y H:i:s');
            }

            $FIRMATEC = $A['FIRMATEC'];
            $FFIRMATEC = $A['FFIRMATEC'];
            if ($FIRMATEC != '') {
                $FFIRMATEC = $FFIRMATEC->format('d/m/Y H:i:s');
            }

            if ($SEND == 1 && ((strtotime($A['FECHAFIRM']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) < 0) {
                trigger_error("La fecha de la firma del usuario es inferior a la fecha fin", E_USER_ERROR);
            }


            $SERIE = $A['SERIE'];
            $MODELO = $A['MODELO'];
            $PLACA = $A['PLACA'];
            $PRODUCTO = $A['PRODUCTO'];
            $MARCA = $A['MARCA'];

            $SERIE_CORRESP = $A['SERIE_CORRESP'];
            $SOFT_HARD = $A['SOFT_HARD'];
            $DANO_FIS = $A['DANO_FIS'];
            $ATENC_PEND = $A['ATENC_PEND'];
            $RAZON_PEND = utf8_encode($A['RAZON_PEND']);
            $PARTE_PEND = $A['PARTE_PEND'];
            $CAMBIO_COMP = $A['CAMBIO_COMP'];
            $SOLUCION = utf8_encode($A['SOLUCION']);
            $SOLUCION = str_replace('\n', '<br>', $SOLUCION);
            $TELEFONO = $A['TELEFONO'];
            $PROBLEMA_REP = utf8_encode($A['PROBLEMA_REP']);
            $PROBLEMA_REP = str_replace('\n', '<br>', $PROBLEMA_REP);
            $TBOL = utf8_encode($A['TBOL']);
            $IDCLIENTE = $A['IDCLIENTE'];
            $IDUSR = $A['IDUSR'];
            $CODHPE = utf8_encode($A['CODHPE']);

            $HTMLBOL = str_replace("%IMGLOGO%", $IMGLOGO, $HTMLBOL);
            $HTMLBOL = str_replace("%Cliente%", $CLIENTE, $HTMLBOL);
            $HTMLBOL = str_replace("%Institucion%", $NOMSEC, $HTMLBOL);
            $HTMLBOL = str_replace("%UNINEG%", $COMPANY, $HTMLBOL);
            $HTMLBOL = str_replace("%ENCABEZADO%", $ENCABEZADO, $HTMLBOL);
            $HTMLBOL = str_replace("%UNeA%", $UNeA, $HTMLBOL);
            $HTMLBOL = str_replace("%Codigo%", $CODPRE, $HTMLBOL);
            $HTMLBOL = str_replace("%Ubicacion%", $UBIC, $HTMLBOL);
            $HTMLBOL = str_replace("%fini%", $HINICIO, $HTMLBOL);
            $HTMLBOL = str_replace("%ffin%", $HFIN, $HTMLBOL);
            $HTMLBOL = str_replace("%Telefono%", $TELEFONO, $HTMLBOL);
            $HTMLBOL = str_replace("%tecn%", $TECNICO, $HTMLBOL);
            $HTMLBOL = str_replace("%TIPOBOL%", $TBOL, $HTMLBOL);
            $HTMLBOL = str_replace("%lic%", $LICIT, $HTMLBOL);
            $HTMLBOL = str_replace("%PROBLEMA%", $PROBLEMA_REP, $HTMLBOL);
            $HTMLBOL = str_replace("%CodHPE%", $CODHPE, $HTMLBOL);
            /*Si tiene atenciones relacionadas se aplica*/
            $SQLREL = sqlsrv_query($connARANDABD, "		SELECT
		CASE
		WHEN B.IDCLIENTE=1340 AND C.CAMPOSTR !='' THEN CONCAT('IDCC-',C.CAMPOSTR)
		ELSE CONCAT('AT-',A.IDAS)
		END RELACION,A.IDAS IDASACT FROM ATENCIONES_RELACION A WITH(NOLOCK)
		INNER JOIN ATENCIONES B WITH(NOLOCK) ON B.IDATENCION=A.IDAS
		LEFT JOIN DATOS_ADICIONALES C WITH(NOLOCK) ON C.TREGISTRO = 2 AND C.IDREGISTRO = B.IDATENCION AND C.IDCAMPO = 75
		WHERE A.IDAP='$IDATEN'");
            $ATENCIONES = '';
            while ($sqlf = sqlsrv_fetch_array($SQLREL)) {
                $RELACION = $sqlf['RELACION'];
                $ATENCIONES .= $RELACION . ', ';
                $IDASACT = $sqlf['IDASACT'];

                if ($SEND == 1) {
                    $IDUSR = $_SESSION['IDU'];
                    if ($ATENC_PEND == 1) {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '20' WHERE IDATENCION = '$IDASACT'");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDASACT','2','183','20','$IDUSR'");
                    } else {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDASACT'");
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDASACT','2','183','17','$IDUSR'");
                    }
                }
            }
            if ($ATENCIONES != '') {
                $ATENCIONES = rtrim($ATENCIONES, ', ');
                $SOLUCION .= '<br><b>Relaciones:</b> ' . $ATENCIONES;
            }

            if ($A['IDCLIENTE'] == 2066 && $A['FECHAFIRM'] != '' && $A['FFIRMATEC'] != '') {
                if ((((strtotime($A['FFIRMATEC']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) > 10 ||
                    ((strtotime($A['FECHAFIRM']->format('Y-m-d H:i')) - strtotime($A['HFIN']->format('Y-m-d H:i'))) / 60) > 10)  && $A['JUSTFFIRMA'] != '') {
                    $SOLUCION .= '<br><b>¿Porque la fecha y hora de firma supera los 10 minutos despues de la fecha y hora de salida?: </b> ' . $A['JUSTFFIRMA'];
                }
            }

            $HTMLBOL = str_replace("%SOLUCION%", $SOLUCION, $HTMLBOL);
            $HTMLBOL = str_replace("%NOMUSRAUT%", $NUSUARIO, $HTMLBOL);
            $HTMLBOL = str_replace("%CEDULA%", $CEDULA, $HTMLBOL);
            $HTMLBOL = str_replace("%FECHAFIRMA%", $FECHAFIRM, $HTMLBOL);
            $HTMLBOL = str_replace("%FIRMA%", $FIRMAUSR, $HTMLBOL);

            $HTMLBOL = str_replace("%FECHAFIRMATEC%", $FFIRMATEC, $HTMLBOL);
            $HTMLBOL = str_replace("%FIRMATEC%", $FIRMATEC, $HTMLBOL);

            $HTMLBOL = str_replace("%Bol%", $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%TITULO%", $IDATEN . " - " . $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%RepCEO%", "AT-" . $IDATENCION, $HTMLBOL);
            $HTMLBOL = str_replace("%Bol%", $BOLETA, $HTMLBOL);
            $HTMLBOL = str_replace("%Marca%", $MARCA, $HTMLBOL);
            $HTMLBOL = str_replace("%Modelo%", $MODELO, $HTMLBOL);
            $HTMLBOL = str_replace("%Prod%", $PRODUCTO, $HTMLBOL);
            $HTMLBOL = str_replace("%Serie%", $SERIE, $HTMLBOL);
            $HTMLBOL = str_replace("%Activo%", $PLACA, $HTMLBOL);
            $HTMLBOL = str_replace("%RepC%", $REPCLIENTE, $HTMLBOL);

            if ($SERIE_CORRESP == 1) {
                $HTMLBOL = str_replace("%SERIER1%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%SERIER2%", "  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%SERIER1%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%SERIER2%", "X", $HTMLBOL);
            }

            $HTMLBOL = str_replace("%Error%", $COD_ERROR, $HTMLBOL);

            if ($SOFT_HARD == "Software") {
                $HTMLBOL = str_replace("%soft%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%hard%", "  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%soft%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%hard%", "X", $HTMLBOL);
            }

            if ($IDCLIENTE != 1340) {
                if ($DANO_FIS == 1) {
                    $HTMLBOL = str_replace("%daño1%", "X", $HTMLBOL);
                    $HTMLBOL = str_replace("%daño2%", "  ", $HTMLBOL);
                } else {
                    $HTMLBOL = str_replace("%daño1%", "  ", $HTMLBOL);
                    $HTMLBOL = str_replace("%daño2%", "X", $HTMLBOL);
                }
            } else {
                $HTMLBOL = str_replace('%DISDF%', "display:none;", $HTMLBOL);
            }




            if ($ATENC_PEND == 1) {
                $HTMLBOL = str_replace("%Incidente1%", "X", $HTMLBOL);
                $HTMLBOL = str_replace("%Incidente2%", "  ", $HTMLBOL);
            } else {
                $HTMLBOL = str_replace("%Incidente1%", "  ", $HTMLBOL);
                $HTMLBOL = str_replace("%Incidente2%", "X", $HTMLBOL);
            }

            $SQL = sqlsrv_query($connARANDABD, "SELECT RET_SPARE,RET_CT,RET_DFPRT,RET_ESTPRT,INS_SPARE,INS_CT,B.NOMCAT LVL1,C.NOMCAT LVL2,D.NOMCAT LVL3 FROM SPEEDY_SOLTEC A WITH(NOLOCK)
LEFT JOIN SPEEDE_SOLTEC_CAT1 B WITH(NOLOCK) ON convert(varchar(36),B.IDU) = A.CATLVL1 AND B.ESTADO = 1
LEFT JOIN SPEEDE_SOLTEC_CAT2 C WITH(NOLOCK) ON convert(varchar(36),C.IDU) = A.CATLVL2 AND C.ESTADO = 1
LEFT JOIN SPEEDE_SOLTEC_CAT3 D WITH(NOLOCK) ON convert(varchar(36),D.IDU) = A.CATLVL3 AND D.ESTADO = 1
WHERE IDATEN='$IDATEN' AND RET_ESTPRT != 'DOA' AND CATLVL1 != '' AND CATLVL2 != '' AND CATLVL3 != ''");

            $PRTSINS = '
<table cellspacing="0" cellpadding="2" border="0" width="100%">
  <thead>
    <tr>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Parte Instalada Cliente</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Spare</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">CT</font></b></th>
    </tr>
  </thead>
  <tbody>';

            $PRTSRET = '
<table cellspacing="0" cellpadding="2" border="0" width="100%">
  <thead>
    <tr>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Partes a devolver</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top"> <b><font face="Calibri">Spare</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">CT</font></b></th>
      <th height="28" align="center" valign="top" bgcolor="#A6A6A6" style="border: 1px solid #000000;" align="center" valign="top" ><b><font face="Calibri">Estado</font></b></th>
    </tr>
  </thead>
<tbody>';

            while ($A = sqlsrv_fetch_array($SQL)) {
                $LVL1 = utf8_encode($A['LVL1']);
                $LVL2 = utf8_encode($A['LVL2']);
                $LVL3 = utf8_encode($A['LVL3']);
                $RET_SPARE = $A['RET_SPARE'];
                $RET_CT = $A['RET_CT'];
                $RET_DFPRT = $A['RET_DFPRT'];
                $RET_ESTPRT = $A['RET_ESTPRT'];
                $INS_SPARE = $A['INS_SPARE'];
                $INS_CT = $A['INS_CT'];

                $PRTSINS .= '<tr>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $LVL3 . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $INS_SPARE . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $INS_CT . '</font></td>
  </tr>';

                $PRTSRET .= '<tr>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . "$LVL1 / $LVL2 / $LVL3" . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_SPARE . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_CT . '</font></td>
    <td style="border: 1px solid #000000;" align="center" valign="top"><font color="#000000">' . $RET_ESTPRT . '</font></td>
  </tr>';
            }

            $PRTSINS .= '</tbody></table>';
            $PRTSRET .= '</tbody></table>';

            $HTMLBOL = str_replace("%PRTSINS%", $PRTSINS, $HTMLBOL);
            $HTMLBOL = str_replace("%PRTSRET%", $PRTSRET, $HTMLBOL);

            $fh = fopen("D:/SpeedyFiles/Boletas/SERVING/" . $IDATEN . " - " . $BOLETA . ".html", 'w+') or die("Se produjo un error al crear el archivo");
            fwrite($fh, $HTMLBOL) or die("No se pudo escribir en el archivo");
            fclose($fh);

            if ($SEND == 1) {

                $RESP = EnviarCorreo($HTMLBOL, "D:/SpeedyFiles/Boletas/SERVING/" . $IDATEN . " - " . $BOLETA . ".html", $IDATEN, $connARANDABD, 'SERVING');

                if ($RESP == 'Correo Enviado') {
                    if ($IDCLIENTE != 1340) {
                        EnviarEncuesta($IDATEN, $connARANDABD);
                    }
                    if ($ATENC_PEND == 1) {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '20' WHERE IDATENCION = '$IDATEN'");
                        $IDUSR = $_SESSION['IDU'];
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','20','$IDUSR'");
                    } else {
                        sqlsrv_query($connARANDABD, "UPDATE ATENCIONES SET IDESTADO = '17' WHERE IDATENCION = '$IDATEN'");
                        $IDUSR = $_SESSION['IDU'];
                        sqlsrv_query($connARANDABD, "EXEC SP_INS_DATA_INT '$IDATEN','2','183','17','$IDUSR'");
                    }
                }
            }



        ?>
            <script>
                $('#downBoleta').attr("href", "https://ti-obgroup.app:5557/SpeedyFiles/Boletas/SERVING/<?php echo $IDATEN; ?> - <?php echo $BOLETA; ?>.html");
                $('#downBoleta')[0].click();

                swal.fire({
                    <?php
                    if ($RESP == 'Correo Enviado' || $SEND == 0) {
                    ?>
                        icon: 'success',
                        text: 'Generación de boleta exitosa'
                    <?php
                    } else if ($RESP == 'El Correo no se pudo enviar: ya existe este numero de boleta') {
                    ?>
                        icon: 'info',
                        text: '<?php echo $RESP ?>'
                    <?php
                    } else {
                    ?>
                        icon: 'warning',
                        text: '<?php echo $RESP ?>'
                    <?php
                    }
                    ?>
                }).then((result) => {
                    if (result.value) {
                        //window.location.reload();
                    }
                });
            </script>
<?php

        }
    }
}



?>