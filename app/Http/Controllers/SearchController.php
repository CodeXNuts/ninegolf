<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        $this->validate($request, [
            'search' => 'required',
            'fromDate' => ['nullable', 'date', 'date_format:m/d/Y'],
            'fromTime' => ['nullable'],
            'toDate' => ['nullable', 'date', 'date_format:m/d/Y'],
            'toTime' => ['nullable'],
        ]);

        if (!empty($request->search)) {
            $term = $request->search;
            $modifiedTerm = $this->prepareSearchTerm($term);
           
            $data = $this->search($term,$modifiedTerm);
        }
        return view('search');
    }

    public function search($term,$modifiedTerm)
    {
        $res = Club::with(['clubLists'])

            ->where(function ($q) use ($term,$modifiedTerm) {
                $q->where('set_name', 'like', '%' . $modifiedTerm . '%')
                    ->orWhere('type', 'like', '%' . $modifiedTerm . '%')
                    ->orWhere(['gender' => $term])
                    ->orWhere('dexterity', 'like', '%' . $modifiedTerm . '%')
                    ->orWhereHas('clubLists', function ($query) use ($term,$modifiedTerm) {
                        $query->where('name', 'like', '%' . $modifiedTerm . '%')
                            ->orWhere('brand', 'flex', '%' . $modifiedTerm . '%');
                        if (str_contains($modifiedTerm, 'adjust')) {
                            $query->orWhere(['is_adjustable' => true]);
                        }
                        $query->where(['is_active' => true]);
                    });
            })->where(['is_active' => true]);

        dd($res->get());
    }

    public function prepareSearchTerm($term)
    {
        if(!empty($term))
        {
            $replace = [
                ' ' => ',', 
                '-' => ',', 
                '/' => ','
             ];
            $term = Str::lower($term);
            
            $term = Str::replace(array_keys($replace),$replace,$term);
             dd( explode(',',$term));
            return $term;
        }
    }
}
