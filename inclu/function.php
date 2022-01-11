
<?php
/**
 * Fonction qui sert à afficher plus simplement une variable de type array
 * @param  array $tableau
 * @return void
 */
function debug($tableau)
{
    echo '<pre style="height:300px;overflow: scroll; font-size: .8em;padding: 10px;font-family: Consolas, Monospace; background-color: #000;color:#fff;">';
    print_r($tableau);
    echo '</pre>';
}

/**
 * la fonction xss permet de contrer les failles XSS
 *
 * @param  mixed $value
 * @return void
 */
function xss($value)
{
    return trim(strip_tags($value));
}

/**
 * Permet d'afficher les erreurs
 *
 * @param  array $errors
 * @param  mixed $key
 * @return void
 */
function viewError($errors, $key)
{
    if (!empty($errors[$key])) {
        echo $errors[$key];
    }
}


function validTelephone($errors, $key, $tel)
{
    if (preg_match("#[0][6][- \.?]?([0-9][0-9][- \.?]?){4}$#", $tel) || preg_match("#[0][7][- \.?]?([0-9][0-9][- \.?]?){4}$#", $tel)) {
    } else {
        $errors[$key] = 'Veuillez renseigner un numéro valide.';
    }
    return $errors;
}

function validEmail($errors, $value, $key = 'mail')
{
    if (!empty($value)) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            $errors[$key] = 'Veuillez renseigner un email valide.';
        }
    } else {
        $errors[$key] = 'Veuillez renseigner un email.';
    }
    return $errors;
}

function validText($errors, $value, $key, $min, $max)
{
    if (empty($value)) {
        $errors[$key] = 'Ce champ est obligatoire.';
    } elseif (mb_strlen($value) < $min) {
        $errors[$key] = 'caractère min:' . $min . '';
    } elseif (mb_strlen($value) > $max) {
        $errors[$key] = 'caractère max:' . $max . '';
    }
    return $errors;
}
function validSport($errors, $value, $key, $min, $max)
{
    if (empty($value)) {
        $errors[$key] = 'Veuillez remplir ce champ.';
    } elseif (mb_strlen($value) < $min) {
        $errors[$key] = 'caractère min:' . $min . '';
    } elseif (mb_strlen($value) > $max) {
        $errors[$key] = 'caractère max:' . $max . '';
    }
    return $errors;
}

function validcodepostal($errors, $value, $key)
{
    if (empty($value)) {
        $errors[$key] = 'Veuillez remplir ce champ.';
    } elseif (preg_match("~^[0-9]{5}$~", $value)) {
    } else {
        $errors[$key] = 'Code postal non valide';
    }
    return $errors;
}

// vérifier que les champs ne soient pas vides
function verif_empty($key, $errors)
{
    if (empty($_POST[$key])) {
        $errors[$key] = "Veuillez remplir ce champ";
    }
    return $errors;
}

// vérification du type pour la valeur du champ 
function verif_type($key, $type, $errors)
{
    if ($type === "int") {
        if (!is_int($_POST[$key])) {
            $errors[$key] = "Le champ $key n'est pas de type $type.";
        }
    }
    if ($type === "string") {
        if (!is_string($_POST[$key])) {
            $errors[$key] = "Le champ $key n'est pas de type $type.";
        }
    }
    if ($type === "bool") {
        if (!is_bool($_POST[$key])) {
            $errors[$key] = "Le champ $key n'est pas de type $type.";
        }
    }
    return $errors;
}