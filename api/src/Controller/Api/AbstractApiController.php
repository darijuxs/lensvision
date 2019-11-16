<?php

namespace App\Controller\Api;

use App\Service\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AbstractApiController
 *
 * @package App\Controller\Api
 */
class AbstractApiController extends AbstractController
{
    /**
     * @return array
     */
    public static function getSubscribedServices()
    {
        return array_merge(
            parent::getSubscribedServices(),
            [
                Validator::class,
            ]
        );
    }
}