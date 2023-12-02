<?php

/**
* This update is used to track the amount of time an opportunity spends in each sales stage. 
* This information can be used in reports, or to determine sales cycle times and also useful conversion information. 
* The file is called with a before_save module hook from the logic hooks file in the Opportunities module folder.
* 
* Prerequisites:
* - create an integer field for each sales stage to keep track of the amount of time in that stage. (ie. time_in_qualification_c)
* - create a DateTime field called sales_stage_date_set_c to keeep track of the last time the sales stage time informatio  was set.
* - create a DateTime field for each sales stage to keep track of the last time the sales stage was set to that particular stage. (datetime_qualification_set_c) 
* - create a DropDown field called last_sales_stage_c to keep track of the last sales stage the opp was in. 

* Note that time in each stage is stored in minutes. Feel free to change for your purposes.
*/
                class Calc {
                function setTime($bean, $event, $arguments) {

                        $current_time = new DateTime(); // Variable to hold curent date/time

                        $proposal_date_set = date_create_from_format("Y-m-d H:i:s", $bean -> datetime_proposal_set_c); // Creates date/time variable from proposal_set field to use in interval calculation
                        $sales_stage_date_set = date_create_from_format("Y-m-d H:i:s", $bean -> datetime_sales_stage_updated_c); // Creates date/time variable from date sales stage time updated field to use in interval calculation

                        $interval = $current_time -> diff($sales_stage_date_set); // Calculate time interval between Now and when the sales stage update time was last changed

                        switch ($bean -> last_sales_stage_c) { // Adds on minutes from Interval to Time in relevant sales stage.
                                case "Prospecting":
                                        $bean-> time_in_prospecting_c = ($bean -> time_in_prospecting_c) + ($interval -> i); 
                                        break;
                                case "Qualification":
                                        $bean-> time_in_qualification_c = ($bean -> time_in_qualification_c) + ($interval -> i); 
                                        break;
                                case "NeedsAnalysis":
                                        $bean-> time_in_needsanalysis_c = ($bean -> time_in_needsanalysis_c) + ($interval -> i); 
                                        break;
                                case "ValueProposition":
                                        $bean-> time_in_valueprop_c = ($bean -> time_in_valueprop_c) + ($interval -> i); 
                                        break;
                                case "IDDecisionMakers":
                                        $bean-> time_in_iddecisionmak_c = ($bean -> time_in_iddecisionmak_c) + ($interval -> i); 
                                        break;
                                case "PerceptionAnalysis":
                                        $bean-> time_in_percepanalysis_c = ($bean -> time_in_percepanalysis_c) + ($interval -> i);
                                        break;
                                case "ProposalPriceQuote":
                                        $bean-> time_in_proposalpricequote_c = ($bean -> time_in_proposalpricequote_c) + ($interval -> i); 
                                        break;
                                case "NegotiationReview":
                                        $bean-> time_in_negoreview_c = ($bean -> time_in_negoreview_c) + ($interval -> i); 
                                        break;
                                }

                        if (($bean -> last_sales_stage_c) != ($bean -> sales_stage)) { // If Stage has changed, sets date/time at which stage was changed to relevant sales stage.

                                switch ($bean -> sales_stage) {
                                       case "Prospecting":
                                               $bean -> datetime_prospecting_set_c = date('Y-m-d H:i:s');  
                                               break;
                                       case "Qualification":
                                               $bean -> datetime_qualification_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "NeedsAnalysis":
                                               $bean -> datetime_needsanalysis_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "IDDecisionMakers":
                                               $bean -> datetime_iddecisionmak_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "Invoicing":
                                               $bean -> datetime_invoicing_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "LegalNegotiation":
                                               $bean -> datetime_legalnegot_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "PerceptionAnalysis":
                                               $bean -> datetime_percepanalysis_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "ProposalPriceQuote":
                                               $bean -> datetime_proposalpricequote_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "NegotiationReview":
                                               $bean -> datetime_negoreview_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "ClosedWon":
                                               $bean -> datetime_closedwon_set_c = date('Y-m-d H:i:s'); 
                                               break;
                                       case "ClosedLost":
                                               $bean -> datetime_closedlost_set_c = date('Y-m-d H:i:s'); 
                                               break;
                               }

                        }

                        $bean -> datetime_sales_stage_updated_c = date('Y-m-d H:i:s'); // Sets date/time at which sales stage update date was last updated (current time).
                        $bean -> last_sales_stage_c = $bean -> sales_stage; // Keeps track of current Sales Stage
                        
/* Used for debugging purposes
echo '<pre>';
var_dump ($bean -> last_sales_stage_c);
var_dump ($bean -> sales_stage);

echo $interval->format('%m month, %d days, %h hours, %i minutes; %s seconds');

echo '</pre>';
                       die;
*/

               }
       }
?>
