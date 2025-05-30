<?php

declare(strict_types=1);

namespace Tempest\Auth;

use Tempest\Http\Session\Session;
use Tempest\Reflection\ClassReflector;

final readonly class SessionAuthenticator implements Authenticator
{
    private const string USER_KEY = 'tempest_session_user';

    public function __construct(
        private AuthConfig $authConfig,
        private Session $session,
    ) {}

    public function login(CanAuthenticate $user): void
    {
        $this->session->set(self::USER_KEY, $user->id);
    }

    public function logout(): void
    {
        $this->session->remove(self::USER_KEY);
        $this->session->destroy();
    }

    public function currentUser(): ?CanAuthenticate
    {
        $id = $this->session->get(self::USER_KEY);

        if (! $id) {
            return null;
        }

        $userModelClass = new ClassReflector($this->authConfig->userModelClass);

        /** @var \Tempest\Database\Builder\QueryBuilders\SelectQueryBuilder<\Tempest\Auth\CanAuthenticate> $query */
        $query = $userModelClass->callStatic('select');

        return $query->with('userPermissions.permission')->get($id);
    }
}
