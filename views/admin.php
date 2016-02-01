<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
    <input type="text"
           id="<?php echo $this->get_field_id( 'title' ); ?>"
           name="<?php echo $this->get_field_name( 'title' ); ?>"
           value="<?php echo $instance['title']; ?>"
           style="width:100%;"/>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'url' ); ?>">Podcast Feed Url:</label>
    <input type="text"
           id="<?php echo $this->get_field_id( 'url' ); ?>"
           name="<?php echo $this->get_field_name( 'url' ); ?>"
           value="<?php echo $instance['url']; ?>"
           style="width:100%;"/>
</p>
