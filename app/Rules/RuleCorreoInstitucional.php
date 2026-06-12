<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RuleCorreoInstitucional implements ValidationRule
{
    /**
     * Ejecuta la regla de validación.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Convertimos el correo a minúsculas para evitar problemas de mayúsculas
        $email = strtolower($value);

        // 2. Definimos los dominios institucionales permitidos en tu centro
        // Puedes añadir aquí los que necesites (ej: el de Murcia, el genérico de tu IES, etc.)
        $dominiosPermitidos = [
            'alumno.es',
            'murciaeduca.es',
            'iesingenierodelacierva.com'
        ];

        $valido = false;

        // 3. Comprobamos si el correo termina con alguno de los dominios
        foreach ($dominiosPermitidos as $dominio) {
            if (str_ends_with($email, '@' . $dominio)) {
                $valido = true;
                break;
            }
        }

        // 4. Si no es válido, disparamos el mensaje de error que verá el alumno
        if (!$valido) {
            $fail('El correo electrónico debe ser una cuenta institucional válida del centro (ejemplo: @alumno.es).');
        }
    }
}
