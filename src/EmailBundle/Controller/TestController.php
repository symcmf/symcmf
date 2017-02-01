<?php

namespace EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    /**
     * Test route
     */
    public function testAction()
    {
        $emailService = $this->get('email_service');
        $emailService->sendMessage(1, 1);
        return $this->redirect('/');
    }
}
