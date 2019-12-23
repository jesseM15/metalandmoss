<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleModel;

class PagesController extends Controller
{

	public function home()
	{
		\Cart::session(1);
		\Cart::clear();
		\Cart::session(1)->clear();
		\Cart::add(1, 'Sample Item', 49.95, 2, []);

		$schedules = ScheduleModel::select('id', 'title', 'start', 'end', 'is_all_day as isAllDay')->get();
		for ($n = 0; $n < count($schedules); $n++)
		{
			$schedules[$n]->isAllDay = $schedules[$n]->isAllDay ? true : false;
		}
		$data['schedules'] = json_encode($schedules);
		
		$data['summedPrice'] = \Cart::get(1)->getPriceSum();
		return view('home', $data);
	}

	public function cart()
	{
		// NOTE: Cart adds lines in config/app.php under Autoloaded Service Providers and Class Aliases
		\Cart::session(1);
		\Cart::clear();
		\Cart::session(1)->clear();
		\Cart::add(1, 'Sample Item', 49.95, 2, []);
		$data['summedPrice'] = \Cart::get(1)->getPriceSum();
		$data['nav_pages'] = $this->getNav();
		return view('cart', $data);
	}

	public function calendar()
	{
		$schedules = ScheduleModel::select('id', 'title', 'start', 'end', 'is_all_day as isAllDay')->get();
		for ($n = 0; $n < count($schedules); $n++)
		{
			$schedules[$n]->isAllDay = $schedules[$n]->isAllDay ? true : false;
		}
		$data['schedules'] = json_encode($schedules);
		$data['nav_pages'] = $this->getNav();
		return view('calendar', $data);
	}

	public function getSchedules()
	{
		$schedules = ScheduleModel::select('id', 'title', 'start', 'end', 'is_all_day as isAllDay')->get();
		for ($n = 0; $n < count($schedules); $n++)
		{
			$schedules[$n]->isAllDay = $schedules[$n]->isAllDay ? true : false;
		}
		return response($schedules);
	}

	public function saveSchedule(Request $request)
	{
		$data['success'] = false;

		if ($request->input())
		{
			$schedule['title'] = $request->input('title');
			$schedule['start'] = $this->convertToDatetime($request->input('start._date'));
			$schedule['end'] = $this->convertToDatetime($request->input('end._date'));
			$schedule['is_all_day'] = $request->input('is_all_day');
			if ($request->input('id'))
			{
				$schedule['id'] = $request->input('id');
				ScheduleModel::where('id', $schedule['id'])->update($schedule);
				$data['success'] = true;
			}
			else
			{
				$id = ScheduleModel::create($schedule)->id;
				$data['id'] = $id;
				$data['success'] = true;
			}
		}

		return response($data);
	}

	public function deleteSchedule(Request $request)
	{
		$data['success'] = false;

		if ($request->input('id'))
		{
			ScheduleModel::where('id', $request->input('id'))->delete();
			$data['success'] = true;
		}

		return response($data);
	}

	private function convertToDatetime($date)
	{
		date_default_timezone_set('America/New_York'); 	// TODO: set this in laravel
		$time = strtotime($date); // time is now equals to the timestamp
		$converted = date('Y-m-d H:i:s', $time);
		return $converted;
	}
}
