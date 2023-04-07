<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<style>
    .digi_affi {
        background-color: #ebebeb;
        padding: 20px; color: #444444;
    }
    .digi_affi h1{font-size: 23px}
    .digi_affi_installed{float:left;background: #4caf50;padding:4px 10px;border-radius: 4px;color: white;font-family: tahoma;font-size: 60%;font-weight: normal}
    #digi_affi_id{width:100%;direction: ltr;}
</style>
<div class="wrap">
    <h1>
        <a href="https://mrrashidpour.ir/" target="_blank">
            <img src="<?php echo digi_affi_IMG_URL ?>logo.png" />
        </a>
    </h1>
		<?php if($error = get_transient('error_digi_affi')){ ?>
            <div class="error">
                <p><?php echo esc_html( $error ); ?></p>
            </div>
		<?php set_transient('error_digi_affi', ''); } ?>

		<?php if($success = get_transient('success_digi_affi')){ ?>
            <div class="notice notice-success settings-error is-dismissible">
                <p><?php echo esc_html( $success ); ?></p>
            </div>
		<?php set_transient('success_digi_affi', ''); } ?>
        <div class="digi_affi">
            <h1>
                <?php _e('Settings', 'mrra_digi_affiliate'); ?>
            </h1>
            <hr>
            <p>
                <?php _e('After introducing the media, in the link section, register the new link publicly and enter the created links', 'mrra_digi_affiliate'); ?>
            </p>
            <p>
                <?php _e('<a href="https://panel.affilio.ir/" target="_blank">Digikala affiliate website</a>', 'mrra_digi_affiliate'); ?>
            </p>
            <br>
            <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" id="form-token">
                <input type="hidden" value="wp_save_digi_affi" name="action">
                <div>
                    <label for="digi_affi_id">
                        <?php _e('Links made:', 'mrra_digi_affiliate'); ?>
                    </label>
                    <input type="url" id="digi_affi_id" name="widget_id" autocomplete="off" value="<?php if ($widget_id && $widget_id!="") {echo $widget_id;} ?>" placeholder="https://migmig.affilio.ir/api/v1/Click/{YOUR_BASE64_ENCODED_URL}"  />
                    <br><br>
                    <?php wp_nonce_field( 'digi_affi_nonce'.get_current_user_id() ); ?>
                    <input type="submit" name="submit" class="button button-primary" value="<?php _e('Register settings', 'mrra_digi_affiliate'); ?>">
                </div>
            </form>
        </div>

    <p style="font-size: 12px;text-align: center">
        <?php _e('Digikala affiliate, a special tool for cooperation in the sale of Digikala
        <a href="https://mrrashidpour.ir/" target="_blank">Designer and programmer Mohammad Reza Rashidpour</a>', 'mrra_digi_affiliate'); ?>
    <p>
</div>
