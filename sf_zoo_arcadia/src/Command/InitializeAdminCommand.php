<?php


namespace App\Command;

use App\Service\AdminInitializer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class InitializeAdminCommand extends Command
{
    protected static $defaultName = 'app:initialize-admin';

    private $adminInitializer;

    public function __construct(AdminInitializer $adminInitializer)
    {
        $this->adminInitializer = $adminInitializer;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Initializes the admin user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->adminInitializer->initializeAdmin();

        return Command::SUCCESS;
    }
}