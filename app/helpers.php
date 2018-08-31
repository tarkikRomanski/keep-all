<?php
if (!function_exists('transformFields')) {
    /**
     * Transform fields names by alias
     *
     * @param array $args
     * @param array $alias
     * @return array
     */
    function transformFields(array $args, array $alias = [])
    {
        return array_column(array_map(function ($key, $value) use ($alias) {
            $key = isset($alias[$key]) ? $alias[$key] : $key;
            return [$key, $value];
        }, array_keys($args), $args), 1, 0);
    }
}