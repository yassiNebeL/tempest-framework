<?php

declare(strict_types=1);

namespace Tests\Tempest\Fixtures\Controllers;

use Tempest\Auth\Allow;
use Tempest\Router\Get;
use Tempest\Router\Response;
use Tempest\Router\Responses\Ok;
use Tests\Tempest\Integration\Auth\Fixtures\CustomAuthorizer;
use Tests\Tempest\Integration\Auth\Fixtures\UserPermissionUnitEnum;

final readonly class AdminController
{
    #[Allow(UserPermissionUnitEnum::ADMIN)]
    #[Get('/admin')]
    public function admin(): Response
    {
        return new Ok();
    }

    #[Allow(UserPermissionUnitEnum::GUEST)]
    #[Get('/guest')]
    public function guest(): Response
    {
        return new Ok();
    }

    #[Allow(CustomAuthorizer::class)]
    #[Get('/custom-authorizer')]
    public function customAuthorizer(): Response
    {
        return new Ok();
    }
}
