{*
***********************************************
Show the wizard to include / remove fields
***********************************************
*}


<style>
	{literal}
		.edit {
			background-color: transparent !important;
		}
		.yui-dt table {
			width: 390px;	
		}
		
		#SUGAR_GRID table{
			border: none !important;
		}

		.tabDetailViewDF{
			padding:1.5%;
		}

		.ygrid-mso{
			height: 310px! important; 
		}

		.yui-dt-hd div {
			height: 50px;
			text-align: center;
			font-size: 1.3em;
			background-color: rgb(242, 242, 242) !important;
			color: #f08377;
		} 

		.yui-dt th a {
			color: #f08377 !important;
		} 		

		.yui-dt-liner {
			height: 40px;
			padding: 14px 10px 14px 10px !important;
		}	

		.tabDetailViewDF:first-child th:not(.yui-dt-asc):not(.yui-dt-desc) .yui-dt-label:after{
			content: "▼";
			color: black;
			font-size: 0.6em;			
			position: absolute;
			right:22px;
			margin: 1.5% 0;
		}

		tr.yui-dt-even td.yui-dt-asc, 
		tr.yui-dt-even td.yui-dt-desc {
			background-color: #ffffff !important;
		}

		.yui-dt-odd {
			background-color: #dbeaff !important;
		}
	
	{/literal}
</style>

<div id='grid_Div'>
    <table width="100%">
        <tr>
            <td><h2>{$MOD.LBL_WEBFORMS_GRID_TITLE}{$MAP.SELECTION_MODULE_LABEL}</h2></td>
            <td align="right" nowrap><span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span> {$APP.NTC_REQUIRED}</td>
        </tr>
    </table>

    <table width="100%" style="margin-top: 2%">
    	<tr>
    		<td><b>{$MOD.LBL_DRAG_DROP_COLUMNS}</b></td>
    	</tr>
    	<tr>
    		<td>
        		<table class="edit view">
					<tr>
						<td style="height=370px">{$DRAG_DROP_CHOOSER_WEB_TO_LEAD}</td>
					</tr>
        			<tr>
        				<td colspan='3'>
        				  <div id='webformfields'></div>
        				</td>
        			</tr>
        		</table>
            </td>
        </tr>
    </table>
	
    <table width="100%" style="margin-top: 2%">
		<tr>
    		<td width= "15%">
    			<input id="add_remove_all_button" type='button' title="{$APP.LBL_ADD_ALL_LEAD_FIELDS}" class="button" onclick="javascript:dragDropAllFields(this,'{$APP.LBL_ADD_ALL_LEAD_FIELDS}','{$APP.LBL_REMOVE_ALL_LEAD_FIELDS}');" name="button" value="{$APP.LBL_ADD_ALL_LEAD_FIELDS}">
    		</td>
    		<td>			
				<input title="{$APP.LBL_BACK}" accessKey="{$APP.LBL_BACK}" class="button" onclick="return back('webforms');" type="submit" name="button" value="{$APP.LBL_BACK}"> 
				
				<input id="next_button" type='submit' onclick="return next('webforms');" title="{$APP.LBL_NEXT_BUTTON_LABEL}" class="button" name="next_button" value="{$APP.LBL_NEXT_BUTTON_LABEL}">
    		</td>
		</tr>
    </table>
</div>
