<?php 
  // info setup
  $url        = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $post_types = get_post_types();
  $content    = '';
?>
<div class="wrap">
  <h1>Post Type Templates</h1>
  <form>
    <select name="template_post_type" id="template_post_type">
      <?php foreach( $post_types as $post_type ): ?>
        <option value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
      <?php endforeach; ?>
    </select>
    <?php wp_editor( $content, 'brg_ppt' ); ?>
  </form>
</div>
<script>

</script>