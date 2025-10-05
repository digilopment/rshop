<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->name('*.php')
    ->notName('*.blade.php')
    ->exclude(['vendor', 'tmp', 'logs']);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true, // základ PSR-12
        'strict_param' => true, // prísne porovnania
        'array_syntax' => ['syntax' => 'short'], // []
        'no_unused_imports' => true, // odstráni nepoužité use
        'ordered_imports' => ['sort_algorithm' => 'alpha'], // zoradí use
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal',
        ],
        'no_trailing_whitespace' => true,
        'phpdoc_align' => ['align' => 'left'],
        'single_quote' => true, // preferuj jednoduché úvodzovky
        'blank_line_before_statement' => ['statements' => ['return']], // medzera pred return
        'trim_array_spaces' => true, // odstráni nadbytočné medzery v poliach
        'no_extra_blank_lines' => ['tokens' => ['extra']], // zredukuje prázdne riadky
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setRiskyAllowed(true); // potrebné pre niektoré pravidlá ako strict_param
