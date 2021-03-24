<?php

function calculo($M,$C,$m){
    #DATOS 
    //$M = 1000;      #Monto al contado
   // $C = 9.47;      #Valor de cada cuota
   // $m = 144;       #Cantidad de meses a pagar

    #Auxiliares para calculo
    $i = 1;         #Interes mensual para inicio de iteracion
    $j = $m - 1;    #Exponente para iteracion de calculo de B

    $L = False;     #Interes mensual esta Listo?

    $imax = 0.99;   #Para operar con $f y hacer converger $i al valor real (cota superior)
    $imin = 0;      #Para operar con $f y hacer converger $i al valor real (cota inferior)

    #Loop para calculo de interes mensual
    $t1 = time();
    $t2 = 0;

    
    while ($L == FALSE){
        
        $B = 0;

        for ($k = 0; $k <= $j; $k++){
            $B = $B + (1 + $i)**$k;
        }

        #$X = ( (-1)* $M * ((1 + $i)**$m) ) + ( $C * $B )
        $A = (1 + $i)**$m;      
        $A = $M * $A;
        $D = $C * $B;

        $X = $D - $A;   #Delta entre costo contado y costo con interes $i actual

        //echo "InteresMensual = ". $i ." | A = -". $A ." | D = ". $D ." | X = ". $X ."<br>";

        if (-0.09 <= $X and $X <= 0.09){  //CAUSA BUCLE  #Revisa si el valor del delta es aceptable y sale de iteracion
            $L = TRUE;
        } elseif ($X < -0.09){               #Delta es negativo, acotamos rango superior a $i actual
            $imax = $i;
            $f = ($imax + $imin)/2;
            $i = $f;
        } elseif ($X > 0.09){                #Delta es positivo, acotamos rango inferior a $i actual
            $imin = $i;
            $f = ($imax + $imin)/2;
            $i = $f;
        } 
        
        $t2 = time();
        if($t2-$t1 > 4){
            
            return array("CAE" => $CAE, "costoTotal" => $T, "error" => 1);
            
        }
    }
    #En este punto el interes mensual ($i) esta en rango aceptado

    #Calculo de CAE
    if ($L == TRUE){                        #Verifica que no hubo ERROR en calculo e imprime
        $CAE = ((1 + $i)**12 - 1) * 100;    #CAE en %
        $T = $C * $m;                       #Costo total en cuotas

        //echo "CAE = ". $CAE."% | Costo total en cuotas= $". $T;
        return array("CAE" => $CAE, "costoTotal" => $T ,"error" => 0);
    }else{
        echo "ERROR en calculo";
    }
}

//print_r(calculo(1000,110,10));
?>