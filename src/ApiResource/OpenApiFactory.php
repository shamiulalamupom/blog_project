<?php

namespace App\ApiResource;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\OpenApi\OpenApi;

final class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private readonly OpenApiFactoryInterface $decorated) {}

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        $this->addRegisterEndpoint($openApi);
        $this->retagLoginEndpoint($openApi);

        return $openApi;
    }

    private function retagLoginEndpoint(OpenApi $openApi): void
    {
        $pathItem = $openApi->getPaths()->getPath('/auth');
        if ($pathItem === null || $pathItem->getPost() === null) {
            return;
        }

        $openApi->getPaths()->addPath('/auth', $pathItem->withPost(
            $pathItem->getPost()->withTags(['Auth'])
        ));
    }

    private function addRegisterEndpoint(OpenApi $openApi): void
    {
        $pathItem = new Model\PathItem(
            post: new Model\Operation(
                operationId: 'postRegisterItem',
                tags: ['Auth'],
                summary: 'Register a new user',
                requestBody: new Model\RequestBody(
                    required: true,
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'username' => ['type' => 'string', 'example' => 'johndoe'],
                                    'password' => ['type' => 'string', 'example' => 'secret'],
                                ],
                                'required' => ['username', 'password'],
                            ],
                        ],
                    ]),
                ),
                responses: [
                    '201' => [
                        'description' => 'User registered',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => ['message' => ['type' => 'string']],
                                ],
                            ],
                        ],
                    ],
                    '422' => ['description' => 'Validation error'],
                ],
            ),
        );

        $openApi->getPaths()->addPath('/api/register', $pathItem);
    }
}
