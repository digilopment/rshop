<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->name('*.php')
    ->notName('*.blade.php')
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal',
        ],
        'no_trailing_whitespace' => true,
        'phpdoc_align' => ['align' => 'left'],
    ])
    ->setFinder($finder)
    ->setUsingCache(true);
