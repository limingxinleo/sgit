<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Psr\Container\ContainerInterface;

#[Command]
class VersionCommand extends HyperfCommand
{
    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('version');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('当前版本');
    }

    public function handle()
    {
        $this->output->table(['当前版本'], [
            [
                env('APP_VERSION'),
            ],
        ]);
    }
}
