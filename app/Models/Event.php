<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Event extends Model
{
    use HasFactory;

    public function scopeSingleDateQuery($query, $ignore_year_from_query, $single_date) {
        if($ignore_year_from_query == false && $single_date != "") {
            return $query->where('date', '=', $single_date);
        } elseif ($ignore_year_from_query == true && $single_date != "") {
           $month = date_format(date_create($single_date), 'm');
           $day = date_format(date_create($single_date), 'd');
           return $query->whereMonth('date', $month)
            ->whereDay('date', $day);
        }
    }

    public function scopeDateRangeQuery($query, $ignore_year_from_query, $start_date, $end_date) {
        if ($ignore_year_from_query == true) {

            if($start_date && $end_date) {
                $rangeStartMonth = date_format(date_create($start_date), 'm');
                $rangeStartDay = date_format(date_create($start_date), 'd');
                $rangeEndMonth = date_format(date_create($end_date), 'm');
                $rangeEndDay = date_format(date_create($end_date), 'd');
                $start_date_no_year = DateTime::createFromFormat('m-d', $rangeStartMonth . "-" . $rangeStartDay);
                $end_date_no_year = DateTime::createFromFormat('m-d', $rangeEndMonth . "-" . $rangeEndDay);



                if($rangeStartMonth == $rangeEndMonth) { // if start_date and end_date are on the same month, we must take all days in between range
                    $query->
                        whereMonth('date', '=', $rangeStartMonth)->
                        whereDay('date', '>=', $rangeStartDay)->
                        whereDay('date', '<=', $rangeEndDay);
                } else {
                    $query->
                        whereMonth('date', '>', $rangeStartMonth)-> // take all months between start and end date, if any
                        whereMonth('date', '<', $rangeEndMonth)->
                        orWhereMonth('date', '=', $rangeStartMonth)-> // since start_date is after end_date, in the corner case they should be both in the same month we take e.g. all days > 20 and all days < 15
                        whereDay('date', '>=', $rangeStartDay)->
                        orWhereMonth('date', '=', $rangeEndMonth)->
                        whereDay('date', '<=', $rangeEndDay);
                }
            } else {
                return $query;
            }

        }

        else { // date query when checkbox is not checked
            if($start_date && $end_date) {
             $query->
                whereDate('date', '>=', date_format(date_create($start_date), 'Y-m-d'))->
                whereDate('date', '<=', date_format(date_create($end_date), 'Y-m-d'));
            } else {
                return $query;
            }
        }
    }



}
