<?php


/**
 *Precarga de la info del producto más vendido del mes
 * 
 * @return Array listado de juegos
 */
function precarga_juegos_mas_ventas(){
    $juego_mas_ventas[0] = ["juego" => 'Montaña Rusa', "precio" => 200.5, "cant" => 100];
    $juego_mas_ventas[1] = ["juego" => 'Rueda de la Fortuna', "precio" => 50.0, "cant" => 120];
    $juego_mas_ventas[2] = ["juego" => 'Carrusel', "precio" => 30.0, "cant" => 300];
    $juego_mas_ventas[3] = ["juego" => 'Barco Pirata', "precio" => 150.0, "cant" => 30];
    $juego_mas_ventas[4] = ["juego" => 'Laser Tag', "precio" => 190.0, "cant" => 70];
    $juego_mas_ventas[5] = ["juego" => 'Montaña Rusa', "precio" => 200.5, "cant" => 50];
    $juego_mas_ventas[6] = ["juego" => 'Autitos Chocadores', "precio" => 140.0, "cant" => 60];
    $juego_mas_ventas[7] = ["juego" => 'Paseo Oscuro', "precio" => 40.0, "cant" => 250];
    $juego_mas_ventas[8] = ["juego" => 'Viaje en tren', "precio" => 70.0, "cant" => 70];
    $juego_mas_ventas[9] = ["juego" => 'El Martillo', "precio" => 180.0, "cant" => 100];
    $juego_mas_ventas[10] = ["juego" => 'Sillas Voladora', "precio" => 200.0, "cant" => 120];
    $juego_mas_ventas[11] = ["juego" => 'Rueda de la Fortuna', "precio" => 50.0, "cant" => 300];
    return $juego_mas_ventas;
}

/**
 * precarga de la info del monto total de los juegos del mes
 * 
 * @return Array 
 */
function precarga_monto_total_tickets($juego_mas_ventas){
    
    foreach ($juego_mas_ventas as $juego) { 
       $tickets[] = $juego["precio"]*$juego["cant"];
    }
    return $tickets;
}

/* Inicio del programa*/
$juego_mas_ventas = precarga_juegos_mas_ventas();
$tickets = precarga_monto_total_tickets($juego_mas_ventas);
menu_opciones($juego_mas_ventas, $tickets);

/**
 * Muestra las opciones del menu
 * 
 * @param 
 * 
 * @return void
 */
function menu(){
    echo <<<END

    --------------------------------- Menu ---------------------------------
        1) Ingresar una Venta
        2) Mostrar mes con mayor monto de ventas
        3) Mostrar primer mes que supera un monto de ventas
        4) Mostrar información del mes
        5) Ordenar y mostrar juegos de menor a mayor por monto de venta
        6) Salir
    ------------------------------------------------------------------------
    - Ingrese una opcion: 
    END;
    return fgets(STDIN);
}

/**
 * Menu principal del programa
 */
function menu_opciones(&$juego_mas_ventas, &$tickets){

    do {
        $opcion = menu();
        echo("\n");

        switch($opcion){
            case 1: 
                $mes = solicitar_mes();
                $nombre = solicitar_nombre();
                $precio = solicitar_precio();
                $cant = solicitar_cantidad();
                $tickets[$mes] = $tickets[$mes] + $precio * $cant;
                actualizar_juego_del_mes($juego_mas_ventas, $nombre, $mes, $precio, $cant);
                break;
            case 2: 
                
                break;
            case 3: 
                
                break;
            case 4: 
                $index = solicitar_mes();
                mostrar_info_mes($juego_mas_ventas, $tickets, $index);
                
                break;
            case 5: 
                break; 
            case 6: 
                break;               
            default: 
                echo "Ingrese una opcion valida";
                break;
        }
    } while ($opcion != 6);
}

/**
 * mostrar la informacion del mes
 * @param array arreglo con los juegos de mayor venta en cada mes
 * @param array arreglo con los montos totales de cada mes
 * @param int indice del mes
 */
function mostrar_info_mes(&$juego_mas_ventas, &$tickets, $index){
    $nombre = $juego_mas_ventas[$index]["juego"];
    $precio = $juego_mas_ventas[$index]["precio"];
    $cant = $juego_mas_ventas[$index]["cant"];
    $venta_total = $precio * $cant;
    $monto = $tickets[$index];
    $mes = indice_a_mes($index);

    echo <<<END

    <$mes>                                                                                 
        - Info del juego más vendido del mes:
             Nombre del juego con mayor venta del mes: $nombre     
             Precio del juego: $precio                               
             Cantidad de tickets del juego: $cant                    
             Venta total del juego: $venta_total                     
                                                             
        - Monto total de ventas del mes: $monto                   

    END;
} 

function actualizar_juego_del_mes(&$juego_mas_ventas, $nombre, $mes, $precio, $cant){
    $montoJuego = $precio * $cant;
    $montoActual = $juego_mas_ventas[$mes]["precio"]*$juego_mas_ventas[$mes]["cant"];

    if ($montoJuego > $montoActual){
        $juego_mas_ventas[$mes] = ["juego" => $nombre, "precio" => $precio, "cant" => $cant];
    }
}

/**
 * solicita la cantidad de productos que vendio en el mes
 * @return int cantidad
 */
function solicitar_cantidad(){
    do {
        echo "Ingrese la cantidad que vendio en el mes: \n";
        $precio = trim(fgets(STDIN));
        $flag = $precio > 0;
        if (!$flag){
            echo "ERROR: Ingrese una cantidad coherente\n";
        }
    } while (!$flag);
    return $precio;
}

/**
 * solicita el precio del producto que vendio en el mes
 * @return float precio
 */
function solicitar_precio(){
    
    do {
        echo "Ingrese el precio del juego: \n";
        $precio = trim(fgets(STDIN));
        $flag = $precio > 0;
        if (!$flag){
            echo "ERROR: Ingrese un precio coherente\n";
        }
    } while (!$flag);
    return $precio;
}

/**
 * solicita el nombre del producto 
 * @return string nombre
 */
function solicitar_nombre(){
    do {
        echo "Ingrese el nombre del juego: \n";
        $nombre = trim(fgets(STDIN));
        $flag = empty($nombre);
        if ($flag){
            echo "ERROR: No ingrese un nombre vacio \n";
        }
    } while ($flag);
    return $nombre;
}

/**
 * solicita el nombre del mes 
 * @return int indice del mes
 */
function solicitar_mes(){
    
    do {
        echo "Ingrese el nombre del mes de la venta: \n";
        $index = mes_a_indice(trim(fgets(STDIN)));
        if ($index == -1){
            echo "ERROR: el mes no existe \n";
        }
    } while ($index == -1);
    return $index;
}

/**
 * Devuelve el mes que le corresponde al indice que entra por param. 
 * El indice debe estar entre [0, 11]
 * @param int indice 
 * @return string devuelve un string con un mes o uno invalido en caso de exceder el rango
 */
function indice_a_mes($index){
    $mes = "Mes invalido";
    if ($index >= 0 && $index <= 11) { 
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
         "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $meses[$index];
    } 
    return $mes;
}


/**
 * Convierte un mes al indice al que le corresponde. Devuelve -1 si el mes no existe
 * 
 * @param string nombre del mes a convertir
 * @return int devuelve el indice del mes
 */
function mes_a_indice($mes){
    $mes = strtolower($mes); //lo paso a miniscula para evitar problemas de mayus
    $index = -1; 

    switch($mes){
        case "enero": 
            $index = 0;    
            break;
        case "febrero": 
            $index = 1;
            break;
        case "marzo": 
            $index = 2;
            break;
        case "abril": 
            $index = 3;
            break;
        case "mayo": 
            $index = 4;
            break; 
        case "junio": 
            $index = 5;
            break; 
        case "julio": 
            $index = 6;      
            break;
        case "agosto": 
            $index = 7;    
            break;
        case "septiembre": 
            $index = 8;    
            break;
        case "octubre": 
            $index = 9;    
            break;
        case "noviembre": 
            $index = 10;    
            break; 
        case "diciembre": 
            $index = 11;
            break;                  
    }
    return $index;
}




?>













