<?php 
  // info setup
  $url           = strtok($_SERVER["REQUEST_URI"],'?') . "?page=" . self::SETTINGS_PAGE_SLUG;
  $post_types    = get_post_types();
  $selected_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : 'post';
  $content       = (BRG_PTT_Database_Interface::get_instance())->get_template( $selected_type );
  $content = empty( $content ) ? '' : $content['template_html'];
?>

<div class="wrap">
  <h1>Post Type Templates</h1>
  <form method="POST" action="">
    <select name="template_post_type" id="template_post_type">
      <?php foreach( $post_types as $post_type ): ?>
        <option value="<?php echo $post_type; ?>" <?php if( $post_type == $selected_type): echo 'selected="selected"'; endif;?>><?php echo $post_type; ?></option>
      <?php endforeach; ?>
    </select>
    <?php wp_editor( $content, 'template_html' ); ?>
    <?php submit_button(); ?>
  </form>
</div>
<script>
  let url = "<?php echo $url; ?>";
  let dropdown = document.querySelector('#template_post_type');
  dropdown.addEventListener('change', (event) => {
    let pt = dropdown.value;
    window.location.replace( url + '&post_type=' + pt);
  });
</script>
<style>
  select {
    margin-bottom: 20px;
  }
</style>