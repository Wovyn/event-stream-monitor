<div id="smartwizard" class="swMain sw-modal">
    <ul class="nav">
       <li>
           <a class="nav-link" href="#step-1">
                <div class="stepNumber">
                    1
                </div>
                <span class="stepDesc">
                    Step 1
                    <br />
                    <small>Sink Configuration</small>
                </span>
            </a>
       </li>
       <li>
           <a class="nav-link" href="#step-2">
                <div class="stepNumber">
                    2
                </div>
                <span class="stepDesc">
                    Step 2
                    <br />
                    <small>Event Type Subscriptions</small>
                </span>
            </a>
       </li>
       <li>
           <a class="nav-link" href="#step-3">
                <div class="stepNumber">
                    3
                </div>
                <span class="stepDesc">
                    Step 3
                    <br />
                    <small>Summary</small>
                </span>
            </a>
       </li>
    </ul>

    <div class="progress progress-striped active progress-sm">
        <div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-success step-bar">
            <span class="sr-only">0% Complete (success)</span>
        </div>
    </div>

    <div class="tab-content">
        <div id="step-1" class="tab-pane" role="tabpanel" style="display: block;">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="StepTitle">Step 1</h3>
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
                                <input type="text" class="form-control" id="role_arn" name="role_arn" value="<?php echo $kinesis['event_stream_role_arn'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="external_id">External ID</label>
                                <div class="input-group input-append input-hidden-container input-hidden">
                                    <input type="text" class="form-control" id="external_id" name="external_id" value="<?php echo $kinesis['external_id'] ?>" readonly>
                                    <span class="input-group-addon add-on toggle"><i class="clip-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="webhook">
                            <div class="form-group">
                                <label class="control-label" for="destination_url">Destination URL</label>
                                <input type="text" class="form-control" id="destination_url" name="destination_url" placeholder="Destination URL" required data-rule-url>
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
                    <div class="form-group">
                        <label class="control-label" for="data_view_url">Data View URL</label>
                        <input type="text" class="form-control" id="data_view_url" name="data_view_url" placeholder="Data View URL" data-rule-url>
                    </div>
                </div>
            </div>
        </div>

        <div id="step-2" class="tab-pane" role="tabpanel">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="StepTitle">Step 2</h3>
                    <div class="form-group">
                        <label class="control-label" for="eventTypes">Subscribe to Events Types</label>
                        <div id="jstree"><?php echo json_encode($eventTypes); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="step-3" class="tab-pane" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="StepTitle">Step 3</h3>
                </div>
                <div class="summary"></div>
            </div>
        </div>
    </div>
</div>