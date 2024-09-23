<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->name('*.php')
;

$config = (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'trailing_comma_in_multiline' => false,
    ])
    ->setFinder($finder)
;

return $config;
