<?php


namespace App\Utilities;


use Cocur\Slugify\Slugify;

class Utility
{
    // Configuration de slug
    public function slugify($string)
    {
        $slugify = new Slugify();

        return $slugify->slugify($string);
    }
}