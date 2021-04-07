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
                <div class="col-md-12">
                    <h3 class="StepTitle">Step 2</h3>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend>Configure Domain</legend>
                        <div class="form-group">
                            <label class="control-label" for="domain_name">Elasticsearch Domain Name</label>
                            <input type="text" class="form-control" id="domain_name" name="domain_name" placeholder="Elasticsearch Domain Name" data-rule-nospace required>
                            <p class="help-block">The name must start with a lowercase letter and must be between 3 and 28 characters. Valid characters are a-z (lowercase only), 0-9, and - (hyphen).</p>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Auto-Tune</legend>
                        <div class="form-group">
                            <label class="control-label" for="auto_tune">Auto-Tune</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="disable" name="auto_tune" />
                                    Disable
                                    <p class="help-block">No automated changes to your cluster. Amazon ES will still send occasional recommendations for how to optimize cluster performance.</p>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="enable" name="auto_tune" checked="checked" />
                                    Enable
                                    <p class="help-block">Automatically makes node-level changes that require no downtime, such as tuning queues and cache sizes.</p>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend>Data nodes</legend>
                        <div class="form-group">
                            <label class="control-label" for="availability_zones">Availability Zones</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="2" name="availability_zones" checked="checked" />
                                    2-AZ
                                    <p class="help-block">Suitable for production workloads.</p>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="1" name="availability_zones" />
                                    1-AZ
                                    <p class="help-block">Suitable for non-critical workloads.</p>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="instance_type">Instance type</label>
                            <select name="instance_type" id="instance_type" class="form-control form-select2" required data-placeholder="Select an Instance type" style="width: 100%">
                                <option></option>
                                <optgroup label="C4 (Compute optimized)">
                                    <option value="c4.large.elasticsearch">c4.large.elasticsearch</option>
                                    <option value="c4.xlarge.elasticsearch">c4.xlarge.elasticsearch</option>
                                    <option value="c4.2xlarge.elasticsearch">c4.2xlarge.elasticsearch</option>
                                    <option value="c4.4xlarge.elasticsearch">c4.4xlarge.elasticsearch</option>
                                    <option value="c4.8xlarge.elasticsearch">c4.8xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="C5 (Compute optimized)">
                                    <option value="c5.large.elasticsearch">c5.large.elasticsearch</option>
                                    <option value="c5.xlarge.elasticsearch">c5.xlarge.elasticsearch</option>
                                    <option value="c5.2xlarge.elasticsearch">c5.2xlarge.elasticsearch</option>
                                    <option value="c5.4xlarge.elasticsearch">c5.4xlarge.elasticsearch</option>
                                    <option value="c5.9xlarge.elasticsearch">c5.9xlarge.elasticsearch</option>
                                    <option value="c5.18xlarge.elasticsearch">c5.18xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="i2">
                                    <option value="i2.xlarge.elasticsearch">i2.xlarge.elasticsearch</option>
                                    <option value="i2.2xlarge.elasticsearch">i2.2xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="i3 (Storage optimized)">
                                    <option value="i3.large.elasticsearch">i3.large.elasticsearch</option>
                                    <option value="i3.xlarge.elasticsearch">i3.xlarge.elasticsearch</option>
                                    <option value="i3.2xlarge.elasticsearch">i3.2xlarge.elasticsearch</option>
                                    <option value="i3.4xlarge.elasticsearch">i3.4xlarge.elasticsearch</option>
                                    <option value="i3.8xlarge.elasticsearch">i3.8xlarge.elasticsearch</option>
                                    <option value="i3.16xlarge.elasticsearch">i3.16xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="m3">
                                    <option value="m3.medium.elasticsearch">m3.medium.elasticsearch</option>
                                    <option value="m3.large.elasticsearch">m3.large.elasticsearch</option>
                                    <option value="m3.xlarge.elasticsearch">m3.xlarge.elasticsearch</option>
                                    <option value="m3.2xlarge.elasticsearch">m3.2xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="m4 (General purpose)">
                                    <option value="m4.large.elasticsearch">m4.large.elasticsearch</option>
                                    <option value="m4.xlarge.elasticsearch">m4.xlarge.elasticsearch</option>
                                    <option value="m4.2xlarge.elasticsearch">m4.2xlarge.elasticsearch</option>
                                    <option value="m4.4xlarge.elasticsearch">m4.4xlarge.elasticsearch</option>
                                    <option value="m4.10xlarge.elasticsearch">m4.10xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="m5 (General purpose)">
                                    <option value="m5.large.elasticsearch">m5.large.elasticsearch</option>
                                    <option value="m5.xlarge.elasticsearch">m5.xlarge.elasticsearch</option>
                                    <option value="m5.2xlarge.elasticsearch">m5.2xlarge.elasticsearch</option>
                                    <option value="m5.4xlarge.elasticsearch">m5.4xlarge.elasticsearch</option>
                                    <option value="m5.12xlarge.elasticsearch">m5.12xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="r3">
                                    <option value="r3.large.elasticsearch">r3.large.elasticsearch</option>
                                    <option value="r3.xlarge.elasticsearch">r3.xlarge.elasticsearch</option>
                                    <option value="r3.2xlarge.elasticsearch">r3.2xlarge.elasticsearch</option>
                                    <option value="r3.4xlarge.elasticsearch">r3.4xlarge.elasticsearch</option>
                                    <option value="r3.8xlarge.elasticsearch">r3.8xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="r4 (Memory optimized)">
                                    <option value="r4.large.elasticsearch">r4.large.elasticsearch</option>
                                    <option value="r4.xlarge.elasticsearch">r4.xlarge.elasticsearch</option>
                                    <option value="r4.2xlarge.elasticsearch">r4.2xlarge.elasticsearch</option>
                                    <option value="r4.4xlarge.elasticsearch">r4.4xlarge.elasticsearch</option>
                                    <option value="r4.8xlarge.elasticsearch">r4.8xlarge.elasticsearch</option>
                                    <option value="r4.16xlarge.elasticsearch">r4.16xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="r5 (Memory optimized)">
                                    <option value="r5.large.elasticsearch" selected="selected">r5.large.elasticsearch</option>
                                    <option value="r5.xlarge.elasticsearch">r5.xlarge.elasticsearch</option>
                                    <option value="r5.2xlarge.elasticsearch">r5.2xlarge.elasticsearch</option>
                                    <option value="r5.4xlarge.elasticsearch">r5.4xlarge.elasticsearch</option>
                                    <option value="r5.12xlarge.elasticsearch">r5.12xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="t2">
                                    <option value="t2.small.elasticsearch">t2.small.elasticsearch</option>
                                    <option value="t2.medium.elasticsearch">t2.medium.elasticsearch</option>
                                </optgroup>
                                <optgroup label="t3 (General purpose)">
                                    <option value=""></option>
                                    <option value=""></option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="number_of_nodes">Number of nodes</label>
                            <input type="number" class="form-control" id="number_of_nodes" name="number_of_nodes" placeholder="Number of nodes" value="2" required>
                            <p class="help-block">For two Availability Zones, you must choose instances in multiples of two.</p>
                        </div>
                    </fieldset>
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