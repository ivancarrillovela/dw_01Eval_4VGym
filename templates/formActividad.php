<form class="form-horizontal" method="POST" action="<?php echo $form_action; ?>">
    
    <?php if ($activity_id !== null) : ?>
        <input type="hidden" name="id" value="<?php echo $activity_id; ?>">
    <?php endif; ?>

    <div class="form-group mb-3">
        <label for="type" class="col-sm-2 control-label">Tipo</label>
        <div class="col-sm-10">
            <select id="type" class="form-control" name="type">
                <option value="spinning" <?php if ($type_value === 'spinning') echo 'selected'; ?>>Spinning</option>
                <option value="bodypump" <?php if ($type_value === 'bodypump') echo 'selected'; ?>>BodyPump</option>
                <option value="pilates" <?php if ($type_value === 'pilates') echo 'selected'; ?>>Pilates</option>
            </select>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="monitor" class="col-sm-2 control-label">Monitor</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="monitor" id="monitor" placeholder="Nombre del monitor" value="<?php echo htmlspecialchars($monitor_value); ?>">
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="place" class="col-sm-2 control-label">Lugar</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="place" id="place" placeholder="Lugar (ej: Aula 14)" value="<?php echo htmlspecialchars($place_value); ?>">
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="date" class="col-sm-2 control-label">Fecha</label>
        <div class="col-sm-10">
            <?php
            $formatted_date = '';
            if (!empty($date_value)) {
                // Formateamos el TIMESTAMP a 'YYYY-MM-DDTHH:MM'
                $formatted_date = date('Y-m-d\TH:i', strtotime($date_value));
            }
            ?>
            <input type="datetime-local" class="form-control" name="date" id="date" value="<?php echo $formatted_date; ?>">
        </div>
    </div>

    <div class="form-group mb-3">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary"><?php echo $button_text; ?></button>
        </div>
    </div>
</form>