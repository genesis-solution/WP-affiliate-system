<div class="form-group wslu-admin-input-text wslu-admin-input-text-<?php echo esc_attr(self::strify($name)); ?>">
	<label for="wslu-admin-option-text<?php echo esc_attr(self::strify($name)); ?>"><?php echo esc_html($label); ?></label>
	<input
		type="color"
		class="attr-form-control"
		id="wslu-admin-option-text<?php echo esc_attr(self::strify($name)); ?>"
		aria-describedby="wslu-admin-option-text-help<?php echo esc_attr(self::strify($name)); ?>"
		placeholder="<?php echo esc_attr($placeholder); ?>"
		name="<?php echo esc_attr($name); ?>"
		value="<?php echo esc_attr($value); ?>"
		<?php echo esc_attr($disabled) ?>
	>
	<small id="wslu-admin-option-text-help<?php echo esc_attr(self::strify($name)); ?>" class="form-text text-muted"><?php echo esc_html($info); ?></small>
</div>