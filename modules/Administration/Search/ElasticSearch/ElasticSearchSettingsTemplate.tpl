<h1>Elasticsearch Settings</h1>
<p class="text-muted">Manage your settings. Elasticsearch requires an external Elasticsearch server to work.</p>
<p class="text-muted">Check Elasticsearch's <a href="https://github.com/elastic/elasticsearch">repo</a> to learn how to
    set up their server.</p>

<br/>

<form id="ConfigureSettings"
      name="ConfigureSettings"
      enctype='multipart/form-data'
      method="POST"
      action="index.php?module=Administration&action=ElasticSearchSettings&do=save">

    <div class="row">
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
            <button class="btn btn-primary" onclick="alert('TODO');" type="button">Test connection [TODO]</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>Server</h2>
            <div class="form-group">
                <label for="es-host">Host</label>
                <input type="text" class="form-control"
                       id="es-host" name="host" value="{$config.host}">
                <small id="emailHelp" class="form-text text-muted">e.g. localhost, 192.168.1.1:9200,
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
        <div class="col-md-6">
            <h2>Schedulers</h2>
            <p>The following schedulers were detected</p>
            <ul class="list-group">
                <li class="list-group-item">Elasticsearch Scheduler 1</li>
                <li class="list-group-item">Elasticsearch Scheduler 2</li>
                <li class="list-group-item">Elasticsearch Scheduler 3</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <h2>Search Preferences</h2>
        <p>There are no search preferences available at the current time.</p>
    </div>

    <div>
        {$BUTTONS}
    </div>

    {$JAVASCRIPT}

</form>