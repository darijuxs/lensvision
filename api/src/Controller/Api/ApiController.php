<?php

namespace App\Controller\Api;

use App\Entity\Request\LenseOption;
use App\Service\Validator\ValidatorTrait;
use App\Service\Serializer\SerializerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 *
 * @package App\Controller\Api
 *
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractApiController
{
    use ValidatorTrait;
    use SerializerTrait;

    /**
     * @Route(name="index")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        $data = [
            'option1' => 'true',
        ];

        $lense = $this->denormalize($data, LenseOption::class);
        if (!$this->validate($lense)) {
            return $this->json($this->getErrors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json($lense);
    }
}
