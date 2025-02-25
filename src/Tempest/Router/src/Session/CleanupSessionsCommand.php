<?php

declare(strict_types=1);

namespace Tempest\Router\Session;

use Tempest\Console\Console;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\Schedule;
use Tempest\Console\Scheduler\Every;
use Tempest\EventBus\EventHandler;

final readonly class CleanupSessionsCommand
{
    public function __construct(
        private Console $console,
        private SessionManager $sessionManager,
    ) {
    }

    #[ConsoleCommand(
        name: 'session:clean',
        description: 'Finds and removes all expired sessions',
    )]
    #[Schedule(Every::MINUTE)]
    public function __invoke(): void
    {
        $this->console->info('Cleaning up sessions...');

        $this->sessionManager->cleanup();

        $this->console->success('Done');
    }

    #[EventHandler]
    public function onSessionDestroyed(SessionDestroyed $event): void
    {
        $this->console->info("\t- {$event->id} removed");
    }
}
