<?php

namespace MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TestController
 * @package MessageBundle\Controller
 */
class TestController extends Controller
{
    /**
     * Test route
     * Need to delete in prod
     */
    public function testAction()
    {
        $idUser = 2;
        $idTemplate = 1;

        $messageService = $this->get('message_service');
        $messageService->sendMessage($idTemplate, $idUser);

        return $this->redirect('/');
    }
}
