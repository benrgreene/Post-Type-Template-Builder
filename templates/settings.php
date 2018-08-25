<?php 
  // Get the post typtes to display
  $post_types = apply_filters( 'brg/posts_with_templates', array() );

  // List of all the custom templates made
  $all_templates = get_posts( array(
    'post_type'      => 'brg_post_templates',
    'posts_per_page' => -1
  ) );
?>

<div class="wrap">
  <h1>Post Type Templates</h1>
  <p>Set the template you want to be displayed around the coresponding post type. Templates can be used for multiple post types.</p>
  <form method="POST" action="">
    <input type="hidden" name="brg_template_form" value="should-save" />
    <table>
      <tr>
        <td><h2>Post Type</h2></td>
        <td><h2>Template</h2></td>
      </tr>
      <?php foreach( $post_types as $post_type ): ?>
        <?php $current_option = get_option( 'template_for_' . $post_type ); ?>
        <tr>
          <td><?php echo $post_type; ?></td>
          <td><select name="template_for_<?php echo $post_type; ?>">
            <option value="0">No Template</option>
            <?php foreach( $all_templates as $template ): ?>
              <option value="<?php echo $template->ID; ?>" <?php if($current_option ==  $template->ID): echo 'selected="selected"'; endif; ?>><?php echo $template->post_title; ?></option>
            <?php endforeach; ?>
          </select></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php submit_button(); ?>
  </form>
</div>