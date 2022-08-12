<?php 

class Card{
    public $suit;
    public $value;
    public $intValue;

    function __construct(string $suit, string $value, int $intValue)
    {
        $this->suit = $suit;
        $this->value = $value;
        $this->intValue = $intValue;
    }

    function getCardString(): string{
        return $this->suit . $this->value . '(' . $this->intValue. ')';
    }
}


class Deck{
    public $deck;

    function __construct()
    {
        $this->deck = $this->generateDeck();
    }

    function generateDeck(): array{
        //生成されるデッキ
        $new_Deck = [];

        $suits = ["♣", "♦", "♥", "♠"];
        $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];

        for ($i = 0; $i < count($suits); $i++){
            for ($j = 0; $j < count($values); $j++){
                array_push($new_Deck, new Card($suits[$i], $values[$j], $j + 1));
            }
        }

        return $new_Deck;
    }

    function printDeck(){
        echo "Displaying cards...".PHP_EOL;

        for ($i = 0; $i < count($this->deck); $i++){
            echo $this->deck[$i]->getCardString().PHP_EOL;
        }
    }

    function shuffleDeck(){
        for ($i = count($this->deck) - 1; $i >= 0; $i--){
            $j = mt_rand($i, count($this->deck) - 1);
            $temp = $this->deck[$i];
            $this->deck[$i] = $this->deck[$j];
            $this->deck[$j] = $temp;
        }
    }

    function draw(){
        return array_pop($this->deck);
    }
}

class Dealer{
    public $table;
    function startGame(int $amount_of_Players, string $gameMode): array{
        $table = [
            "players"=>[],
            "gameMode"=>$gameMode,
            "deck"=>new Deck(),
        ];

        $table["deck"]->shuffleDeck();

        for ($i = 0; $i < $amount_of_Players; $i++) {
            $playerCard = [];

            for ($j = 0; $j < $this->initial_Cards($gameMode); $j++) {
                array_push($playerCard, $table["deck"]->draw()); 
            }
            array_push($table["players"], $playerCard);
        }

        return $table;
    }

    function initial_Cards(string $gameMode): int{
        if ($gameMode == "poker") return 5;
        if ($gameMode == "21") return 2;
    }

    function printTableInformation(array $table){
        echo "Amount of players: " . count($table["players"]) . "... Game mode: " . $table["gameMode"] . ". At this table: " . PHP_EOL;

        for ($i = 0; $i < count($table["players"]); $i++){
            echo "Player " . ($i + 1) . " hand is: " . PHP_EOL;
            for ($j = 0; $j < count($table["players"][$i]); $j++){
                echo $table["players"][$i][$j]->getCardString() . PHP_EOL;
            }
        }
    }
}
