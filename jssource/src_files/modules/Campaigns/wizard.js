/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/



	/*
	 * this function hides a div element using the passed in id value
	 */
    function hide(divname){
        var elem1 = document.getElementById(divname);
        elem1.style.display = 'none';
    }

	/*
	 * this function shows a div using the passed in value
	 */
    function show(div){
        var elem1 = document.getElementById(div);
        elem1.style.display = '';
    }
	/*
	 * this function calls the methods to hide all divs and show the passed in div
	 */
    function showdiv(div){
        hideall();
        show(div);
    }
	
	/*
	 * this function iterates through all "stepx" divs (ie. step1, step2,etc) and hides them
	 */
    function hideall(){
        var last_val = document.getElementById('wiz_total_steps');
        var last = parseInt(last_val.value);
        for(i=1; i<=last; i++){
            hide('step'+i);
        }
    }
    
    
    /*this function should be run first.  It will call the methods that:
    *  1.hide the divs initially
    *  2.show the first div
    *  3.shows/hides the proper buttons
    *  4.highlites the step title
    *  5.adjusts the step location message
    */
    function showfirst(wiz_mode){
        //no validation needed.
        
       //show first step        
        showdiv('step1');
    
        //set div value
        var current_step = document.getElementById('wiz_current_step');
        current_step.value="1";
        
        //set button values
   

        var save_button = document.getElementById('wiz_submit_button');
		var next_button = document.getElementById('wiz_next_button');
		var save_button_div = document.getElementById('save_button_div');		
		var next_button_div = document.getElementById('next_button_div');	
		var back_button_div = document.getElementById('back_button_div');			

        save_button.disabled = true;
		back_button_div.style.display = 'none';
		save_button_div.style.display = 'none';		
		next_button.focus();
		if(wiz_mode == 'marketing'){
			back_button_div.style.display = '';
		}
        
        //set nav hi-lite
        hilite(current_step.value);
        

    }


    
    /*this function runs on each navigation in the wizard.  It will call the methods that:
    *  1.hide the divs
    *  2.show the div being navigated to
    *  3.shows/hides the proper buttons
    *  4.highlites the step title
    *  5.adjusts the step location message
    */

    function navigate(direction){
        //get the current step
        var current_step = document.getElementById('wiz_current_step');
        var currentValue = parseInt(current_step.value);
    
        //validation needed. (specialvalidation,  plus step number, plus submit button)
        if(validate_wiz(current_step.value,direction)){
            
            //change current step value to that of the step being navigated to
            if(direction == 'back'){
                current_step.value = currentValue-1;
            }
            if(direction == 'next'){
                current_step.value = currentValue+1;
            }
            if(direction == 'direct'){
            //no need to modify current step, this is a direct navigation
            }
                
            //show next step        
            showdiv("step"+current_step.value);
        
            //set nav hi-lite
            hilite(current_step.value);

            //enable save button if on last step
            var total = document.getElementById('wiz_total_steps').value;
            var save_button = document.getElementById('wiz_submit_button');
			var back_button_div = document.getElementById('back_button_div');
			var save_button_div = document.getElementById('save_button_div');		
			var next_button_div = document.getElementById('next_button_div');		
            if(current_step.value==total){
                //save_button.display='';
                save_button.disabled = false;
				back_button_div.style.display = '';
				save_button_div.style.display = '';		
				next_button_div.style.display = 'none';
                
            }else{
	            if(current_step.value<2){                
		            back_button_div.style.display = 'none';	
	            }else{
		            back_button_div.style.display = '';		            	
	            }
				var next_button = document.getElementById('wiz_next_button');	            
				next_button_div.style.display = '';
				save_button_div.style.display = 'none';		
				next_button.focus();                
            }

        }else{
         //error occurred, do nothing   
        }    
    
    }

    /*
     * This function highlites the right title on the navigation div.
     * It also changes the title to a navigational link
     * */
     var already_linked ='';
    function hilite(hilite){
	    	var last = parseInt(document.getElementById('wiz_total_steps').value);
	        for(i=1; i<=last; i++){
	            var nav_step = document.getElementById('nav_step'+i);
	              nav_step.className   = '';
	        }
	        var nav_step = document.getElementById('nav_step'+hilite);
			nav_step.className   = '';
			if(already_linked.indexOf(hilite)<0){
		        nav_step.innerHTML= "<a href='#'  onclick=\"javascript:direct('"+hilite+"');\">" +nav_step.innerHTML+ "</a>";
		        already_linked +=',hilite'; 
			}
    }
    
    /*
     * Given a start and end, This function highlights the right title on the navigation div.
     * It also changes the title to a navigational link
     * */
    function link_navs(beg, end){
		if(beg==''){
			beg=1;
		}
		if(end==''){
	    	var last = document.getElementById('wiz_total_steps').value;			
			end=last;
		}		
		beg =parseInt(beg);
		end =parseInt(end);	

    	for(i=beg; i<=end; i++){
	        var nav_step = document.getElementById('nav_step'+ i);
	        nav_step.innerHTML= "<a href='#'  onclick=\"javascript:direct('"+i+"');\">" +nav_step.innerHTML+ "</a>";
    	}
    	
    }    

    /**
     * This function is called when clicking on a title that has already been changed
     * to show a link.  It is a direct navigation link
     */
    function direct(stepnumber){
        //get the current step
        var current_step = document.getElementById('wiz_current_step');
        var currentValue = parseInt(current_step.value);

        //validation needed. (specialvalidation,  plus step number, plus submit button)
        if(validate_wiz(current_step.value,'direct')){

            //lets set the current step to the selected step and invoke navigation
            current_step.value = stepnumber;
            navigate('direct'); 
        }else{
         //do nothing, validation failed   
        }
    }


/*
 * This is a generic create summary function.  It scrapes the form for all elements that 
 * are not hidden and displays it's value.  It uses the "title" parameter as the title
 * in the summary  There is also a provision for overriding this function and providing more
 * precise summary functions
 */
    
    /*
     * This function will perform basic navigation validation, and then call the customized 
     * form validation specified for this step.  This custom call should reside on wizard page itself.
     *
     */
    function validate_wiz(step, direction){
        var total = document.getElementById('wiz_total_steps').value;
        var wiz_message = document.getElementById('wiz_message');
        //validate step
         if(direction =='back'){
            //cancel and alert if on step1
            if(step=='1'){
                var msg = SUGAR.language.get('mod_strings', 'LBL_WIZARD_FIRST_STEP_MESSAGE');
                wiz_message.innerHTML = "<font color=\'red\' size=\'2\'><b>"+msg+"</b></font>";
                return false;
            }else{
                wiz_message.innerHTML = '';
            }
         }

        if(direction =='next'){
           //cancel and alert if on last step
            if(step==total){
                var msg = SUGAR.language.get('mod_strings', 'LBL_WIZARD_LAST_STEP_MESSAGE');
                wiz_message.innerHTML = "<font color=\'red\' size=\'2\'><b>"+msg+"</b></font>";
                return false;
            }else{
                wiz_message.innerHTML = '';
            }        
         }
         if(direction =='direct'){
            //no need to perform navigation validation
         }
    
         //make call to custom form validation, do not call if this is a direct navigation
         //if this is a direct navigation, then validation has already happened, calling twice 
         //will not allow page to navigate
        if((direction !='direct')  && ( window.validate_wiz_form ) && (!validate_wiz_form('step'+step))){
            return false;
         }
         
        return true;        
    }

