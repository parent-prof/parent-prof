// Polyfill for Element.prototype.closest (for IE 9+)
if (!Element.prototype.matches) { Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector; }
if (!Element.prototype.closest) {
    Element.prototype.closest = function(s) {
      var el = this;
      do {
        if (Element.prototype.matches.call(el, s)) return el;
        el = el.parentElement || el.parentNode;
      } while (el !== null && el.nodeType === 1);
      return null;
    };
}

/**
 * @class CalendarPicker.
 * @description Provides a simple way to get a minimalistic calender in your DOM.
 * @author Mathias Picker - 29 July 2020.
 */
function CalendarPicker(element, options) {
    // Core variables.
    this.date = new Date();
    this._formatDateToInit(this.date);

    this.day = this.date.getDay()
    this.month = this.date.getMonth();
    this.year = this.date.getFullYear();

    // Storing the todays date for practical reasons.
    this.today = this.date;

    // The calendars value should always be the current date.
    this.value = this.date;

    // Ranges for the calendar (optional).
    this.min = options.min;
    this.max = options.max;
    this._formatDateToInit(this.min);
    this._formatDateToInit(this.max);

    // Element to insert calendar in.
    this.userElement = document.querySelector(element);

    // Setting current date as readable text.
    this._setDateText();

    // The elements used to build the calendar.
    this.calendarWrapper = document.createElement('div');
    this.calendarElement = document.createElement('div')
    this.calendarHeader = document.createElement('header');
    this.calendarHeaderTitle = document.createElement('h4');
    this.navigationWrapper = document.createElement('section')
    this.previousMonthArrow = document.createElement('button');
    this.nextMonthArrow = document.createElement('button');
    this.calendarGridDays = document.createElement('section')
    this.calendarGrid = document.createElement('section');
    this.calendarDayElementType = 'time';

    // Hard-coded list of all days.
    this.listOfAllDaysAsText = [
        'Lun',
        'Mar',
        'Mer',
        'Jeu',
        'Ven',
        'Sam',
        'Dim'
    ];

    // Hard-coded list of all months.
    this.listOfAllMonthsAsText = [
        'Janvier',
        'Fevrier',
        'Mars',
        'Avril',
        'Ma',
        'Juin',
        'Juillet',
        'Aout',
        'Septembre',
        'Octobre',
        'Novembre',
        'Decembre'
    ];

    // Creating the calendar
    this.calendarWrapper.id = 'calendar-wrapper';
    this.calendarElement.id = 'calendar';
    this.calendarGridDays.id = 'calendar-days';
    this.calendarGrid.id = 'calendar-grid';
    this.navigationWrapper.id = 'navigation-wrapper';
    this.previousMonthArrow.id = 'previous-month';
    this.nextMonthArrow.id = 'next-month';

    this._insertHeaderIntoCalendarWrapper();
    this._insertCalendarGridDaysHeader();
    this._insertDaysIntoGrid();
    this._insertNavigationButtons();
    this._insertCalendarIntoWrapper();

    this.userElement.appendChild(this.calendarWrapper);
}


/**
 * @param {Number} The month number, 0 based.
 * @param {Number} The year, not zero based, required to account for leap years.
 * @return {Array<Date>} List with date objects for each day of the month.
 * @author Juan Mendes - 30th October 2012.
 */
CalendarPicker.prototype._getDaysInMonth = function (month, year) {
    if ((!month && month !== 0) || (!year && year !== 0)) return;

    var date = new Date(year, month, 1);
    var days = [];

    while (date.getMonth() === month) {
        days.push(new Date(date));
        date.setDate(date.getDate() + 1);
    }
    return days;
}

/**
 * @param {DateObject} date.
 * @description Sets the clock of a date to 00:00:00 to be consistent.
 */
CalendarPicker.prototype._formatDateToInit = function (date) {
    if (!date) return;
    date.setHours(0, 0, 0);
}

/**
 * @description Sets the current date as readable text in their own variables
 */
CalendarPicker.prototype._setDateText = function () {
    // Setting current date as readable text.
    var dateData = this.date.toString().split(' ');
    this.dayAsText = dateData[0];
    this.monthAsText = dateData[1];
    this.dateAsText = dateData[2];
    this.yearAsText = dateData[3];
}

/**
 * @description Inserts the calendar into the wrapper and adds eventListeners for the calender-grid.
 */
CalendarPicker.prototype._insertCalendarIntoWrapper = function () {
    this.calendarWrapper.appendChild(this.calendarElement);

    /**
     * @param {Event} event An event from an eventListener.
     */
    var handleSelectedElement = (event) => {
        if (event.target.nodeName.toLowerCase() === this.calendarDayElementType && !event.target.classList.contains('disabled')) {

            // Removes the 'selected' class from all elements that have it.
            Array.from(document.querySelectorAll('.selected')).forEach(element => element.classList.remove('selected'));

            // Adds the 'selected'-class to the selected date.
            event.target.classList.add('selected');

            this.value = event.target.value;

            var dateString = event.target.value + '';

            //var dateString = (event.target.value)
            var dataDate = dateString.split(' ')
            var date = dataDate[1] + '-' + dataDate[2] + '-' +dataDate[3]
            var dateObject = new Date(dateString)
            var reunionsDiv = document.querySelector('#reunions');
            reunionsDiv.innerHTML = "";

            axios.get('/api-reunion?date='+date)
                .then((response) => {
                    console.log(response.data);
                    if (response.data.length === 0){
                        console.log('ZERO');
                        var contentDiv = document.createElement('div');
                        var h6 = document.createElement('h4');
                        h6.textContent = "Vous n'avez encore aucun rendez pris a cette date"
                        contentDiv.appendChild(h6)
                        reunionsDiv.appendChild(contentDiv)
                    }

                    for (let i = 0; i < response.data.length; i++) {
                        console.log('valuer de i ' + i)
                        var contentDiv = document.createElement('div');
                        contentDiv.classList.add('card');
                        contentDiv.classList.add('card-primary');
                        contentDiv.setAttribute("id", "div"+i);

                        var div = document.createElement('div');
                        div.classList.add('card-body');

                        var h6 = document.createElement('h6');
                        h6.textContent = response.data[i]['plage']

                        var b1 = document.createElement('b');
                        b1.textContent = "Parent : ";

                        var span1 = document.createElement('span');
                        span1.setAttribute("id", "spanParent"+i);
                        span1.textContent = response.data[i]['parent']

                        var b2 = document.createElement('b');
                        b2.textContent = "  Eleve : ";

                        var span2 = document.createElement('span');
                        span2.setAttribute("id", "spanEleve"+i);
                        span2.textContent = response.data[i]['eleve']

                        var b3 = document.createElement('b');
                        b3.textContent = "  Classe : ";

                        var span3 = document.createElement('span');
                        span3.setAttribute("id", "spanEleve"+i);
                        span3.textContent = response.data[i]['classe']

                        div.appendChild(h6)
                        div.appendChild(b1)
                        div.appendChild(span1)
                        div.appendChild(b2)
                        div.appendChild(span2)
                        div.appendChild(b3)
                        div.appendChild(span3)
                        contentDiv.appendChild(div)
                        reunionsDiv.appendChild(contentDiv)

                        contentDiv.appendChild(div)
                        reunionsDiv.appendChild(contentDiv)
                    }
                    console.log(response.data[0]['non'])
                })
                .catch(error => {
                    element.parentElement.innerHTML = `Error: ${error.message}`;
                    console.error('There was an error!', error);
                });
            console.log(date)

            // Fires the onValueChange function with the provided callback.
            this.onValueChange(this.callback);
        }
    }

    this.calendarGrid.addEventListener('click', handleSelectedElement, false);

    this.calendarGrid.addEventListener('keydown', (keyEvent) => {
        console.log('fdd')
        if (keyEvent.key !== 'Enter') return;

        handleSelectedElement(keyEvent);
    }, false);
}

/**
 * @description Adds the "main" calendar-header.
 */
CalendarPicker.prototype._insertHeaderIntoCalendarWrapper = function () {
    this.calendarHeaderTitle.textContent = this.listOfAllMonthsAsText[this.month] + ' - ' + this.year;
    this.calendarHeaderTitle.style.marginLeft= "20px";
    this.calendarHeader.appendChild(this.calendarHeaderTitle);
    this.calendarWrapper.appendChild(this.calendarHeader);
}

/**
 * @description Inserts the calendar-grid header with all the weekdays.
 */
CalendarPicker.prototype._insertCalendarGridDaysHeader = function () {
    this.listOfAllDaysAsText.forEach(day => {
        var dayElement = document.createElement('span');
        dayElement.textContent = day;
        this.calendarGridDays.appendChild(dayElement);
    })

    this.calendarElement.appendChild(this.calendarGridDays);
}

/**
 * @description Adds the "Previous" and "Next" arrows on the side-navigation.
 * Also inits the click-events used to navigating.
 */
CalendarPicker.prototype._insertNavigationButtons = function () {
    // Ugly long string, but at least the svg is pretty.
    var arrowSvg = '<svg width="32px" height="32px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 16 5 C 22.085938 5 27 9.914063 27 16 C 27 22.085938 22.085938 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 9.914063 9.914063 5 16 5 Z M 10.71875 12.78125 L 9.28125 14.21875 L 15.28125 20.21875 L 16 20.90625 L 16.71875 20.21875 L 22.71875 14.21875 L 21.28125 12.78125 L 16 18.0625 Z"/></svg>';

    this.previousMonthArrow.innerHTML = arrowSvg;
    this.nextMonthArrow.innerHTML = arrowSvg;

    this.previousMonthArrow.setAttribute('aria-label', 'Go to previous month');
    this.nextMonthArrow.setAttribute('aria-label', 'Go to next month');

    this.navigationWrapper.appendChild(this.previousMonthArrow);
    this.navigationWrapper.appendChild(this.nextMonthArrow);

    // Cannot use arrow-functions for IE support :(
    var that = this;
    this.navigationWrapper.addEventListener('click', function (clickEvent) {
        if (clickEvent.target.closest('#' + that.previousMonthArrow.id)) {
            if (that.month === 0) {
                that.month = 11;
                that.year -= 1;
            } else {
                that.month -= 1;
            }
            that._updateCalendar();
        }

        if (clickEvent.target.closest('#' + that.nextMonthArrow.id)) {
            if (that.month === 11) {
                that.month = 0;
                that.year += 1;
            } else {
                that.month += 1;
            }
            that._updateCalendar();
        }
    }, false)

    that.calendarElement.appendChild(that.navigationWrapper);
}

/**
 * @description Adds all the days for current month into the calendar-grid.
 * Takes into account which day the month starts on, so that "empty/placeholder" days can be added
 * in case the month for example starts on a Thursday.
 * Also disables the days that are not within the provided.
 */
CalendarPicker.prototype._insertDaysIntoGrid = function () {
    this.calendarGrid.innerHTML = '';

    var arrayOfDays = this._getDaysInMonth(this.month, this.year);
    var firstDayOfMonth = arrayOfDays[0].getDay();

    // Converting Sunday (0 when using getDay()) to 7 to make it easier to work with.
    firstDayOfMonth = firstDayOfMonth === 0 ? 7 : firstDayOfMonth;

    if (1 < firstDayOfMonth) {
        arrayOfDays = Array(firstDayOfMonth - 1).fill(false, 0).concat(arrayOfDays);
    }

    var daysDisponibilite =[]
    axios.get('/api-disponibilite?mois='+(this.month+1)+'-'+this.year)
        .then((response) => {
            console.log(response.data);

            daysDisponibilite.push(response.data)
            days = []
            console.log(response.data)

            for (let i = 0; i < response.data.length; i++) {
                dates = response.data[i]['date']+'';
                dates = dates.split('-')
                days.push(dates[0])
                //console.log(dates[0])
            }
            const daysInCalendar = document.getElementById('calendar-grid');
            console.log('calendar '+this.calendarGrid.children.length)
            for (let i = 0; i < daysInCalendar.children.length; i++) {
                var element = daysInCalendar.children[i]
                if (days.includes(element.textContent)){
                    element.style.backgroundColor = "#33ccff";
                    element.classList.add('primary')
                    console.log(element.textContent)
                }

                //console.log(daysInCalendar.children[i].textContent);
            }


        })
        .catch(error => {
            console.error('There was an error!', error);
        });


    arrayOfDays.forEach(date => {
        var month = ("0" + (this.month+1)).slice(-2);

        var dateDay = date.toString().split(' ')[2]+'-'+(month)+'-'+this.year+'';
        var dateElement = document.createElement(date ? this.calendarDayElementType : 'span');
        //console.log('dispo '+response)
        //console.log('dispo dd '+daysDisponibilite[0])
        for (var i=0; i<daysDisponibilite.length; i++){
           console.log('date ' +daysDisponibilite['date'])
        }
        //console.log(daysDisponibilite.indexOf(dateDay))
        //console.log(daysDisponibilite.includes(dateDay))
        //console.log(dateDay)
        var Date = date.toString().split(' ')[2];

        var dateIsTheCurrentValue = this.value.toString() === date.toString();
        if (dateIsTheCurrentValue) this.activeDateElement = dateElement;

        var dateIsBetweenAllowedRange = (this.min || this.max) && (date.toString() !== this.today.toString() && (date < this.min || date > this.max))
        if (dateIsBetweenAllowedRange) {
            dateElement.classList.add('disabled');
        } else {
            dateElement.tabIndex = 0;
            dateElement.value = date;
        }

        dateElement.textContent = date ? Date : '';
        //console.log(date.toString().split(' ')[2]+'-'+(this.month+1)+'-'+this.year+'')
        this.calendarGrid.appendChild(dateElement);
    })

    this.calendarElement.appendChild(this.calendarGrid);
    this.activeDateElement.classList.add('selected');
}

/**
 * @description Updates the core-values for the calendar based on the new month and year
 * given by the navigation. Also updates the UI with the new values.
 */
CalendarPicker.prototype._updateCalendar = function () {
    this.date = new Date(this.year, this.month);

    this._setDateText();

    this.day = this.date.getDay();
    this.month = this.date.getMonth();
    this.year = this.date.getFullYear();

    // Cannot use arrow-functions for IE support :(
    var that = this;
    window.requestAnimationFrame(function () {
        that.calendarHeaderTitle.textContent = that.listOfAllMonthsAsText[that.month] + ' - ' + that.year;
        that._insertDaysIntoGrid();
    })
}

/**
 * @param {Function} callback
 * @description A "listener" that lets the user do something everytime the value changes.
 */
CalendarPicker.prototype.onValueChange = function (callback) {
    if (this.callback) return this.callback(this.value);
    this.callback = callback;
}

