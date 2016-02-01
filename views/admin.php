<p>
    <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
    <input type="text"
           id="<?php echo $this->get_field_id('title'); ?>"
           name="<?php echo $this->get_field_name('title'); ?>"
           value="<?php echo $instance['title']; ?>"
           style="width:100%;"/>
</p>
<p>
    <label for="<?php echo $this->get_field_id('url'); ?>">Podcast Feed Url:</label>
    <input type="text"
           required="required"
           id="<?php echo $this->get_field_id('url'); ?>"
           name="<?php echo $this->get_field_name('url'); ?>"
           value="<?php echo $instance['url']; ?>"
           style="width:100%;"/>
</p>
<p>
    <label for="<?php echo $this->get_field_id('count'); ?>">Number of items:</label>
    <input type="text"
           id="<?php echo $this->get_field_id('count'); ?>"
           name="<?php echo $this->get_field_name('count'); ?>"
           value="<?php echo $instance['count']; ?>"
           style="width:100%;"/>
</p>
<p>
    <label for="<?php echo $this->get_field_id('autoplay'); ?>">Auto Play:</label>
    <input type="checkbox"
           id="<?php echo $this->get_field_id('autoplay'); ?>"
           name="<?php echo $this->get_field_name('autoplay'); ?>"
        <?php checked('1', $instance['autoplay']); ?>
        value="1"
    />
</p>
