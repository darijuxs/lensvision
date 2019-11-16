<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 *
 * @package App\Controller\Api
 *
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route(name="index")
     */
    public function index()
    {
        return $this->json(
            [
                'ok'
            ]
        );
    }
}
