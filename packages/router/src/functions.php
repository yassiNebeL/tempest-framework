<?php

declare(strict_types=1);

namespace Tempest {
    use Tempest\Reflection\MethodReflector;
    use Tempest\Router\Router;

    /**
     * Creates a valid URI to the given controller `$action`.
     */
    function uri(array|string|MethodReflector $action, mixed ...$params): string
    {
        if ($action instanceof MethodReflector) {
            $action = [
                $action->getDeclaringClass()->getName(),
                $action->getName(),
            ];
        }

        $router = get(Router::class);

        return $router->toUri(
            $action,
            ...$params,
        );
    }

    /**
     * Checks whether the given controller action matches the current URI.
     */
    function is_current_uri(array|string|MethodReflector $action, mixed ...$params): bool
    {
        if ($action instanceof MethodReflector) {
            $action = [
                $action->getDeclaringClass()->getName(),
                $action->getName(),
            ];
        }

        $router = get(Router::class);

        return $router->isCurrentUri(
            $action,
            ...$params,
        );
    }
}
