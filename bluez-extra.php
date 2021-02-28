<?php

/*
Plugin Name: TheBluez Extra Functionality
Plugin URI: https://github.com/thebluez/extra
Description: Extra functionality for TheBluez.gr
Version: 1.0.0
Author: Alexandros Koutroulis
Author URI: https://github.com/mistericy/
License: GPL3
Requires PHP: 7.4
Requires at least: 5.5

*/


/**
 * Adds a Reject Button in media buttons
 */
function bluez_add_reject_work_button(): void
{
    global $pagenow;

    if (!in_array($pagenow, ['post.php'])) {
        return;
    }

    ?>
    <a href="#TB_inline?height=500&width=600&inlineId=bluez_rejection_form"
       class="thickbox button button-primary"
       style="background: #dc3232; border-color: #b41f1f">
        Απόρριψη κειμένου
    </a>
    <?php
}

add_action('media_buttons', 'bluez_add_reject_work_button');
/**
 * Adds a rejection form in a thickbox
 */
function bluez_rejection_form(): void
{
    global $pagenow, $post;
    if (!in_array($pagenow, ['post.php'])) {
        return;
    }
    ?>
    <div id="bluez_rejection_form" style="display:none">
        <h2>Απόρριψη κειμένου</h2>
        <?php
        $complete_url = wp_nonce_url("post.php?post={$post->ID}&action=reject_post", 'reject_post');
        ?>
        <form action="<?php
        echo $complete_url; ?>" method="POST">
            <table>
                <tr>
                    <td><label for="bluez_rejection_primary_reason" style="display: block">Κύριος λόγος
                            απόρριψης:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select id="bluez_rejection_primary_reason"
                                class="postbox"
                                name="bluez_rejection_primary_reason"
                                style="float: left;">
                            <option value="">Επέλεξε...</option>
                            <option value="content">Μη αποδεκτό περιεχόμενο</option>
                            <option value="conditions">Προβλήματα γραφής</option>
                            <option value="other">Άλλο</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="bluez_rejection_secondary_reason" style="display: block">Αιτιολογία: </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select id="bluez_rejection_secondary_reason" name="bluez_rejection_secondary_reason"
                                class="postbox"
                                disabled style="float:left">
                            <option value="">Επέλεξε...</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="bluez_rejection_description">Σχόλια επιμελητή:</label>

                    </td>
                </tr>
                <tr>
                    <td>
                    <textarea id="bluez_rejection_description" rows="4" cols="80"
                              name="bluez_rejection_description"></textarea>
                    </td>
                </tr>
            </table>
            <input type="submit" name="blz_reject_post" value="Απόρριψη κειμένου">
        </form>

        <script type="application/javascript">

          jQuery(document).ready(() => {
            console.log('BluezPlugin is ready');
            jQuery('#bluez_rejection_primary_reason').on('change', (evt) => {

              // Clean up current options from secondary dropdown
              // Get value of option box
              var currentVal = jQuery('#bluez_rejection_primary_reason').val();
              if (currentVal === '') {
                jQuery('#bluez_rejection_secondary_reason').prop('disabled', true);
              } else {
                jQuery('#bluez_rejection_secondary_reason').prop('disabled', false);
              }

              jQuery('#bluez_rejection_secondary_reason')
                .find('option')
                .remove();

              var contentOptions = [
                { value: '', text: 'Επέλεξε...' },
                {
                  value: 'political',
                  text: 'Πολιτικό περιεχόμενο',
                },
                {
                  value: 'racism',
                  text: 'Ρατσιστικό / ομοφοβικό περιεχόμενο',
                },
                {
                  value: 'sexism',
                  text: 'Σεξιστικό περιεχόμενο',
                },
                {
                  value: 'hate',
                  text: 'Λόγος μίσους',
                },
                {
                  value: 'insult',
                  text: 'Προσβολές / Διασυρμός',
                }, {
                  value: 'extreme',
                  text: 'Εξαιρετικά ακραίο, εξτρεμιστικό, παράνομο ή προσηλυτιστικό περιεχόμενο',
                }, {
                  value: 'press',
                  text: 'Δελτία τύπου',
                }, {
                  value: 'news',
                  text: 'Ειδήσεις',
                },
                {
                  value: 'paralirima',
                  text: 'Παραληρηματικός λόγος',
                },
                {
                  value: 'poetry',
                  text: 'Ποίηση',
                }, {
                  value: 'theater',
                  text: 'Θεατρικά έργα',
                }, {
                  value: 'movie',
                  text: 'Σενάρια ταινιών',
                },
              ];
              var conditionsOptions = [
                {
                  value: '',
                  text: 'Επέλεξε...',
                },
                {
                  value: 'short',
                  text: 'Πολύ μικρό κείμενο',
                }, {
                  value: 'long',
                  text: 'Πολύ μεγάλο κείμενο',
                }, {
                  value: 'incomplete',
                  text: 'Μη αυτοτελές κείμενο',
                }, {
                  value: 'other-language',
                  text: 'Ξενόγλωσσο',
                }, {
                  value: 'greeklish',
                  text: 'Greeklish',
                }, {
                  value: 'spelling',
                  text: 'Ανορθόγραφο',
                }, {
                  value: 'syntax',
                  text: 'Ασύντακτο',
                }, {
                  value: 'punctuation-eng',
                  text: 'Αγγλικά σημεία στίξης',
                }, {
                  value: 'quotation',
                  text: 'Εσφαλμένα εισαγωγικά',
                }, {
                  value: 'paragraphs',
                  text: 'Παραγραφοποίηση',
                }, {
                  value: 'netspeak',
                  text: 'Διαδικτυακή γραφή',
                }, {
                  value: 'punctuation-abuse',
                  text: 'Κατάχρηση σημείων στίξης',
                }, {
                  value: 'accents',
                  text: 'Άτονο',
                }, {
                  value: 'cohesion',
                  text: 'Ασυνέχεια λόγου / Έλλειψη συνοχής',
                }, {
                  value: 'polytonic',
                  text: 'Πολυτονικὸ σύστημα',
                },
              ];
              var otherOptions = [
                { value: '', text: 'Επέλεξε...' },
                { value: 'copyright', text: 'Λογοκλοπή' },
                { value: 'missing-info', text: 'Ανεπαρκή στοιχεία αποστολέα' },
              ];
              if (currentVal === 'content') {
                jQuery.each(contentOptions, (index, value) => {
                  var option = jQuery('<option></option>')
                    .attr('value', value.value)
                    .text(value.text);
                  jQuery('#bluez_rejection_secondary_reason')
                    .append(option);
                });
              } else if (currentVal === 'conditions') {
                jQuery.each(conditionsOptions, (index, value) => {
                  var option = jQuery('<option></option>')
                    .attr('value', value.value)
                    .text(value.text);
                  jQuery('#bluez_rejection_secondary_reason')
                    .append(option);
                });
              } else if (currentVal === 'other') {
                jQuery.each(otherOptions, (index, value) => {
                  var option = jQuery('<option></option>')
                    .attr('value', value.value)
                    .text(value.text);
                  jQuery('#bluez_rejection_secondary_reason')
                    .append(option);
                });
              }
            });

          });
        </script>
    </div>
    <?php
}

add_action('admin_footer', 'bluez_rejection_form');
/**
 * Performs the Rejection of the Post
 *
 * @param int $data Post Id
 */
function bluez_admin_reject_post($data)
{
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'reject_post')) {
        // Check nonce
        status_header(401);
        wp_redirect(admin_url('edit.php'));
        exit();
    }

    $reason = $_POST['bluez_rejection_secondary_reason'];
    $rejection = $_POST['bluez_rejection_description'];

    $reasons = [
        'political' => 'Το κείμενο περιέχει πολιτικό περιεχόμενο',
        'racism' => 'Το κείμενο έχει ρατσιστικό / ομοφοβικό ύφος ή περιεχόμενο',
        'sexism' => 'Το κείμενο έχει σεξιστικό ύφος ή περιεχόμενο',
        'hate' => 'Το κείμενο περιέχει εκφράσεις μίσους',
        'insult' => 'Το κείμενο φαίνεται να έχει σκοπό να προσβάλει ή να διασύρει',
        'extreme' => ' Το κείμενο περιέχει Εξαιρετικά ακραίο, εξτρεμιστικό, παράνομο ή προσηλυτιστικό περιεχόμενο',
        'press' => 'Δεν δημοσιεύουμε δελτία τύπου',
        'news' => 'Δεν δημοσιεύουμε ειδήσεις',
        'paralirima' => 'Το κείμενο έχει παραληρηματικό λόγο',
        'poetry' => 'Δεν δημοσιεύουμε ποίηση',
        'theater' => 'Δεν δημοσιεύουμε θεατρικά έργα',
        'movie' => 'Δεν δημοσιεύουμε σενάρια ταινιών',
        'short' => 'Το κείμενο είναι πολύ μικρής έκτασης',
        'long' => 'Το κείμενο είναι πολύ μεγάλης έκτασης',
        'incomplete' => 'Το κείμενο δεν είναι αυτοτελές',
        'other-language' => 'Το κείμενο είναι ξενόγλωσσο',
        'greeklish' => 'Den dimosievoume keimena gramena se greeklish',
        'spelling' => 'Το κείμενο στερείται ορθογραφικού ελέγχου',
        'syntax' => 'Το κείμενο είναι ασύντακτο',
        'punctuation-eng' => 'Το κείμενο έχει αγγλικά σημεία στίξης',
        'quotation' => 'Το κείμενο έχει εσφαλμένα εισαγωγικά',
        'paragraphs' => 'Το κείμενο στερείται παραγραφοποίησης',
        'netspeak' => 'Δεν δημοσιεύουμε κειμενα με διαδικτυακή γραφή',
        'punctuation-abuse' => 'Το κειμενο καταχράται τα σημεία στίξης......',
        'accents' => 'Το κείμενο στερείται τονισμού',
        'cohesion' => 'Το κείμενο έχει έλλειψη συνοχής ή υπάρχει ασυνέχεια λόγου',
        'polytonic' => 'Δεν δημοσιεύουμε κείμενα γραμμένα σε πολυτονικό σύστημα',
        'copyright' => 'Το κείμενο φέρεται να είναι προϊόν λογοκλοπής',
        'missing-info' => 'Το κείμενο υπογράφεται με ανεπαρκή στοιχεία δημιουργού',
    ];

    $post = get_post($data);

    $to = get_post_meta($data, 'user_submit_email', true);
    $subject = 'Απόρριψη Κειμένου';
    $message = bluez_get_email_body($post->post_title, $reasons[$reason], $rejection);
    $headers = ['Reply-To: darski669@gmail.com', 'Content-Type: text/html; charset=UTF-8'];
    $attachments = [];

    add_post_meta($data, 'blz_reject_reason', $reasons[$reason], true);
    add_post_meta($data, 'blz_reject_message', $rejection, true);
    add_post_meta($data, 'blz_reject_date', date('d/m/Y'), true);

    wp_mail($to, $subject, $message, $headers, $attachments);
    wp_trash_post($data);
}
add_action('post_action_reject_post', 'bluez_admin_reject_post');
/**
 * Generates the email template
 *
 * @param string $title Post Title
 * @param string $reason Rejection Reason
 * @param string $message Editor's message
 * @return string
 */
function bluez_get_email_body($title, $reason, $message = '') : string
{
    $template = <<<HTML
<!doctype html><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><title></title><!--[if !mso]><!-- --><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]--><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">#outlook a { padding:0; }
          body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
          table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
          img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
          p { display:block;margin:13px 0; }</style><!--[if mso]>
        <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        <![endif]--><!--[if lte mso 11]>
        <style type="text/css">
          .mj-outlook-group-fix { width:100% !important; }
        </style>
        <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
        .mj-column-per-100 { width:100% !important; max-width: 100%; }
      }</style><style type="text/css">@media only screen and (max-width:480px) {
      table.mj-full-width-mobile { width: 100% !important; }
      td.mj-full-width-mobile { width: auto !important; }
    }</style></head><body style="background-color:#FFE6CC;"><div style="background-color:#FFE6CC;"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="background:#1d1e1f;background-color:#1d1e1f;margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#1d1e1f;background-color:#1d1e1f;width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:200px;"><img height="auto" src="https://thebluez.gr/wp-content/uploads/elementor/thumbs/thebleuz-gr-logo-retina-og48iob340xdcjxmu5kv6o9j68g6fqv9cirhmmm61s.png" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="200"></td></tr></tbody></table></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Didact Gothic;font-size:20px;line-height:1;text-align:left;color:#000000;">Απόρριψη κειμένου</div></td></tr><tr><td style="font-size:0px;padding:10px 25px;word-break:break-word;"><p style="border-top:solid 4px #2d2e2f;font-size:1px;margin:0px auto;width:100%;"></p><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 4px #2d2e2f;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]--></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Didact Gothic;font-size:13px;line-height:1;text-align:left;color:#000000;">Σας ενημερώνουμε ότι το κείμενό σας με τίτλο <i>{{title}}</i> δεν θα δημοσιευτεί στον ιστότοπο <a href="https://thebluez.gr">TheBluez.gr</a>.</div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Didact Gothic;font-size:13px;line-height:1;text-align:left;color:#000000;">Ο/η επιμελητής/επιμελήτρια το απέρριψε με αιτιολογία: <b>{{reason}}.</b></div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Didact Gothic;font-size:13px;line-height:1;text-align:left;color:#000000;">Επιπλέον, παρέθεσε τα παρακάτω σχόλια:</div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Didact Gothic;font-size:13px;line-height:1;text-align:left;color:#000000;">{{notes}}</div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Didact Gothic;font-size:13px;line-height:1;text-align:left;color:#000000;">Είμαστε στη διάθεσή σας για οποιαδήποτε περαιτέρω πληροφορία ή διευκρίνιση.</div></td></tr><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Didact Gothic;font-size:13px;line-height:1;text-align:left;color:#000000;"><i>&mdash; Η ομάδα επιμέλειας του TheBluez.gr</i></div></td></tr><tr><td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Didact Gothic;font-size:9px;line-height:1;text-align:center;color:#000000;">Αυτό είναι ένα αυτοματοποιημένο μήνυμα ηλεκτρονικού ταχυδρομείου</div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body></html>
HTML;

    $template = str_replace('{{title}}', $title, $template);
    $template = str_replace('{{reason}}', $reason, $template);

    return str_replace('{{notes}}', $message, $template);
}
