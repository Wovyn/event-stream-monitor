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
                    <small>Select Region</small>
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
                    <small>Name and Source</small>
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
                    <small>Destination</small>
                </span>
            </a>
       </li>
       <li>
           <a class="nav-link" href="#step-4">
                <div class="stepNumber">
                    4
                </div>
                <span class="stepDesc">
                    Step 4
                    <br />
                    <small>Review</small>
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
                        <label class="control-label" for="region">Region</label>
                        <select name="region" id="region" class="form-control form-select2" required data-placeholder="Select a Region" style="width: 100%">
                            <option></option>
                            <?php foreach ($regions as $key => $value): ?>
                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
       </div>

       <div id="step-2" class="tab-pane" role="tabpanel">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="StepTitle">Step 2</h3>
                    <div class="form-group">
                        <label class="control-label" for="name">Delivery Stream Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Delivery Stream Name" data-rule-nospace required>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="kinesis_id">Kinesis Data Stream</label>
                        <select name="kinesis_id" id="kinesis_id" class="form-control form-select2" required data-placeholder="Select a Kinesis Data Stream" style="width: 100%">
                            <option></option>
                        </select>
                        <input type="hidden" id="kinesis" value='<?php echo json_encode($kinesis) ?>'>
                    </div>
                </div>
            </div>
       </div>

       <div id="step-3" class="tab-pane" role="tabpanel">
           <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="StepTitle">Step 3</h3>
                    <div class="form-group">
                        <label class="control-label" for="elasticsearch_id">Amazon Elasticsearch</label>
                        <select name="elasticsearch_id" id="elasticsearch_id" class="form-control form-select2" required data-placeholder="Select a Domain" style="width: 100%">
                            <option></option>
                        </select>
                        <input type="hidden" id="domains" value='<?php echo json_encode($domains) ?>'>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="index">Index</label>
                        <input type="text" class="form-control" id="index" name="index" placeholder="Enter an Index name" required>
                        <p class="help-block">A new index will be created if the the specified index name does not exist.</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="index_rotation">Index Rotation</label>
                        <select name="index_rotation" id="index_rotation" class="form-control form-select2" required data-placeholder="Select a Domain" style="width: 100%">
                            <option value="no_rotation">No rotation</option>
                            <option value="hour">Every Hour</option>
                            <option value="day">Every Day</option>
                            <option value="week">Every Week</option>
                            <option value="month">Every Month</option>
                        </select>
                        <p class="help-block">Select how often to rotate the Elasticsearch index. Kinesis Data Firehose appends a corresponding timestamp to the index and rotates it.</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="type">Type</label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="Enter a type name" required>
                        <p class="help-block">A new type will be created if the specified type name does not exist.</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="retry_duration">Retry duration (in seconds)</label>
                        <input type="number" class="form-control" id="retry_duration" name="retry_duration" placeholder="Enter a retry duration from 0 - 7200 seconds" value="300" data-rule-min="0" data-rule-max="7200" required >
                        <p class="help-block">Select how long a failed index request should be retried. Failed documents are delivered to the backup S3 bucket.</p>
                    </div>
                </div>
            </div>
       </div>

       <div id="step-4" class="tab-pane" role="tabpanel">
           <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="StepTitle">Step 4</h3>
                    <div class="summary">

                    </div>
                </div>
            </div>
       </div>
    </div>
</div>