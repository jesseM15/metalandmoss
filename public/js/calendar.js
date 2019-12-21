$( document ).ready(function() {

    // TODO

    // - Finish UI stuff
    //     - Arrows to navigate months, etc.

    // - Implement saving/loading schedules to/from DB
    // - Implement basic auth or some other method for admin access

    // See https://nhn.github.io/tui.calendar/latest/Schedule

    var scheduleCounter = 1;     // Temporary global for creating unique ids for schedules

    var MONTHLY_CUSTOM_THEME = {
        // month header 'dayname'
        'month.dayname.height': '42px',
        'month.dayname.borderLeft': 'none',
        'month.dayname.paddingLeft': '8px',
        'month.dayname.paddingRight': '0',
        'month.dayname.fontSize': '13px',
        'month.dayname.backgroundColor': 'inherit',
        'month.dayname.fontWeight': 'normal',
        'month.dayname.textAlign': 'left',

        // month day grid cell 'day'
        'month.holidayExceptThisMonth.color': '#f3acac',
        'month.dayExceptThisMonth.color': '#bbb',
        'month.weekend.backgroundColor': '#fafafa',
        'month.day.fontSize': '16px',

        // month schedule style
        'month.schedule.borderRadius': '5px',
        'month.schedule.height': '18px',
        'month.schedule.marginTop': '2px',
        'month.schedule.marginLeft': '10px',
        'month.schedule.marginRight': '10px',

        // month more view
        'month.moreView.boxShadow': 'none',
        'month.moreView.paddingBottom': '0',
        'month.moreView.border': '1px solid #9a935a',
        'month.moreView.backgroundColor': '#f9f3c6',
        'month.moreViewTitle.height': '28px',
        'month.moreViewTitle.marginBottom': '0',
        'month.moreViewTitle.backgroundColor': '#f4f4f4',
        'month.moreViewTitle.borderBottom': '1px solid #ddd',
        'month.moreViewTitle.padding': '0 10px',
        'month.moreViewList.padding': '10px'
    };


    // register templates
    const templates = {
        popupIsAllDay: function() {
          return 'All Day';
        },
        popupStateFree: function() {
          return 'Free';
        },
        popupStateBusy: function() {
          return 'Busy';
        },
        titlePlaceholder: function() {
          return 'Subject';
        },
        locationPlaceholder: function() {
          return 'Location';
        },
        startDatePlaceholder: function() {
          return 'Start date';
        },
        endDatePlaceholder: function() {
          return 'End date';
        },
        popupSave: function() {
          return 'Save';
        },
        popupUpdate: function() {
          return 'Update';
        },
        popupDetailDate: function(isAllDay, start, end) {
          var isSameDate = moment(start).isSame(end);
          var endFormat = (isSameDate ? '' : 'YYYY.MM.DD ') + 'hh:mm a';

          if (isAllDay) {
            return moment(start).format('YYYY.MM.DD') + (isSameDate ? '' : ' - ' + moment(end).format('YYYY.MM.DD'));
          }

          return (moment(start).format('YYYY.MM.DD hh:mm a') + ' - ' + moment(end).format(endFormat));
        },
        popupDetailLocation: function(schedule) {
          return 'Location : ' + schedule.location;
        },
        popupDetailUser: function(schedule) {
          return 'User : ' + (schedule.attendees || []).join(', ');
        },
        popupDetailState: function(schedule) {
          return 'State : ' + schedule.state || 'Busy';
        },
        popupDetailRepeat: function(schedule) {
          return 'Repeat : ' + schedule.recurrenceRule;
        },
        popupDetailBody: function(schedule) {
          return 'Body : ' + schedule.body;
        },
        popupEdit: function() {
          return 'Edit';
        },
        popupDelete: function() {
          return 'Delete';
        }
    };

    var cal = new tui.Calendar('#calendar', {
        defaultView: 'month',
        template: templates,
        useCreationPopup: true,
        useDetailPopup: true,
        theme: MONTHLY_CUSTOM_THEME
    });

    // This would be schedules loaded in from db
    cal.createSchedules([
        {
            id: scheduleCounter++,
            calendarId: '1',
            title: 'Open 2 - 4 pm',
            category: 'time',
            dueDateClass: '',
            start: '2019-12-08T22:30:00+09:00',
            end: '2019-12-09T02:30:00+09:00',
            // isReadOnly: true    // schedule is read-only
        },
        {
            id: scheduleCounter++,
            calendarId: '1',
            title: 'second schedule',
            category: 'time',
            dueDateClass: '',
            start: '2019-11-18T17:30:00+09:00',
            end: '2019-11-19T17:31:00+09:00',
            // isReadOnly: true    // schedule is read-only
        },
        {
            id: scheduleCounter++,
            calendarId: '1',
            title: 'third schedule',
            category: 'time',
            dueDateClass: '',
            start: '2019-11-22T17:30:00+09:00',
            end: '2019-11-23T17:31:00+09:00',
            // isReadOnly: true    // schedule is read-only
        },
        {
            id: scheduleCounter++,
            calendarId: '1',
            title: 'fourth schedule',
            category: 'time',
            dueDateClass: '',
            start: '2019-11-08T05:30:00+09:00',
            end: '2019-11-08T06:30:00+09:00',
            // isReadOnly: true    // schedule is read-only
        }
    ]);

    cal.on('beforeCreateSchedule', function(event) {
        var schedule = {
            id: scheduleCounter++,     // How should this be set/iterated?
            calendarId: '1',
            title: event.title,
            isAllDay: event.isAllDay,
            category: 'time',
            start: event.start,
            end: event.end,
        };

	    if (event.triggerEventName === 'click') {
	        // open writing simple schedule popup
            // schedule = {...};
	    } else if (event.triggerEventName === 'dblclick') {
	        // open writing detail schedule popup
	        // schedule = {...};
	    }

	    cal.createSchedules([schedule]);
	});

    cal.on('beforeUpdateSchedule', function(event) {
        var schedule = event.schedule;
        // Do any desired modifications of the schedule here...
        cal.updateSchedule(schedule.id, schedule.calendarId, schedule);
    });

    cal.on('beforeDeleteSchedule', function(event) {
        var schedule = event.schedule;
        cal.deleteSchedule(schedule.id, schedule.calendarId);
    });

    cal.on('clickSchedule', function(event) {
        var schedule = event.schedule;

        // focus the schedule
        if (lastClickSchedule) {
            cal.updateSchedule(lastClickSchedule.id, lastClickSchedule.calendarId, {
                isFocused: false
            });
        }
        cal.updateSchedule(schedule.id, schedule.calendarId, {
            isFocused: true
        });

        var lastClickSchedule = schedule;

        // open detail view
    });

    cal.on('clickMore', function(event) {
	    console.log('clickMore', event.date, event.target);
	});

});
