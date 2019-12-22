$( document ).ready(function() {

    // TODO

    // - Finish UI stuff
    //     - Arrows to navigate months, etc.

    // - Implement basic auth or some other method for admin access

    // See https://nhn.github.io/tui.calendar/latest/Schedule

    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

    const saveScheduleUrl = '//metalandmoss.box/save-schedule';
    const deleteScheduleUrl = '//metalandmoss.box/delete-schedule';

    const fetchParams = {
      headers: {
        "content-type":"application/json; charset=UTF-8",
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-Token": csrfToken
      },
      method: "POST",
      credentials: "same-origin"
    };



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

    // For moment.js formatting rules see: https://momentjscom.readthedocs.io/en/latest/moment/04-displaying/01-format/

    // register templates
    const templates = {
      time: function(schedule) {
          return '<strong>' + moment(schedule.start.getTime()).format('h:mm') + '-' + moment(schedule.end.getTime()).format('h:mm') + '</strong>&nbsp;' + schedule.title;
        },
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
          var endFormat = (isSameDate ? '' : 'MM/DD/YYYY ') + 'hh:mm a';

          if (isAllDay) {
            return moment(start).format('MM/DD/YYYY') + (isSameDate ? '' : ' - ' + moment(end).format('MM/DD/YYYY'));
          }

          return (moment(start).format('MM/DD/YYYY hh:mm a') + ' - ' + moment(end).format(endFormat));
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

    // For Customize Popups example see: https://github.com/nhn/tui.calendar/blob/master/docs/getting-started.md#customize-popups

    var cal = new tui.Calendar('#calendar', {
        defaultView: 'month',
        template: templates,
        useCreationPopup: true,
        useDetailPopup: true,
        theme: MONTHLY_CUSTOM_THEME,
        // timezones: [{
        //   timezoneOffset: -300,  // what should this be???
        //   displayLabel: 'GMT-05:00',  // This would be accurate if above was correct?
        //   tooltip: 'Eastern'
        // }],
        month: {
          isAlways6Week: false
        }
    });

    let schedules = JSON.parse(document.getElementById("existing_schedules").getAttribute('data-schedules'));
    schedules.forEach(function (schedule) {
      schedule.calendarId = 1;
      schedule.category = 'time';
      // schedule.isReadOnly = true;
    });
    console.log(schedules);

    cal.createSchedules(schedules);

    cal.on('beforeCreateSchedule', function(event) {
        var schedule = {
            // id: scheduleCounter++,     // How should this be set/iterated?
            // calendarId: '1',
            title: event.title,
            is_all_day: event.isAllDay,
            // category: 'time',
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
      // console.log('beforeCreateSchedule');

      fetchParams.body = JSON.stringify(schedule);
      fetch(saveScheduleUrl, fetchParams)
      .then(data=>{return data.json()})
      .then(res=>{
        console.log(res);
        schedule.id = res.id;
      })
      .catch(error=>console.log(error))

      schedule.calendarId = 1;
      schedule.category = 'time';

	    cal.createSchedules([schedule]);
	});

    cal.on('beforeUpdateSchedule', function(event) {
        var schedule = {
            id: event.schedule.id,
            title: event.changes.title || event.schedule.title,
            start: event.changes.start || event.schedule.start,
            end: event.changes.end || event.schedule.end,
            is_all_day: event.changes.isAllDay || event.schedule.isAllDay,
        };

        // Do any desired modifications of the schedule here...
        fetchParams.body = JSON.stringify(schedule);
        fetch(saveScheduleUrl, fetchParams)
        .then(data=>{return data.json()})
        .then(res=>{
          console.log(res);
        })
        .catch(error=>console.log(error))

        schedule.calendarId = 1;
        schedule.category = 'time';

        cal.updateSchedule(schedule.id, schedule.calendarId, schedule);
    });

    cal.on('beforeDeleteSchedule', function(event) {
        var schedule = {
            id: event.schedule.id,
        };

        fetchParams.body = JSON.stringify(schedule);
        fetch(deleteScheduleUrl, fetchParams)
        .then(data=>{return data.json()})
        .then(res=>{
          console.log(res);
        })
        .catch(error=>console.log(error))

        schedule.calendarId = event.schedule.calendarId;

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




// const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

// const Url = '//metalandmoss.box/cp';
// const Data = {
//   id: 311,
//   name: "Veronica"
// };
// const otherParams = {
//   headers: {
//     "content-type":"application/json; charset=UTF-8",
//     "Accept": "application/json",
//     "X-Requested-With": "XMLHttpRequest",
//     "X-CSRF-Token": csrfToken
//   },
//   body: JSON.stringify(Data),
//   method: "POST",
//   credentials: "same-origin"
// };

// fetch(Url, otherParams)
// .then(data=>{return data.json()})
// .then(res=>{console.log(res)})
// .catch(error=>console.log(error))
  