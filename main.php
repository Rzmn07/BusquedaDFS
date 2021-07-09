<?php
function imprimir($matriz,$num){ #permite imprimir la matriz
    for($i = 0; $i < $num; $i++){
        for($j = 0; $j < $num; $j++){
            echo "{$matriz[$i][$j]}";
        }
    }
    echo "\n";
}
echo "(0) Usar archivo matriz.txt\n(1) Usar otro texto";
$opcion = readline("\nIngrese opcion: ");
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
$matriz = crear_matriz($matrizDFS,$numero); #genera una matriz numero x numero (arreglo x arreglo) con valor de 0s, esta sirve para almacenar los valores de la funcion recursiva generar_DFS
function generar_DFS($indice,$mat,$numero){ #genera una matriz global numero X numero lleno de 0's, esta sirve para almacenar los valores de la funcion recursiva generar_DFS
    $padre = array($indice);
    $padre[$indice] = 1;
    foreach(range(0,$numero) as $i){
        if($i == $indice){
            foreach(range(0,$numero) as $j){
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
    $array = explode("\t",fread($fp, filesize($thefile))); #leer cada linea del file, cada elemento separado por una tabulacion \t
    foreach(range(0,$numero) as $col){
        $matriz[$row][$col] = $array[$col];
    }
    $padre[$row] = 0;
}

echo "---------------------------------------------------------------------------\n\n";

echo "Martiz del grafo: \n";
imprimir($matriz,$numero); #Imprimir la matriz de adyacencia

for($y = 0; $y < $numero; $y++){
    if($y <= 25){
        echo $y." Vertice ".chr(65+$y).".";
    }else{
        $label = "";
        for($v = 0; $v <= ((65 + $y) / 26); $v++){
            $label += ((65+$v)/26);
        }
        echo $y." Vertice ".chr($label).".";
    }
}
echo "\n\n---------------------------------------------------------------------------\n\n";
$indice = readline("Ingrese el numero del vertice de inicio de la busqueda: ");
while($indice > $n){
    $indice = readline("Error: Numero de vertices excedido.\nIntente otra vez: ");
}
echo "\nMatriz DFS: \n";
$matrizresultante = generar_DFS($indice, $matriz, $numero);
imprimir($matrizresultante, $numero);
?>