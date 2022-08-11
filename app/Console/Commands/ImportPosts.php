<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\BlogImporter;
use Illuminate\Console\Command;

class ImportPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import blog posts';
    /**
     * @var BlogImporter
     */
    private $blogImporter;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BlogImporter $blogImporter)
    {
        parent::__construct();

        $this->blogImporter = $blogImporter;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting importing sequence...');

        if(User::whereEmail('admin@blog.com')->doesntExist()){
            User::factory()->admin()->create();
        }

        $this->blogImporter->handle();

        $this->info('Importing sequence completed...');

    }
}
