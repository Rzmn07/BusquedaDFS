<?php
function imprimir($matriz,$numero){ #permite imprimir la matriz
    foreach(range(0,$numero) as $row){
        foreach(range(0,$numero) as $col){
            echo $matriz[$row][$col];
        }
    }
    echo "\n";
}
echo "(0) Usar archivo matriz.txt\n(1) Usar otro texto\n";
$opcion = readline("Ingrese opcion: ");
if($opcion == 0){
    $thefile = "matriz.txt";
}else{
    echo "El archivo de texto debe estar dentro de la carpeta Proyecto\n";
    $thefile = readline("Ingrese el nombre del archivo (no olvidar la extension .txt): ");
}

$padre = array(); #variable para saber si todos los vertices fueron visitados
function get_num_vertices($thefile){
    $content = file($thefile, FILE_IGNORE_NEW_LINES);
    return count($content);
}
$numero = get_num_vertices($thefile);
//Funcion para crear un arreglo bidimenasional con uso de foreach
function crear_matriz($gmat,$numero){
    foreach(range(0,$numero) as $row){
        foreach(range(0,$numero) as $col){
            $gmat[$row][$col] = 0;
        }
    }
    return $gmat;
}
$gmat = array();
$padre = array($numero);
$matrizDFS = crear_matriz($gmat,$numero); #genera una matriz numero x numero (arreglo x arreglo) con valor de 0s, esta sirve para almacenar los valores de la funcion recursiva generar_DFS
$matriz = crear_matriz($matrizDFS,$numero);
function generar_DFS($indice,$mat,$numero){ #genera una matriz global numero X numero lleno de 0's, esta sirve para almacenar los valores de la funcion recursiva generar_DFS
    $padre[$indice] = 1;
    vardump($numero);
    for($i = 0; $i<$numero; $i++){
        if($i == $indice){
            for($j = 0; $j<$numero; $j++){
                if($mat[$i][$j]==1 && $padre[$j]==0){ #si el vertice inicial esta conectado al vertice final y este no fue visitado
                    $matrizDFS[$i][$j] = 1;
                    generar_DFS($j,$mat,$numero);
                 } #se registra la conexion en la matriz dfs global
            }
        }
    }
     #los datos de la matriz global pasan a una matriz local
    return $matrizDFS; #se regresa la matriz DFS
}
crear_matriz($matriz,$numero);


#Importar datos de file "matriz.txt"
foreach(range(0,$numero) as $row){
    $array = file($thefile,FILE_IGNORE_NEW_LINES); #leer cada linea del file, cada elemento separado por una tabulacion \t
    foreach(range(0,$numero) as $col){
        $matriz[$row][$col] = $array[$col];
    }
    $padre[$row] = 0;
}

echo("---------------------------------------------------------------------------\n\n");

echo("Martiz del grafo: \n");
imprimir($matriz,$numero); #Imprimir la matriz de adyacencia

$n = $numero - 1;
foreach(range(0,$n) as $y){
    if($y <= 25){
        echo($y." Vertice ".chr(65+$y).".\n");
    }else{
        $label = "";
        foreach(range(0,((65+$y)/26)) as $v){
            $label += ((65+$v)/26);
        }
        echo($y." Vertice ".chr($label).".\n");
    }
}
echo "\n\n---------------------------------------------------------------------------\n\n";
$ind = readline("Ingrese el numero del vertice de inicio de la busqueda: ");
$indice = (int) $ind; //convertir dato de entrada a entero
while($indice > $n){
    $ind = readline("Error: Numero de vertices excedido.Intente otra vez: \n");
    $indice = (int) $ind;
}
echo "\nMatriz DFS: \n";
$matrizresultante = generar_DFS($indice, $matriz, $numero);
imprimir($matrizresultante, $numero);
?>
