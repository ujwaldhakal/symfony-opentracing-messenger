<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'no_superfluous_phpdoc_tags' => true,
        'no_trailing_whitespace_in_string' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'final_internal_class' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'void_return' => true,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
        ],
        'class_definition' => ['multi_line_extends_each_single_line' => true],
        'heredoc_indentation' => true,
        'single_line_throw' => false,
        'class_attributes_separation' => [
            'elements' => [
                'property' => 'one',
                'method' => 'one',
            ],
        ],
        'php_unit_test_annotation' => ['style' => 'annotation'],
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'php_unit_set_up_tear_down_visibility' => true,
        'php_unit_internal_class' => false,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
    ])
    ->setFinder($finder)
    ;
