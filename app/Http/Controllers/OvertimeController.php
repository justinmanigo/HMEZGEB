<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Overtime;
use App\Actions\Hr\Payroll\CalculateHourRate;
use App\Actions\Hr\Payroll\DayRate;
use App\Actions\Hr\Payroll\NightRate;
use App\Actions\Hr\Payroll\HolidayWeekendRate;
use Illuminate\Http\Request;
use App\Http\Requests\HumanResource\StoreOvertimeRequest;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overtimes = Employee::join(
            'overtimes',
            'overtimes.employee_id',
            '=',
            'employees.id'
        )->select(
            'overtimes.id',
            'overtimes.date',
            'overtimes.from',
            'overtimes.to',
            'overtimes.is_weekend_holiday',
            'overtimes.price',
            'employees.first_name',
            'employees.type',
        )->where('overtimes.accounting_system_id', session('accounting_system_id'))
        ->get();
        return view('hr.overtime.index', compact('overtimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOvertimeRequest $request)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        
        for($i = 0; $i < count($request->employee); $i++)
        {
            // Store
            $overtime = new Overtime;
            $overtime->accounting_system_id = $accounting_system_id;
            $overtime->employee_id =  $request->employee[$i]->value;
            $overtime->date = $request->date;
            $overtime->from = $request->from[$i];
            $overtime->to = $request->to[$i];

            $from = Carbon::parse($request->from[$i]);
            $to = Carbon::parse($request->to[$i]);
            // Convert to minutes to include minutes in the calculation          
            // convert to hours


            if($request->is_weekend_holiday != null)
            {
                $overtime->is_weekend_holiday = 'yes';
                $holiday_hours = ($from->diffInMinutes($to)) / 60;
                $computeTotal = CalculateHourRate::run($request->employee[$i]->value,$accounting_system_id)*$holiday_hours;
                $overtime->price = HolidayWeekendRate::run($computeTotal,$accounting_system_id);
            }
            else
            {
                $overtime->is_weekend_holiday = 'no';

                // get 24 hour format of $from and $to
                $from_24_hour = $from->format('H:i');
                $to_24_hour = $to->format('H:i');

                // if $to is greater than 6:00 pm, compute difference of $to and 6pm               
                if($to_24_hour>'18:00' && $from_24_hour < '18:00')
                {
                    $night_hours = (($to->diffInMinutes('18:00')) / 60);
                    //  set value of $to to 5:59pm to compute the day rate. 
                    $to = Carbon::parse('17:59');
                    // convert to hours
                    $day_hours = ($from->diffInMinutes($to)) / 60;
                    $overtime->price =  CalculateHourRate::run($request->employee[$i]->value, $accounting_system_id)*(NightRate::run($night_hours,$accounting_system_id)+DayRate::run($day_hours,$accounting_system_id));
                }

                else
                {
                    if($from_24_hour >= '18:00' && $to_24_hour < '6:00')
                    {
                        $night_hours = ($from->diffInMinutes($to)) / 60;
                        $overtime->price =  CalculateHourRate::run($request->employee[$i]->value,$accounting_system_id)*(NightRate::run($night_hours,$accounting_system_id));
                    }
                    else{
                        $day_hours = ($from->diffInMinutes($to)) / 60;
                        $overtime->price = CalculateHourRate::run($request->employee[$i]->value,$accounting_system_id)*(DayRate::run($day_hours,$accounting_system_id));
                    }
                }
            }
            $overtime->description = $request->description;
            $overtime->save();
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show(Overtime $overtime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtime $overtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Overtime $overtime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete
        $overtime = Overtime::find($id);
        $overtime->delete();
        
        return redirect('overtime/')->with('danger', "Successfully deleted overtime");
    }
}
