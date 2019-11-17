<?php

namespace App\Controller\Api;

use App\Entity\Request\LenseOption;
use App\Service\Lense\Options;
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
     * @Route("/v1", name="index")
     *
     * @param Request $request
     * @param Options $options
     *
     * @return JsonResponse
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(Request $request, Options $options)
    {
        $data = json_decode($request->getContent(), true);
        $lenseRequest = $this->denormalize($data, LenseOption::class);
        if (!$this->validate($lenseRequest)) {
            return $this->json($this->getErrors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $lenseOptionValues = $options->getGroupedValues($lenseRequest);

        return $this->json($lenseOptionValues);
    }
}
