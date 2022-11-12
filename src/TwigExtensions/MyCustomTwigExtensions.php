<?php

namespace App\TwigExtensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyCustomTwigExtensions extends AbstractExtension
{

    public function getFilters(){

        return [
            new TwigFilter('defaultImage',[$this,'defaultImage'])
        ];



    }

    public function defaultImage(string $path):string{

        if(strlen($path)==0){
            return 'th.jpeg';
        }
        return $path;
    }


}