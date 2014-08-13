<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MysqlClearCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mysql:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop, Create, Migrate & Seed MySQL.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {

        if (Config::get('database.default') == 'mysql') {
            $connection = Config::get('database.connections.' . Config::get('database.default'));
            $username   = $connection['username'];
            $password   = $connection['password'];
            $database   = $connection['database'];
            $cmd        = 'mysql --user=' . $username . ' --password=' . $password . ' -BNe "show tables" ' . $database . ' | tr \'\n\' \',\' | sed -e \'s/,$//\' | awk \'{print "SET FOREIGN_KEY_CHECKS = 0;DROP TABLE IF EXISTS " $1 ";SET FOREIGN_KEY_CHECKS = 1;"}\' | mysql --user=' . $username . ' --password=' . $password . ' ' . $database;

            $this->info('Dropping Database ' . $database);
            exec($cmd);
            $this->info('Creating Database ' . $database);
            $this->comment('-----------------');

            $this->call('migrate');
            $this->comment('-----------------');

            $this->info("Seeding Database");
            $this->call('db:seed', ["--class" => "DatabaseSeeder"]);
            $this->comment('-----------------');
        }

    }
}
