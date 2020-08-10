<?php

class Cli
{
    public $args = [
        "--columns" => null,
        "--rows" => null,
        "--show-grid" => null,
    ];

    public function __construct()
    {
        global $argv;
        //get args from cli
        $arr_args = null;
        for ($ar = 1; $ar < count($argv); $ar++) {
            $value = explode("=", $argv[$ar]);
            if (count($value) > 1) {
                $arr_args[$value[0]] = $value[1];
            }
        }
//take valid args
        if ($arr_args !== null) {
            foreach ($arr_args as $key => $arg) {
                switch ($key) {
                    case "--columns":
                        if(!intval($arg)) exit("invalid argument '${arg}' on --column, value most be a integer\n");
                        $this->args["--columns"] = $arg;
                        break;
                    case "--rows":
                        if(!intval($arg)) exit("invalid argument '${arg}' on --row, value most be a integer\n");
                        $this->args["--rows"] = $arg;
                        break;
                    case "--show-grid":
                        if($arg== "symbol" || $arg == "letter"){
                            $this->args["--show-grid"] = $arg;
                        } else exit("invalid argument '${arg}' on --show-grid, try with 'symbol' or 'letter'\n");
                        break;
                    default:
                        die("unrecognised command '${key}'\n");
                }
            }
        }
    }
}