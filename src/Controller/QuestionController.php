<?php

namespace App\Controller;

use App\Entity\Departamento;
use App\Form\PersonaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question/{id}", name="question")
     */
    public function index($id): Response
    {
        return $this->render('question/question'.$id.'.twig' );
    }

    /**
     * @Route("/question6", name="question6")
     */
    public function question3(): Response
    {

        $listDepartamentos = $this->getDoctrine()->getRepository(Departamento::class)->getWithMoreThanThreeEmpleados();

        return $this->render('question/question6.twig',[
                'departamentWithMoreThanThreeEmpleados' => $listDepartamentos
            ]);
    }

    /**
     * @Route("/question10", name="question10")
     */
    public function question10(): Response
    {
        $lastRun = "25/05/2020";

        $tabla1 = [
                "id"=>2,
                "nombre" => "pepe",
                "DNI" => "7777777x",
                "saldo" => 25,
                "fecha" => "25/05/2020"
            ];

        $tabla2 = [
            "id"=>2,
            "nombre" => "pepe",
            "DNI" => "7777777x",
            "saldo" => 25,
            "fecha" => "25/05/1998"
        ];

        $fechaLastRun = \DateTime::createFromFormat('d/m/Y', $lastRun);
        $fechaTabla1 = \DateTime::createFromFormat('d/m/Y', $lastRun);
        $fechaTabla2 = \DateTime::createFromFormat('d/m/Y', $lastRun);

        $saldo = 0;
        $tabla = 0;
        if( $fechaLastRun == $fechaTabla1){
            $saldo = $tabla1['saldo'];
            $tabla = 1;
            if ($fechaTabla1 != $fechaTabla2){
                $tabla2['saldo'] = $tabla1['saldo'];
                $tabla2['fecha'] = $lastRun;
            }
        } elseif ($fechaLastRun == $fechaTabla2){
            $saldo = $tabla2['saldo'];
            $tabla1['saldo'] = $tabla2['saldo'];
            $tabla = 2;
        }

        return $this->render('question/question10.twig',[
            'saldo' => $saldo,
            'fecha' => $fechaLastRun,
            'tabla' => $tabla
        ]);
    }

    /**
     * @Route("/questionanswer/1", name="questionanswer")
     */
    public function questionAnswer(Request $request)
    {
        $stringTest = $request->get('stringTest');
        preg_match_all('/\d{2}\/\d{2}\/\d{4}/',$stringTest,$matches);
        preg_match_all('/\d{2}\-\d{2}\-\d{4}/',$stringTest,$matches1);

        $arrayExplode = explode('desde las ',$stringTest );
        $arrayExplode1 = explode(' a las ',$arrayExplode[1] );
        //En arrayExplode1[0] se guarda el inicio
        $arrayExplode2 = explode(' horas',$arrayExplode1[1] );
        //En arrayExplode2[0 se guarda el fin

        $dateTimeInicio = false;
        $dateTimeFin = false;
        if (isset($matches[0][0])){
            $dateTimeInicio = \DateTime::createFromFormat('d/m/Y H', $matches[0][0] . ' ' . $arrayExplode1[0]);
            if ($dateTimeInicio == false) {
                $dateTimeInicio = \DateTime::createFromFormat('d/m/Y H:i', $matches[0][0] . ' ' . $arrayExplode1[0]);
            }
        } else if(isset($matches1[0][0])){
            $dateTimeInicio = \DateTime::createFromFormat('d-m-Y H', $matches1[0][0] . ' ' . $arrayExplode1[0]);
            if ($dateTimeInicio == false) {
                $dateTimeInicio = \DateTime::createFromFormat('d-m-Y H:i', $matches[0][0] . ' ' . $arrayExplode1[0]);
            }
        }

        if (isset($matches[0][0])){
            $dateTimeFin = date_create_from_format('d/m/Y H', $matches[0][0] . ' ' . $arrayExplode2[0]);
            if ($dateTimeFin == false) {
                $dateTimeFin = date_create_from_format('d/m/Y H:i', $matches[0][0] . ' ' . $arrayExplode2[0]);
            }
        } else if(isset($matches1[0][0])){
            $dateTimeFin = date_create_from_format('d-m-Y H', $matches1[0][0] . ' ' . $arrayExplode2[0]);
            if ($dateTimeFin == false) {
                $dateTimeFin = date_create_from_format('d-m-Y H:i', $matches[0][0] . ' ' . $arrayExplode2[0]);
            }
        }

            return $this->render('question/question1.twig',[
                'dateTimeInicio' => $dateTimeInicio,
                'dateTimeFin' => $dateTimeFin
            ] );

    }

}
