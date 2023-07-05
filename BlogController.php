<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
    /**
     * @Route("/blog", requirements={"_locale": "en|es|fr"}, name="blog_")
     */

class BlogController extends AbstractController
{
    // /**
    //  * @Route("/db", name="savedata", methods="POST")
    //  */
    // public function savedata(Request $request){
    //     $name=$request->request->get("name");
    //     $phone = $request->request->get("phone");
    //     $address = $request->request->get("address");

    //     $user_obj = new Users();
    //     $user_obj->setName($name);
    //     $user_obj->setPhone($phone);
    //     $user_obj->setAddress($address);
        
    //     $entitymanager = $this->getDoctrine()->getmanager();
    //     $entitymanager->persist($user_obj);
    //     $entitymanager->flush();
    //     $msg = "data save";

    //      return $this->render('default/form.html.twig', [
    //         'controller_name' => 'DefaultController',
    //         'msg' => $msg,
    //     ]);
    // }


    /**
     * @Route("/{_locale}", name="index")
     */
    public function index(): Response
    {
        dd('bye');
    }

    /**
     * @Route("/{_locale}/posts/{slug}", name="show")
     */
    public function show(string $slug): Response
    {
       dd('heyy');
    }

    /**
     * @Route("/", name="mobile_homepage", host="m.example.com")
     */
    public function mobileHomepage(): Response
    {
        dd('4');
    }

    /**
     * @Route({
     *     "en": "/about-us",
     *     "nl": "/over-ons"
     * }, name="about_us")
     */
    public function about(): Response
    {
       dd('3');
    }
    
}
