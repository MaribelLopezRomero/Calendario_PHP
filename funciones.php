<?php

//Generar el calendario

function calendario($año_calendario_, $dia_empieza)
{


    $año = [];

    $septiembre = ["dias" => 30, "inicio" => $dia_empieza, "inicio-curso" => 8, "fin-curso" => 0, "festivos" => [], "no-lectivo" => [], "vacaciones" => []];

    $octubre = ["dias" => 31, "inicio" => 0, "inicio-curso" => 0, "fin-curso" => 0, "festivos" => [12 => "Dia del Pilar"], "no-lectivo" => [31], "vacaciones" => []];

    $noviembre = ["dias" => 30, "inicio" => 0, "inicio-curso" => 0, "fin-curso" => 0, "festivos" => [1 => "Dia de todos los Santos"], "vacaciones" => []];

    $diciembre = ["dias" => 31, "inicio" => 0, "inicio-curso" => 0, "fin-curso" => 0, "festivos" => [6 => "Dia de la Constitucion", 8 => "Día de la Inmaculada Concepción"], "no-lectivo" => [5, 7], "vacaciones" => [23, 24, 25, 25, 26, 27, 28, 29, 30, 31]];

    $enero = ["dias" => 31, "inicio" => 0, "inicio-curso" => 0, "fin-curso" => 0, "festivos" => [], "no-lectivo" => [], "vacaciones" => [1, 2, 3, 4, 5, 6, 7, 8]];


    //Febrero bisiesto o no.

    if (esBisiesto($año_calendario_ + 1)) {
        $febrero = ["dias" => 29, "inicio" => 0, "inicio-curso" => 0, "festivos" => [], "no-lectivo" => [24, 27], "vacaciones" => []];
    } else {
        $febrero = ["dias" => 28, "inicio" => 0, "inicio-curso" => 0, "festivos" => [], "no-lectivo" => [24, 27], "vacaciones" => []];
    }

    //Determinar la semana santa

    $arraysSemanaSanta = pascua(($año_calendario_ + 1));

    $arraySemanaSantaMarzo =  $arraysSemanaSanta[0];
    $arraySemanaSantaAbril =  $arraysSemanaSanta[1];


    //Viernes no lectivo de semana santa.
    $arraysViernesNoLectivos = viernesNoLectivo(($año_calendario_ + 1));
    $ViernesNoLectivoMarzo = $arraysViernesNoLectivos[0];
    $ViernesNoLectivoAbril = $arraysViernesNoLectivos[1];


    $marzo = ["dias" => 31, "inicio" => 0, "inicio-curso" => 0, "fin-curso" => 0, "festivos" => [20 => "Dia del padre"], "no-lectivo" => [$ViernesNoLectivoMarzo], "vacaciones" =>
    $arraySemanaSantaMarzo];

    $abril = ["dias" => 30, "inicio" => 0, "inicio-curso" => 0, "fin-curso" => 0, "festivos" => [], "no-lectivo" => [$ViernesNoLectivoAbril], "vacaciones" =>  $arraySemanaSantaAbril];

    $mayo = ["dias" => 31, "inicio" => 0, "inicio-curso" => 0, "fin-curso" => 0, "festivos" => [1 => "Dia de los Trabajadores", 2 => "Dia de la Comunidad de Madrid"], "no-lectivo" => [], "vacaciones" => []];

    $junio = ["dias" => 31, "inicio" => 0, "inicio-curso" => 0, "fin-curso" => 22, "festivos" => [], "no-lectivo" => [], "vacaciones" => []];



    $año["septiembre"] = $septiembre;
    $año["octubre"] = $octubre;
    $año["noviembre"] = $noviembre;
    $año["diciembre"] = $diciembre;
    $año["enero"] = $enero;
    $año["febrero"] = $febrero;
    $año["marzo"] = $marzo;
    $año["abril"] = $abril;
    $año["mayo"] = $mayo;
    $año["junio"] = $junio;



    //Generar el año

    $año_Generado = añoGenerado($año);


    //CALENDARIO

    $año_calendario = $año_calendario_;
    $año_calendario1 = $año_calendario_ + 1;

    echo "<h1 class='title-año'>  Calendario $año_calendario / $año_calendario1 </h2>";
    echo "<div class='calendario'>";

    $arrayNombreMeses = ["Septiembre", "Octubre", "Noviembre", "Diciembre", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"];
    $n_mes = 0;


    $dia_empieza_mes = 0; //la tengo que inicializar fuera

    foreach ($año_Generado as $meses_Generados) {

        echo "<div class='mes'>";

        echo "<h2 class='title'> $arrayNombreMeses[$n_mes]</h2>";
        echo "<div class='day-name name'>L</div>";
        echo "<div class='name'>M</div>";
        echo "<div class='name'>X</div>";
        echo "<div class='name'>J</div>";
        echo "<div class='name'>V</div>";
        echo "<div class='name'>S</div>";
        echo "<div class='name'>D</div>";

        $inicio = 0; //Chivato para el dia que empieza el mes, asignarle despues del grid-strat




        //DIA DONDE EMPEZAR A PINTAR DEL MES (A partir del segundo mes)
        if ($meses_Generados[0]["inicio"] == 0) {

            $meses_Generados[0]["inicio"] = $dia_empieza_mes;
        }

        //FINES DE SEMANA
        $fin_de_semana = $meses_Generados[0]["inicio"] - 1; //ponemos uno menos que el dia inicio, porque en la primera vuelta al aumentar ++ no estaria contando el dia actual 

        //NUMEROS DEL MES
        $dia_numero = 1;

        //RECORRO LOS MESES

        foreach ($meses_Generados  as $dia) {

            //para colocar el dia que empieza el mes en su posicion.

            if ($dia["inicio"] != 0) {
                $inicio = 1;
                $day_first = $dia["inicio"];
            }

            //para hallar los fines de semana

            if ($fin_de_semana == 7) {
                $fin_de_semana = 0;
            }

            $fin_de_semana++;

            //pintar los dias 

            if ($fin_de_semana == 6 || $fin_de_semana == 7) {
                finde($inicio, $dia, $day_first, $dia_numero);
            } else {
                normal($inicio, $dia, $day_first, $dia_numero);
            }

            $inicio = 0;
            $dia_numero++;
        }

        echo "</div>";

        $n_mes++;

        $dia_empieza_mes = $fin_de_semana + 1; //determino el dia donde empezara el mes siguiente

        if ($dia_empieza_mes > 7) {
            $dia_empieza_mes = 1;
        }
    }

    echo "</div>";
}

//Año bisiesto

function esBisiesto($año)
{
    return !($año % 4) && ($año % 100 || !($año % 400)); //bisiesto si es divisible entre 4 y no entre 100. O divisible entre 100 y 400
}

//Generar año

function añoGenerado($año)
{


    $año_Generado = [];

    foreach ($año as $meses => $mes) {

        $mes_Generado = mes($año[$meses]);
        array_push($año_Generado, $mes_Generado);
    }

    return $año_Generado;
}


//Semana Santa

function pascua($añoPascua)
{

    $pascua =  date("d", easter_date($añoPascua));

    $pascuaMes =  date("m", easter_date($añoPascua));

    //Semana Santa en Marzo

    $arraySemanaSantaMarzo = [];

    if ($pascuaMes == 04) {

        $diaComienzoMarzo = (31 - 7) + $pascua;

        //Parte de la semana santa en marzo
        if ($diaComienzoMarzo <= 31) {

            for ($diaSemanaSanta = $diaComienzoMarzo; $diaSemanaSanta <= 31; $diaSemanaSanta++) {

                array_push($arraySemanaSantaMarzo, $diaSemanaSanta);
            }
        }
    } else {
        //semana santa completa en marzo marzo
        $diaComienzoSemanaSanta = $pascua - 7;
        $diaPascuaMarzo = $pascua;
        for ($diaSemanaSanta =  $diaComienzoSemanaSanta; $diaSemanaSanta <= $diaPascuaMarzo; $diaSemanaSanta++) {

            array_push($arraySemanaSantaMarzo, $diaSemanaSanta);
        }
    }

    //Semana santa en abril (parte o completa)
    $arraySemanaSantaAbril = [];

    if ($pascuaMes == 04) {

        $diaComienzoSemanaSanta = $pascua - 7;

        for ($diaSemanaSanta = ($diaComienzoSemanaSanta + 1); $diaSemanaSanta <= $pascua; $diaSemanaSanta++) {

            if ($diaSemanaSanta > 0) {
                array_push($arraySemanaSantaAbril, $diaSemanaSanta);
            }
        }
    }

    return [$arraySemanaSantaMarzo, $arraySemanaSantaAbril];
}


//Viernes no lectivo de semana santa

function viernesNoLectivo($añoPascua)
{


    //viernes anterior de semana santa Festivo siempre seran 9 dias menos desde la pascua (domingo). Seria por tanto el viernes el decimo dia.

    $pascua =  date("d", easter_date($añoPascua));

    $pascuaMes =  date("m", easter_date($añoPascua));

    $ViernesNoLectivo = $pascua - 9;

    $ViernesNoLectivoMarzo = null;
    $ViernesNoLectivoAbril  = null;


    if ($pascuaMes == 4) {

        if ($ViernesNoLectivo == 0) {
            $ViernesNoLectivoMarzo = 31; //cae el ultimo dia de  marzo
        } else if ($ViernesNoLectivo < 0) {
            $ViernesNoLectivoMarzo = 31 + $ViernesNoLectivo; //se suma porque el numero es negativo. para que de el dia de marzo correcto.

        } else { //cae en abril
            $ViernesNoLectivoAbril = $ViernesNoLectivo;
        }
    } else {
        $ViernesNoLectivoMarzo = $ViernesNoLectivo;
    }

    return [$ViernesNoLectivoMarzo, $ViernesNoLectivoAbril];
}

//Generar el mes

function mes($mes)

{
    $mesGenerado = [];

    $dias = $mes["dias"];

    //Añadimos en cada posicion de cada mes (tantas como dias tenga el mes), un array con los valores por defecto de cada dia

    for ($i = 0; $i < $dias; $i++) {

        array_push($mesGenerado, ["inicio" => 0,  "inicio-curso" => "no", "fin-curso" => "no", "festivo" => "no", "fiesta" => "no", "no-lectivo" => "no", "vacaciones" => "no"]);
    }

    //modificamos valores en funcion de las claves y el dia

    foreach ($mes as $key => $value) {
        if ($key == "inicio") {
            if ($value != 0) {
                $mesGenerado[0]["inicio"] = $value;
            }
        }
    }


    //Si el dia es festivo,añadir si a la key festivo del array $mesGenerado

    foreach ($mes as $key => $value) {
        if ($key == "festivos") {
            foreach ($value as $festivo => $n_fiesta) {

                $mesGenerado[$festivo - 1]["festivo"] = "si";
                $mesGenerado[$festivo - 1]["fiesta"] = $n_fiesta;
            }
        }
    }

    // Si el dia es no-lectivo ,añadir si a la key no-lectivo del array $mesGenerado

    foreach ($mes as $key => $value) {
        if ($key == "no-lectivo") {
            foreach ($value as $no_lectivo) {
                if ($no_lectivo != null) { //por el viernes festivo de semana santa
                    $mesGenerado[$no_lectivo - 1]["no-lectivo"] = "si";
                }
            }
        }
    }

    // Si el dia es de vacaciones ,añadir si a la key vacaciones del array $mesGenerado

    foreach ($mes as $key => $value) {
        if ($key == "vacaciones") {
            foreach ($value as $vacaciones) {
                $mesGenerado[$vacaciones - 1]["vacaciones"] = "si";
            }
        }
    }

    // Si el dia es de inicio curso, añadir si a la key inicio-curso del array $mesGenerado

    foreach ($mes as $key => $value) {
        if ($key == "inicio-curso") {
            if ($value > 1) {
                $mesGenerado[$value - 1]["inicio-curso"] = "si";
            }
        }
    }

    // Si el dia es de fin de curso, añadir si a la key fin-curso del array $mesGenerado

    foreach ($mes as $key => $value) {
        if ($key == "fin-curso") {
            if ($value > 1) {
                $mesGenerado[$value - 1]["fin-curso"] = "si";
            }
        }
    }

    return $mesGenerado;
}

//pintar los dias que caen en fin de semana

function finde($inicio, $dia, $day_first, $dia_numero)
{


    if ($inicio == 1) {
        if ($dia["inicio-curso"] == "si") {
            echo " <div style ='grid-column-start: $day_first' class = 'day festivo tooltip'>$dia_numero <span class='tooltiptext'> Inicio curso </span></div>";
        } else if ($dia["fin-curso"] == "si") {
            echo " <div style ='grid-column-start: $day_first' class = 'day festivo tooltip '>$dia_numero<span class='tooltiptext'> Fin curso </span></div>";
        } else if ($dia["festivo"] == "si") {
            $n_fiesta = $dia["fiesta"];
            echo " <div style ='grid-column-start: $day_first' class = 'day festivo tooltip'  >$dia_numero <span class='tooltiptext'> $n_fiesta</span></div>";
        } else if ($dia["no-lectivo"] == "si") {
            echo " <div style ='grid-column-start: $day_first' class = 'day festivo tooltip'>$dia_numero<span class='tooltiptext'> Dia no lectivo</span></div>";
        } else if ($dia["vacaciones"] == "si") {
            echo " <div style ='grid-column-start: $day_first' class = 'day vacaciones'>$dia_numero</div>";
        } else {
            echo " <div style ='grid-column-start: $day_first' class = 'day festivo'>$dia_numero</div>";
        }
    } else {;
        if ($dia["inicio-curso"] == "si") {
            echo " <div class = 'day festivo tooltip'>$dia_numero<span class='tooltiptext'> Inicio curso </span></div>";
        } else if ($dia["fin-curso"] == "si") {
            echo " <div class = 'day festivo tooltip'>$dia_numero<span class='tooltiptext'> Fin curso </span></div>";
        } else if ($dia["festivo"] == "si") {
            $n_fiesta = $dia["fiesta"];
            echo " <div  class = 'day festivo tooltip' >$dia_numero<span class='tooltiptext'> $n_fiesta</span></div>";
        } else if ($dia["no-lectivo"] == "si") {
            echo " <div class = 'day festivo tooltip'>$dia_numero <span class='tooltiptext'> Dia no lectivo</span></div>";
        } else if ($dia["vacaciones"] == "si") {
            echo " <div class = 'day vacaciones'>$dia_numero</div>";
        } else {
            echo " <div class = 'day festivo'>$dia_numero</div>";
        }
    }
}


//pintar los dias que caen entre semanas

function normal($inicio, $dia, $day_first, $dia_numero)
{


    if ($inicio == 1) {
        if ($dia["inicio-curso"] == "si") {
            echo " <div style ='grid-column-start: $day_first' class = 'day inicio-curso tooltip'>$dia_numero<span class='tooltiptext'> Inicio curso </span></div>";
        } else if ($dia["fin-curso"] == "si") {
            echo " <div style ='grid-column-start: $day_first' class = 'day inicio-curso tooltip'>$dia_numero<span class='tooltiptext'> Fin curso </span></div>";
        } else if ($dia["festivo"] == "si") {
            $n_fiesta = $dia["fiesta"];
            echo " <div style ='grid-column-start: $day_first'  class = 'day festivo tooltip' >$dia_numero <span class='tooltiptext'> $n_fiesta</span></div>";
        } else if ($dia["no-lectivo"] == "si") {
            echo " <div style ='grid-column-start: $day_first' class = 'day no-lectivo tooltip'>$dia_numero<span class='tooltiptext'> Dia no lectivo</span></div>";
        } else if ($dia["vacaciones"] == "si") {
            echo " <div style ='grid-column-start: $day_first' class = 'day vacaciones'>$dia_numero</div>";
        } else {
            echo " <div style ='grid-column-start: $day_first' class = 'day '>$dia_numero</div>";
        }
    } else {
        if ($dia["inicio-curso"] == "si") {
            echo " <div class = 'day inicio-curso tooltip'>$dia_numero<span class='tooltiptext'> Inicio curso </span></div>";
        } else if ($dia["fin-curso"] == "si") {
            echo " <div class = 'day inicio-curso tooltip'>$dia_numero<span class='tooltiptext'> Fin curso </span></div>";
        } else if ($dia["festivo"] == "si") {
            $n_fiesta = $dia["fiesta"];
            echo " <div  class = 'day festivo tooltip' >$dia_numero <span class='tooltiptext'> $n_fiesta</span></div>";
        } else if ($dia["no-lectivo"] == "si") {
            echo " <div class = 'day no-lectivo tooltip'>$dia_numero<span class='tooltiptext'> Dia no lectivo</span></div>";
        } else if ($dia["vacaciones"] == "si") {
            echo " <div class = 'day vacaciones'>$dia_numero</div>";
        } else {
            echo " <div class = 'day '>$dia_numero</div>";
        }
    }
}
