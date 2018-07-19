<h1>Elasticsearch Settings</h1>
<p class="text-muted">Manage your settings. Elasticsearch requires an external Elasticsearch server to work.</p>
<p class="text-muted">Check Elasticsearch's <a href="https://github.com/elastic/elasticsearch">repo</a> to learn how to
    set up their server.</p>

<br/>

<form id="ConfigureSettings"
      name="ConfigureSettings"
      class="detail-view"
      enctype='multipart/form-data'
      method="POST"
      action="index.php?module=Administration&action=ElasticSearchSettings&do=save">

    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">General</div>
            <div class="panel-body tab-content text-center">
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                               id="es-enabled" name="enabled"
                               {if $config.enabled}checked='checked'{/if}>
                        <label class="form-check-label" for="es-enabled">Enable Elasticsearch.</label>
                    </div>
                </div>
                <div class="col-md-6">
                    {*TODO check connection action*}
                    <button
                            class="btn btn-primary"
                            onclick="alert('TODO');"
                            type="button">Test connection [TODO]
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Server</div>
                <div class="panel-body tab-content">
                    <div class="form-group">
                        <label for="es-host">Host</label>
                        <input type="text" class="form-control"
                               id="es-host" name="host" value="{$config.host}">
                        <small class="form-text text-muted">e.g. localhost, 192.168.1.1:9200,
                            mydomain.server.com:9201, https://192.168.1.3:9200
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="es-user">Username</label>
                        <input type="text" class="form-control"
                               id="es-user" name="user" value="{$config.user}">
                        <label for="es-password">Password</label>
                        <input type="password" class="form-control"
                               id="es-password" name="pass" value="{$config.pass}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Schedulers</div>
                <div class="panel-body tab-content">
                    <label>The following ElasticSearch schedulers were detected:</label>
                    <ul class="list-group">
                        {foreach from=$schedulers item=scheduler}
                            <li class="list-group-item {if $scheduler->status eq 'Inactive'}list-group-item-warning{/if}">
                                {sugar_link
                                module=$scheduler->module_name
                                record=$scheduler->id
                                label=$scheduler->name
                                action='DetailView'}
                                &mdash;
                                <b>{$scheduler->status}</b>
                                &mdash; last run: {$scheduler->last_run}
                                (<b>{diff_for_humans datetime=$scheduler->last_run}</b>)
                            </li>
                            {foreachelse}
                            <p class="error">No schedulers found. Consider creating one.</p>
                        {/foreach}
                    </ul>
                    <small class="form-text text-muted">The ElasticSearch module uses schedulers to keep the database
                        and the indexing engine synchronised.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">Search Preferences</div>
            <div class="panel-body tab-content">
                <p>There are no search preferences available at the current time.</p>
            </div>
        </div>
    </div>

    <div>
        {$BUTTONS}
    </div>

    {$JAVASCRIPT}

</form>