<div class="form-group">
    <label class="control-label" for="description">Description</label>
    <textarea name="description" id="description" class="form-control no-resize" cols="30" rows="3" placeholder="Description" required></textarea>
</div>
<div class="form-group">
    <label class="control-label" for="sink_type">Sink Type</label>
    <select name="sink_type" id="sink_type" class="form-control">
        <option value="kinesis">AWS Kinesis</option>
        <option value="webhook">Webhook</option>
    </select>
</div>
<fieldset class="sink-type">
    <label for="sink_type_configuration">Sink Configuration</label>
    <div class="kinesis">
        <div class="form-group">
            <label class="control-label" for="kinesis_data_stream">Kinesis Data Stream</label>
            <select name="kinesis_data_stream" id="kinesis_data_stream" class="form-control form-select2" required data-placeholder="Select a Kinesis Data Stream">
                <option></option>
                <?php foreach ($kinesisDataStreams as $stream): ?>
                    <option value="<?php echo $stream->id ?>"><?php echo $stream->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="webhook" style="display: none;">
        <div class="form-group">
            <label class="control-label" for="destination_url">Destination URL</label>
            <input type="text" class="form-control" id="destination_url" name="destination_url" placeholder="Destination URL" data-rule-nospace required>
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