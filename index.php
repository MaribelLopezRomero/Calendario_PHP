<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <link rel="stylesheet" href="styles.css">


</head>

<body>

    <?php

    include("funciones.php");

    //sacar el dia que empieza el año y el año.

    $fecha = strtotime('2022-09-01');

    $dia_empieza = date("w", $fecha);
    $año_empieza = date("Y", $fecha);

    calendario($año_empieza, $dia_empieza);


    ?>

    <article class="leyenda">

        <div class="cuadro c_festivo"></div>
        <p class="p_leyenda">Festivos</p>
        <div class="cuadro c_noLectivo"></div>
        <p class="p_leyenda">No lectivo</p>
        <div class="cuadro c_inicioFinCurso"></div>
        <p class="p_leyenda">Inicio/Fin curso</p>

    </article>


</body>

</html>