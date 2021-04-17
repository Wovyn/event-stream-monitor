<div class="form-group">
    <label class="control-label" for="description">Description</label>
    <textarea name="description" id="description" class="form-control no-resize" cols="30" rows="3" placeholder="Description" required></textarea>
</div>
<div class="form-group">
    <label class="control-label" for="sink_type">Sink Type</label>
    <select name="sink_type" id="sink_type" class="form-control">
        <option value="webhook">Webhook</option>
        <option value="kinesis">AWS Kinesis Data Sink</option>
    </select>
</div>
<fieldset class="sink-type">
    <h4><label for="sink_type_configuration">Sink Configuration</label></h4>
    <div class="kinesis" style="display:none">
        <div class="form-group">
            <label class="control-label" for="kinesis_data_stream">Kinesis Data Stream</label>
            <select name="kinesis_data_stream" id="kinesis_data_stream" class="form-control form-select2" required data-placeholder="Select a Kinesis Data Stream" style="width: 100%">
                <option></option>
                <?php foreach ($kinesisDataStreams as $stream): ?>
                    <option value="<?php echo $stream->id ?>"><?php echo $stream->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label" for="role_arn">Role ARN</label>
            <input type="text" class="form-control" id="role_arn" value="<?php echo $kinesis['event_stream_role_arn'] ?>" readonly>
        </div>
        <div class="form-group">
            <label class="control-label" for="external_id">External ID</label>
            <input type="text" class="form-control" id="external_id" value="<?php echo $kinesis['external_id'] ?>" readonly>
        </div>
    </div>
    <div class="webhook">
        <div class="form-group">
            <label class="control-label" for="destination_url">Destination URL</label>
            <input type="text" class="form-control" id="destination_url" name="destination_url" placeholder="Destination URL" required>
        </div>
        <div class="form-group">
            <label class="control-label" for="method">Method</label>
            <select name="method" id="method" class="form-control">
                <option value="post">POST</option>
                <option value="get">GET</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label" for="batch_events">Batch Events</label>
            <select name="batch_events" id="batch_events" class="form-control">
                <option value="true">TRUE</option>
                <option value="false">FALSE</option>
            </select>
        </div>
    </div>
</fieldset>