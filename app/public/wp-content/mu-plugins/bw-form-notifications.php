<?php
/**
 * Plugin Name: BW Formuliermeldingen
 * Description: E-mailwaarschuwingen bij opgeslagen formulieren. Gebruikt wp_mail en werkt samen met SMTP-plugins.
 * Version: 1.0.0
 */
namespace BW\FormNotifications;
defined('ABSPATH')||exit;
const DEFAULT_RECIPIENT='info@mondaymakers.be';
function types(){return ['noor_inquiry','cc_inquiry','market_inquiry','bridge_inquiry','cottage_inquiry','elegant_inquiry','softskin_inquiry','redwood_inquiry','bordeaux_inquiry','suits_inquiry','barber_inquiry','experience_inquiry','monday_inquiry','fc_inquiry','photo_inquiry','mm_demo_interest'];}
function supported($post){return $post&&in_array($post->post_type,types(),true)&&$post->post_status==='private';}
function recipient(){return sanitize_email(get_option('bw_notification_email',DEFAULT_RECIPIENT));}
add_action('wp_after_insert_post',function($id,$post,$update){
 if($update||!supported($post)||wp_is_post_revision($id))return;
 if(!add_post_meta($id,'_bw_notification_status','pending',true))return;
 $GLOBALS['bw_notification_queue'][]=$id;
},10,3);
add_action('shutdown',function(){foreach(array_unique($GLOBALS['bw_notification_queue']??[])as$id)send($id);},5);
function send($id){
 $id=absint($id);$post=get_post($id);if(!supported($post)||in_array(get_post_meta($id,'_bw_notification_status',true),['sent','local'],true))return;
 $lock='bw_notification_lock_'.$id;if(!add_option($lock,time(),'','no')){if((int)get_option($lock)<time()-120){delete_option($lock);if(!add_option($lock,time(),'','no'))return;}else return;}
 $attempts=(int)get_post_meta($id,'_bw_notification_attempts',true)+1;
 try{
 $to=recipient();if(!is_email($to))throw new \RuntimeException('Geen geldig ontvangstadres ingesteld.');
 update_post_meta($id,'_bw_notification_attempts',$attempts);
 $site=html_entity_decode(wp_strip_all_tags(get_bloginfo('name')),ENT_QUOTES,'UTF-8');
 $subject='['.$site.'] Nieuwe formulierinzending #'.$id;
 $body="Er staat een nieuwe formulierinzending klaar.\n\nWebsite: ".$site."\nAdres: ".home_url('/')."\nOntvangen: ".get_post_time('d-m-Y H:i',false,$post)."\n\nBekijk de aanvraag in het beveiligde beheer:\n".admin_url('post.php?post='.$id.'&action=edit')."\n\nDe formulierinhoud blijft in de website opgeslagen. Deze waarschuwing bevat geen berichtinhoud of persoonsgegevens.\n";
 $error='';$failed=function($e)use(&$error){$error=$e->get_error_message();};add_action('wp_mail_failed',$failed);
 $sent=wp_mail($to,$subject,$body,['Content-Type: text/plain; charset=UTF-8','X-BW-Submission-ID: '.$id]);remove_action('wp_mail_failed',$failed);
 if(!$sent)throw new \RuntimeException($error?:'De mailtransportlaag heeft de melding geweigerd.');
 $host=wp_parse_url(home_url(),PHP_URL_HOST);$mailer=$GLOBALS['phpmailer']??null;
 $external=$mailer&&$mailer->Mailer==='smtp'&&!in_array($mailer->Host,['localhost','127.0.0.1','::1'],true);
 $local=(!$external)&&(in_array($host,['localhost','127.0.0.1'],true)||str_ends_with((string)$host,'.local'));
 $status=$local?'local':'sent';update_post_meta($id,'_bw_notification_status',$status);update_post_meta($id,'_bw_notification_to',$to);update_post_meta($id,'_bw_notification_at',current_time('mysql'));delete_post_meta($id,'_bw_notification_error');
 if($post->post_type==='photo_inquiry')update_post_meta($id,'_bp_mail_status',$local?'Lokaal aangeboden; controleer Mailpit':'Aangeboden aan mailtransport');
 if($post->post_type==='monday_inquiry')update_post_meta($id,'_monday_email_sent','yes');
 wp_clear_scheduled_hook('bw_notification_retry',[$id]);
 }catch(\Throwable$e){update_post_meta($id,'_bw_notification_status','failed');update_post_meta($id,'_bw_notification_error',mb_substr($e->getMessage(),0,500));if($attempts<3&&!wp_next_scheduled('bw_notification_retry',[$id]))wp_schedule_single_event(time()+300,'bw_notification_retry',[$id]);
 }finally{delete_option($lock);}
}
add_action('bw_notification_retry',__NAMESPACE__.'\\send');
function status_label($id){$status=get_post_meta($id,'_bw_notification_status',true);return ['pending'=>'Wacht op verzending','local'=>'Lokaal aangeboden — controleer Mailpit; externe bezorging niet bevestigd','sent'=>'Aangeboden aan mailtransport — bezorging niet bevestigd','failed'=>'Verzenden mislukt'][$status]??'Geen melding verstuurd (bestaande aanvraag)';}
add_action('add_meta_boxes',function(){foreach(types()as$type)if(post_type_exists($type))add_meta_box('bw-notification','E-mailmelding',function($post){echo '<p><strong>'.esc_html(status_label($post->ID)).'</strong></p><p>Ontvanger: '.esc_html(get_post_meta($post->ID,'_bw_notification_to',true)?:recipient()).'</p>';if($at=get_post_meta($post->ID,'_bw_notification_at',true))echo '<p>'.esc_html($at).'</p>';if($error=get_post_meta($post->ID,'_bw_notification_error',true))echo '<p>'.esc_html($error).'</p>';echo '<p><a href="'.esc_url(admin_url('options-general.php?page=bw-form-notifications')).'">Meldingsinstellingen</a></p>';if(in_array(get_post_meta($post->ID,'_bw_notification_status',true),['failed','pending'],true))echo '<p><a class="button" href="'.esc_url(wp_nonce_url(admin_url('admin-post.php?action=bw_notification_retry&id='.$post->ID),'bw_notification_retry_'.$post->ID)).'">Opnieuw proberen</a></p>';},$type,'side');});
add_action('admin_post_bw_notification_retry',function(){$id=absint($_GET['id']??0);if(!current_user_can('edit_post',$id)||!current_user_can('manage_options'))wp_die('Geen toegang.','',['response'=>403]);check_admin_referer('bw_notification_retry_'.$id);send($id);wp_safe_redirect(admin_url('post.php?post='.$id.'&action=edit'));exit;});
add_action('admin_menu',function(){add_options_page('Formuliermeldingen','Formuliermeldingen','manage_options','bw-form-notifications',function(){if(!current_user_can('manage_options'))return;?><div class="wrap"><h1>Formuliermeldingen</h1><p>Nieuwe opgeslagen contact-, cadeau-, inschrijf- en demo-aanvragen sturen één waarschuwing met een link naar het beheer. De inhoud blijft privé in de website.</p><form method="post" action="options.php"><?php settings_fields('bw_notifications');?><table class="form-table"><tr><th><label for="bw_notification_email">Ontvangstadres</label></th><td><input class="regular-text" type="email" id="bw_notification_email" name="bw_notification_email" required value="<?=esc_attr(recipient())?>"></td></tr></table><?php submit_button();?></form><h2>Bezorging</h2><p>De meldingen gebruiken WordPress wp_mail(). Configureer SMTP via je mailprovider of een SMTP-plugin. Local vangt e-mail meestal op in Mailpit: dat betekent niet dat de ontvanger de e-mail extern heeft ontvangen.</p><p>Een geslaagde aanroep betekent alleen dat het mailtransport de melding heeft aangenomen. Bij fouten blijft de aanvraag bewaard, wordt de fout getoond bij de aanvraag en volgen maximaal twee nieuwe pogingen via WP-Cron. Oude aanvragen worden niet automatisch alsnog gemaild.</p></div><?php });});
add_action('admin_init',function(){register_setting('bw_notifications','bw_notification_email',['type'=>'string','default'=>DEFAULT_RECIPIENT,'sanitize_callback'=>function($v){$email=is_string($v)?sanitize_email($v):'';if(!is_email($email)){add_settings_error('bw_notification_email','invalid','Vul een geldig e-mailadres in.');return recipient();}return$email;}]);});
