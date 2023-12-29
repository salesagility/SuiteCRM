<?php

$config = Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        'blankline_after_open_tag',
        'empty_return',
        'extra_empty_lines',
        'function_typehint_space',
        'join_function',
        'method_argument_default_value',
        'multiline_array_trailing_comma',
        'no_blank_lines_after_class_opening',
        'no_empty_lines_after_phpdocs',
        'phpdoc_indent',
        'phpdoc_no_access',
        'phpdoc_no_empty_return',
        'phpdoc_no_package',
        'phpdoc_params',
        'phpdoc_scalar',
        'phpdoc_separation',
        'phpdoc_trim',
        'phpdoc_type_to_var',
        'phpdoc_types',
        'phpdoc_var_without_name',
        'remove_leading_slash_use',
        'remove_lines_between_uses',
        'short_bool_cast',
        'single_quote',
        'spaces_after_semicolon',
        'spaces_before_semicolon',
        'spaces_cast',
        'standardize_not_equal',
        'ternary_spaces',
        'trim_array_spaces',
        'unneeded_control_parentheses',
        'unused_use',
        'whitespacy_lines',
        'align_double_arrow',
        'concat_with_spaces',
        'logical_not_operators_with_successor_space',
        'multiline_spaces_before_semicolon',
        'newline_after_open_tag',
        'ordered_use',
        'php_unit_construct',
        'phpdoc_order',
        'short_array_syntax',
    ]);

if (null === $input->getArgument('path')) {
    $config
        ->finder(
            Symfony\CS\Finder\DefaultFinder::create()
                ->in('src')
                ->in('test')
                ->exclude('vendor')
        );
}

return $config;
