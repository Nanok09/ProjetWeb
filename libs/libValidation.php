<?php

// Validation de différentes entrées utilisateur
// pas sûr que ce soit le bon endroit ?

/**
 * Vérifie si une note est valide (entier entre 1 et 5)
 * @param int note
 * @return bool
 */
function valider_note($note)
{
    return (is_int($note) && $note > 0 && $note <= 5);
}
