<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:', $this->get_widget_slug())?></label>
    <input type="text"
           id="<?php echo $this->get_field_id('title'); ?>"
           name="<?php echo $this->get_field_name('title'); ?>"
           value="<?php echo $instance['title']; ?>"
           style="width:100%;"/>
</p>
<p>
    <label for="<?php echo $this->get_field_id('url'); ?>"><?php echo __('Podcast Feed Url:', $this->get_widget_slug())?></label>
    <input type="text"
           required="required"
           id="<?php echo $this->get_field_id('url'); ?>"
           name="<?php echo $this->get_field_name('url'); ?>"
           value="<?php echo $instance['url']; ?>"
           style="width:100%;"/>
</p>
<p>
    <label for="<?php echo $this->get_field_id('corsenabled'); ?>"><?php echo __('CORS enabled Feed?', $this->get_widget_slug())?></label>
    <input type="checkbox"
           id="<?php echo $this->get_field_id('corsenabled'); ?>"
           name="<?php echo $this->get_field_name('corsenabled'); ?>"
        <?php checked('1', $instance['corsenabled']); ?>
           value="1"
    />
</p>
<p>
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php echo __('Number of items:', $this->get_widget_slug())?></label>
    <input type="text"
           id="<?php echo $this->get_field_id('count'); ?>"
           name="<?php echo $this->get_field_name('count'); ?>"
           value="<?php echo $instance['count']; ?>"
           style="width:100%;"/>
</p>
<p>
    <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php echo __('Auto Play:', $this->get_widget_slug())?></label>
    <input type="checkbox"
           id="<?php echo $this->get_field_id('autoplay'); ?>"
           name="<?php echo $this->get_field_name('autoplay'); ?>"
        <?php checked('1', $instance['autoplay']); ?>
        value="1"
    />
</p>
