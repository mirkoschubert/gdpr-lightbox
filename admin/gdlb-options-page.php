<div id="gdlb-plugin" class="wrap"> 
  <div id="icon-plugins" class="icon32"></div> 
  <h1><?php _e( 'GDPR Lightbox', 'gdlb' ); ?> <small><?php echo 'v'. $gdlb_version; ?></small></h1>
  <form action="options.php" method="POST">
  <?php settings_fields( 'gdlb_plugin_options' ); ?>
    <div class="metabox-holder">
      <div class="meta-box-sortables ui-sortable">
        <div class="postbox panel-overview">
          <h2 class="hndle ui-sortable-handle"><?php esc_html_e('Overview', 'gdlb'); ?></h2>
          <div class="inside">
            <div class="main">
              <p><strong><?php echo $gdlb_plugin; ?></strong> <?php esc_html_e('is a lightbox plugin which can also be used for a GDPR compliant way to display oEmbeds.', 'gdlb'); ?></p>
              </ul>
            </div>
          </div>
        </div>
        <div class="postbox panel-options">
          <h2 class="hndle ui-sortable-handle"><?php esc_html_e('Options', 'gdlb'); ?></h2>
          <div class="inside">
            <div class="main">
              <table class="form-table">
                <tbody>
                  <tr>
                    <th scope="row"><label class="" for="gdlb_options[theme]"><?php esc_html_e('Theme', 'gdlb'); ?></label></th>
                    <td>
                      <select name="gdlb_options[theme]">
                        <option value="dark">Dark Theme</option>
                        <option value="light" selected>Light Theme</option>
                      </select>
                      <p class="description"><?php esc_html_e('Select your preferred theme.', 'gdlb'); ?></p>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><label class="" for="gdlb_options[selectors]"><?php esc_html_e('Selectors', 'gdlb'); ?></label></th>
                    <td>
                      <input type="text" name="gdlb_options[selectors]" value="<?php if (isset($gdlb_options['selectors'])) { echo $gdlb_options['selectors']; } ?>"/>
                      <p class="description"><?php esc_html_e('These selectors will be used to apply the lightbox to the images.', 'gdlb'); ?></p>
                    </td>
                  </tr>

                  <tr>
                    <th scope="row"><label class="" for="gdlb_options[caption]"><?php esc_html_e('Caption', 'gdlb'); ?></label></th>
                    <td>
                      <input name="gdlb_options[caption]" type="checkbox" value="1" <?php if (isset($gdlb_options['caption'])) { checked('1', $gdlb_options['caption']); } ?> />
                      <span class="mm-item-caption"><?php esc_html_e('Show caption for images in the lightbox.', 'gdlb'); ?></span>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row"><label class="" for="gdlb_options[exif]"><?php esc_html_e('Exif-Data', 'gdlb'); ?></label></th>
                    <td>
                      <input name="gdlb_options[exif]" type="checkbox" value="1" <?php if (isset($gdlb_options['exif'])) { checked('1', $gdlb_options['exif']); } ?> />
                      <span class="mm-item-caption"><?php esc_html_e('Show exif data for images in the lightbox.', 'gdlb'); ?></span>
                    </td>
                  </tr>
                  <?php if (get_option('wp_page_for_privacy_policy') === false || get_option('wp_page_for_privacy_policy') === '0') : ?>
                  <tr>
                    <th scope="row"><label class=""><?php esc_html_e('Privacy Policy', 'gdlb'); ?></label></th>
                    <td>
                      <p class="description"><?php printf(__('You have to set a privacy policy page in the %1$s!', 'gdlb'), '<a href="' . get_admin_url() . 'privacy.php">' . esc_html__('Privacy Settings', 'gdlb') . '</a>'); ?></p>
                    </td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php submit_button(); ?>
  </form>
</div>