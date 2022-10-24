<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Movie;
use Carbon\Carbon;

class ClientIndexController extends Controller
{
    public function index()
    {
        $halls = Hall::with('seances')->get();
        return view('client.index', ['hallsShow' => $this->movieShow(), 'weekDayRus' => $this->getWeekDayRus()], compact('halls'));
    }

    public function movieShow() {
        $movies = Movie::join('movie_shows', 'movie_shows.id', '=', 'movies.id')
            ->join('halls', 'halls.id', '=', 'movies.id')
            ->get();
        $arr = [];
        for($i = 0; $i < $movies->count(); $i++) {
            $arr[$i] = [];
        }
        return $arr;
    }

    public function getWeekDayRus() {
        $days = array(
            'Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'
        );

        $arr = [];
        for($i = 0; $i < 7; $i++) {
            $date = Carbon::now();
            $arr[$i] = [];
            $date->addDays($i);
            $myDay = $date->format('w');
            $weekEnd = (($myDay == 0) || ($myDay == 6)) ? 'page-nav__day_weekend' : '';
            $timeStamp = $date->getTimeStamp();

            $result = array('day' => $date->format('j'),
                'dayWeek' => $days[$myDay],
                'weekEnd' => $weekEnd,
                'timeStamp' => $timeStamp);
            array_push($arr[$i], $result);
        }
        return $arr;
    }
}
