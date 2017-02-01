<?php

namespace EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    /**
     * Test route
     * Need to delete in prod
     */
    public function testAction()
    {
        $idUser = 1;
        $idTemplate = 1;

        $emailService = $this->get('email_service');
        $emailService->sendMessage($idUser, $idTemplate);

        return $this->redirect('/');
    }
}
