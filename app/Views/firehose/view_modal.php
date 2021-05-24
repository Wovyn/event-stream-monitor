<div class="form-group">
    <label class="control-label text-bold">Delivery Name:</label>
    <p class="form-control-static display-value"><?php echo $aws['DeliveryStreamDescription']['DeliveryStreamName'] ?></p>
</div>
<div class="form-group">
    <label class="control-label text-bold">Delivery Stream ARN:</label>
    <p class="form-control-static display-value"><?php echo $aws['DeliveryStreamDescription']['DeliveryStreamARN'] ?></p>
</div>
<fieldset>
    <legend>Source:</legend>
    <div class="form-group">
        <label class="control-label text-bold">Kinesis Stream:</label>
        <p class="form-control-static display-value"><?php echo $db->kinesis_name ?></p>
    </div>
</fieldset>
<fieldset>
    <legend>Destination:</legend>
    <div class="form-group">
        <label class="control-label text-bold">Elasticsearch:</label>
        <p class="form-control-static display-value"><?php echo $db->elasticsearch_name ?></p>
    </div>
</fieldset>