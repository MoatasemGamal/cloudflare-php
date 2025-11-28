<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PHP84Migration' => true,

        // Strict types
        'declare_strict_types' => true,

        // Nullable type declaration for default null values (PHP 8.4)
        'nullable_type_declaration_for_default_null_value' => true,

        // Array syntax
        'array_syntax' => ['syntax' => 'short'],

        // Import ordering
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],

        // Remove unused imports
        'no_unused_imports' => true,

        // Strict comparison
        'strict_comparison' => true,
        'strict_param' => true,

        // Return types
        'void_return' => true,
        'phpdoc_to_return_type' => true,

        // Modernization
        'modernize_types_casting' => true,
        'no_alias_functions' => true,
        'native_function_invocation' => [
            'include' => ['@all'],
            'scope' => 'namespaced',
            'strict' => true,
        ],

        // Code quality
        'single_quote' => true,
        'no_empty_phpdoc' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'remove_inheritdoc' => false,
        ],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_separation' => false,
        'phpdoc_summary' => true,
        'phpdoc_trim' => true,

        // Whitespace and formatting
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'extra',
                'throw',
                'use',
                'use_trait',
            ],
        ],
        'single_blank_line_at_eof' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],

        // Binary operators
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'concat_space' => ['spacing' => 'one'],

        // Control structures
        'no_alternative_syntax' => true,
        'no_superfluous_elseif' => true,
        'simplified_if_return' => true,

        // Function declaration
        'function_declaration' => ['closure_function_spacing' => 'one'],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],

        // Return statements
        'no_useless_return' => true,
        'simplified_null_return' => false, // Keep explicit null returns for clarity

        // Class notation
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'one',
            ],
        ],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public',
                'method_protected',
                'method_private',
            ],
        ],
        'visibility_required' => [
            'elements' => ['property', 'method', 'const'],
        ],

        // Comments
        'single_line_comment_style' => true,
        'multiline_comment_opening_closing' => true,
    ])
    ->setFinder($finder);
