<?php

// Sami is an API documentation generator: https://github.com/FriendsOfPHP/Sami

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;

return new Sami(__DIR__ . '/../src', [
    'theme'                => 'default',
    'title'                => 'Fluent WebDriver Client API',
    'build_dir'            => __DIR__.'/../docs/sami',
    'cache_dir'            => __DIR__.'/../cache',
    'default_opened_level' => 2,
]);
