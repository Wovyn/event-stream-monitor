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
                    <small>Step 1 description</small>
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
                    <small>Step 2 description</small>
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
                    <small>Step 3 description</small>
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
                    <small>Step 4 description</small>
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
                        <select name="region" id="region" class="form-control select2">
                            <option value="">Select Region</option>
                            <option value="us-east-2">US East (Ohio)</option>
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
                        <label class="control-label" for="name">Data Stream Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Data Stream Name">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
       </div>

       <div id="step-3" class="tab-pane" role="tabpanel">
           <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="StepTitle">Step 3</h3>
                    <div class="form-group">
                        <label class="control-label" for="shards">Number of open shards</label>
                        <input type="number" class="form-control" id="shards" name="shards" placeholder="Number of open shards" value="1">
                        <span class="help-block">Minimum: 1, Maximum: 500, Account limit: 500.</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description">Calculated Rates:</label>
                        <span class="help-block">Total data stream capacity is calculated based on the number of shards entered above.</span>
                        <p>
                            <b>Write</b><br>
                            <span class="write-calculated-mib">1</span> MiB/second, <span class="write-calculated-data">1000</span> Data records/second
                            <br><br>
                            <b>Read</b><br>
                            <span class="read-calculated-mib">2</span> MiB/second
                        </p>
                    </div>
                </div>
            </div>
       </div>

       <div id="step-4" class="tab-pane" role="tabpanel">
            <h3 class="StepTitle">Step 4 Content</h3>
            <div class="form-group">
                <label class="control-label">Username <span class="symbol required"></span></label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Text Field">
            </div>
       </div>
    </div>
</div>