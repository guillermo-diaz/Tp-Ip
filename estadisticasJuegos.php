<?php


/**
 *Precarga de la info del producto más vendido del mes
 * 
 * @return Array listado de juegos
 */
function precarga_juegos_mas_ventas(){
    $juego_mas_ventas[0] = ["juego" => 'Montaña Rusa', "precio" => 200.5, "cant" => 50];
    $juego_mas_ventas[1] = ["juego" => 'Rueda de la Fortuna', "precio" => 50.0, "cant" => 120];
    $juego_mas_ventas[2] = ["juego" => 'Carrusel', "precio" => 30.0, "cant" => 300];
    $juego_mas_ventas[3] = ["juego" => 'Barco Pirata', "precio" => 150.0, "cant" => 30];
    $juego_mas_ventas[4] = ["juego" => 'Laser Tag', "precio" => 190.0, "cant" => 70];
    $juego_mas_ventas[5] = ["juego" => 'Montaña Rusa', "precio" => 200.5, "cant" => 30];
    $juego_mas_ventas[6] = ["juego" => 'Autitos Chocadores', "precio" => 140.0, "cant" => 60];
    $juego_mas_ventas[7] = ["juego" => 'Paseo Oscuro', "precio" => 40.0, "cant" => 250];
    $juego_mas_ventas[8] = ["juego" => 'Viaje en tren', "precio" => 70.0, "cant" => 70];
    $juego_mas_ventas[9] = ["juego" => 'El Martillo', "precio" => 180.0, "cant" => 100];
    $juego_mas_ventas[10] = ["juego" => 'Sillas Voladoras', "precio" => 200.0, "cant" => 120];
    $juego_mas_ventas[11] = ["juego" => 'Rueda de la Fortuna', "precio" => 50.0, "cant" => 300];
    return $juego_mas_ventas;
}

/**
 * precarga de la info del monto total de los juegos del mes
 * 
 * @return Array monto total de todos los meses
 */
function precarga_monto_total_tickets($juego_mas_ventas){
    
    foreach ($juego_mas_ventas as $juego) { 
       $tickets[] = $juego["precio"]*$juego["cant"];
    }
    return $tickets;
}

/**
 * Muestra las opciones del menu
 * 
 * @param 
 * 
 * @return void
 */
function menu(){
    do {
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
        $opcion = trim(fgets(STDIN));

        $salir = $opcion > 0 && $opcion <7;
        if (!$salir){
            echo "ERROR: Ingrese una opcion válida";
        }
    } while (!$salir);
    return $opcion;
}

/**
 * Menu principal del programa
 * @param array arreglo con los juegos de mayor venta en cada mes
 * @param array arreglo con los montos totales de cada mes
 */
function menu_opciones(&$juego_mas_ventas, &$tickets){

    do {
        $opcion = menu();
        //echo("\n");

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
                $mesMayor = buscar_mes_mayor_ventas($tickets);
                mostrar_info_mes($juego_mas_ventas, $tickets, $mesMayor);
                break;
            case 3: 
                $monto = solicitar_monto_de_venta();
                $primer_mes = buscar_primer_mes_mayor_venta($tickets, $monto);
                if ($primer_mes != -1){
                    mostrar_info_mes($juego_mas_ventas, $tickets, $primer_mes);
                } else {
                    echo "No existe ningún mes que supere este monto";
                }
                
                break;
            case 4: 
                $index = solicitar_mes();
                mostrar_info_mes($juego_mas_ventas, $tickets, $index);
                break;
            case 5: 
                /*$juegos_ordenados = heap_sort($juego_mas_ventas);
                print_r($juegos_ordenados);*/
                

                $juegos_ordenados = array_merge($juego_mas_ventas);
                uasort($juegos_ordenados, "comparar_juegos");
                print_r($juegos_ordenados);
                break; 
            case 6: 
                echo "Saliendo...";
                break;
            }               
    } while ($opcion != 6);
}

/**
 * Busca el primer mes que supere el monto de venta ingresado
 * Retorna -1 si no hubo ningun mes que supere el monto
 * @param array $tickets array de los montos totales de todos los meses
 * @param $monto monto ingresado
 * @return int indice del mes
 */
function buscar_primer_mes_mayor_venta(&$tickets, $monto){
    $mes = -1;
    $limite = count($tickets);
    $i = 0;

    while ($mes == -1 && $i < $limite){
        if ($tickets[$i] > $monto){
            $mes = $i;
        } else {
            $i++;
        }
    }
    return $mes;
}

/**
 * solicita un monto de ventas
 * @return float $monto ingresado
 */
function solicitar_monto_de_venta(){
    do {
        echo "Ingrese el monto de venta: \n";
        $monto = trim(fgets(STDIN));
        $flag = $monto > 0 && is_numeric($monto); //si es un numero y es coherente
        if (!$flag){
            echo "ERROR: Ingrese un monto coherente\n";
        }
    } while (!$flag);
    return $monto;
}
/**
 * busca el mes con mayor monto de ventas
 * @param array $tickets arreglo de los monto totales de todos los meses
 * @return int $mes indice del mes
 */
function buscar_mes_mayor_ventas($tickets){
    $mes = 0; //tomo a enero como el mayor inicialmente
    $montoAux = $tickets[0]; //dejo como primer monto el mes de enero y comparo con los demás
    $limite = count($tickets);

    for ($i = 1; $i < $limite; $i++){
        if ($montoAux < $tickets[$i]){
            $mes = $i;
            $montoAux = $tickets[$i];
        } 
    } 
    return $mes;
}

/**
 * muestra la informacion completa del mes indicado
 * @param array arreglo con los juegos de mayor venta en cada mes
 * @param array arreglo con los montos totales de cada mes
 * @param int indice del mes
 */
function mostrar_info_mes($juego_mas_ventas, $tickets, $index){
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

/**
 * Verifica si el juego ingresado es mayor que el juego cargado en el mes
 * Si es mayor, lo reemplaza en el arreglo
 * @param array $juego_mas_ventas referencia al array de los juegos con mayor venta en cada mes
 * @param string $nombre nombre del juego ingresado
 * @param int $mes 
 * @param int $cant cantidad de tickets vendidos
 * @param float $precio precio del juego
 */
function actualizar_juego_del_mes(&$juego_mas_ventas, $nombre, $mes, $precio, $cant){
    $montoJuego = $precio * $cant; //monto del juego ingresado
    $montoActual = $juego_mas_ventas[$mes]["precio"]*$juego_mas_ventas[$mes]["cant"]; //monto del mes

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
        $cant = trim(fgets(STDIN));
        $flag = $cant > 0 && is_numeric($cant);//si es un numero y es coherente
        if (!$flag){
            echo "ERROR: Ingrese una cantidad coherente\n";
        }
    } while (!$flag);
    return $cant;
}

/**
 * solicita el precio del producto que vendio en el mes
 * @return float precio
 */
function solicitar_precio(){
    
    do {
        echo "Ingrese el precio del juego: \n";
        $precio = trim(fgets(STDIN));
        $flag = $precio > 0 && is_numeric($precio);//si es un numero y es coherente
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
        default: 
            $index = -1;
            break;                
    }
    return $index;
}



/**
 * Metodo de ordenamiento heapsort para ordenar los juegos del parque
 * @param array juegos con mayor monto de venta de cada mes
 * @return array juegos ordenados de menor a mayor
 */
function heap_sort(&$juegos){
    $fin = count($juegos)-1;
    $ret = []; //arreglo a retornar
    $pos = 0; //pos para moverme por el arreglo a retornar

    //lo convierto en un heap max al otro arreglo
    for ($i = $fin; $i >= 0; $i--){
        $ret[$pos] = $juegos[$i];
        sift_up($ret, $pos +1); //le sumo uno para que pueda ser de [1, n]
        $pos++;  
    }

    while (0 < $fin){ //mientras el heap tenga elementos
        //elimino la cima, reemplazo con el ult elemento del heap
        $temp = $ret[0];
        $ret[0] = $ret[$fin];
        $ret[$fin] = $temp;
        $fin--; //disminuyo el fin 

        sift_down($ret, 1, $fin); //hundo el elemento que quedó en la cima
    }
    return $ret;
}

/**
 * Compara 2 juegos por el total de ventas que tuvieron en el mes
 * Retorna un numero negativo si juego1 < juego2
 * Retorna 0 si juego1 = juego2
 * Retorna un numero positivo si juego1 > juego2
 * 
 * @param juego $juego1 
 * @param juego $juego2
 * @return int valor de la comparacion
 */
function comparar_juegos($primer_juego, $segundo_juego){
    $monto1 = $primer_juego["precio"] * $primer_juego["cant"];
    $monto2 = $segundo_juego["precio"] * $segundo_juego["cant"];
    return $monto1 - $monto2;
}

/**
 * Verifica si el elem de la pos_hijo cumple la propiedad de heap max
 * Si no la cumple, lo empuja hacia arriba sucesivamente (lo intercambia con su padre), hasta cumplir dicha propiedad
 * 
 * @param array arreglo de juegos
 * @param int posicion del hijo (tiene que ser: (pos = posicion original + 1) por cuestiones de diseño
 * 
 */
function sift_up(&$arr, $pos_hijo){
    $aux = $arr[$pos_hijo-1];
    $flag = false;

    while (!$flag){
        $pos_padre = ($pos_hijo / 2)-1; 
        if ($pos_padre >= 0){ //si tiene padre
            if (comparar_juegos($aux, $arr[$pos_padre]) > 0){ //si no comple la prop heap (su padre no es mayor que su hijo) lo intercambio
                $arr[$pos_hijo-1] = $arr[$pos_padre];
                $arr[$pos_padre] = $aux;
                $pos_hijo = $pos_padre+1;
            }else {
                $flag = true; //ya cumple prop heap
            }
        } else {
            $flag = true; //es raiz
        }
    }
}


/**
 * Verifica si el elem de la pos_padre cumple la propiedad de heap max
 * Si no la cumple, lo hunde sucesivamente (se intercambia con su hijo), hasta cumplir dicha propiedad
 * @param array arreglo de juegos
 * @param int $pos_padre posicion del padre que hay que acomodar. Ttiene que ser: (pos = posicion original + 1) por cuestiones de diseño
 * @param int $ultimo posicion del limite hasta donde se quiere hundir
 */
function sift_down(&$arr, $pos_padre, $ultimo){
    $pos_hijo = ($pos_padre *2)-1;
    $temp = $arr[$pos_padre-1];
    $flag = false;

    while (!$flag && $pos_hijo <= $ultimo){
        if ($pos_hijo < $ultimo){ //si es menor estricto tiene HD
            if (comparar_juegos($arr[$pos_hijo+1], $arr[$pos_hijo]) > 0 ){ //si el HD es el mayor me muevo hacia el
                $pos_hijo++; 
            }
        }
        
        if (comparar_juegos($temp, $arr[$pos_hijo])< 0){ //si el padre no es mayor que sus hijos los intercambio
            $arr[$pos_padre-1] = $arr[$pos_hijo];
            $arr[$pos_hijo] = $temp;
            $pos_padre = $pos_hijo+1;  //pos_padre tiene que tener la pos original + 1
            $pos_hijo = ($pos_padre*2)-1; 
        } else {
            $flag = true;
        }
    }
}


/* Inicio del programa*/
$array_juegos = precarga_juegos_mas_ventas();
$array_tickets = precarga_monto_total_tickets($array_juegos);
print_r($array_tickets);
menu_opciones($array_juegos, $array_tickets);



?>













