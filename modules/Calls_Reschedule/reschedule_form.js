function get_form(){


    var id = document.getElementsByName('record')[0];
    var form = '';
    var titleval = SUGAR.language.get('app_strings', 'LBL_RESCHEDULE_LABEL');

    var callback = {

        success: function(result) {

            form = result.responseText;

            dialog = new YAHOO.widget.Dialog('dialog1', {
                width: '400px',

                fixedcenter : "contained",
                visible : false,
                draggable: true,
                effect:[{effect:YAHOO.widget.ContainerEffect.SLIDE, duration:0.2},
                        {effect:YAHOO.widget.ContainerEffect.FADE,duration:0.2}],
                modal:true
            });

            dialog.setHeader(titleval);
            dialog.setBody(form);

            var handleCancel = function() {
                this.cancel();

            };
            var handleSubmit = function() {

                date_box = dialog.getData().date;
                reason_box = dialog.getData().reason;
                hours = dialog.getData().date_start_hours;
                mins = dialog.getData().date_start_minutes;
                format = dialog.getData().format;
                dateformat = dialog.getData().dateformat;
                ampm = dialog.getData().date_start_meridiem;
                username = dialog.getData().user;

                //basic validation
                if(date_box == '' && reason_box == '' ){

                    document.getElementById('error1').style.display = "";
                    document.getElementById('error2').style.display = "";

                }else if(date_box == '' || !isDate(date_box)){

                    document.getElementById('error1').style.display = "";
                    document.getElementById('error2').style.display = "none";

                }
                else if(reason_box == '' && !isDate(date_box)){

                    document.getElementById('error1').style.display = "";
                    document.getElementById('error2').style.display = "";

                }
                else if(reason_box == ''){

                    document.getElementById('error1').style.display = "none";
                    document.getElementById('error2').style.display = "";

                }
                else{

                     this.submit();
                     update(date_box, reason_box, hours, mins, format, dateformat, ampm, username);
                }

            };
            var myButtons = [{ text: "Save", handler: handleSubmit, isDefault: true },
                             { text: "Cancel", handler:handleCancel }];

            dialog.cfg.queueProperty("buttons", myButtons);
            dialog.render(document.body);
            dialog.show();

            document.getElementById('call_id').value = id.value;
            eval(document.getElementById('script').innerHTML);
            eval(document.getElementById('script2').innerHTML);

        }

    }

    var connectionObject = YAHOO.util.Connect.asyncRequest ("GET", "index.php?entryPoint=Reschedule&call_id="+id.value, callback);

    //Updates date/time field on page
    function update(date_box, reason_box, hours, mins, format, dateformat, ampm, username){

        //used to update the history list
        var currentdate = new Date();
        var Year = currentdate.getFullYear();
        var Month = currentdate.getMonth()+1;
        var Day = currentdate.getDate();
        var Hours = currentdate.getHours();
        var Minutes = currentdate.getMinutes();
        var date;

        Month = Month<10?"0"+Month:Month; // get 2 digit months
        Day = Day<10?"0"+Day:Day; // get 2 digit days
        Hours = Hours<10?"0"+Hours:Hours; // get 2 digit hours
        Minutes = Minutes<10?"0"+Minutes:Minutes; // get 2 digit Minutes

        //convert to 12 hour format (am/pm)
        var h = Hours;
        //determine if 12 hour format should user Capitals for am/pm or not
        if(format == '11:00pm' || format == '11:00 pm' || format == '11.00pm' || format == '11.00 pm'){
            var d = 'am';

            if (h >= 12) {
                h = Hours-12;
                d = 'pm';

            }

            if (h == 0) {
                h = 12;
            }

        }
        else{//set am/pm to uppercase
            var d = 'AM';

            if (h >= 12) {
                h = Hours-12;
                d = 'PM';

            }

            if (h == 0) {
                h = 12;
            }

        }

        h = h<10?"0"+h:h; // get 2 digit hours

        //set dateformat
        if(dateformat == 'Y-m-d'){

            date = Year+'-'+Month+'-'+Day;
        }
        else if(dateformat == 'm-d-Y'){

            date = Month+'-'+Day+'-'+Year;
        }
        else if(dateformat == 'd-m-Y'){

            date = Day + '-' + Month +'-' + Year;
        }
        else if(dateformat == 'Y/m/d'){

            date = Year+'/'+Month+'/'+Day;
        }
        else if(dateformat == 'm/d/Y'){

            date = Month+'/'+Day+'/'+Year;
        }
        else if(dateformat == 'd/m/Y'){

            date = Day + '/' + Month +'/' + Year;
        }
        else if(dateformat == 'Y.m.d'){

            date = Year+'.'+Month+'.'+Day;
        }
        else if(dateformat == 'm.d.Y'){

            date = Month+'.'+Day+'.'+Year;
        }
        else if(dateformat == 'd.m.Y'){

            date = Day + '.' + Month +'.' + Year;
        }

        //set time format
        if(format =='23.00'){

            time = hours +'.'+ mins;//the time for updating the scheduled call start time
            time2 = Hours +'.'+ Minutes; //the time for updating the history list

        }
        else if(format == '23:00'){

            time = hours +':'+ mins;
            time2 = Hours +':'+ Minutes;

        }
        else if(format == '11:00pm' || format == '11:00PM'){

            time = hours +':'+ mins + ampm;
            time2 = h +':'+ Minutes + d;

        }
        else if(format == '11:00 pm' || format == '11:00 PM'){

            time = hours +':'+ mins + ' ' + ampm;
            time2 = h +':'+ Minutes + ' ' + d;

        }
        else if(format == '11.00pm' || format == '11.00PM'){

            time = hours +'.'+ mins + ampm;
            time2 = h +'.'+ Minutes + d;
        }
        else if(format == '11.00 pm' || format == '11.00 PM'){

            time = hours +'.'+ mins + ' ' + ampm;
            time2 = h +'.'+ Minutes + ' ' + d;
        }


        //update call start time
        document.getElementById('date_start').innerHTML = date_box + ' ' + time;

        //update call attempt history
        var list = document.getElementById('history_list');
        var new_element = document.createElement('li');
        var call_reschedule_dom = SUGAR.language.languages.app_list_strings['call_reschedule_dom'];
        new_element.innerHTML = call_reschedule_dom[reason_box] + ' - ' + date + ' ' + time2 + ' by: ' + username;
        list.insertBefore(new_element, list.firstChild);
    }

}
