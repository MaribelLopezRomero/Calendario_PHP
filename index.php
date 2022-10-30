<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>

</head>

<body>

    <style>
        .calendario {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-around;

        }

        .mes {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            width: 400px;
            height: 400px;
            margin: 40px;

        }

        .title-año {

            font-size: 18px;
            font-size: 2.8rem;
            text-align: center;
            font-weight: 500;
        }

        .title {

            grid-column-start: 3;
            grid-column-end: 6;
            font-size: 1.2rem;
            text-align: center;
            font-weight: 500;

        }

        .day-name {
            grid-column-start: 1;

        }

        .name {
            font-size: 1.2rem;
            text-align: center;
            font-weight: 500;
        }

        .day {
            background-color: #F4F8A5;
            font-size: 1.5rem;
            font-weight: 500;
            color: black;
            text-align: center;
            border-color: gray;
            border-width: 1px;
            border-style: solid;

        }

        .festivo {
            background-color: #9DDAC3;

        }

        .no-lectivo {
            background-color: #E78C78;
        }

        .vacaciones {
            background-color: #9DDAC3;
        }

        .inicio-curso {
            background-color: #BE8FDE;
        }

        .tooltip {
            font-size: 1.5rem;
            font-weight: 500;
            position: relative;
        }

        .tooltip .tooltiptext {

            font-size: 16px;
            visibility: hidden;
            width: 120px;
            background-color: #F0E8C1;
            color: black;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 100%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            visibility: visible;
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #F4F8A5 transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>



    <?php

    // $septiembre = [["inicio" => 4, "festivo" => "no", "vacaciones" => "no", "inicio-curso" => "no"], ["inicio" => 0, "festivo" => "si", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "no", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "no", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "si", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "no", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "no", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "si", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "no", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "no", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "si", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "no", "vacaciones" => "si", "inicio-curso" => "si"], ["inicio" => 0, "festivo" => "no", "vacaciones" => "si", "inicio-curso" => "si"]];

    include("funciones.php");

    //sacar el dia que empieza el año 

    $fecha = strtotime('2022-09-01');

    $dia_empieza = date("w", $fecha);
    $año_empieza = date("Y", $fecha);


    calendario($año_empieza, $dia_empieza);

    echo date("d", easter_date($año_empieza + 1));

    ?>

</body>

</html>