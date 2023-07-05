<?php

    namespace App\Controller;

use App\Entity\Users;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\CurlHttpClient;

    class ApiController extends AbstractFOSRestController{

        /**
         * @Route("/api", name = "app_api", methods = "GET")
         */
        public function getuser(){
            $entitymanager = $this->getDoctrine()->getmanager();
            $p = $entitymanager->getRepository(Users::class)->findOneBySomeField(7);

            $view = $this->view($p,200)->setFormat('json');

            return $view;
        }

        /**
         * @Route("/api/user/{id}", name = "app_api_id")
         */
        public function GetUserid(Request $request, $id)
        {
            // dd($request->request->all());
            $data = $request->request->all();
            $view = $this->view($data,200);
            return $view;
        }

        /**
         * @Route("/api/geturl", name = "app_api_geturldata")
         */
        public function fetchdata(SerializerInterface $serializer){
            $httpclient = HttpClient::Create();

            // //data to be updated
            // $data = [
            //     'name' => 'priya',
            //     'email' => 'rp@1234.com',
            // ];

            // $jsondata = $serializer->serialize($data,'json');

            $response = $httpclient->request('GET','http://localhost/symfony/myproject/public/api/user/3');

            //  // Check the response status code
            // if ($response->getStatusCode() === 200) {
            //     // Data updated successfully
            //     return new JsonResponse(['message' => 'Data updated successfully'], 200);
            // } else {
            //     // Handle the case when the update was not successful
            //     return new JsonResponse(['message' => 'Failed to update data'], $response->getStatusCode());
            // }
            $content = $response->getContent();
            // $jsonContent = $serializer->serialize($content,'json');

            $view = $this->view($content)->setStatusCode(200)->setFormat('json');
            return $view;

        }
        /**
         * @Route("/api/{id}", name = "app_api_update" ,methods = "PUT")
         */
        public function updatedate(Request $request,$id,SerializerInterface $serializer){
         
            $entitymanager = $this->getDoctrine()->getmanager();
            $data = $entitymanager->getRepository(Users::class)->find($id);
    
            $data->setName($request->request->get('name'));
            $data->setAddress($request->request->get('address'));
            $entitymanager->persist($data);
            $entitymanager->flush();

            return new JsonResponse(['message' => 'User updated successfully'], 200);
        }

        /**
         * @Route("/api/{id}", name = "api_api_delete", methods = "DELETE")
         */
        public function deletedata(Request $request,$id){
            $entitymanager = $this->getDoctrine()->getmanager();
            $data = $entitymanager->getRepository(Users::class)->find($id);
            $entitymanager->remove($data);
            $entitymanager->flush();

            return new JsonResponse(['User deleted successfully'],Response::HTTP_OK);
        }

        /**
         * @Route("/api", name = "api_post", methods = "POST")
         */
        public function postdata(Request $request){
            $entitymanager = $this->getDoctrine()->getmanager();
             
            $user_obj = new Users();

            $user_obj->setName($request->request->get("name"));
            $user_obj->setPhone($request->request->get("phone"));
            $user_obj->setAddress($request->request->get("address"));

            $entitymanager->persist($user_obj);
            $entitymanager->flush();

            return new JsonResponse(['Data added successfully'], Response::HTTP_Ok);
        }

        /**
         * @Route("/oauth/v2/token" , name = "token")
         */
        public function getToken(Request $request){
            $grant_type = $request->request->get('grant_type');
        }
    }
