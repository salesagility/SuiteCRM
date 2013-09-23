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
function method_callback(o){var resp=YAHOO.lang.JSON.parse(o.responseText),request_id=o.tId,result=resp.result;if(result==null){return;}
reqid=global_request_registry[request_id];if(typeof(reqid)!='undefined'){widget=global_request_registry[request_id][0];method_name=global_request_registry[request_id][1];widget[method_name](result);}}
SugarClass.inherit("SugarVCalClient","SugarClass");function SugarVCalClient(){this.init();}
SugarVCalClient.prototype.init=function(){}
SugarVCalClient.prototype.load=function(user_id,request_id){this.user_id=user_id;YAHOO.util.Connect.asyncRequest('GET','./vcal_server.php?type=vfb&source=outlook&noAuth=noAuth&user_id='+user_id,{success:function(result){if(typeof GLOBAL_REGISTRY.freebusy=='undefined'){GLOBAL_REGISTRY.freebusy=new Object();}
if(typeof GLOBAL_REGISTRY.freebusy_adjusted=='undefined'){GLOBAL_REGISTRY.freebusy_adjusted=new Object();}
GLOBAL_REGISTRY.freebusy[user_id]=SugarVCalClient.prototype.parseResults(result.responseText,false);GLOBAL_REGISTRY.freebusy_adjusted[user_id]=SugarVCalClient.prototype.parseResults(result.responseText,true);global_request_registry[request_id][0].display();},failure:function(result){this.success(result);},argument:{result:result}});}
SugarVCalClient.prototype.parseResults=function(textResult,adjusted){var match=/FREEBUSY.*?\:([\w]+)\/([\w]+)/g;var result;var timehash=new Object();var dst_start;var dst_end;if(GLOBAL_REGISTRY.current_user.fields.dst_start==null)
dst_start='19700101T000000Z';else
dst_start=GLOBAL_REGISTRY.current_user.fields.dst_start.replace(/ /gi,'T').replace(/:/gi,'').replace(/-/gi,'')+'Z';if(GLOBAL_REGISTRY.current_user.fields.dst_end==null)
dst_end='19700101T000000Z';else
dst_end=GLOBAL_REGISTRY.current_user.fields.dst_end.replace(/ /gi,'T').replace(/:/gi,'').replace(/-/gi,'')+'Z';gmt_offset_secs=GLOBAL_REGISTRY.current_user.fields.gmt_offset*60;while(((result=match.exec(textResult)))!=null){var startdate;var enddate;if(adjusted){startdate=SugarDateTime.parseAdjustedDate(result[1],dst_start,dst_end,gmt_offset_secs);enddate=SugarDateTime.parseAdjustedDate(result[2],dst_start,dst_end,gmt_offset_secs);}
else{startdate=SugarDateTime.parseUTCDate(result[1]);enddate=SugarDateTime.parseUTCDate(result[2]);}
var startmins=startdate.getUTCMinutes();if(startmins>=0&&startmins<15){startdate.setUTCMinutes(0);}
else if(startmins>=15&&startmins<30){startdate.setUTCMinutes(15);}
else if(startmins>=30&&startmins<45){startdate.setUTCMinutes(30);}
else{startdate.setUTCMinutes(45);}
while(startdate.valueOf()<enddate.valueOf()){var hash=SugarDateTime.getUTCHash(startdate);if(typeof(timehash[hash])=='undefined'){timehash[hash]=0;}
timehash[hash]+=1;startdate=new Date(startdate.valueOf()+(15*60*1000));}}
return timehash;}
SugarVCalClient.parseResults=SugarVCalClient.prototype.parseResults;SugarRPCClient.allowed_methods=['retrieve','query','save','set_accept_status','get_objects_from_module','email','get_user_array','get_full_list'];SugarClass.inherit("SugarRPCClient","SugarClass");function SugarRPCClient(){this.init();}
SugarRPCClient.prototype.allowed_methods=['retrieve','query','get_objects_from_module'];SugarRPCClient.prototype.init=function(){this._showError=function(e){alert("ERROR CONNECTING to: ./index.php?entryPoint=json_server, ERROR:"+e);}
this.serviceURL='./index.php?entryPoint=json_server';}
SugarRPCClient.prototype.call_method=function(method,args,synchronous){var result,transaction,post_data=YAHOO.lang.JSON.stringify({method:method,id:1,params:[args]});synchronous=synchronous||false;try{if(synchronous){result=http_fetch_sync(this.serviceURL,post_data);result=YAHOO.lang.JSON.parse(result.responseText).result;return result;}else{transaction=YAHOO.util.Connect.asyncRequest('POST',this.serviceURL,{success:method_callback,failure:method_callback},post_data);return transaction.tId;}}catch(e){this._showError(e);}}
var global_rpcClient=new SugarRPCClient();