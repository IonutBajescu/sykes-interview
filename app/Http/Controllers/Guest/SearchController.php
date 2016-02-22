<?php

namespace App\Http\Controllers\Guest;


use App\Http\Controllers\AbstractController;
use App\Property;
use Illuminate\Http\Request;

class SearchController extends AbstractController
{

    /**
     * ElasticSearch would be a better software than MySQL for this kind of applications.
     *
     * @param Request  $request
     * @param Property $repo
     * @return mixed
     */
    public function index(Request $request, Property $repo)
    {
        $properties = false;

        if ($request->has('_token')) {
            $properties = $this->search($request, $repo);
        }

        return view('guest.search', compact('properties'));
    }

    /**
     * @param Request  $request
     * @param Property $repo
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function search(Request $request, Property $repo)
    {
        $query = $repo->newQuery();

        if ($location = $request->input('location')) {
            $query->whereHas('location', function ($subquery) use ($location) {
                $subquery->where('location_name', 'LIKE', '%'.$location.'%');
            });
        }

        if (($from = $request->input('availability.from')) && ($to = $request->input('availability.to'))) {
            $query->whereDoesntHave('bookings', function ($subquery) use ($from, $to) {
                $subquery->where(function($clause) use ($from, $to) {
                    $clause->whereBetween('start_date', [$from, $to]);
                    $clause->orWhereBetween('end_date', [$from, $to]);
                });
            });
        }

        if ($sleeps = $request->input('minimum_sleeps')) {
            $query->where('sleeps', '>=', $sleeps);
        }

        if ($beds = $request->input('minimum_beds')) {
            $query->where('beds', '>=', $beds);
        }

        if ($request->has('near_beach')) {
            $query->whereNearBeach(1);
        }

        if ($request->has('accepts_pets')) {
            $query->whereAcceptsPets(1);
        }

        $properties = $query->paginate(4);

        return $properties;
    }
}


if (!function_exists('dump_builder')) {

    /**
     * @param Builder $builder
     */
    function dump_builder($builder, array $outputAlso = [])
    {
        $sql_string = $builder->toSql();
        $params = $builder->getBindings();

        if (!empty($params)) {
            $indexed = $params == array_values($params);
            foreach ($params as $k => $v) {
                if (is_object($v)) {
                    if ($v instanceof \DateTime) {
                        $v = $v->format('Y-m-d H:i:s');
                    } else {
                        continue;
                    }
                } elseif (is_string($v)) {
                    $v = "'$v'";
                } elseif ($v === null) {
                    $v = 'NULL';
                } elseif (is_array($v)) {
                    $v = implode(',', $v);
                }

                if ($indexed) {
                    $sql_string = preg_replace('/\?/', $v, $sql_string, 1);
                } else {
                    if ($k[0] != ':') {
                        $k = ':'.$k;
                    } //add leading colon if it was left out
                    $sql_string = str_replace($k, $v, $sql_string);
                }
            }
        }

        array_unshift($outputAlso, 'SQL: '.$sql_string);
        call_user_func_array('dd', $outputAlso);
    }
}