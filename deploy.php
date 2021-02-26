<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'mensa_poc');

// Project repository
set('repository', 'git@github.com:davidbschneider/mensa-prototype.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('mensa.davidschneider.info')
    ->user('ubuntu')
    ->set('deploy_path', '/srv/{{application}}');

// Tasks
//task('build', function () {
//    run('cd {{release_path}} && build');
//});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

