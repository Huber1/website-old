<?php

namespace app\controllers;

use DateTime;
use Exception;
use framework\Controller;
use Parsedown;

class NewsController extends Controller
{
    static string $tab = 'news';

    private array $weekdays = ["Mo", "Di", "Mi", "Do", "Fr", "Sa", "So"];
    private array $months = ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"];

    public function index(): string
    {
        $news = [
            ['date' => "2004-02-12T15:19:21+00:00", 'content' => 'Inhalt'],
            ['date' => "2022-11-07T18:46:20+01:00", 'content' => "Und der Content"],
            ['date' => "2023-01-05", 'content' => "#Hi \n Hallo [Link](https://google.de)"],
        ];

        $parser = new Parsedown();
        $parser->setSafeMode(true);

        foreach ($news as &$item) {
            $item['content'] = $parser->parse($item['content']);
            try {
                $dt = new DateTime($item['date']);
                // Format Mo 7. Nov
                $item['date'] = $this->weekdays[$dt->format("N") - 1] . " " . $dt->format("j. ") . $this->months[$dt->format("n") - 1];
            } catch (Exception $e) {
            }
        }

        return $this->view('news', ["news" => $news]);
    }
}