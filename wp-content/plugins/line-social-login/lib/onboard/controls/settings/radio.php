<div class="attr-input attr-input-radio wslu-admin-input-radio <?php echo esc_attr($class); ?>">
    <div class="wslu-admin-input-switch wslu-admin-card-shadow attr-card-body">
        <input <?php echo esc_attr($options['checked'] === true ? 'checked' : ''); ?> 
            type="radio" value="<?php echo esc_attr($value); ?>" 
            class="wslu-admin-control-input" 
            name="<?php echo esc_attr($name); ?>" 
            id="wslu-admin-radio__<?php echo esc_attr(self::strify($name) . $value); ?>"

            <?php 
            if(isset($attr)){
                foreach($attr as $k => $v){
                    echo esc_attr("$k='$v'");
                }
            }
            ?>
        >

        <label class="wslu-admin-control-label"  for="wslu-admin-radio__<?php echo esc_attr(self::strify($name) . $value); ?>">
            <?php echo esc_html($label); ?>
            <?php if(!empty($description)) : ?>
                <span class="wslu-admin-control-desc"><?php echo esc_html($description); ?></span>
            <?php endif; ?>
        </label>
    </div>
</div>