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
use Symfony\Component\Console\Input\InputOption;

#[Command]
class UpdateCommand extends HyperfCommand
{
    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('update');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('更新子模块');
        $this->addOption('branch', 'B', InputOption::VALUE_OPTIONAL, '需要被更新的分支', 'master');
    }

    public function handle()
    {
        $branch = $this->input->getOption('branch');

        $root = getcwd();
        if (! file_exists($path = $root . '/.gitmodules')) {
            $this->output->writeln($path . ' not found.');
            return;
        }
        $content = file_get_contents($path);
        $preg = '/path = (.*)/';

        $matched = null;
        preg_match_all($preg, $content, $matched);
        $command = 'cd %s && git checkout %s && git pull && cd %s';
        if ($paths = $matched[1] ?? null) {
            foreach ($paths as $path) {
                shell_exec(sprintf($command, $root . '/' . $path, $branch, $root));
            }
        }
    }
}
