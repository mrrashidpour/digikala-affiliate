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
            <h1>تنظیمات</h1>
            <hr>
            <p>بعد از معرفی رسانه در بخش لینک لینک جدید را به صورت عمومی ثبت کنید و لینکهای ساخته شده را وارد کنید
            </p>
            <br>
            <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" id="form-token">
                <input type="hidden" value="wp_save_digi_affi" name="action">
                <div>
                    <label for="digi_affi_id">لینکهای ساخته شده : </label>
                    <input type="url" id="digi_affi_id" name="widget_id" autocomplete="off" value="<?php if ($widget_id) {echo $widget_id;} ?>"  />
                    <br><br>
                    <?php wp_nonce_field( 'digi_affi_nonce'.get_current_user_id() ); ?>
                    <input type="submit" name="submit" class="button button-primary" value="ثبت تنظیمات">
                </div>
            </form>

        </div>

    <p style="font-size: 12px;text-align: center">
        افیلیت دیجی کالا، ابزار ویژه همکاری در فروش دیجیکالا |
        <a href="https://mrrashidpour.ir/" target="_blank">طراح و برنامه نویس محمدرضا رشیدپور</a>
    <p>
</div>
