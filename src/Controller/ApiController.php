<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

/**
 * @Route("/API")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/persona/{id}", name="editpersona")
     */
    public function editPersona(Request $request, $id)
    {
        /** @var Persona $persona */
//        $persona = $this->getDoctrine()->getRepository(Persona::class)->find($id);

        $variable = $request->get('fechaNacimiento');
        if ($request->get('fechaNacimiento') == null || $request->get('nombre') == null) {
            return $this->json(['result' => 'No se han enviado los parametros adecuados']);
        }

        if ($persona instanceof Persona) {
            $fechaNacimiento = \DateTime::createFromFormat('d/m/Y',$request->get('fechaNacimiento'));

            if ($fechaNacimiento == false){
                return $this->json(['result' => 'La fecha no ha sido introducida en el formato correcto (d/m/Y)']);
            }

            $persona->setFechaNacimiento($fechaNacimiento->format('d/m/Y'));
            $persona->setNombre($request->get('nombre'));
            $this->getDoctrine()->getManager()->flush();

            return $this->json([
                'result' => ' Editado correctamente',
                'id' => $persona->getId(),
                'nombre' => $persona->getNombre(),
                'fechaNacimiento' => $persona->getFechaNacimiento()
            ]);
        } else {
            return $this->json(['result' => ' No se ha encontrado la persona']);
        }
    }

}

