<?php

namespace app\controllers;

use app\models\NewsModel;
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
        $count = (int)($_GET['count'] ?? null) ? $_GET['count'] : 5;

        $news = NewsModel::last($count);

        $parser = new Parsedown();
        $parser->setSafeMode(true);

        foreach ($news as $item) {
            $item->content = $parser->parse($item->content);
            try {
                $dt = new DateTime($item->date);
                // Format Mo 7. Nov
                $item->date = $this->weekdays[$dt->format("N") - 1] . " " . $dt->format("j. ") . $this->months[$dt->format("n") - 1];
            } catch (Exception $e) {
            }
        }

        return $this->view('news', ["news" => $news, "count" => $count, "showMore" => !isset($_GET['count'])]);
    }
}