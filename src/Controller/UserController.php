<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use App\Entity\User;

class UserController extends AbstractController
{
    private $em;
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    #[Route('v1/user/test', name: 'app_v1_user_test', methods: ['GET'])]
    public function test(): Response
    {
        return new Response(
            '<html><body>Acabas de acceder a la Api Rest el usuario de test</body></html>'
        );
    }

    #[Route('v1/user/create', name: 'app_v1_user_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $email = $request->query->get('email');
        $roles = ["ROL_USER"];
        $name = $request->query->get('name');
        $date = new DateTime();
        $msg = "El usuario se ha creado correctamente.";
        $msgError = "No se puede crear un usuario sin: email o nombre. Revise los datos a introducir.";

        if(empty($email) || empty($name)){
            return new Response($msgError);
        }        

        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setName($name);
        $user->setCreatedAt($date);
        $user->setUpdatedAt($date);
        $user->setDeletedAt(null);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {    
            return new Response($errors);
        }

        $this->em->persist($user);
        $this->em->flush();

        return new Response($msg);
    }

    #[Route('v1/user/update/{id}', name: 'app_v1_user_update', methods: ['PUT'])]
    public function update(Request $request, $id): Response
    {
        $email = $request->query->get('email');
        $roles = ["ROL_USER"];
        $name = $request->query->get('name');
        $date = new DateTime();
        $msg = "El usuario se ha actualizado correctamente.";
        $msgError = ["No se puede actualizar un usuario sin: ID, email o nombre. Revise los datos a introducir.", "El usuario no existe en la BD."];

        if(empty($id) || !is_numeric($id) || empty($email) || empty($name)){
            return new Response($msgError[0]);
        }

        $user = $this->em->getRepository(User::class)->findOneByRow($id);

        if(is_null($user)) {
            return new Response($msgError[1]);
        }

        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setName($name);
        $user->setCreatedAt($date);
        $user->setUpdatedAt($date);
        $user->setDeletedAt(null);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {    
            return new Response($errors);
        }

        $this->em->persist($user);
        $this->em->flush();

        return new Response($msg);
    }

    #[Route('v1/user/delete/{id}', name: 'app_v1_user_delete', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $msg = "El usuario se ha borrado correctamente.";
        $msgError = ["No se puede borrar un usuario sin ID.", "El usuario no existe en la BD."];

        if(empty($id) || !is_numeric($id)){
            return new Response($msgError[0]);
        }

        $user = $this->em->getRepository(User::class)->findOneByRow($id);

        if(is_null($user)) {
            return new Response($msgError[1]);
        }

        $this->em->remove($user);
        $this->em->flush();

        return new Response($msg);
    }
}
