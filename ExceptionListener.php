<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener{
    public function onKernelException(ExceptionEvent $event){
        $exception = $event->getThrowable();
        $message = sprintf(
            'hey',
            $exception->getMessage(),
            $exception->getCode()
        );
        $response = new Response();
        $response->setContent($message);
        $event->setResponse($response);
    }
    
    // public function fun(ExceptionEvent $event){
    //     $excep = $event->getThrowable();
    //     $mssg = sprintf(
    //         'hello',
    //         $excep->getMessage(),
    //         $excep->getCode()
    //     );
    //     $respon = new Response();
    //     $respon->setContent($mssg);
    //     $event->setReponse($mssg);
    // }

}