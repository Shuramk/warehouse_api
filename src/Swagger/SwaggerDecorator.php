<?php

declare(strict_types=1);

namespace App\Swagger;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;
use ArrayObject;

final class SwaggerDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Token'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);
        $schemas['Credentials'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'test',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'testtest',
                ],
            ],
        ]);

        $pathItem = new Model\PathItem(
            'JWT Token', null, null, null, null,
            new Model\Operation(
                'postCredentialsItem',
                ['Users'],
                [
                    '200' => [
                        'description' => 'Get JWT token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Token',
                                ],
                            ],
                        ],
                    ],
                ],
                'Get JWT token to login.',
                '',
                null,
                [],
                new Model\RequestBody(
                    'Generate new JWT Token',
                    new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials',
                            ],
                        ],
                    ]),
                ),
                null, false, null, null,

            ),
        );
        $openApi->getPaths()->addPath('/api/login_check', $pathItem);


        $schemas['Register'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'name' => [
                    'type' => 'string',
                    'example' => 'Вася Пупкин',
                ],
                'username' => [
                    'type' => 'string',
                    'example' => 'test',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'testtest',
                ],
            ],
        ]);
        $pathItem = new Model\PathItem(
            'Users', null, null, null, null,
            new Model\Operation(
                'postRegisterData',
                ['Users'],
                [
                    '200' => [
                        'description' => 'User successfully created',
                    ],
                    '422' => [
                        'description' => 'Validation errors',
                    ],
                    'default' => [
                        'description' => 'unexpected error'
                    ]

                ],
                'Register new user.',
                '',
                null,
                [],
                new Model\RequestBody(
                    'Register new user',
                    new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Register',
                            ],
                        ],
                    ]),
                ),
                null, false, null, null,

            ),
        );

        $openApi->getPaths()->addPath('/api/register', $pathItem);

        return $openApi;
    }

}