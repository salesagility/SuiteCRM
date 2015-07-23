<table width="100%" cellspacing="0" cellpadding="0" border="0" class="edit view">
    <tr>
        <th align="left" scope="row">
            <h4>{$MOD.LBL_INDEX_STATS}</h4>
        </th>
    </tr>
    <tr><td  scope="row" width="15%">{$MOD.LBL_TOTAL_RECORDS}</td><td>{$revisionCount}</td></tr>
    <tr><td  scope="row" width="15%">{$MOD.LBL_INDEXED_RECORDS}</td><td>{$indexedCount}</td></tr>
    <tr><td  scope="row" width="15%">{$MOD.LBL_UNINDEXED_RECORDS}</td><td>{$revisionCount-$indexedCount}</td></tr>
    <tr><td  scope="row" width="15%">{$MOD.LBL_FAILED_RECORDS}</td><td>{$failedCount}</td></tr>
    <tr><td  scope="row" width="15%">{$MOD.LBL_INDEX_FILES}</td><td>{$indexFiles}</td></tr>
    <tr><td  scope="row" width="15%">{$MOD.LBL_LAST_OPTIMISED}</td><td>{$index->last_optimised|default:$MOD.LBL_NEVER_OPTIMISED}<form action="index.php?module=AOD_Index&action=optimise" method="post"><input type="submit" value="{$MOD.LBL_OPTIMISE_NOW}"></form></td></tr>
</table>
