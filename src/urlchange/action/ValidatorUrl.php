<?php
namespace PhpPro\urlchange\action;




class ValidatorUrl
{
    public $url;
    public function __construct()
    {
        $this->url = $url;
    }

    public function validet()
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            echo("$url is a valid URL");
        } else {
            echo("$url is not a valid URL");
        }

    }
}



