<?php

namespace App\Console\Commands;

use App\Models\MenuItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DcsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Updating dcs/admin dcs/ref dcs/ged dcs/core');
        shell_exec('composer update dcs/admin dcs/ref dcs/ged dcs/core');

        $this->call('admin', ['action' => 'update']);
        $this->call('ref', ['action' => 'update']);
        $this->call('ged', ['action' => 'update']);
        $this->call('core', ['action' => 'update']);

        $this->info('Success');

        return 0;
    }
}
