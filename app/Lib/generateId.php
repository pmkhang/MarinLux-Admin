<?php

function generateId()
{
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $idLength = 16;
    $generatedID = "";

    for ($i = 0; $i < $idLength; $i++) {
        if ($i > 0 && $i % 4 === 0) {
            $generatedID .= "-";
        }
        $randomIndex = rand(0, strlen($characters) - 1);
        $generatedID .= $characters[$randomIndex];
    }

    return $generatedID;
}
