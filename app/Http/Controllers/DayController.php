<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Http\Request;


class DayController extends Controller
{
    /** 
     * this method will return an array of 7 days that make up the specified week. If the days don't exist yet they will be created and saved into the database. 
     * @param int $weekNumber the ISO week number of the requested week. Week 1 = the first week of the year with at least 4 days in the current year.
     * @return Day[] array of the 7 days of the specified week. 
     */
    public function getWeek($weekNumber)
    {
        $startOfWeek = Carbon::now();
        $endOfWeek = Carbon::now();

        $startOfWeek->setISODate($startOfWeek->year, $weekNumber, 1);
        $endOfWeek->setISODate($startOfWeek->year, $weekNumber, 7);

        $dayIterator = $startOfWeek; 
        $days = [];
        for ($i = 0; $i < 7; $i++)
        {
            // find or create day, and add to array $days
            $days[] = Day::with('menuItem')->firstOrCreate([
                'date' => $dayIterator->toDateString()
            ]);

            $dayIterator->addDay();
        }
        return $days;

        //$days = Day::whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])->get();
        
        //return('Week number ' . $weekNumber . ' begins with ' . $startOfWeek->toDateString() . ' and ends with ' . $endOfWeek->toDateString() . ". /n  Days in this week found in database: " . count($days) );
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $day = Day::findOrFail($id);

        $validatedData = $request->validate([
            'date' => 'required | date',
            'menuItemID' => 'nullable'
        ]);

        $day->date = Carbon::parse($validatedData['date']);
        
        if ($validatedData['menuItemID'] != null )
        {
            $menuItem = MenuItem::findOrFail($validatedData['menuItemID']);
            $day->menuItem()->associate($menuItem);
        }
        
        $day->save();

        return $day;
    }
}
