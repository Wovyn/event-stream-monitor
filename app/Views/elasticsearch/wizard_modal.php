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
                    <small>Configure domain</small>
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
                    <small>Data Nodes</small>
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
                    <small>Configure access and security</small>
                </span>
            </a>
        </li>
        <li>
            <a class="nav-link" href="#step-5">
                <div class="stepNumber">
                    5
                </div>
                <span class="stepDesc">
                    Step 5
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
                    <fieldset>
                        <legend>Configure Domain</legend>
                        <div class="form-group">
                            <label class="control-label" for="domain_name">Elasticsearch Domain Name</label>
                            <input type="text" class="form-control" id="domain_name" name="domain_name" placeholder="Elasticsearch Domain Name" data-rule-domain-name required>
                            <p class="help-block">The name must start with a lowercase letter and must be between 3 and 28 characters. Valid characters are a-z (lowercase only), 0-9, and - (hyphen).</p>
                        </div>
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" value="enable" name="custom_endpoint" id="custom_endpoint" />
                                Enable custom endpoint
                            </label>
                        </div>
                        <div id="custom_endpoint_container" style="display: none">
                            <div class="form-group">
                                <label class="control-label" for="aws_certificate">AWS Certificate</label>
                                <select name="aws_certificate" id="aws_certificate" class="form-control form-select2" required data-placeholder="Select an AWS Certificate" data-region="" style="width: 100%">
                                    <option></option>
                                </select>
                                <p class="help-block">Certified Domains on AWS Certificate Manager.</p>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="custom_hostname">Custom hostname</label>
                                <input type="text" class="form-control" id="custom_hostname" name="custom_hostname" placeholder="example.yourdomain.com" data-rule-valid-url required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Auto-Tune</legend>
                        <div class="form-group">
                            <label class="control-label" for="auto_tune">Auto-Tune</label>
                            <label class="radio">
                                <input type="radio" value="DISABLED" name="auto_tune" />
                                Disable
                                <p class="help-block">No automated changes to your cluster. Amazon ES will still send occasional recommendations for how to optimize cluster performance.</p>
                            </label>
                            <label class="radio">
                                <input type="radio" value="ENABLED" name="auto_tune" checked="checked" />
                                Enable
                                <p class="help-block">Automatically makes node-level changes that require no downtime, such as tuning queues and cache sizes.</p>
                            </label>
                        </div>
                    </fieldset>
                </div>
            </div>
       </div>

       <div id="step-3" class="tab-pane" role="tabpanel">
           <div class="row">
                <div class="col-md-12">
                    <h3 class="StepTitle">Step 3</h3>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend>Data nodes</legend>
                        <div class="form-group">
                            <label class="control-label" for="availability_zones">Availability Zones</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="3" name="availability_zones" class="availability_zones" />
                                    3-AZ (Recommended for production workloads with higher availability requirements)
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="2" name="availability_zones" class="availability_zones" />
                                    2-AZ (Suitable for production workloads)
                                </label>
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" value="1" name="availability_zones" class="availability_zones" checked="checked" />
                                    1-AZ (Suitable for non-critical workloads)
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
                                    <option value="r5.large.elasticsearch">r5.large.elasticsearch</option>
                                    <option value="r5.xlarge.elasticsearch">r5.xlarge.elasticsearch</option>
                                    <option value="r5.2xlarge.elasticsearch">r5.2xlarge.elasticsearch</option>
                                    <option value="r5.4xlarge.elasticsearch">r5.4xlarge.elasticsearch</option>
                                    <option value="r5.12xlarge.elasticsearch">r5.12xlarge.elasticsearch</option>
                                </optgroup>
                                <optgroup label="t2">
                                    <option value="t2.small.elasticsearch" selected="selected">t2.small.elasticsearch</option>
                                    <option value="t2.medium.elasticsearch">t2.medium.elasticsearch</option>
                                </optgroup>
                                <optgroup label="t3 (General purpose)">
                                    <option value="t3.small.elasticsearch">t3.small.elasticsearch</option>
                                    <option value="t3.medium.elasticsearch">t3.medium.elasticsearch</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="number_of_nodes">Number of nodes</label>
                            <input type="number" class="form-control" id="number_of_nodes" name="number_of_nodes" placeholder="Number of nodes" value="1" required data-rule-multiple-of="1">
                            <p class="help-block">For three Availability Zones, we recommend instances in multiples of three for equal distribution across the Availability Zones.</p>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Data nodes storage</legend>
                        <!--
                        <div class="form-group">
                            <label class="control-label">Data node storage type</label>
                            <p class="form-control-static">EBS</p>
                        </div>
                        -->
                        <div class="form-group">
                            <label class="control-label" for="ebs_volume_type">EBS Volume type</label>
                            <select name="ebs_volume_type" id="ebs_volume_type" class="form-control form-select2" required data-placeholder="Select an EBS volume type" style="width: 100%">
                                <option></option>
                                <option value="gp2" selected="selected">General Purpose (SSD)</option>
                                <option value="io1">Provisioned IOPS (SSD)</option>
                                <option value="standard">Magnetic</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="ebs_storage_size_per_node">EBS storage size per node</label>
                            <input type="number" class="form-control" id="ebs_storage_size_per_node" name="ebs_storage_size_per_node" placeholder="EBS storage size per node" value="10" required data-rule-min="10" data-rule-max="1024">
                            <p class="help-block">Total cluster size is EBS volume size x Instance count.</p>
                        </div>
                        <div id="provisioned-iops-field" class="form-group" style="display: none;">
                            <label class="control-label" for="provisioned_iops">Provisioned IOPS</label>
                            <input type="number" class="form-control" id="provisioned_iops" name="provisioned_iops" placeholder="Provisioned IOPS" value="1000" required data-rule-min="1000" data-rule-max="16000">
                            <p class="help-block">The provisioned IOPS value must be an integer between 1000 and 16000.</p>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend>Dedicated master nodes</legend>
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" value="enable" name="dedicated_master_nodes" id="dedicated_master_nodes" />
                                Enable Dedicated master nodes
                            </label>
                        </div>
                        <div id="dedicated_container" style="display: none">
                            <div class="form-group">
                                <label class="control-label" for="dedicated_master_node_instance_type">Instance type</label>
                                <select name="dedicated_master_node_instance_type" id="dedicated_master_node_instance_type" class="form-control form-select2" required data-placeholder="Select an Instance type" style="width: 100%">
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
                                        <option value="r5.large.elasticsearch">r5.large.elasticsearch</option>
                                        <option value="r5.xlarge.elasticsearch">r5.xlarge.elasticsearch</option>
                                        <option value="r5.2xlarge.elasticsearch">r5.2xlarge.elasticsearch</option>
                                        <option value="r5.4xlarge.elasticsearch">r5.4xlarge.elasticsearch</option>
                                        <option value="r5.12xlarge.elasticsearch">r5.12xlarge.elasticsearch</option>
                                    </optgroup>
                                    <optgroup label="t2">
                                        <option value="t2.small.elasticsearch" selected="selected">t2.small.elasticsearch</option>
                                        <option value="t2.medium.elasticsearch">t2.medium.elasticsearch</option>
                                    </optgroup>
                                    <optgroup label="t3 (General purpose)">
                                        <option value="t3.small.elasticsearch">t3.small.elasticsearch</option>
                                        <option value="t3.medium.elasticsearch">t3.medium.elasticsearch</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="dedicated_master_node_number_of_nodes">Number of nodes</label>
                                <select name="dedicated_master_node_number_of_nodes" id="dedicated_master_node_number_of_nodes" class="form-control form-select2" required data-placeholder="Select an Instance type" style="width: 100%">
                                    <option value="3" selected="selected">3</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <fieldset>
                                <legend>UltraWarm data nodes</legend>
                                <div class="form-group">
                                    <label class="checkbox">
                                        <input type="checkbox" value="enable" name="ultrawarm_data_node" id="ultrawarm_data_node" />
                                        Enable UltraWarm data nodes
                                    </label>
                                </div>
                                <div id="ulrawarm_container" style="display: none">
                                    <div class="form-group">
                                        <label class="control-label" for="ultrawarm_instance_type">Instance type</label>
                                        <select name="ultrawarm_instance_type" id="ultrawarm_instance_type" class="form-control form-select2" required data-placeholder="Select an UltraWarm Instance type" style="width: 100%">
                                            <option></option>
                                            <option value="ultrawarm1.medium.elasticsearch" selected="selected">ultrawarm1.medium.elasticsearch</option>
                                            <option value="ultrawarm1.large.elasticsearch">ultrawarm1.large.elasticsearch</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="number_of_warm_data_nodes">Number of warm data nodes</label>
                                        <input type="number" class="form-control" id="number_of_warm_data_nodes" name="number_of_warm_data_nodes" placeholder="Number of nodes" value="2" data-rule-min="2" required>
                                        <p class="help-block">UltraWarm requires a minimum of two warm nodes.</p>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </fieldset>
                </div>
            </div>
       </div>

       <div id="step-4" class="tab-pane" role="tabpanel">
           <div class="row">
                <div class="col-md-12">
                    <h3 class="StepTitle">Step 4</h3>
                </div>
                <div class="col-md-6">
                    <!-- to be updated -->
                    <fieldset class="hidden">
                        <legend>Network configuration</legend>
                        <div class="form-group">
                            <!--
                            <label class="radio">
                                <input type="radio" value="vpc" name="network_configuration" />
                                VPC access
                            </label>
                            -->
                            <label class="radio">
                                <input type="radio" value="public" name="network_configuration" checked="checked" />
                                Public access
                            </label>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Fine-grained access control</legend>
                        <div class="form-group">
                            <label class="checkbox" for="fine_grain_access_control">
                                <input type="checkbox" value="enable" name="fine_grain_access_control" id="fine_grain_access_control" />
                                Enable fine-grained access control
                            </label>
                        </div>
                        <div id="fine_grain_options_container" style="display: none">
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="create_master_user" name="fine_grain_option" class="fine_grain_option" checked="checked" />
                                        Create master user
                                        <p class="help-block">By creating a master user, your domain will have the internal user database enabled with HTTP basic authentication.</p>
                                    </label>
                                </div>
                            </div>

                            <div id="create_master_user_fields">
                                <div class="form-group">
                                    <label class="control-label" for="master_username">Master username</label>
                                    <input type="text" class="form-control" id="master_username" name="master_username" placeholder="Master username" data-rule-minlength="1" data-rule-maxlength="16" required>
                                    <p class="help-block">Must be between 1 and 16 characters.</p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="master_password">Master password</label>
                                    <input type="password" class="form-control" id="master_password" name="master_password" placeholder="Master password" data-rule-minlength="8" data-rule-passwordExt required>
                                    <p class="help-block">Must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.</p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="confirm_master_password">Confirm master password</label>
                                    <input type="password" class="form-control" id="confirm_master_password" name="confirm_master_password" placeholder="Master password" data-rule-equalTo="#master_password">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Encryption</legend>
                        <div class="form-group">
                            <label class="checkbox" for="require_https">
                                <input type="checkbox" value="enable" name="require_https" id="require_https" checked="checked" />
                                Require HTTPS for all traffic to the domain
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox" for="note_to_node_encryption">
                                <input type="checkbox" value="enable" name="note_to_node_encryption" id="note_to_node_encryption" />
                                Node-to-node encryption
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox" for="enable_encryption_of_data_at_rest">
                                <input type="checkbox" value="enable" name="enable_encryption_of_data_at_rest" id="enable_encryption_of_data_at_rest" />
                                Enable encryption of data at rest
                            </label>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend>Access policy</legend>
                        <div id="allow_open_access_container" class="form-group" style="display: none">
                            <label class="checkbox">
                                <input type="checkbox" value="enable" name="allow_open_access" id="allow_open_access" />
                                Allow open access to the domain
                            </label>
                        </div>
                        <div id="access_policy_container" class="form-group">
                            <!-- <label class="control-label" for="access_policy">JSON defined access policy</label> -->
                            <div id="access_policy_json" style="height: 300px"></div>
                            <input type="hidden" id="access_policy" name="access_policy">
                            <input type="hidden" id="aws_account" value="<?php echo $aws_account ?>">
                        </div>
                    </fieldset>
                </div>
            </div>
       </div>

       <div id="step-5" class="tab-pane" role="tabpanel">
           <div class="row">
                <div class="col-md-12">
                    <h3 class="StepTitle">Step 5</h3>
                </div>
                <div class="summary">
                    <div class="col-md-6">
                        <fieldset id="details-field">
                            <legend class="border-0">Details:</legend>
                        </fieldset>
                        <fieldset id="data-nodes-field">
                            <legend class="border-0">Data Nodes:</legend>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset id="dedicated-instances-field">
                            <legend class="border-0">Dedicated Instances:</legend>
                        </fieldset>
                        <fieldset id="network-confi-field">
                            <legend class="border-0">Network Configuration:</legend>
                        </fieldset>
                        <fieldset id="access-policy-field">
                            <legend class="border-0">Access Policy:</legend>
                        </fieldset>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>