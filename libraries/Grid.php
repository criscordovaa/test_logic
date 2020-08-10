<?php
require("Cli.php");

class Grid extends Cli
{
    static $default_rows = 3;
    static $default_columns = 3;
    static $round_side;
    private $current;
    private $last;
    private $intents;
    private $finish;
    static $settings = [
        [
            "letter" => "R",
            "symbol" => ">",
            "name" => "right",
            "round_letter" => "D"
        ],
        [
            "letter" => "L",
            "symbol" => "<",
            "name" => "left",
            "round_letter" => "U"
        ],
        [
            "letter" => "U",
            "symbol" => "^",
            "name" => "up",
            "round_letter" => "R"
        ],
        [
            "letter" => "D",
            "symbol" => "v",
            "name" => "down",
            "round_letter" => "L"
        ],
    ];
    private $col;
    private $row;
    private $grid_array;

    public function __construct()
    {
        parent::__construct();

        self::$round_side = "R";
        $this->current = self::$round_side;
        $this->last = [0, 0];
        $this->intents = 0;
        $this->finish = false;
        $this->col = 0;
        $this->row = 0;

        $this->fillGrid();
    }

    public function fillGrid()
    {
        $this->args["--rows"] = $this->args["--rows"] ?? self::$default_rows;
        $this->args["--columns"] = $this->args["--columns"] ?? self::$default_columns;
        $row = $this->args["--rows"];
        $col = $this->args["--columns"];

        //Fill with empty values
        $r = 0;
        while ($r < $row) {
            $c = 0;
            while ($c < $col) {
                //If is the start array(0,0) insert the current position $CURRENT
                $this->grid_array[$r][$c] = ($r == $this->row && $c == $this->col) ? $this->current : "";
                $c++;
            }
            $r++;
        }
    }


    public function start(): Grid
    {
        ["--rows" => $rows, "--columns" => $columns] = $this->args;
        echo "\nTest for (${rows},${columns})\n\n";
        while (!$this->finish) {
            //logic here
            if ($this->check()) {
                $this->move();
                $this->intents = 0;
                $this->last = [$this->row, $this->col];
                $this->grid_array[$this->row][$this->col] = $this->current;
            } else {
                $this->intents++;
                if ($this->intents > 1) {
                    //break now
                    $this->finish = true;
                }
                $roundTo = $this->resolve($this->current)["round_letter"];
                $this->current = $roundTo;
            }
        }

        return $this;
    }

    private function check(): bool
    {
        $canMove = true;
        switch ($this->current) {
            case "R":
                $canMove = key_exists($this->col + 1, $this->grid_array[$this->row])
                    && empty($this->grid_array[$this->row][$this->col + 1]);
                break;
            case "L":
                $canMove = key_exists($this->col - 1, $this->grid_array[$this->row])
                    && empty($this->grid_array[$this->row][$this->col - 1]);
                break;
            case "D":
                $canMove = key_exists($this->row + 1, $this->grid_array)
                    && empty($this->grid_array[$this->row + 1][$this->col]);
                break;
            case "U":
//            var_dump(empty($GRID_ARRAY[$ROW-1][$COL]));
                $canMove = key_exists($this->row - 1, $this->grid_array)
                    && empty($this->grid_array[$this->row - 1][$this->col]);
                break;
        }
//        var_dump($canMove);
//        sleep(2);
        return $canMove;
    }

    private function move(): void
    {
        switch ($this->current) {
            //movement for right positions
            case "R":
                $this->col++;
                break;
            //movement for left positions
            case "L":
                $this->col--;
                break;
            //movement for down positions
            case "D":
                $this->row++;
                break;
            //movement for up positions
            case "U":
                $this->row--;
                break;

        }
    }

    private function resolve(string $letter): array
    {
        $filter = array_filter(self::$settings, function ($value) use ($letter) {
            return $value["letter"] == $letter;
        }, ARRAY_FILTER_USE_BOTH);
        $filter = array_values($filter);
        return current($filter);
    }

    public function printPath(): void
    {
        //show array with data
        [$row, $column] = $this->last;
        ["--show-grid" => $gridType] = $this->args;
        for ($r = 0; $r < count($this->grid_array); $r++) {
            echo "[";
            for ($c = 0; $c < count($this->grid_array[$r]); $c++) {
                $grid = ($gridType == "symbol")
                    ? $this->resolve($this->grid_array[$r][$c])["symbol"]
                    : $this->grid_array[$r][$c];
                echo ($c == 0) ? "" : "[";
                echo ($r == $row && $c == $column)
                    ? "(" . $grid . ")"
                    : " " . $grid . " ";
                echo ($c == count($this->grid_array[$r]) - 1) ? "" : "]";
            }
            echo "] \n";
        }
    }

    public function getLast(): string
    {
        [$row, $col] = $this->last;
        return $this->grid_array[$row][$col];
    }

}