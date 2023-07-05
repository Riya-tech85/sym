<?php
namespace App\Service;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

class servicecall{

public function __construct(EntityManagerInterface $em){

    $this->em = $em;

}
    public function func($id){
        // $this->em = $this->getDoctrine()->getmanager();
        // $repository=$this->em->getRepository(Users::class);
        // $checking=$repository->findOneById($id);
        $pp = $this->em->getRepository(Users::class)->findOneById($id);
        $this->em->flush();

        // dd($pp);
        // die();
        return $pp;
    }
}
?>
