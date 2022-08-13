<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\MovieShow;
use App\Models\HallSize;
use App\Models\Price;
//use Illuminate\Http\Request;

class ClientHallController extends Controller
{
    public function index()
    {
        $halls = Hall::all();
        $hall_name = $_GET['hall_name'];
        $hall = $halls->where('name', $hall_name)->first();
        $movie_title = $_GET['movie'];
        $start_time = $_GET['start_time'];
        $hall_price_standart = Price::where('hall_id', $hall->id)->where('status', 'standart')->first()->price;
        $hall_price_vip = Price::where('hall_id', $hall->id)->where('status', 'vip')->first()->price;

        $rows = (int)HallSize::where('id', $hall->id)->first()->rows;
        $cols = (int)HallSize::where('id', $hall->id)->first()->cols;

        $seats = $this->seats($start_time);

        return view('client.hall', [
            'hall_name' => $hall_name,
            'hall' => $hall,
            'movie_title' => $movie_title,
            'start_time' => $start_time,
            'hall_price_standart' => $hall_price_standart,
            'hall_price_vip' => $hall_price_vip,
            'seats' => $seats,
            'rows' => $rows,
            'cols' => $cols
        ]);
    }

    public function seats($start_time)
    {
        $hc = HallSize::all();
        foreach ($hc as $key => $value) {
            $hall = Hall::where('id', $value->id)->first();
            $rows = $value->rows;
            $cols = $value->cols;

            for ($i = 0; $i < $value->rows; $i++) {
                for ($j = 0; $j < $value->cols; $j++) {
                    $arr[$value->id][$i][$j] = [];
                    try {
                        $seance_id = MovieShow::where('hall_id', $value->id)->where('start_time', $start_time)->first()->id;
                        $s = $hall->seats->where('row_num', $i)->where('seat_num', $j)->first()->status;
                        if ($hall->takenSeat->where('hall_id', $hall['id'])->where('seance_id', $seance_id)->where('row_num', $i)->where('seat_num', $j)->first()->taken) {
                            $s = 'taken';
                        }
                        array_push($arr[$value->id][$i][$j], $s);
                    } catch (\Exception $e) {
                        array_push($arr[$value->id][$i][$j], 'standart');
                    }
                }
            }
    }
        return $arr;
    }
}
