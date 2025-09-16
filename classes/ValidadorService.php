<?php
class ValidadorService {
    public static function sanitizar($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitizar'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    // ...métodos de la clase...
}
