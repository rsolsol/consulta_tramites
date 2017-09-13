<?php
                 
require_once("clases/conexion.php");

$numero = filter_input(INPUT_POST, 'txtNumeroExpediente');
$valor=filter_input(INPUT_POST, 'tipo');
$numerotxt = (strlen($numero)>5) ? $numero : null ;
    
if (!mysqli_set_charset($con, "utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($con));
    exit();
} else {
    printf("", mysqli_character_set_name($con));
}
        $peti = "SELECT 
                        tramite.nu_expe_todo AS expediente,
                        tramite.nu_foli_trmte AS folio,
                        SUBSTRING(tramite.fe_ingr_trmte, 1, 10) AS fecha,
                        tipo.de_tpo_trmte AS tramite,
                        area.de_area AS area,
                        usuario.no_crto AS contribuyente,
                        tramite.nu_docu_trmte AS documento,
                        tramite.cdgo_dto_trmte AS codigo
                FROM
				        p_dto_trmtes tramite
                                INNER JOIN
                        a_tpo_trmtes tipo ON tipo.cdgo_tpo_trmte = tramite.cdgo_tpo_trmte
                                INNER JOIN
                        a_areas area ON area.cdgo_area = tramite.cdgo_area
                                INNER JOIN
                        p_usrios usuario ON usuario.cdgo_usrios = tramite.cdgo_usrios
                WHERE
                        $valor = '$numerotxt' 
                ORDER BY tramite.fe_ingr_trmte DESC;";

		 $result = mysqli_query($con,$peti);
		 $rm=@mysqli_num_rows($result);
              
        if($rm!=0 && $rm<100)
        {
            echo "<div class='mock-table'>
                    <div>
                        <span>Nro. Expediente</span>
                        <span>Folio</span>
                        <span>Fecha de Ingreso</span>
                        <span>Tipo de Tramite</span>
                        <span>Area</span>
                        <span>Administrado</span>
                        <span>Seleccionar</span>						
                    </div>";
            while($fila=@mysqli_fetch_array($result,MYSQLI_ASSOC))
            {
                $x=$fila['codigo'];
                echo "<div>
                    <span data-label='Nro. Expediente'>".$fila['expediente']."</span>
                    <span data-label='Folio'>".$fila['folio']."</span>
                    <span data-label='Fecha de Ingreso'>".$fila['fecha']."</span>
                    <span data-label='Tipo de Tramite'>".$fila['tramite']."</span>
                    <span data-label='Area'>".$fila['area']."</span>
                    <span data-label='Administrado'>".$fila['contribuyente']."</span>	
                    <span data-label='Seleccionar'>
                        <input type='radio' id='".$x."' class='css-checkbox' name='cliente' value='".$x."' onchange='muestracliente(this.value)'/>
                        <label for='".$x."' class='css-label4 radGroup1'>
                        </label>
                    </span>						
                  </div>";
            }
            echo    "</div>";
        }
        else if ($rm>=200)  
        {
            ?>
              <span></span>           
            <?php
        }		 
        else   
        {
            ?>
              <span></span>
            <?php
        }
           ?>