<?php foreach($eventTypes as $eventType): ?>
    <label class="checkbox-inline">
        <input type="checkbox" name="eventTypes[]" class="flat-green" value="<?php echo $eventType->type ?>">
        <?php echo $eventType->description ?>
    </label>
<?php endforeach; ?>