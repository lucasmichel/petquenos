<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use thiagoalessio\TesseractOCR\TesseractOCR;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }



    private function criarImagem($imgBase64)
    {
        $caminhoTemporarioImagem = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'imagens'  . \DIRECTORY_SEPARATOR . "imgTemp" . \DIRECTORY_SEPARATOR;

        $img = str_replace('data:image/png;base64,', '', $imgBase64);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $nameImg = uniqid() . '.png';
        $imagemExameCriado = $caminhoTemporarioImagem . $nameImg;
        $success = file_put_contents($imagemExameCriado, $data);

        $dataReturn["resultado"] = $imagemExameCriado;
        $dataReturn["nomeImg"] = $nameImg;


        return $dataReturn;

    }

    private function createAndEditImage($imgBase64)
    {
        //return path img tratada
        $data = $this->criarImagem($imgBase64);

        //$data["resultado"] = $imagemExameCriado;
        //$data["nomeImg"] = $nameImg;

        $resultado = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'imagens'  . \DIRECTORY_SEPARATOR . "imgTemp" . \DIRECTORY_SEPARATOR . "nova_" . $data["nomeImg"];

        $imgTratar = \imagecreatefrompng($data["resultado"]);
        \imagefilter($imgTratar, IMG_FILTER_GRAYSCALE);
        \imagefilter($imgTratar, IMG_FILTER_CONTRAST, -60);

        \imagepng($imgTratar, $resultado);


        return $resultado;


    }

    private function getAssinatura($login)
    {
        $path="";
        $assinatura="";
        switch ($login) {
            case "rita":
                $path = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'imagens'  . \DIRECTORY_SEPARATOR . 'assinaturas' . \DIRECTORY_SEPARATOR . 'rita.png';
                $assinatura= 'Drª. Rita de Cássia do N. Silva.
                <br>
                CRMV-PE 3900';
                break;
            case "suellen":
                $path = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'imagens'  . \DIRECTORY_SEPARATOR . 'assinaturas' . \DIRECTORY_SEPARATOR . 'suellen.png';
                $assinatura= 'Drª. Suellên Cris Regis da Silva Negrão.
                <br>
                CRMV-PE 4184';
                break;
            case "angela":
                $path = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'imagens'  . \DIRECTORY_SEPARATOR . 'assinaturas' . \DIRECTORY_SEPARATOR . 'angela.png';
                $assinatura= 'Drª. Ângela Roberta Batista da Silva.
                <br>
                CRMV-PE 5207';
                break;
        }
        $dadosAssinatura["path"] = $path;
        $dadosAssinatura["assinatura"] = $assinatura;
        return $dadosAssinatura;
    }



    private function getFolder()
    {
        $dt = new \DateTime();
        $ano = $dt->format('Y');
        $mes = $dt->format('m_Y');
        $dia = $dt->format('d_m_Y');
        //$caminhoLog = Util::getParametroEnv("DIR_RAIZ", true) . \DIRECTORY_SEPARATOR . "log";
        $caminhoLog = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'arquivos';
        $pastaAno = $caminhoLog . \DIRECTORY_SEPARATOR . $ano;
        $pastaMes = $caminhoLog . \DIRECTORY_SEPARATOR . $ano . \DIRECTORY_SEPARATOR . $mes;
        $pastaDia = $caminhoLog . \DIRECTORY_SEPARATOR . $ano . \DIRECTORY_SEPARATOR . $mes . \DIRECTORY_SEPARATOR . $dia;
        self::createFolder($pastaAno, "ano");
        self::createFolder($pastaMes, "mes");
        self::createFolder($pastaDia, "dia");
        return $pastaDia;
    }

    private function createFolder($pasta, $tipo)
    {
        if (!\is_dir($pasta)) {
            if (!\mkdir($pasta, 0777)) {
                throw new \Exception ("Erro ao criar a pasta log " . $tipo . ": " . $pasta);
            }
        }
    }






    public function generatePdf(Request $request)
    {
        //var_dump($request->all());die();

        $nomeTutor = $request->input('nomeTutor');
        $nomeAnimal = $request->input('nomeAnimal');
        $especie = $request->input('especie');
        $raca = $request->input('raca');
        $idade = $request->input('idade');
        $genero = $request->input('genero');
        $laudo = nl2br($request->input('laudo'));
        $image = $request->input('image');
        $login = $request->input('login');
        $dataExame = $request->input('dataExame');
        $namePDF = $nomeAnimal . "_" . $dataExame.".pdf";

        $caminhoResultado = $this->createAndEditImage($image);

        $mpdf = new Mpdf();
        $caminhoCss = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'css' . \DIRECTORY_SEPARATOR . 'testestyle.css';

        //$caminhoPDF = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'arquivos'  . \DIRECTORY_SEPARATOR .  $namePDF;
        $caminhoPDF = $this->getFolder() . \DIRECTORY_SEPARATOR .  $namePDF;


        $caminhoImagem = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'imagens'  . \DIRECTORY_SEPARATOR .  'logo.png';
        //$caminhoResultado = $path = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'imagens'  . \DIRECTORY_SEPARATOR . 'resultado_EXAME.jpg';
        //$caminhoImagemAssinatura = \storage_path() . \DIRECTORY_SEPARATOR . 'PDF' . \DIRECTORY_SEPARATOR . 'imagens'  . \DIRECTORY_SEPARATOR . 'assinaturas' . \DIRECTORY_SEPARATOR . 'rita.png';
        $dadosAssinatura = $this->getAssinatura($login);

        ///str = str.replace(/(?:\r\n|\r|\n)/g, '<br>');

		/*$teste='Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Praesent in libero vel eros varius lobortis. Mauris
                    porttitor mi sit amet elit lacinia consectetur.
                    Ut condimentum nisl a felis volutpat efficitur. Fusce
                    porttitor consequat odio a pharetra. Ut vel lacus dolor.
                    Pellentesque bibendum sed elit rutrum lobortis. In hac
                    habitasse platea dictumst. Praesent ullamcorper massa sit
                    amet sagittis finibus. Etiam efficitur nulla nec malesuada
                    venenatis. Morbi congue erat a tellus vestibulum, ut
                    hendrerit nulla accumsan. Phasellus elementum nulla ac
                    neque mattis, in dignissim lorem laoreet. Donec id
                    vehicula nulla, sit amet accumsan turpis.';

		var_dump(strlen($teste));

		die();*/


        /*$laudo='Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Praesent in libero vel eros varius lobortis. Mauris
        porttitor mi sit amet elit lacinia consectetur.
        Ut condimentum nisl a felis volutpat efficitur. Fusce
        porttitor consequat odio a pharetra. Ut vel lacus dolor.
        Pellentesque bibendum sed elit rutrum lobortis. In hac
        habitasse platea dictumst. Praesent ullamcorper massa sit
        amet sagittis finibus. Etiam efficitur nulla nec malesuada
        venenatis. Morbi congue erat a tellus vestibulum, ut
        hendrerit nulla accumsan. Phasellus elementum nulla ac
        neque mattis, in dignissim lorem laoreet. Donec id
        vehicula nulla, sit amet accumsan turpis.';*/


$html = '
<!DOCTYPE html5>
<html lang="pt">
    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700;900&display=swap" rel="stylesheet">

        <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        footer {

            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            background-color: #f48221;


        }

        .tabelaHeader {
            margin: 20px;
            border-top: 3px solid;
            border-bottom: 3px solid;
        }

        .tabelaHeader td{
            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
            font-size:15px;

        }



        .tabelaFooter td{
            font-family: "Roboto", sans-serif;
            font-size:  25px;
            color: white;
        }

        .titulo{
            font-family: "Roboto", sans-serif;
            font-size:  30px;


        }
        .bu{
            padding-top: 1cm;
            padding-left: 3cm;
        }

        .tabelaBody td{
            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
            font-size:15px;
            text-align: center;
            vertical-align: middle;
            padding-left:30px;
            padding-right:30px;

        }


        td.container > div {
            width: 100%;
            height: 100%;
            overflow:hidden;
        }
        td.container {
            height: 60px;
        }

        </style>
    </head>
    <body>
        <header>
        </header>
            <table width="100%">
                <tr>
                    <td style="width:20px;" >
                        <img style=" padding-top:20px; padding-left:20px; width:20%; height:10%;" src="' . $caminhoImagem . '" />
                    </td>
                    <td class="bu">
                        <p class="titulo" >Laboratório Clínico</p>
                    </td>
                </tr>
            </table>
            <table width="100%" class="tabelaHeader" >
                <tr>
                    <td width="50%">
                        <b>Nome do Tutor: '.$nomeTutor.'</b>
                    </td>
                    <td width="50%" >
                        <b>Espécie......: '.$especie.'</b>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <b>Raça.........: '.$raca.'</b>
                    </td>
                    <td width="50%" >
                        <b>Idade........: '.$idade.'<b>
                    </td>
                </tr>
                <tr>
                    <td >
                        <b>Nome.........: '.$nomeAnimal.'</b>
                    </td>
                    <td >
                        <b>Gênero.......: '.$genero.'</b>
                    </td>
                </tr>
            </table>
            <table width="100%" class="tabelaBody" >
                <tr>
                    <td>
                        <i><b>HEMOGRAMA</b></i>
                    </td>
                </tr>
                <tr>
                    <td style="height: 12cm; " >
                        <img style="
                        padding-left:20px;

                        max-width:65%;
                        max-height:55%;

                        width: auto;
                        height: auto;"
                        src="' . $caminhoResultado . '" />
                    </td>
                </tr>
                <tr>
                    <td style="height: 5cm; "  align="justify">
                        <p><b>Laudo/Observações:</b></p>
                        '.$laudo.'
                    </td>
                </tr>
                <tr>
                    <td   >
                        <img style="
                        padding-top:5px;
                        padding-left:20px;
                        max-width:17%;
                        max-height:7%;
                        width: auto;
                        height: auto;
                        "
                        src="' . $dadosAssinatura["path"] . '"
                    />
                    </td>
                </tr>
                <tr>
                    <td >
                    ' . $dadosAssinatura["assinatura"] . '
                    </td>
                </tr>

            </table>
        <footer>


            <div style="padding:10px;">
            <table style="margin: 30px;" width="100%">
                <tr>
                    <td width="50%">
                        <table width="100%" class="tabelaFooter" style="color: white;">
                            <tr>
                                <td><b>MORENO</b></td>
                            </tr>
                            <tr>
                                <td><b>Rua 15 de Novembro, 16 - Centro - Moreno-PE</b></td>
                            </tr>
                            <tr>
                                <td><b>Fone: (81) 3535.1947</b></td>
                            </tr>
                            <tr>
                                <td><b>E-mail: petquenos@gmail.com</b></td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table width="100%" class="tabelaFooter" style="color: white;">
                            <tr>
                                <td><b>VITÓRIA DE SANTO ANTÃO</b></td>
                            </tr>
                            <tr>
                                <td><b>Rua Dias Cardoso, 96 - Matriz - Vitória de Santo Antão-PE</b></td>
                            </tr>
                            <tr>
                                <td><b>Fone: (81) 4137.0799</b></td>
                            </tr>
                            <tr>
                                <td><b>E-mail: petquenosvitoria@gmail.com</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </div>
            </table>
            </div>

        </footer>
    </body>';

        $mpdf->WriteHTML($html);
        $mpdf->Output($caminhoPDF, "F");
        $mpdf->Output($caminhoPDF, "D");
    }

    //
}
