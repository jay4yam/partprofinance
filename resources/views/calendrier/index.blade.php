@section('css3')
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">
@endsection

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

@section('js3')
    <!-- fullCalendar -->
    <script src="{{ asset('bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('bower_components/fullcalendar/dist/locale/fr.js') }}"></script>

    <!-- Page specific script -->
    <script>
        $(function () {

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date();
            var d    = date.getDate();
            m    = date.getMonth();
            y    = date.getFullYear();

            $('#calendar').fullCalendar({
                header    : {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'month,agendaWeek,agendaDay, listMonth'
                },
                locale : 'fr',
                buttonText: {
                    today: 'aujourd\'hui',
                    month: 'mois',
                    week : 'semaine',
                    day  : 'jour'
                },
                //Random default events
                eventSources: [
                    '{{ action('CalendarController@getMonthRelance') }}',
                    '{{ action('CalendarController@getMonthDossier') }}'
                ],
                editable  : true,
                droppable : true, // this allows things to be dropped onto the calendar !!!
                drop      : function (date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start           = date;
                    copiedEventObject.allDay          = allDay;
                    copiedEventObject.backgroundColor = $(this).css('background-color');
                    copiedEventObject.borderColor     = $(this).css('border-color');

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove()
                    }

                }
            });
        })
    </script>
@endsection