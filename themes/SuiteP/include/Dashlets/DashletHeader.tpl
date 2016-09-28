<div onmouseover="this.style.cursor = 'move';" id="dashlet_header_{$DASHLET_ID}" class="hd dashlet">
    <div class="tl"></div>
    <div class="hd-center">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formHeader h3Row">
            <tr>
                <td class="dashlet-title" colspan="2">
                    <h3>
                        {capture name="dashlet_img_capture" assign="dashlet_img"}{sugar_getimagepath file_name=$DASHLET_MODULE file_extension='svg' directory='sidebar/modules'}{/capture}
                        {if !empty($dashlet_img)}
                            <img src="{$dashlet_img}"/>
                        {else}
                            <img src="themes/SuiteP/images/sidebar/modules/basic.svg"/>
                        {/if}
                       <span>{$DASHLET_TITLE}</span>
                    </h3>
                </td>
                <td style="padding-right: 0px;" nowrap="" width="1%">
                    <div class="dashletToolSet">
                        <a href="javascript:void(0)"
                                                   onclick="SUGAR.mySugar.configureDashlet('{$DASHLET_ID}'); return false;">

                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                 width="25px" height="25px" viewBox="0 0 512 512" enable-background="new 0 0 512 512"
                                 xml:space="preserve">
<g class="icon" id="Icon_6_">
    <g>
        <path class="icon" d="M64,368v80h80l235.727-235.729l-79.999-79.998L64,368z M441.602,150.398
			c8.531-8.531,8.531-21.334,0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865,0l-39.468,39.469l79.999,79.998
			L441.602,150.398z"></path>
    </g>
</g>
</svg>
                        </a>
                        <a href="javascript:void(0)"
                               onclick="SUGAR.mySugar.retrieveCurrentPage(); return false;">

                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                 width="25px" height="25px" viewBox="0 0 512 512" enable-background="new 0 0 512 512"
                                 xml:space="preserve">
<g>
    <path class="icon" d="M256,388c-72.597,0-132-59.405-132-132c0-72.601,59.403-132,132-132c36.3,0,69.299,15.4,92.406,39.601L278,234h154V80
		l-51.698,51.702C348.406,99.798,304.406,80,256,80c-96.797,0-176,79.203-176,176s78.094,176,176,176
		c81.045,0,148.287-54.134,169.401-128H378.85C360.105,353.561,311.712,388,256,388z"></path>
</g>



</svg>
                        </a>
                        <a href="javascript:void(0)"
                               onclick="SUGAR.mySugar.deleteDashlet('{$DASHLET_ID}'); return false;">

                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                 width="25px" height="25px" viewBox="0 0 512 512" enable-background="new 0 0 512 512"
                                 xml:space="preserve">
<g id="Icon_5_">
    <g>
        <polygon class="icon" points="405,136.798 375.202,107 256,226.202 136.798,107 107,136.798 226.202,256 107,375.202 136.798,405 256,285.798
			375.202,405 405,375.202 285.798,256 		"></polygon>
    </g>
</g>
</svg>
                        </a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="tr"></div>
</div>
<div class="bd">
    <div class="ml"></div>
    <div class="bd-center">