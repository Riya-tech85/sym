<?php 
    namespace App\Service;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\AccessToken;
// use FOS\OAuthServerBundle\Model\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpComponent\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use OAuth2\OAuth2;

class TokenGenerator{

    private $clientManager;
    private $oauthServer;
    private $em;
    private $session;

    public function __construct(ContainerInterface $container,ClientManagerInterface $clientManager,OAuth2 $outhServer,SessionInterface $session,EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->container = $container;
        $this->clientManager = $clientManager;
        $this->oauthServer = $outhServer;
        $this->em = $em;
        
    }

    public function createClient($user)
    {
        $clientManager = $this->clientManager;

        $client = $clientManager->createClient();
        $client->setRedirectUris(['http://localhost/symfony/myproject/public/login']);
        $client->setAllowedGrantTypes(array('token', 'password', 'refresh_token', 'client_credentials'));
        $client->setUser($user);
        $clientManager->updateClient($client);
        // $this->session->set('client', $client);
        return $client;

        // return ([

        //     'client_id' => $client->getPublicId(),
        //     'client_secret' => $client->getSecret(),
        //     'client_randomid' => $client->getRandomId()
        // ]);
    }
    
    public function createToken($client, $userid, $password){
        if ( !empty( $client->getRandomId() ) && !empty( $client->getSecret() ) ) {
            $grantRequest = new Request(array(
                'client_id' => $client->getId() . '_' . $client->getRandomId(),
                'client_secret' => $client->getSecret(),
                'grant_type' => 'client_credentials',
                'user_id' =>$userid,
                'password' => $password
            ));
            // dd($grantRequest);
            $tokenResponse = $this->oauthServer->grantAccessToken($grantRequest);
            $token_detail = $tokenResponse->getContent();
            if (!empty($token_detail)) {
                $token_detail = json_decode($token_detail, true);
                $token_detail['client_id'] = $client->getRandomId();
                $token_detail['client_secret'] = $client->getSecret();
                return json_encode($token_detail);
            }
            return false;
        } else {
            throw new \Exception("Error Processing Request", 1);
        }
    }
    
    public function refreshToken($clientId, $clientSecret, $refreshToken) {
        $grantRequest = new Request(array(
            'client_id'  => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ));
        $tokenResponse = $this->oauthServer->grantAccessToken($grantRequest);
        $token = $tokenResponse->getContent();
        return $token;
    }
}