<?php

declare(strict_types=1);

use Ergebnis\PhpCsFixer;
use PhpCsFixer\Finder;

$ruleSet = PhpCsFixer\Config\RuleSet\Php84::create()
    ->withRules(PhpCsFixer\Config\Rules::fromArray([
        'attribute_empty_parentheses' => [
            'use_parentheses' => false,
        ],
        'date_time_immutable' => false,
        'declare_strict_types' => [
            'preserve_existing_declaration' => true,
        ],
        'error_suppression' => false,
        'explicit_string_variable' => false,
        'final_class' => false,
        'final_public_method_for_abstract_class' => false,
        'heredoc_to_nowdoc' => false,
        'increment_style' => false,
        'mb_str_functions' => false,
        'method_chaining_indentation' => false,
        'multiline_string_to_heredoc' => false,
        'native_constant_invocation' => false,
        'native_function_invocation' => false,
        'ordered_class_elements' => false,
        'phpdoc_line_span' => [
            'const' => 'multi',
            'method' => 'multi',
            'property' => 'single',
        ],
        'phpdoc_list_type' => false,
        'phpdoc_to_property_type' => false,
        'protected_to_private' => false,
        'return_assignment' => false,
        'static_lambda' => false,
        'static_private_method' => false,
        'strict_comparison' => false,
        'yoda_style' => false,
    ]));

$finder = Finder::create()
    ->exclude([
        '.build/',
        '.docker/',
        '.gitea/',
        '.idea/',
        '.note/',
        'assets/',
        'bin/',
        'lib/',
        'node_modules/',
        'public/',
        'templates/',
        'var/',
        'src/Playground/',
    ])
    ->ignoreDotFiles(false)
    ->in(__DIR__);

$config = PhpCsFixer\Config\Factory::fromRuleSet($ruleSet);

$config->setCacheFile(__DIR__ . '/.build/php-cs-fixer/.php-cs-fixer.cache');
$config->setFinder($finder);

return $config;
