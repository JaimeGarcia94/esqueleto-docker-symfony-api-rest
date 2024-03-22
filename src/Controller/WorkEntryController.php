<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use App\Entity\WorkEntry;
use App\Entity\User;

class WorkEntryController extends AbstractController
{
    private $em;
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    #[Route('v1/works-entries', name: 'app_v1_works_entries', methods: ['GET'])]
    public function list(Request $request): Response
    {
        $worksEntries = $this->em->getRepository(WorkEntry::class)->findAll();
        $data = [];

        foreach($worksEntries as $workEntry){
            $id = $workEntry->getId();
            $user = $workEntry->getUser();
            $startDate = $workEntry->getStartDate();
            $endDate = $workEntry->getEndDate();
            $createdAt = $workEntry->getCreatedAt();
            $updatedAt = $workEntry->getUpdatedAt();

            $data[] = [
                'id' => $id,
                'user' => $user,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'createdAt' => $createdAt,
                'updatedAt' => $updatedAt
            ];
        }

        $array = [
            "data" => $data
        ];
        
        return new Response(json_encode($array));   
    }

    #[Route('v1/work-entry/{id}', name: 'app_v1_work_entry', methods: ['GET'])]
    public function workEntry(Request $request, $id): Response
    {
        $workEntry = $this->em->getRepository(WorkEntry::class)->findOneById($id);
        $msgError = "No existe registro de fecha en la BD con este ID. Por favor introduzca uno válido.";

        if(empty($workEntry)) { 
            return new Response($msgError);
        }

        $data = [];
        $id = $workEntry->getId();
        $user = $workEntry->getUser();
        $startDate = $workEntry->getStartDate();
        $endDate = $workEntry->getEndDate();
        $createdAt = $workEntry->getCreatedAt();
        $updatedAt = $workEntry->getUpdatedAt();

        $data[] = [
            'id' => $id,
            'user' => $user,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt
        ];

        $array = [
            "data" => $data
        ];
        
        return new Response(json_encode($array));    
    }

    #[Route('v1/work-entry/create', name: 'app_v1_work_entry_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $userId = $request->query->get('userId');
        $date = new DateTime();
        $startDate = $request->query->get('startDate');
        $startDateObject = new DateTime($startDate);
        $endDate = $request->query->get('endDate');
        $endDateObject = empty($endDate) ? null : new DateTime($endDate);
        $user = $this->em->getRepository(User::class)->findOneById($userId);
        $msg = "La fecha se ha creado correctamente.";
        $msgError = ["No se puede crear la fecha de entrada sin el ID del usuario o la fecha de acceso. Revise los datos a introducir.", "La fecha de salida no puede ser inferior a la de entrada."];

        if(empty($userId) || empty($startDate)){
            return new Response($msgError[0]);
        }
        
        if(!empty($endDateObject)){
            if($endDateObject < $startDateObject) {
                return new Response($msgError[1]);
            }
        }        

        $workEntry = new WorkEntry();
        $workEntry->setUser($user);
        $workEntry->setCreatedAt($date);
        $workEntry->setUpdatedAt($date);
        $workEntry->setDeletedAt(null);
        $workEntry->setStartDate($startDateObject);
        $workEntry->setEndDate($endDateObject);

        $errors = $this->validator->validate($workEntry);

        if (count($errors) > 0) {    
            return new Response($errors);
        }

        $this->em->persist($workEntry);
        $this->em->flush();

        return new Response($msg);
    }

    #[Route('v1/work-entry/update/{id}', name: 'app_v1_work_entry_update', methods: ['PUT'])]
    public function update(Request $request, $id): Response
    {
        $date = new DateTime();
        $startDate = $request->query->get('startDate');
        $startDateObject = new DateTime($startDate);
        $endDate = $request->query->get('endDate');
        $endDateObject = empty($endDate) ? null : new DateTime($endDate);
        $msg = "La fecha se ha actualizado correctamente.";
        $msgError = ["No se puede actualizar la fecha de acceso. Revise los datos a introducir.", "La fecha de salida no puede ser inferior a la de entrada."];

        if(empty($startDate)){
            return new Response($msgError[0]);
        }
        
        if(!empty($endDateObject)){
            if($endDateObject < $startDateObject) {
                return new Response($msgError[1]);
            }
        }        

        $workEntry = $this->em->getRepository(WorkEntry::class)->findOneById($id);
        $workEntry->setUpdatedAt($date);
        $workEntry->setDeletedAt(null);
        $workEntry->setStartDate($startDateObject);
        $workEntry->setEndDate($endDateObject);

        $errors = $this->validator->validate($workEntry);

        if (count($errors) > 0) {    
            return new Response($errors);
        }

        $this->em->persist($workEntry);
        $this->em->flush();

        return new Response($msg);
    }

    #[Route('v1/work-entry/delete/{id}', name: 'app_v1_work_entry_delete', methods: ['DELETE'])]
    public function delete($id): Response
    {
        
    }
}
