<?php

namespace App\Traits;

trait ConvertsCamelToSnake
{
    /**
     * Convert all camelCase keys in the request to snake_case.
     */
    public function convertCamelToSnake(array $input): array
    {
        $converted = [];

        foreach ($input as $key => $value) {
            $snakeKey = preg_replace_callback('/[A-Z]/', function ($match) {
                return '_' . strtolower($match[0]);
            }, $key);

            $converted[$snakeKey] = $value;
        }

        return $converted;
    }
}
