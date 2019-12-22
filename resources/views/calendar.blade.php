@extends('layouts.main')

@section('title', 'Metal & Moss')

@section('content')
		<div id="existing_schedules" data-schedules="{{ $schedules }}"></div>
    	<div class="container">
    		<h1>Calendar</h1>
    		<div id="menu">
		      <span id="menu-navi">
		        <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>
		        <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
		          <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
		        </button>
		        <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
		          <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
		        </button>
		      </span>
		      <span id="renderRange" class="render-range"></span>
		    </div>

		    <div id="calendar"></div>
    	</div>
@endsection
