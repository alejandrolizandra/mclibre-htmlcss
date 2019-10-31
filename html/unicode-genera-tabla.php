<!DOCTYPE html>
<html lang="es">
<?php
    define("EMOJIS", 1);    // sólo muestra emojis (es decir, los que están en twemoji)
    define("SIMBOLOS", 0);  // muestra todos los caracteres
    $muestra = EMOJIS;
?>

<head>
    <meta charset="utf-8">
    <title>Genera fichas Pictogramas. Páginas web HTML y hojas de estilo CSS. Bartolomé Sintes Marco. www.mclibre.org</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../varios/htmlcss.css" title="Color">
    <link rel="icon" href="../varios/favicon.ico">
    <style>
        @font-face {
            font-family: "Symbola";
            src: url("unicode/Symbola.ttf");
        }

        @font-face {
            font-family: "Twemoji";
            src: url("unicode/TwitterColorEmoji-SVGinOT.ttf");
        }

        div.u-l {
            display: flex;
            flex-flow: row wrap;
            justify-content: space-between;
        }

        div.u {
            display: flex;
            flex-direction: column;
<?php
    if ($muestra == SIMBOLOS) {
        print "            flex: 0 1 200px;\n";
    } else {
        print "            flex: 0 1 280px;\n";
    }
?>
            margin: 5px;
            border: black 1px solid;
            text-align: center;
        }

        div.u p:nth-child(odd) {
            background-color: #eee;
        }

        div.u p {
            margin: 0;
            padding: 5px 10px;
        }

        div.u p.uc {
            font-weight: bold;
        }

        div.u p.si {
            font-size: 80px;
            line-height: 100px;
            text-align: center;
        }

        div.u span.ss {
            font-family: sans-serif;
            border-right: 2px solid black;
            padding-right: 20px;
        }

        div.u span.sy {
            font-family: "Symbola";
        }

        div.u span.te {
            font-family: "Twemoji";
        }

        div.u p.en {}

        div.u p.no {
            flex: 1 0 auto;
            text-transform: uppercase;
        }

        div.u a {
            border: none;
            text-decoration: none;
            color: black;
        }

        table.u {
            border-spacing: 20px 0;
            border-collapse: collapse;
        }

        table.u colgroup {
            border-right: black 1px solid;
            border-left: black 1px solid;
        }

        table.u tr.fila-estrecha { height: auto;
      border-bottom: black 1px solid; }

        table.u tr { height: 90px; }

        table.u .ss {
            font-family: sans-serif;
            font-size: 80px;
        }

        table.u .te {
            font-family: "Twemoji";
            font-size: 80px;
        }
        table.u a {
            border: none;
            text-decoration: none;
            color: black;
        }
    </style>
    <!-- SIN FLEXBOX
<style>
    @font-face {
      font-family: "Symbola";
      src: url("unicode/Symbola.ttf");
    }
    @font-face {
      font-family: "Noto Emoji";
      src: url("unicode/NotoEmoji-Regular.ttf");
    }
    @font-face {
      font-family: "Twemoji";
      src: url("unicode/TwitterColorEmoji-SVGinOT.ttf");
    }
    div.u { float: left; width: 500px; height: 230px; margin: 10px; border: black 1px solid; text-align: center; }
    div.u p { margin: 0; padding: 5px 10px; }
    div.u p.uc { background-color: #ddd; font-weight: bold; }
    div.u p.si { font-size: 80px; line-height: 100px; text-align: center; }
    div.u span.ss { font-family: sans-serif; border-right: 2px solid black; padding-right: 20px;}
    div.u span.sy { font-family: "Symbola";}
    div.u span.ne { font-family: "Noto Emoji";}
    div.u span.te { font-family: "Twemoji"; }
    div.u p.en { background-color: #ddd; }
    div.u p.no { text-transform: uppercase; }
    div.u a { border: none; text-decoration: none; color: black; }
    table.u { border-spacing: 20px 0; }
    table.u span.te { font-family: "Twemoji"; font-size: 80px; }
    table.u a { border: none; text-decoration: none; color: black; }
  </style>
  -->
</head>

<body>
    <?php
    // 1 de septiembre de 2018
    include("unicode-array.php");
    include("unicode-array-combinaciones.php");
    // $rutaSVG = "https://github.com/emojione/emojione/blob/2.2.7/assets/svg";
    // $rutaSVG = "https://github.com/twitter/twemoji/blob/gh-pages/2/svg"; // cambiado en 2019-10-27
    $rutaSVG = "https://github.com/twitter/twemoji/blob/master/assets/svg";


    function genera_grupo($matriz, $grupo, $id, $pdf, $cuenta, $inicial, $final, $fuentes)
    {
        global $rutaSVG, $muestra;

        if ($cuenta) {
            $contador = 0;
            foreach ($matriz as $c) {
                if (count($c[0]) == 1 && hexdec($c[0][0]) >= hexdec($inicial) && hexdec($c[0][0]) <= hexdec($final)) { // no sé si es necesario convertirlo a decimal, pero por si acaso
                    if ($muestra == EMOJIS && $c[5] == "T") {
                        $contador++;
                    } elseif ($muestra == SIMBOLOS) {
                        $contador++;
                    }
                }
            }
        }
        if (!$cuenta || $cuenta && $contador > 0) {
            print "  <section id=\"$id\">\n";
            print "    <h2>$grupo</h2>\n";
            print "\n";

            if ($cuenta) {
                if ($contador == 1) {
                    print "    <p>Se muestra aquí $contador carácter ";
                } else {
                    print "    <p>Se muestran aquí $contador caracteres ";
                }
                print "Unicode del grupo que se extiende desde el carácter U+$inicial hasta el carácter U+$final. Puede descargar la <a href=\"unicode/$pdf\">tabla de códigos de caracteres Unicode 12.1</a> en formato PDF.</p>\n";
                print "\n";
            }

            print "    <div class=\"u-l\">\n";
            foreach ($matriz as $c) {
                if (count($c[0]) > 1 || count($c[0]) == 1 && hexdec($c[0][0]) >= hexdec($inicial) && hexdec($c[0][0]) <= hexdec($final)) { // no sé si es necesario convertirlo a decimal, pero por si acaso
                    if ($muestra == SIMBOLOS) {
                        // 2019-10-27. Muestra el carácter en sans-serif sólo
                        print "      <div class=\"u\">\n";
                        print "        <p class=\"uc\">";
                        foreach ($c[0] as $tmp) {
                            print "U+" . strtoupper(dechex(hexdec($tmp))) . " ";
                        }
                        print "</p>\n";
                        print "        <p class=\"si\">";
                        if (in_array("ss", $fuentes)) {
                            foreach ($c[0] as $tmp) {
                                print "&#x" . strtoupper(dechex(hexdec($tmp))) . ";";
                            }
                        }
                        print "</p>\n";
                        print "        <p class=\"en\"><strong>";
                        foreach ($c[0] as $tmp) {
                            print "&amp;#x" . dechex(hexdec($tmp)) . ";";
                        }
                        print "</strong></p>\n";
                        print "        <p class=\"en\"><strong>";
                        foreach ($c[0] as $tmp) {
                            print "&amp;#" . hexdec($tmp) . ";";
                        }
                        print "</strong></p>\n";
                        print "        <p class=\"no\">$c[6]</p>\n";
                        print "      </div>\n";
                        print "\n";
                    } elseif ($c[5] == "T") {
                        // 2019-08-05. Muestra el carácter en symbola y twemoji
                        print "      <div class=\"u\">\n";
                        print "        <p class=\"uc\">";
                        foreach ($c[0] as $tmp) {
                            print "U+" . strtoupper(dechex(hexdec($tmp))) . " ";
                        }
                        print "</p>\n";
                        print "        <p class=\"si\">\n";
                        if (in_array("ss", $fuentes)) {
                            print "          <span class=\"ss\">";
                            foreach ($c[0] as $tmp) {
                                print "&#x" . strtoupper(dechex(hexdec($tmp))) . ";";
                            }
                            print "</span> \n";
                        }
                        // No dibujo Symbola
                        // if (in_array("sy", $fuentes)) {
                        //     print "          <span class=\"sy\">";
                        //     foreach ($c[0] as $tmp) {
                        //         print "&#x$tmp;";
                        //     }
                        //     print "</span> \n";
                        // }

                        if (in_array("te", $fuentes)) {
                            if ($c[5] == "T") {
                                print "          <span class=\"te\"><a href=\"$rutaSVG/";
                                for ($i = 0; $i < count($c[0]) - 1; $i++) {
                                    $tmp0 = strtolower($c[0][$i]);
                                    while ($tmp0[0] == "0") {
                                        $tmp0 = substr($tmp0, 1);
                                    }
                                    print "$tmp0-";
                                }
                                $tmp0 = strtolower($c[0][$i]);
                                while ($tmp0[0] == "0") {
                                    $tmp0 = substr($tmp0, 1);
                                }
                                print "$tmp0";
                                print ".svg\">";
                                foreach ($c[0] as $tmp) {
                                    print "&#x" . strtoupper(dechex(hexdec($tmp))) . ";";
                                }
                                print "</a></span>\n";
                            }
                            // Si no está en Twemoji
                            // } else {
                            //     print "        <span class=\"te\">";
                            //     foreach ($c[0] as $tmp) {
                            //         print "&#x$tmp;";
                            //     }
                            //     print "</span>\n";
                            // }
                        }
                        if (in_array("ne", $fuentes)) {
                            print "          <span class=\"ne\">";
                            foreach ($c[0] as $tmp) {
                                print "&#x$tmp;";
                            }
                            print "</span>\n";
                        }
                        print "        </p>\n";
                        print "        <p class=\"en\">hexadecimal: <strong>";
                        foreach ($c[0] as $tmp) {
                            print "&amp;#x" . dechex(hexdec($tmp)) . ";";
                        }
                        print "</strong><br>decimal: <strong>";
                        foreach ($c[0] as $tmp) {
                            print "&amp;#" . hexdec($tmp) . ";";
                        }
                        print "</strong></p>\n";
                        print "        <p class=\"no\">$c[6]</p>\n";
                        print "      </div>\n";
                        print "\n";
                    }
                    // 2019-08-05. Muestra el carácter en symbola y twemoji
                }
            }
            print "    </div>\n";
            print "  </section>\n";
            print "\n";
        }
    }

    function genera_grupos($grupos, $fuentes)
    {
        print "  <ul>\n";
        foreach ($grupos as $g) {
            print "    <li><a href=\"#$g[2]\">$g[1]</a></li>\n";
        }
        print "  </ul>\n";
        print "\n";

        foreach ($grupos as $g) {
            genera_grupo($g[0], $g[1], $g[2], $g[3], $g[4], $g[5], $g[6], $fuentes);
        }
    }

    function genera_tabla_colores_piel($matriz, $grupo, $id, $pdf, $cuenta, $inicial, $final, $fuentes)
    {
        global $rutaSVG;

        print "  <section id=\"$id\">\n";
        print "    <h2>$grupo</h2>\n";
        print "\n";

        if ($cuenta) {
            $contador = 0;
            foreach ($matriz as $c) {
                $contador++;
            }
            if ($contador == 1) {
                print "    <p>Se muestra aquí $contador carácter ";
            } else {
                print "    <p>Se muestran aquí $contador caracteres ";
            }
            print "Unicode que al secuenciarse con los cinco modificadores Fitzpatrick (U+1F3FB a U+1F3FF) dan lugar cada uno a cinco nuevos emojis con distintos colores de piel.</p>\n";
            print "\n";
            print "    <p>Los caracteres se muestran únicamente con la fuente Twemoji y el resultado depende del sistema operativo y del navegador empleado.</p>\n";
            print "\n";
        }

        print "    <table class=\"u\">\n";
        print "      <col>\n";
        print "      <colgroup span=\"2\" class=\"borde-lateral\"></colgroup>\n";
        print "      <colgroup span=\"2\" class=\"borde-lateral\"></colgroup>\n";
        print "      <colgroup span=\"2\" class=\"borde-lateral\"></colgroup>\n";
        print "      <colgroup span=\"2\" class=\"borde-lateral\"></colgroup>\n";
        print "      <colgroup span=\"2\" class=\"borde-lateral\"></colgroup>\n";
        print "      <colgroup span=\"2\" class=\"borde-lateral\"></colgroup>\n";
        print "      <col>\n";
        print "      <tr class=\"fila-estrecha\">\n";
        print "        <th rowspan=\"2\">Códigos</th>\n";
        print "        <th colspan=\"2\" rowspan=\"2\">Sin color de piel</th>\n";
        print "        <th colspan=\"10\">Con color de piel</th>\n";
        print "        <th rowspan=\"2\">Nombres</th>\n";
        print "      </tr>\n";
        print "      <tr class=\"fila-estrecha\">\n";
        print "        <th colspan=\"2\">&amp;#x1F3FB;</th>\n";
        print "        <th colspan=\"2\">&amp;#x1F3FC;</th>\n";
        print "        <th colspan=\"2\">&amp;#x1F3FD;</th>\n";
        print "        <th colspan=\"2\">&amp;#x1F3FE;</th>\n";
        print "        <th colspan=\"2\">&amp;#x1F3FF;</th>\n";
        print "      </tr>\n";
        foreach ($matriz as $c) {
            print "      <tr>\n";
            print "        <th>";
            $cad1 = $cad2 = $cad3 = "";
            foreach ($c[0] as $c2) {
                $tmp = strtolower($c2);
                while ($tmp[0] == "0") {
                    $tmp = substr($tmp, 1);
                }
                $cad1 .= "U+" . $c2 . " ";
                $cad2 .= $tmp . "-";
                $cad3 .=  "&#x" . strtoupper(dechex(hexdec($c2))) . ";";
                print "&amp;#x" . strtoupper(dechex(hexdec($c2))) . ";<wbr>";
            }
            print "</th>\n";
            $cad2 = substr($cad2, 0, strlen($cad2) - 1); // quito el guion final que sobra
            print "        <td class=\"ss\">$cad3</td>\n";
            print "        <td class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></td>\n";
            // CUIDADO: Hay varios casos especiales en los que el Fitzpatrick sustituye al segundo carácter de la secuencia
            $cad2 = str_replace("26f9-fe0f-", "26f9-", $cad2);
            $cad2 = str_replace("1f3cb-fe0f-", "1f3cb-", $cad2);
            $cad2 = str_replace("1f3cc-fe0f-", "1f3cc-", $cad2);
            $cad2 = str_replace("1f46e-fe0f-", "1f46e-", $cad2);
            $cad2 = str_replace("1f574-fe0f-", "1f574-", $cad2);
            $cad2 = str_replace("1f575-fe0f-", "1f575-", $cad2);
            $pos = strpos($cad2, "-", 2);
            if ($pos == 0) {
                $cad2 .= "-1f3fb";
            } else {
                $cad2 = substr_replace($cad2, "1f3fb-", $pos + 1, 0);
            }
            $pos = strpos($cad3, ";", 4);
            $cad3 = substr_replace($cad3, "&#x1F3FB;", $pos + 1, 0);
            print "        <td class=\"ss\">$cad3</td>\n";
            if (in_array("te", $fuentes)) {
                print "        <td class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></td>\n";
            }
            $cad2 = str_replace("1f3fb", "1f3fc", $cad2);
            $cad3 = str_replace("&#x1F3FB;", "&#x1F3FC;", $cad3);
            print "        <td class=\"ss\">$cad3</td>\n";
            if (in_array("te", $fuentes)) {
                print "        <td class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></td>\n";
            }
            $cad2 = str_replace("1f3fc", "1f3fd", $cad2);
            $cad3 = str_replace("&#x1F3FC;", "&#x1F3FD;", $cad3);
            print "        <td class=\"ss\">$cad3</td>\n";
            if (in_array("te", $fuentes)) {
                print "        <td class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></td>\n";
            }
            $cad2 = str_replace("1f3fd", "1f3fe", $cad2);
            $cad3 = str_replace("&#x1F3FD;", "&#x1F3FE;", $cad3);
            print "        <td class=\"ss\">$cad3</td>\n";
            if (in_array("te", $fuentes)) {
                print "        <td class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></td>\n";
            }
            $cad2 = str_replace("1f3fe", "1f3ff", $cad2);
            $cad3 = str_replace("&#x1F3FE;", "&#x1F3FF;", $cad3);
            print "        <td class=\"ss\">$cad3</td>\n";
            if (in_array("te", $fuentes)) {
                print "        <td class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></td>\n";
            }
            print "        <td class=\"no\">$c[6]</td>\n";

            // print "        <td><span class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></span></td>\n";
            // $cad2 = str_replace("1f3fb", "1f3fc", $cad2);
            // $cad3 = str_replace("&#x1F3FB;", "&#x1F3FC;", $cad3);
            // print "        <td><span class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></span></td>\n";
            // $cad2 = str_replace("1f3fc", "1f3fd", $cad2);
            // $cad3 = str_replace("&#x1F3FC;", "&#x1F3FD;", $cad3);
            // print "        <td><span class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></span></td>\n";
            // $cad2 = str_replace("1f3fd", "1f3fe", $cad2);
            // $cad3 = str_replace("&#x1F3FD;", "&#x1F3FE;", $cad3);
            // print "        <td><span class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></span></td>\n";
            // $cad2 = str_replace("1f3fe", "1f3ff", $cad2);
            // $cad3 = str_replace("&#x1F3FE;", "&#x1F3FF;", $cad3);
            // print "        <td><span class=\"te\"><a href=\"$rutaSVG/$cad2.svg\">$cad3</a></span></td>\n";
            // print "        <td>" . strtoupper($c[6]) . " </td>\n";

            print "      </tr>\n";
        }
        print "    </table>\n";
        print "  </section>\n";
        print "\n";
    }

    function genera_tablas($grupos)
    {
        print "  <ul>\n";
        foreach ($grupos as $g) {
            print "    <li><a href=\"#$g[2]\">$g[1]</a></li>\n";
        }
        print "  </ul>\n";
        print "\n";

        foreach ($grupos as $g) {
            genera_tabla_colores_piel($g[0], $g[1], $g[2], $g[3], $g[4], $g[5], $g[6], $g[7]);
        }
    }


    $grupos_simbolos = [
        [$caracteres_unicode, "Controles y Latin básico",                          "controles-latin",         "U00000-c0-controls-and-basic-latin.pdf",           1, "0000",  "007F" ],
        [$caracteres_unicode, "Suplemento controles y Latin-1",                    "controles-sup",           "U00080-c1-controls-and-latin-1-supplement.pdf",    1, "0080",  "00FF" ],
        [$caracteres_unicode, "Puntuación",                                        "puntuacion",              "U02000-general-punctuation.pdf",                   1, "2000",  "206F" ],
        [$caracteres_unicode, "Símbolos de monedas",                               "monedas",                 "U020A0-currency-symbols.pdf",                      1, "20A0",  "20BF" ],
        [$caracteres_unicode, "Símbolos con letras",                               "simbolos-letras",         "U02100-letterlike-symbols.pdf",                    1, "2100",  "214F" ],
        [$caracteres_unicode, "Flechas",                                           "flechas",                 "U02190-arrows.pdf",                                1, "2190",  "21FF" ],
        [$caracteres_unicode, "Símbolos técnicos misceláneos",                     "tecnicos-misc",           "U02300-miscellaneous-technical.pdf",               1, "2300",  "23FE" ],
        [$caracteres_unicode, "Símbolos alfanuméricos con círculo alrededor",      "alfanum-circulo",         "U02460-enclosed-alphanumerics.pdf",                1, "2460",  "24FF" ],
        [$caracteres_unicode, "Cajas",                                             "cajas",                   "U02500-box-drawing.pdf",                           1, "2500",  "257F" ],
        [$caracteres_unicode, "Formas geométricas",                                "formas-geometricas",      "U025A0-geometric-shapes.pdf",                      1, "25A0",  "25FF" ],
        [$caracteres_unicode, "Símbolos misceláneos",                              "simbolos-misc",           "U02600-miscellaneous-symbols.pdf",                 1, "2600",  "26FF" ],
        [$caracteres_unicode, "Dingbats",                                          "dingbats",                "U02700-dingbats.pdf",                              1, "2700",  "27BF" ],
        [$caracteres_unicode, "Flechas suplementarias B",                          "flechas-suplementarias",  "U02900-supplemental-arrows-b.pdf",                 1, "2900",  "297F" ],
        [$caracteres_unicode, "Símbolos y flechas misceláneos",                    "simbolos-flechas",        "U02B00-miscellaneous-symbols-and-arrows.pdf",      1, "2B00",  "2BFF" ],
        [$caracteres_unicode, "Símbolos y puntuación CJK",                         "cjk",                     "U03000-cjk-symbols-and-punctuation.pdf",           1, "3000",  "303F" ],
        [$caracteres_unicode, "Símbolos CJK con círculo alrededor",                "cjk-circulo",             "U03200-enclosed-cjk-letters-and-months.pdf",       1, "3200",  "32FF" ],
        [$caracteres_unicode, "Símbolos musicales",                                "musica",                  "U1D100-musical-symbols.pdf",                       1, "1D100", "1D1E8"],
        [$caracteres_unicode, "Fichas de Mahjong",                                 "fichas-mahjong",          "U1F000-mahjong-tiles.pdf",                         1, "1F000", "1F02B"],
        [$caracteres_unicode, "Fichas de dominó",                                  "domino",                  "U1F030-domino-tiles.pdf",                          1, "1F030", "1F093"],
        [$caracteres_unicode, "Cartas",                                            "cartas",                  "U1F0A0-playing-cards.pdf",                         1, "1F0A0", "1F0F5"],
        [$caracteres_unicode, "Suplemento alfanuméricos con círculo alrededor",    "alfanum-circulo-sup",     "U1F100-enclosed-alphanumeric-supplement.pdf",      1, "1F100", "1F1FF"],
        [$caracteres_unicode, "Suplemento ideográfico con círculo alrededor",      "ideografico-circulo-sup", "U1F200-enclosed-ideographic-supplement.pdf",       1, "1F200", "1F2FF"],
        [$caracteres_unicode, "Dingbats decorativos",                              "dingbats-decorativos",    "U1F650-ornamental-dingbats.pdf",                   1, "1F650", "1F67F"],
        [$caracteres_unicode, "Símbolos alquímicos",                               "simbolos-alquimicos",     "U1F700-alchemical-symbols.pdf",                    1, "1F700", "1F773"],
        [$caracteres_unicode, "Formas geométricas extendidas",                     "geometricas-extendidas",  "U1F780-geometric-shapes-extended.pdf",             1, "1F780", "1F7EB"],
        [$caracteres_unicode, "Símbolos y pictogramas misceláneos",                "simbolos-pict-misc",      "U1F300-miscellaneous-symbols-and-pictographs.pdf", 1, "1F300", "1F5FF"],
        [$caracteres_unicode, "Emoticonos",                                        "emoticonos",              "U1F600-emoticons.pdf",                             1, "1F600", "1F64F"],
        [$caracteres_unicode, "Símbolos de transporte y mapas",                    "transporte",              "U1F680-transport-and-map-symbols.pdf",             1, "1F680", "1F6FF"],
        [$caracteres_unicode, "Símbolos y pictogramas misceláneos suplementarios", "simbolos-misc-supl",      "U1F900-supplemental-symbols-and-pictographs.pdf",  1, "1F900", "1F9FF"],
        [$caracteres_unicode, "Símbolos y pictogramas extendidos A",               "simbolos-ext-a",          "U1FA70-symbols-and-pictographs-extended-a.pdf",    1, "1FA70", "1FAFF"],
    ];

    $grupos_secuencias = array(
        array($cu_banderas,     "Banderas",                 "banderas",         "", 0, "", ""),
        array($cu_banderas_sub, "Banderas (subdivisiones)", "banderas-2",       "", 0, "", ""),
        array($cu_otros,        "Otros",                    "otros",            "", 0, "", ""),
        array($cu_familias,     "Familias",                 "familias",         "", 0, "", ""),
        array($cu_parejas_1,    "Parejas (1)",              "parejas-1",        "", 0, "", ""),
        array($cu_parejas_2,    "Parejas (2)",              "parejas-2",        "", 0, "", ""),
        array($genero_2,        "Género: Profesiones",      "hm-profesiones",   "", 0, "", ""),
        array($genero_1,        "Género: Actividades (1)",  "hm-actividades-1", "", 0, "", ""),
        array($genero_3,        "Género: Actividades (2)",  "hm-actividades-2", "", 0, "", ""),
        array($genero_4,        "Género: Actividades (3)",  "hm-actividades-3", "", 0, "", ""),
        array($pelo_1,          "Pelo",                     "pelo",             "", 0, "", ""),

        //  array("Colores de piel",                                     "colores-piel",    "", 0, "0261D", "1F9FF"),
        //  array("Otsros",                                               "otros",           "", 4, "0002A", "1F4FF"),
    );

    $grupos_secuencias_2 = array(
        array($piel_1,   "Colores de piel (1)",           "colores-piel-1", "", 0, "", "", ["ss", "te"]),
        array($genero_1, "Colores de piel (2)",           "colores-piel-2", "", 0, "", "", ["ss", "te"]),
        array($genero_2, "Colores de piel (3)",           "colores-piel-3", "", 0, "", "", ["ss", "te"]),
        array($genero_3, "Colores de piel (4)",           "colores-piel-4", "", 0, "", "", ["ss", "te"]),
        array($genero_4, "Colores de piel NO EN TWEMOJI", "colores-piel-5", "", 0, "", "", ["ss"]),
        array($pelo_1,   "Pelo",                          "pelo",           "", 0, "", "", ["ss", "te"]),
    );

    $grupos_restos = array(
        //  array("Restos",                                              "restos",          "", 1, "00000", "FFFFF"),
        array("Restos",                                              "restos",          "", 4, "1F3C3", "FFFFF"),
        array("Restos",                                              "restos",          "", 5, "1F3C3", "FFFFF"),
    );

    // CAMBIAR VARIABLE $MUESTRA EN LINEA 6 A SIMBOLOS O EMOJIS
    // genera_grupos($grupos_simbolos, ["ss", "sy", "te"]);
    // CAMBIAR VARIABLE $MUESTRA EN LINEA 6 A EMOJIS
    // genera_grupos($grupos_secuencias, ["ss", "te"]);
    // CAMBIAR VARIABLE $MUESTRA EN LINEA 6 A EMOJIS
    genera_tablas($grupos_secuencias_2, ["ss", "te"]);

    // genera_grupos($grupos_restos);

    ?>
</body>

</html>