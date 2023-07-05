<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\servicecall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
// use App\EventListener\ExceptionListener;
use Symfony\Component\Validator\Validator\ValidatorInterface;
// use Symfony\Component\Serializer\Encoder\JsonEncoder;
// use Symfony\Component\Serializer\Encoder\XmlEncoder;
// use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
// use Symfony\Component\Serializer\Serializer;
// use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;




class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="app_default")
     */
    public function index(): Response
    {
        $msg = "";
        return $this->render('default/form.html.twig', [
            'controller_name' => 'DefaultController',
            'msg' => $msg,
        ]);
    }

    /**
     * @Route("/home", name="app_home")
     */
    // public function token(TokenGenerator $tc){
    //     $result = $tc->CreateClienttoken();
    //     $accesstoken = $tc->AccessToken($result['client_id'],$result['client_randomid']);
    //     // $refreshtoken = $tc->RefreshToken($result['client_id'],$result['client_secret']);
    //     // dd($accesstoken);
    // }

    /**
     * @Route("/serviceid/{id}", name="service" ,methods={"GET"})
     */
    public function fun(int $id,servicecall $obj){
        echo $id;
        $pp = $obj->func($id);
        // dd($pp);
        // die();
        return $this->render('default/showdata.html.twig', [
            'controller_name' => 'DefaultController',
            'array' => $pp,
        ]);
    }

    /**
     * @Route("/db", name="savedata", methods="POST")
     */
    public function savedata(Request $request, ValidatorInterface $validator){
        // $request->request->all();
        $name=$request->request->get("name");
        $phone = $request->request->get("phone");
        $address = $request->request->get("address");
        // $image = $request->files->get("image");
        // dd($image);
        // die();
        // $name1 = $image->getclientoriginalname();
        // $image->move("../../public/image".$name1);

        $user_obj = new Users();
        $user_obj->setName($name);
        $user_obj->setPhone($phone);
        $user_obj->setAddress($address);
        // $user_obj->setImage($name1);
        
        $entitymanager = $this->getDoctrine()->getmanager();
        $error = $validator->validate($user_obj);
        //get error message 
        foreach ($error as $violation) {
            $errorMessages = $violation->getMessage();
        }

        if(count($error)>0){
            return $this->render('default/form.html.twig', [
                'errors' => $errorMessages,
            ]);
        }
        // $p = $entitymanager->getRepository(Users::class)->findOneBy(2);
        $entitymanager->persist($user_obj);
        $entitymanager->flush();
        $msg = "data save";

         return $this->render('default/form.html.twig', [
            'controller_name' => 'DefaultController',
            'msg' => $msg,
        ]);
    }

    /**
     * @Route("/db1", name="finddata1", methods="GET")
     */
    public function find(SerializerInterface $serializer,Request $request){
   

        $entitymanager = $this->getDoctrine()->getmanager();
        $p = $entitymanager->getRepository(Users::class)->findOneBySomeField(2);
        $jsoncontent = $serializer->serialize($p,'json',['groups' => 'grp1']);
        // $entitymanager->persist($p);
        //$entitymanager->flush();
        dd($jsoncontent);
    }
    // /**
    //  * @Route("/api/posts/{slug}", methods={"GET","HEAD"}, defaults={"slug":1 ,"title":"hello world!"})
    //  */
    // public function show(int $slug, string $title)
    // {
    //     dd($slug);
    //     dd($title);
    // }

    // /**
    //  * @Route("/api/posts/{id}", methods={"GET"})
    //  */
    // public function edit(string $id): Response
    // {
    //     dd($id);
    // }

    // /**
    //  * @Route(
    //  *     "/articles/{_locale}/search.{_format}",
    //  *     locale="en",
    //  *     format="html",
    //  *     requirements={
    //  *         "_locale": "en|fr",
    //  *         "_format": "html|xml",
    //  *     }
    //  * )
    //  */
    // public function search(): Response
    // {
    //     dd('hey');
    // }

    // /**
    //  * @Route("/share/{token}", name="share", requirements={"token"=".+"})
    //  */
    // public function share($token): Response
    // {
    //     dd('hhi');
    // }
}
