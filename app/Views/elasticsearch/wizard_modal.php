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
                    <small>Name and Describe</small>
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
                    <small>Define Throughput</small>
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
                        <select name="region" id="region" class="form-control form-select2" required data-placeholder="Select a Region">
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

                </div>
            </div>
       </div>

       <div id="step-3" class="tab-pane" role="tabpanel">
           <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="StepTitle">Step 3</h3>

                </div>
            </div>
       </div>

       <div id="step-4" class="tab-pane" role="tabpanel">
           <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="StepTitle">Step 4</h3>

                </div>
            </div>
       </div>
    </div>
</div>