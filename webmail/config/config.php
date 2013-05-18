<?php

/**
 * BEFORE EDITING THIS FILE!
 *
 * Don't edit this file directly.  Copy it to config.php before you
 * edit it.  However, it is best to use the configuration script
 * conf.pl if at all possible.  That is the easiest and cleanest way
 * to configure.
 */

/* Do not change this value. */
global $config_version;
$config_version = '1.4.0';

/* Organization's logo picture (blank if none) */
global $org_logo;
$org_logo = SM_PATH . 'images/.png';

/*  The width of the logo (0 for default) */
$org_logo_width = 308;

/*  The height of the logo (0 for default) */
$org_logo_height = 111;


/* Organization's name */
global $org_name;
$org_name = 'SquirrelMail';

/**
 * Webmail Title
 *   This is the web page title that appears at the top of the browser window.
 */
global $org_title;
$org_title = "SquirrelMail $version";
    
/**
 * Default language
 *   This is the default language. It is used as a last resort
 *   if SquirrelMail can't figure out which language to display.
 *   Use the two-letter code.
 */
global $squirrelmail_default_language;
$squirrelmail_default_language = 'fr_FR';

/* The dns name and port for your imap server. */
global $imapServerAddress, $imapPort;
$imapServerAddress = '81.91.65.94';
$imapPort = 143;

/**
 * The domain part of local email addresses.
 *   This is for all messages sent out from this server.
 *   Reply address is generated by $username@$domain
 * Example: In bob@foo.com, foo.com is the domain.
 */
global $domain;
$domain = 'luluaym.com';

/* Your SMTP server and port number (usually the same as the IMAP server). */
global $smtpServerAddress, $smtpPort;
$smtpServerAddress = '81.91.65.94';
$smtpPort = 25;

/**
 * Uncomment this if you want to deliver locally using sendmail
 * instead of connecting to a SMTP-server.
 */
#global $useSendmail, $sendmail_path;
#$useSendmail = true;
#$sendmail_path = '/usr/sbin/sendmail';

/* This is a message that is displayed immediately after a user logs in. */
global $motd;
$motd = '';

/**
 * Whether or not to use a special color for special folders. If not,
 * special folders will be the same color as the other folders.
 */
global $use_special_folder_color;
$use_special_folder_color = true;

/**
 * The type of IMAP server you are running.
 * Valid type are the following (case is important):
 *   courier
 *   cyrus
 *   exchange
 *   uw
 *   other
 */
global $imap_server_type;
$imap_server_type = 'other';

/**
 * Rather than going to the signout.php page (which only allows you
 * to sign back in), setting signout_page allows you to sign the user
 * out and then redirect to whatever page you want. For instance,
 * the following would return the user to your home page:
 *   $signout_page = '/';
 * Set to the empty string to continue to use the default signout page.
 */
global $signout_page;
$signout_page = '';

/**
 * Many servers store mail in your home directory. With this, they
 * store them in a subdirectory: mail/ or Mail/, etc. If your server
 * does this, please set this to what the default mail folder should
 * be. This is still a user preference, so they can change it if it
 * is different for each user.
 *
 * Example:
 *     $default_folder_prefix = 'mail/';
 *        -- or --
 *     $default_folder_prefix = 'Mail/folders/';
 *
 * If you do not use this, set it to the empty string.
 */
global $default_folder_prefix;
$default_folder_prefix = '';

/**
 * If you do not wish to give them the option to change this, set it
 * to false. Otherwise, if it is true, they can change the folder prefix
 * to be anything.
 */
global $show_prefix_option;
$show_prefix_option = false;

/**
 * The following are related to deleting messages.
 *   $move_to_trash
 *      if this is set to 'true', when 'delete' is pressed, it
 *      will attempt to move the selected messages to the folder
 *      named $trash_folder. If it's set to 'false', we won't even
 *      attempt to move the messages, just delete them.
 *   $trash_folder
 *      This is the path to the default trash folder. For Cyrus
 *      IMAP, it would be 'INBOX.Trash', but for UW it would be
 *      'Trash'. We need the full path name here.
 *   $auto_expunge
 *      If this is true, when a message is moved or copied, the
 *      source mailbox will get expunged, removing all messages
 *      marked 'Deleted'.
 *   $sent_folder
 *      This is the path to where Sent messages will be stored.
 *   $delete_folder
 *      If this is true, when a folder is deleted then it will
 *      not get moved into the Trash folder.
 */
global $default_move_to_trash, $default_move_to_sent, $default_save_as_draft;
global $trash_folder, $sent_folder, $draft_folder, $auto_expunge;
global $delete_folder;
$default_move_to_trash = true;
$default_move_to_sent  = true;
$default_save_as_draft = true;
$trash_folder = 'INBOX.Trash';
$sent_folder  = 'INBOX.Sent';
$draft_folder = 'INBOX.Drafts';
$auto_expunge = true;
$delete_folder = false;

/**
 * Should I create the Sent and Trash folders automatically for
 * a new user that doesn't already have them created?
 */
global $auto_create_special;
$auto_create_special = true;

/* Whether or not to list the special folders first (true/false). */
global $list_special_folders_first;
$list_special_folders_first = true;

/**
 * Are all your folders subfolders of INBOX (i.e. cyrus IMAP server).
 * If you are unsure, set it to false.
 */
global $default_sub_of_inbox;
$default_sub_of_inbox = true;

/**
 * Some IMAP daemons (UW) handle folders weird. They only allow a
 * folder to contain either messages or other folders, not both at
 * the same time. This option controls whether or not to display an
 * option during folder creation. The option toggles which type of
 * folder it should be.
 *
 * If this option confuses you, just set it to 'true'. You can not hurt 
 * anything if it's true, but some servers will respond weird if it's
 * false. (Cyrus works fine whether it's true OR false).
 */
global $show_contain_subfolders_option;
$show_contain_subfolders_option = false;

/**
 * This option controls what character set is used when sending mail
 * and when sending HTMl to the browser. Do not set this to US-ASCII,
 * use ISO-8859-1 instead. For cyrillic it is best to use KOI8-R,
 * since this implementation is faster than the alternatives.
 */
global $default_charset;
$default_charset = 'iso-8859-1';

/**
 * Path to the data/ directory
 *   It is a possible security hole to have a writable directory
 *   under the web server's root directory (ex: /home/httpd/html).
 *   For this reason, it is possible to put the data directory
 *   anywhere you would like. The path name can be absolute or
 *   relative (to the config directory). It doesn't matter. Here
 *   are two examples:
 *
 * Absolute:
 *   $data_dir = '/usr/local/squirrelmail/data/';
 *
 * Relative (to the config directory):
 *   $data_dir = SM_PATH . 'data/';
 */
global $data_dir;
$data_dir = SM_PATH . 'data/';

/**
 * Path to directory used for storing attachments while a mail is
 * being sent. There are a few security considerations regarding
 * this directory:
 *    + It should have the permission 733 (rwx-wx-wx) to make it
 *      impossible for a random person with access to the webserver to
 *      list files in this directory. Confidential data might be laying
 *      around there.
 *    + Since the webserver is not able to list the files in the content
 *       is also impossible for the webserver to delete files lying around 
 *       there for too long.
 *    + It should probably be another directory than data_dir.
 */
global $attachment_dir;
$attachment_dir = "$data_dir";

/* Hash level used for data directory. */
global $dir_hash_level;
$dir_hash_level = 0;

/**
 * This is the default size of the folder list. Default
 * is 150, but you can set it to whatever you wish.
 */
global $default_left_size;
$default_left_size = 150;

/**
 * Some IMAP servers allow a username (like 'bob') to log in if they use
 * uppercase in their name (like 'Bob' or 'BOB'). This creates extra
 * preference files.  Toggling this option to true will transparently
 * change all usernames to lowercase.
 */
global $force_username_lowercase;
$force_username_lowercase = false;

/**
 * Themes
 *   You can define your own theme and put it in this directory.
 *   You must call it as the example below. You can name the theme
 *   whatever you want. For an example of a theme, see the ones
 *   included in the config directory.
 *
 * To add a new theme to the options that users can choose from, just
 * add a new number to the array at the bottom, and follow the pattern.
 */

$theme_default = 0;

global $theme;

$theme[0]['PATH'] = SM_PATH . 'themes/default_theme.php';
$theme[0]['NAME'] = 'Default';

$theme[1]['PATH'] = SM_PATH . 'themes/plain_blue_theme.php';
$theme[1]['NAME'] = 'Plain Blue';

$theme[2]['PATH'] = SM_PATH . 'themes/sandstorm_theme.php';
$theme[2]['NAME'] = 'Sand Storm';

$theme[3]['PATH'] = SM_PATH . 'themes/deepocean_theme.php';
$theme[3]['NAME'] = 'Deep Ocean';

$theme[4]['PATH'] = SM_PATH . 'themes/slashdot_theme.php';
$theme[4]['NAME'] = 'Slashdot';

$theme[5]['PATH'] = SM_PATH . 'themes/purple_theme.php';
$theme[5]['NAME'] = 'Purple';

$theme[6]['PATH'] = SM_PATH . 'themes/forest_theme.php';
$theme[6]['NAME'] = 'Forest';

$theme[7]['PATH'] = SM_PATH . 'themes/ice_theme.php';
$theme[7]['NAME'] = 'Ice';

$theme[8]['PATH'] = SM_PATH . 'themes/seaspray_theme.php';
$theme[8]['NAME'] = 'Sea Spray';

$theme[9]['PATH'] = SM_PATH . 'themes/bluesteel_theme.php';
$theme[9]['NAME'] = 'Blue Steel';

$theme[10]['PATH'] = SM_PATH . 'themes/dark_grey_theme.php';
$theme[10]['NAME'] = 'Dark Grey';

$theme[11]['PATH'] = SM_PATH . 'themes/high_contrast_theme.php';
$theme[11]['NAME'] = 'High Contrast';

$theme[12]['PATH'] = SM_PATH . 'themes/black_bean_burrito_theme.php';
$theme[12]['NAME'] = 'Black Bean Burrito';

$theme[13]['PATH'] = SM_PATH . 'themes/servery_theme.php';
$theme[13]['NAME'] = 'Servery';

$theme[14]['PATH'] = SM_PATH . 'themes/maize_theme.php';
$theme[14]['NAME'] = 'Maize';

$theme[15]['PATH'] = SM_PATH . 'themes/bluesnews_theme.php';
$theme[15]['NAME'] = 'BluesNews';

$theme[16]['PATH'] = SM_PATH . 'themes/deepocean2_theme.php';
$theme[16]['NAME'] = 'Deep Ocean 2';

$theme[17]['PATH'] = SM_PATH . 'themes/blue_grey_theme.php';
$theme[17]['NAME'] = 'Blue Grey';

$theme[18]['PATH'] = SM_PATH . 'themes/dompie_theme.php';
$theme[18]['NAME'] = 'Dompie';

$theme[19]['PATH'] = SM_PATH . 'themes/methodical_theme.php';
$theme[19]['NAME'] = 'Methodical';

$theme[20]['PATH'] = SM_PATH . 'themes/greenhouse_effect.php';
$theme[20]['NAME'] = 'Greenhouse Effect (Changes)';

$theme[21]['PATH'] = SM_PATH . 'themes/in_the_pink.php';
$theme[21]['NAME'] = 'In The Pink (Changes)';

$theme[22]['PATH'] = SM_PATH . 'themes/kind_of_blue.php';
$theme[22]['NAME'] = 'Kind of Blue (Changes)';

$theme[23]['PATH'] = SM_PATH . 'themes/monostochastic.php';
$theme[23]['NAME'] = 'Monostochastic (Changes)';

$theme[24]['PATH'] = SM_PATH . 'themes/shades_of_grey.php';
$theme[24]['NAME'] = 'Shades of Grey (Changes)';

$theme[25]['PATH'] = SM_PATH . 'themes/spice_of_life.php';
$theme[25]['NAME'] = 'Spice of Life (Changes)';

$theme[26]['PATH'] = SM_PATH . 'themes/spice_of_life_lite.php';
$theme[26]['NAME'] = 'Spice of Life - Lite (Changes)';

$theme[27]['PATH'] = SM_PATH . 'themes/spice_of_life_dark.php';
$theme[27]['NAME'] = 'Spice of Life - Dark (Changes)';

$theme[28]['PATH'] = SM_PATH . 'themes/christmas.php';
$theme[28]['NAME'] = 'Holiday - Christmas';

$theme[29]['PATH'] = SM_PATH . 'themes/darkness.php';
$theme[29]['NAME'] = 'Darkness (Changes)';

$theme[30]['PATH'] = SM_PATH . 'themes/random.php';
$theme[30]['NAME'] = 'Random (Changes every login)';

$theme[31]['PATH'] = SM_PATH . 'themes/midnight.php';
$theme[31]['NAME'] = 'Midnight';

$theme[32]['PATH'] = SM_PATH . 'themes/alien_glow.php';
$theme[32]['NAME'] = 'Alien Glow';

$theme[33]['PATH'] = SM_PATH . 'themes/dark_green.php';
$theme[33]['NAME'] = 'Dark Green';

$theme[34]['PATH'] = SM_PATH . 'themes/penguin.php';
$theme[34]['NAME'] = 'Penguin';

$theme[35]['PATH'] = SM_PATH . 'themes/minimal_bw.php';
$theme[35]['NAME'] = 'Minimal BW';

/**
 * LDAP server(s)
 *   Array of arrays with LDAP server parameters. See
 *   functions/abook_ldap_server.php for a list of possible
 *   parameters
 *
 * EXAMPLE:
 *   $ldap_server[0] = Array(
 *       'host' => 'memberdir.netscape.com',
 *       'name' => 'Netcenter Member Directory',
 *       'base' => 'ou=member_directory,o=netcenter.com'
 *   ); 
 */
global $ldap_server;

/**
 * Database-driven private addressbooks
 *   DSN (Data Source Name) for a database where the private
 *   addressbooks are stored.  See doc/db-backend.txt for more info.
 *   If it is not set, the addressbooks are stored in files
 *   in the data dir.
 *   The DSN is in the format: mysql://user:pass@hostname/dbname
 *   The table is the name of the table to use within the
 *   specified database.
 */
global $addrbook_dsn, $addrbook_table;
$addrbook_dsn = '';
$addrbook_table = 'address';

global $prefs_dsn, $prefs_table;
$prefs_dsn = '';
$prefs_table = 'userprefs';

/**
 * Users may search their addressbook via either a plain HTML or Javascript
 * enhanced user interface. This option allows you to set the default choice.
 * Set this default choice as either:
 *    true  = javascript
 *    false = html
 */
global $default_use_javascript_addr_book;
$default_use_javascript_addr_book = false;

/**
 * These next two options set the defaults for the way that the
 * users see their folder list.
 *   $default_unseen_notify
 *       Specifies whether or not the users will see the number of 
 *       unseen in each folder by default and also which folders to
 *       do this to. Valid values are: 1=none, 2=inbox, 3=all.
 *   $default_unseen_type
 *       Specifies the type of notification to give the users by
 *       default. Valid choice are: 1=(4), 2=(4,25).
 */
global $default_unseen_notify, $default_unseen_type;
$default_unseen_notify = 2;
$default_unseen_type   = 1;
 
/**
 * If you are running on a machine that doesn't have the tm_gmtoff
 * value in your time structure and if you are in a time zone that
 * has a negative offset, you need to set this value to 1. This is
 * typically people in the US that are running Solaris 7.
 */
global $invert_time;
$invert_time = false;

/**
 * By default SquirrelMail takes up the whole browser window,
 * this allows you to embed it within sites using frames. Set
 * this to the frame you want it to stay in.
 */

global $frame_top;
$frame_top = '_top';

global $plugins;
/**
 * To install plugins, just add elements to this array that have
 * the plugin directory name relative to the /plugins/ directory.
 * For instance, for the 'sqclock' plugin, you'd put a line like
 * the following.
 *    $plugins[0] = 'sqclock';
 *    $plugins[1] = 'attachment_common';
 */

/**
 * If you don't want to allow users to change their email address
 * then you can set $edit_identity to false, if you want them to
 * not be able to change their full name too then set $edit_name
 * to false as well. $edit_name has no effect unless $edit_identity
 * is false;
 */

global $edit_identity, $edit_name;
$edit_identity = true;
$edit_name = true;


/**
 * If you want to enable server side thread sorting options
 * Your IMAP server must support the THREAD extension for 
 * this to work.
 */

global $allow_thread_sort;
$allow_thread_sort = false;

/** 
 * to use server-side sorting instead of SM client side.
 * Your IMAP server must support the SORT extension for this
 * to work.
 */

global $allow_server_sort;
$allow_server_sort = false;

/**
 * This enables the no select fix for Cyrus when subfolders
 * exist but parent folders do not
 */

global $noselect_fix_enable;
$noselect_fix_enable = false;

/**
 * this disables listing all of the folders on the IMAP Server to
 * generate the folder subscribe listbox (this can take a long time
 * when you have a lot of folders).  Instead, a textbox will be
 * displayed allowing users to enter a specific folder name to subscribe to */
global $no_list_for_subscribe;
$no_list_for_subscribe = false;

/**
 * Advanced authentication options
 * CRAM-MD5, DIGEST-MD5, Plain, and TLS
 * Set reasonable defaults - you'd never know this was there unless you ask for it
 */
global $use_imap_tls;
global $use_smtp_tls;
$use_imap_tls = false;
$use_smtp_tls = false;

/* auth_mech can be either 'login','plain', 'cram-md5', or 'digest-md5'
   SMTP can also be 'none'
*/
global $smtp_auth_mech;
global $imap_auth_mech;
$smtp_auth_mech = 'none';
$imap_auth_mech = 'login';

/* PHP session name.  Leave this alone unless you know what you are doing. */
global $session_name;
$session_name = 'SQMSESSID';
