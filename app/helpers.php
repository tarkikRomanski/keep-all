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

if (!function_exists('humanFileSize')) {
    /**
     * Humanize size format
     *
     * @param $size
     * @param string $unit
     * @return string
     */
    function humanSize($size, $unit = "")
    {
        if ((!$unit && $size >= 1 << 30) || $unit == "GB")
            return number_format($size / (1 << 30), 2) . "GB";
        if ((!$unit && $size >= 1 << 20) || $unit == "MB")
            return number_format($size / (1 << 20), 2) . "MB";
        if ((!$unit && $size >= 1 << 10) || $unit == "KB")
            return number_format($size / (1 << 10), 2) . "KB";
        return number_format($size) . " bytes";
    }
}