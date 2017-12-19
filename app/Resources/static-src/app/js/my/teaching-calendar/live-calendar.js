import CustomFullCalendar from 'app/common/calendar/custom-full-calendar';
import LiveTooltipComp from 'app/common/calendar/comp/tooltip/live-tooltip-comp';
import ClickComp from 'app/common/calendar/comp/click-comp';
import Api from 'common/api';

new CustomFullCalendar({
  'calendarContainer': '#calendar',
  'dataApi': Api.course.search, //需要使用 common/api/index.js 指定的路由
  'attrs': {
    'title': 'title',
    'start': 'createdTime',
    'end': 'updatedTime'
  },
  'currentTime': $('#todayDateStr').html(),
  'components': [
    new LiveTooltipComp(),
    new ClickComp('/course/{id}') //routing course_show
  ],
  'defaultView': 'agendaWeek'
});