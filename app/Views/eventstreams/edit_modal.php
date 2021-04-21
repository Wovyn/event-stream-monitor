<pre class="hidden"><?php var_dump($sink); ?></pre>
<div class="row">
    <div class="col-md-6">
        <div class="summary">
            <fieldset>
                <legend class="border-0">Details</legend>
                <div class="form-group">
                    <label class="control-label text-capitalize text-bold" for="description">Description:</label>
                    <p class="form-control-static"><?php echo $sink->description ?></p>
                </div>
                <div class="form-group">
                    <label class="control-label text-capitalize text-bold" for="sink_type">Sink Type:</label>
                    <p class="form-control-static"><?php echo $sink->sink_type ?></p>
                </div>
            </fieldset>
            <fieldset>
                <legend class="border-0">Sink Configuration</legend>
                <?php $config = json_decode($sink->config); ?>
                <?php if ($sink->sink_type == "webhook"): ?>
                    <div class="form-group">
                        <label class="control-label text-capitalize text-bold" for="destination">Destination:</label>
                        <p class="form-control-static"><?php echo $config->sink_configuration->destination ?></p>
                    </div>
                    <div class="form-group">
                        <label class="control-label text-capitalize text-bold" for="method">Method:</label>
                        <p class="form-control-static"><?php echo $config->sink_configuration->method ?></p>
                    </div>
                    <div class="form-group">
                        <label class="control-label text-capitalize text-bold" for="batch_events">Batch Events:</label>
                        <p class="form-control-static"><?php echo $config->sink_configuration->batch_events ? 'TRUE' : 'FALSE' ?></p>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label class="control-label text-capitalize text-bold" for="arn">ARN:</label>
                        <p class="form-control-static"><?php echo $config->sink_configuration->arn ?></p>
                    </div>
                    <div class="form-group">
                        <label class="control-label text-capitalize text-bold" for="role_arn">Role ARN:</label>
                        <p class="form-control-static"><?php echo $config->sink_configuration->role_arn ?></p>
                    </div>
                <?php endif; ?>
            </fieldset>
        </div>
    </div>

    <div class="col-md-6">
        <fieldset>
            <legend class="border-0">Optional:</legend>
            <?php if ($sink->sink_type == "webhook"): ?>
                <div class="form-group">
                    <label class="control-label" for="webhook_data_view_url">Data View URL:</label>
                    <input type="text" placeholder="Data View URL" class="form-control" id="webhook_data_view_url" name="webhook_data_view_url" value="<?php echo isset($config->webhook_data_view_url) ? $config->webhook_data_view_url : '' ?>" data-rule-url>
                </div>
            <?php endif; ?>

            <?php if ($sink->sink_type == "kinesis"): ?>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    <strong>Heads up!</strong> Coming soon!
                </div>
            <?php endif; ?>
        </fieldset>
    </div>
</div>