<?php

namespace App\Support;


trait ModelOptionsHelper
{
    public static function getOptions($mapKey)
    {
        if (!property_exists(self::class, $mapKey) || !is_array(self::$$mapKey)) {
            return [];
        }
        $options = [];
        foreach (self::$$mapKey as $value => $label) {
            array_push($options, [
                'label' => $label,
                'value' => $value,
            ]);
        }
        return $options;
    }
}
