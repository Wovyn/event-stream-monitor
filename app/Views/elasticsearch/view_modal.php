<div class="row">
    <div class="col-md-6">
        <fieldset id="details-field">
            <legend>Details:</legend>
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label class="control-label text-bold">Domain Name:</label>
                        <p class="form-control-static display-value"><?php echo $domain['DomainName'] ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label text-bold">Status:</label>
                        <p class="form-control-static display-value"><?php echo ($domain['Created'] && $domain['Processing']) ? '<span class="label label-warning">loading</span>' : '<span class="label label-success">active</span>' ?></p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label text-bold">ARN:</label>
                <p class="form-control-static display-value"><?php echo $domain['ARN'] ?></p>
            </div>
            <div class="form-group">
                <label class="control-label text-bold">Endpoint:</label>
                <p class="form-control-static display-value"><?php echo isset($domain['Endpoint']) ? $domain['Endpoint'] : '' ?></p>
            </div>
            <div class="form-group">
                <label class="control-label text-bold">Kibana:</label>
                <p class="form-control-static display-value"><?php echo isset($domain['Endpoint']) ? $domain['Endpoint'] . '/_plugin/kibana/' : '' ?></p>
            </div>
            <?php if($domain['DomainEndpointOptions']['CustomEndpointEnabled']): ?>
                <div class="form-group">
                    <label class="control-label text-bold">Custom Endpoint:</label>
                    <p class="form-control-static display-value"></p>
                </div>
                <div class="form-group">
                    <label class="control-label text-bold">Custom Kibana:</label>
                    <p class="form-control-static display-value"></p>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label class="control-label text-bold">Availability Zones:</label>
                <p class="form-control-static display-value"><?php echo $domain['ElasticsearchClusterConfig']['ZoneAwarenessEnabled'] ? $domain['ElasticsearchClusterConfig']['ZoneAwarenessConfig']['AvailabilityZoneCount'] : '1'; ?></p>
            </div>
        </fieldset>
    </div>

    <div class="col-md-6">
        <fieldset id="data-nodes-field">
            <legend>Data Nodes:</legend>
            <div class="form-group">
                <label class="control-label text-bold">Instance Type:</label>
                <p class="form-control-static display-value"><?php echo $domain['ElasticsearchClusterConfig']['InstanceType'] ?></p>
            </div>
            <div class="form-group">
                <label class="control-label text-bold">Number of Nodes:</label>
                <p class="form-control-static display-value"><?php echo $domain['ElasticsearchClusterConfig']['InstanceCount'] ?></p>
            </div>
            <?php if($domain['ElasticsearchClusterConfig']['DedicatedMasterEnabled']): ?>
                <div class="form-group">
                    <label class="control-label text-bold">Dedicated Instance Type:</label>
                    <p class="form-control-static display-value"></p>
                </div>
                <div class="form-group">
                    <label class="control-label text-bold">Number of Dedicated Nodes:</label>
                    <p class="form-control-static display-value"></p>
                </div>
            <?php endif; ?>
            <?php if($domain['ElasticsearchClusterConfig']['WarmEnabled']): ?>
                <div class="form-group">
                    <label class="control-label text-bold">Warm Instance Type:</label>
                    <p class="form-control-static display-value"></p>
                </div>
                <div class="form-group">
                    <label class="control-label text-bold">Number of Dedicated Nodes:</label>
                    <p class="form-control-static display-value"></p>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label class="control-label text-bold">EBS Volume</label>
                <p class="form-control-static display-value"><b>Type:</b> <?php echo $domain['EBSOptions']['VolumeType'] ?> <b>Size:</b> <?php echo $domain['EBSOptions']['VolumeSize'] ?> GiB</p>
            </div>
            <div class="form-group">
                <label class="control-label text-bold">EBS Volume Size:</label>
                <p class="form-control-static display-value"><?php echo $domain['EBSOptions']['VolumeType'] ?></p>
            </div>
        </fieldset>
    </div>
</div>