<?php
/**
* english.php joomlaboard language file
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Jan de Graaff
* Joomla! is Free Software
**/
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//removed in 1.1.4 stable
/* 
_POST_HTML_ENABLED,_BACK_TO_FORUM,_RESULTS_CATEGORY,_RESULTS_FORUM_NAME,_RESULTS_CONTENT,
_RESULTS_TITLE,_SEARCH_HITS,_SEARCH_RESULTS,_DESCRIPTION_BOLD,_DESCRIPTION_ITALIC,_DESCRIPTION_U,
_DESCRIPTION_QUOTE,_DESCRIPTION_URL,_DESCRIPTION_CODE,_DESCRIPTION_IMAGE,_DESCRIPTION_LIST,_DESCRIPTION_SIZE
_DESCRIPTION_RED,_DESCRIPTION_BLUE,_DESCRIPTION_GREEN,_DESCRIPTION_YELLOW,_DESCRIPTION_ORANGE,
_DESCRIPTION_PURPLE,_DESCRIPTION_NAVY,_DESCRIPTION_DARKGREEN,_DESCRIPTION_AQUA,_DESCRIPTION_MAGENTA,
_HTML_NO,_POST_FORUM,_POST_NO_PUBACCES1_,_USAGE_BOARDCODE,_USAGE_INSTRUCTIONS,_USAGE_MYPROFILE,
_USAGE_PREVIOUS,_USAGE_TEXT,_USAGE_TEXT_BOLD,_USAGE_TEXT_ITALIC,_USAGE_TEXT_QUOTE,_USAGE_TEXT_UNDERLINE,
_USAGE_TEXT_WILL,_VIEW_LOCKED,_VIEW_EDITOR,_SEARCH_HEADER,_POST_TO_VIEW,_POST_POSTED,_POST_BOARDCODE,
_POST_BBCODE_HELP,_POST_ERROR_EXIT,_POST_EDIT_MESSAGE,_MODERATION_DELETE_REPLIES,_MODERATION_DELETE_POST,
_MODERATION_ERROR_MESSAGE,_SEARCH_ON_USER,_SEARCH_OTHER_OPTIONS,_FORUM_USERSEARCH,_RESULTS_USERNAME,
_UPLOAD_UPDATED,_GEN_TODAYS_POSTS,_GEN_UNANSWERED,_GEN_USAGE,_GEN_VIEWS,_GEN_STARTED,_GEN_POST_A_PROFILE,
_GEN_MY_PROFILE,_GEN_NEW,_GEN_NO_NEW,_GEN_NO_ACCESS,_GEN_POSTS,_GEN_POSTS_DISPLAY,_GEN_CATEGORY,
_GEN_EDIT_MESSAGE,_COM_A_HEADER,_COM_A_HEADER_DESC,_COM_A_CONFIG_DESC,_FILE_INSERT,_FILE_COPY_PASTE,
_FILE_BUTTON,_FILE_UPLOAD,_FILE_SUBMIT,_FILE_ERROR_NAME,_FILE_ERROR_EXISTS,_FILE_UPLOADED,_FILE_UPDATED,
_IMAGE_SUBMIT,_IMAGE_ERROR_NAME,_IMAGE_UPDATED,_IMAGE_COPY_PASTE,_COM_A_IMAGES,_IMAGE_INSERT,_IMAGE_BUTTON,
_IMAGE_ERROR_EXISTS,_COM_A_FILES,_GEN_SUBSCRIPTIONS,_POST_SUCCESS_THREAD_VIEW,_COM_C_BOARDSTATS
*/

// changed in 1.1.5

// added in joomlaboard 1.1.5
DEFINE('_GEN_CATEGORY','Category');
DEFINE('_GEN_STARTEDBY','Started by: ');
DEFINE('_GEN_STATS','stats');
DEFINE('_STATS_TITLE',' forum - stats');
DEFINE('_STATS_GEN_STATS','General stats');
DEFINE('_STATS_TOTAL_MEMBERS','Members:');
DEFINE('_STATS_TOTAL_REPLIES','Replies:');
DEFINE('_STATS_TOTAL_TOPICS','Topics:');
DEFINE('_STATS_TODAY_TOPICS','Topics today:');
DEFINE('_STATS_TODAY_REPLIES','Replies today:');
DEFINE('_STATS_TOTAL_CATEGORIES','Categories:');
DEFINE('_STATS_TOTAL_SECTIONS','Sections:');
DEFINE('_STATS_LATEST_MEMBER','Latest member:');
DEFINE('_STATS_YESTERDAY_TOPICS','Topics yesterday:');
DEFINE('_STATS_YESTERDAY_REPLIES','Replies yesterday:');
DEFINE('_STATS_POPULAR_PROFILE','Popular 10 Members (Profile hits)');
DEFINE('_STATS_TOP_POSTERS','Top posters');
DEFINE('_STATS_POPULAR_TOPICS','Top popular topics');
DEFINE('_COM_A_STATSPAGE','Enable Stats Page');
DEFINE('_COM_A_STATSPAGE_DESC','If set to &quot;Yes&quot; a public link in the header menu will be shown to your forum Stats page. This page will display various statistics about your forum. <em>Stats page will be always available to admin regardless of this setting!</em>');
DEFINE('_COM_C_JBSTATS','Forum Stats');
DEFINE('_COM_C_JBSTATS_DESC','Forum Statistics');
define('_GEN_GENERAL','General');
define('_PERM_NO_READ','You do not have sufficient permissions to access this forum.');
//changed in 1.1.4 stable
DEFINE('_COM_A_PMS_TITLE','Private messaging component');
DEFINE('_COM_A_COMBUILDER_TITLE','Community Builder');
DEFINE('_FORUM_SEARCH','Searched for: %s');
DEFINE('_MODERATION_DELETE_MESSAGE','Are you sure you want to delete this message? \n\n NOTE: There is NO way to retrieve deleted messages!');
DEFINE('_MODERATION_DELETE_SUCCESS','The post(s) have been deleted');
DEFINE('_COM_A_SB_BY','Joomla! Forum Component by');
DEFINE('_COM_A_RANKING','Ranking');
DEFINE('_COM_A_BOT_REFERENCE','Show Bot Reference Chart');
DEFINE('_COM_A_MOSBOT','Enable the Discuss Bot');
DEFINE('_PREVIEW','preview');
DEFINE('_COM_C_UPGRADE','Upgrade Database To: ');
DEFINE('_COM_A_MOSBOT_TITLE','Discussbot');
DEFINE('_COM_A_MOSBOT_DESC',
 'The Discuss Bot enables your users to discuss content items in the forums. The Content Title is used as the topic subject.'
.'<br />If a topic does not exist yet a new one is created. If the topic already exists, the user is shown the thread and (s)he can reply.'
.'<br /><strong>You will need to download and install the Bot separately.</strong>'
.'<br />check the <a href="http://www.tsmf.net">TSMF Site</a> for more information.'
.'<br />When Installed you will need to add the following bot lines to your Content:'
.'<br />{mos_sb_discuss:<em>catid</em>}'
.'<br />The <em>catid</em> is the category in which the Content Item can be discussed. To find the proper catid, just look into the forums '
.'and check the category id from the URLs from your browsers status bar.'
.'<br />Example: if you want the article discussed in Forum with catid 26, the Bot should look like: {mos_sb_discuss:26}'
.'<br />This seems a bit difficult, but it does allow you to have each Content Item to be discussed in a matching forum.' );

//new in 1.1.4 stable
// search.class.php
DEFINE('_FORUM_SEARCHTITLE','Search');
DEFINE('_FORUM_SEARCHRESULTS','displaying %s out of %s results.');

// rules.php
DEFINE('_COM_FORUM_RULES','<h3 class="contentheading">Forum Rules</h3><ul><li>Edit this file to insert your rules joomlaroot/administrator/components/com_joomlaboard/language/english.php</li><li>Rule 2</li><li>Rule 3</li><li>Rule 4</li><li>...</li></ul>');

//smile.class.php
DEFINE('_COM_BOARDCODE','Boardcode');

// moderate_messages.php
DEFINE('_MODERATION_APPROVE_SUCCESS','The post(s) have been approved');
DEFINE('_MODERATION_DELETE_ERROR','ERROR: The post(s) could not be deleted');
DEFINE('_MODERATION_APPROVE_ERROR','ERROR: The post(s) could not be approved');

// listcat.php
DEFINE('_GEN_NOFORUMS','There are no forums in this category!');

//new in 1.1.3 stable
DEFINE('_POST_GHOST_FAILED','Failed to create ghost topic in old forum!');
DEFINE('_POST_MOVE_GHOST','Leave ghost message in old forum');

//new in 1.1 Stable
DEFINE('_GEN_FORUM_JUMP','Forum Jump');
DEFINE('_COM_A_FORUM_JUMP','Enable Forum Jump');
DEFINE('_COM_A_FORUM_JUMP_DESC','If set to &quot;Yes&quot; a selector will be shown on the forum pages that allow for a quick jump to another forum or category.');
//new in 1.1 RC1
DEFINE('_GEN_RULES','rules');
DEFINE('_COM_A_RULESPAGE','Enable Rules Page');
DEFINE('_COM_A_RULESPAGE_DESC','If set to &quot;Yes&quot; a link in the header menu will be shown to your Rules page. This page can be used for things like your forum rules etcetera. You can alter the contents of this file to your liking by opening the rules.php in /joomla_root/components/com_joomlaboard. <em>Make sure you always have a backup of this file as it will be overwritten when upgrading!</em>');
DEFINE('_MOVED_TOPIC','MOVED:');
DEFINE('_COM_A_PDF','Enable PDF creation');
DEFINE('_COM_A_PDF_DESC','Set to &quot;Yes&quot; if you would like to enable users to download a simple PDF document with the contents of a thread.<br />It is a <u>simple</u> PDF document; no mark up, no fancy layout and such but it does contain all the text from the thread.');
DEFINE('_GEN_PDFA','Click this button to create a PDF document from this thread (opens in a new window).');
DEFINE('_GEN_PDF', 'PDF');
//new in 1.0.4 stable
DEFINE('_VIEW_PROFILE','Click here to see the profile of this user');
DEFINE('_VIEW_ADDBUDDY','Click here to add this user to your buddy list');
DEFINE('_POST_SUCCESS_POSTED','Your message has been successfully posted');
DEFINE('_POST_SUCCESS_VIEW','[ Return to the post ]');
DEFINE('_POST_SUCCESS_FORUM','[ Return to the forum ]');
DEFINE('_RANK_ADMINISTRATOR','Admin');
DEFINE('_RANK_MODERATOR','Moderator');
DEFINE('_SHOW_LASTVISIT','Since last visit');
DEFINE('_COM_A_BADWORDS_TITLE','Bad Words filtering');
DEFINE('_COM_A_BADWORDS','Use bad words filtering');
DEFINE('_COM_A_BADWORDS_DESC','Set to &quot;Yes&quot; if you want to filter posts containing the words you defined in the Badword Component config. To use this function you must have Badword Component installed!');
DEFINE('_COM_A_BADWORDS_NOTICE','* This message has been censored because it contained one or more words set by the administrator *');
DEFINE('_COM_A_COMBUILDER_PROFILE','Create Community Builder forum profile');
DEFINE('_COM_A_COMBUILDER_PROFILE_DESC','Click the link to create necessary Forum fields in Community Builder user profile. After they are created you are free to move them wherever you want using the Community Builder admin, just do not rename their names or options. If you delete them from the Community Builder admin, you can create them again using this link. Subsequent use of this option <em>will reset all the user forum settings</em>.');
DEFINE('_COM_A_COMBUILDER_PROFILE_CLICK','> Click here <');
DEFINE('_COM_A_COMBUILDER','Community Builder user profiles');
DEFINE('_COM_A_COMBUILDER_DESC','Setting to &quot;Yes&quot; will activate the integration with Community Builder component (www.joomlapolis.com). All Joomlaboard user profile functions will be handled by the Community Builder and the profile link in the forums will take you to the Community Builder user profile. This setting will override the Clexus PMS profile setting if both are set to &quot;Yes&quot;. Also, make sure you apply the required changes in the Community Builder database by using the option below.');
DEFINE('_COM_A_AVATAR_SRC','Use avatar picture from');
DEFINE('_COM_A_AVATAR_SRC_DESC','If you have Clexus PMS or Community Builder component installed, you can configure Joomlaboard to use the user avatar picture from Clexus PMS or Community Builder user profile. NOTE: For Community Builder you need to have thumbnail option turned on because forum uses thumbnail user pictures, not the originals.');
DEFINE('_COM_A_KARMA','Show Karma indicator');
DEFINE('_COM_A_KARMA_DESC','Set to &quot;Yes&quot; to show user Karma and related buttons (increase / decrease) if the User Stats are activated.');
DEFINE('_COM_A_DISEMOTICONS','Disable emoticons');
DEFINE('_COM_A_DISEMOTICONS_DESC','Set to &quot;Yes&quot; to completely disable graphic emoticons (smileys).');
DEFINE('_COM_C_SBCONFIG','Joomlaboard<br/>Configuration');
DEFINE('_COM_C_SBCONFIGDESC','Configure all Joomlaboard\'s functionality');
DEFINE('_COM_C_FORUM','Forum<br/>Administration');
DEFINE('_COM_C_FORUMDESC','Add categories/forums and configure them');
DEFINE('_COM_C_USER','User<br/>Administration');
DEFINE('_COM_C_USERDESC','Basic user and user profile administration');
DEFINE('_COM_C_FILES','Uploaded<br/>Files Browser');
DEFINE('_COM_C_FILESDESC','Browse and administer uploaded files');
DEFINE('_COM_C_IMAGES','Uploaded<br/>Images Browser');
DEFINE('_COM_C_IMAGESDESC','Browse and administer uploaded images');
DEFINE('_COM_C_CSS','Edit<br/>CSS File');
DEFINE('_COM_C_CSSDESC','Tweak Joomlaboard\'s look and feel');
DEFINE('_COM_C_SUPPORT','Support<br/>WebSite');
DEFINE('_COM_C_SUPPORTDESC','Connect to the TSMF website (new window)');
DEFINE('_COM_C_PRUNETAB','Prune<br/>Forums');
DEFINE('_COM_C_PRUNETABDESC','Remove old threads (configurable)');
DEFINE('_COM_C_PRUNEUSERS','Prune<br/>Users');
DEFINE('_COM_C_PRUNEUSERSDESC','Sync Joomlaboard user table with Joomla! user table');
DEFINE('_COM_C_LOADSAMPLE','Load<br/>Sample Data');
DEFINE('_COM_C_LOADSAMPLEDESC','For an easy start: load the Sample Data on an empty Joomlaboard database');
DEFINE('_COM_C_UPGRADEDESC','Get your database up to the latest version after an upgrade');
DEFINE('_COM_C_BACK','Back to Joomlaboard Control Panel');
DEFINE('_SHOW_LAST_SINCE','Active topics since last visit on:');
DEFINE('_POST_SUCCESS_REQUEST2','Your request has been processed');
DEFINE('_POST_NO_PUBACCESS3','Click here to register.');
//==================================================================================================
//Changed in 1.0.4
//please update your local language file with these changes as well
DEFINE('_POST_SUCCESS_DELETE','The message has been successfully deleted.');
DEFINE('_POST_SUCCESS_EDIT','The message has been successfully edited.');
DEFINE('_POST_SUCCESS_MOVE','The Topic has been succesfully moved.');
DEFINE('_POST_SUCCESS_POST','Your message has been successfully posted.');
DEFINE('_POST_SUCCESS_SUBSCRIBE','Your subscription has been processed.');
//==================================================================================================
//new in 1.0.3 stable
//Karma
DEFINE('_KARMA','Karma');
DEFINE('_KARMA_SMITE','Smite');
DEFINE('_KARMA_APPLAUD','Applaud');
DEFINE('_KARMA_BACK','To get back to the topic,');
DEFINE('_KARMA_WAIT','You can modify only one person\'s karma every 6 hours. <br/>Please wait untill this timeout period has passed before modifying any person\'s karma again.');
DEFINE('_KARMA_SELF_DECREASE','Please do not attempt to decrease your own karma!');
DEFINE('_KARMA_SELF_INCREASE','Your karma has been decreased for attempting to increase it yourself!');
DEFINE('_KARMA_DECREASED','User\'s karma decreased. If you are not taken back to the topic in a few moments,');
DEFINE('_KARMA_INCREASED','User\'s karma increased. If you are not taken back to the topic in a few moments,');
DEFINE('_COM_A_TEMPLATE','Template');
DEFINE('_COM_A_TEMPLATE_DESC','Choose the template to use.');
DEFINE('_PREVIEW_CLOSE','Close this window');
//==========================================
//new in 1.0 Stable
DEFINE('_GEN_PATHWAY','Boardwalk :: ');
DEFINE('_COM_A_POSTSTATSBAR','Use Posts Statistics Bar');
DEFINE('_COM_A_POSTSTATSBAR_DESC','Set to &quot;Yes&quot; if you want the number of posts a user has made to be depicted graphically by a Statistics Bar.');
DEFINE('_COM_A_POSTSTATSCOLOR','Color number for Stats Bar');
DEFINE('_COM_A_POSTSTATSCOLOR_DESC','Give the number of the color you want to use for the Post Stats Bar');
DEFINE('_LATEST_REDIRECT','Joomlaboard needs to (re)establish your access privileges before it can create a list of the latest posts for you.\nDo not worry, this is quite normal after more than 30 minutes of inactivity or after logging back in.\nPlease submit your search request again.');
DEFINE('_SMILE_COLOUR','Colour');
DEFINE('_SMILE_SIZE','Size');
DEFINE('_COLOUR_DEFAULT','Standard');
DEFINE('_COLOUR_RED','Red');
DEFINE('_COLOUR_PURPLE','Purple');
DEFINE('_COLOUR_BLUE','Blue');
DEFINE('_COLOUR_GREEN','Green');
DEFINE('_COLOUR_YELLOW','Yellow');
DEFINE('_COLOUR_ORANGE','Orange');
DEFINE('_COLOUR_DARKBLUE','Darkblue');
DEFINE('_COLOUR_BROWN','Brown');
DEFINE('_COLOUR_GOLD','Gold');
DEFINE('_COLOUR_SILVER','Silver');
DEFINE('_SIZE_NORMAL','Normal');
DEFINE('_SIZE_SMALL','Small');
DEFINE('_SIZE_VSMALL','Very Small');
DEFINE('_SIZE_BIG','Big');
DEFINE('_SIZE_VBIG','Very Big');
DEFINE('_IMAGE_SELECT_FILE','Select Image file to attach');
DEFINE('_FILE_SELECT_FILE','Select file to attach');
DEFINE('_FILE_NOT_UPLOADED','Your file has not been uploaded. Try posting again or editing the post');
DEFINE('_IMAGE_NOT_UPLOADED','Your image has not been uploaded. Try posting again or editing the post');
DEFINE('_BBCODE_IMGPH','Insert [img] placeholder in the post for attached image');
DEFINE('_BBCODE_FILEPH','Insert [file] placeholder in the post for attached file');
DEFINE('_POST_ATTACH_IMAGE','[img]');
DEFINE('_POST_ATTACH_FILE','[file]');
DEFINE('_USER_UNSUBSCRIBE_ALL','Check this box to unsubscribe from all topics (including invisible ones for troubleshooting purposes)');
DEFINE('_LINK_JS_REMOVED','<em>Active link containing JavaScript has been removed automatically</em>');
//==========================================
//new in 1.0 RC4
DEFINE('_COM_A_LOOKS','Look and Feel');
DEFINE('_COM_A_USERS','User Related');
DEFINE('_COM_A_LENGTHS','Various length settings');
DEFINE('_COM_A_SUBJECTLENGTH','Max. Subject length');
DEFINE('_COM_A_SUBJECTLENGTH_DESC','Maximum Subject line length. The maximum number supported by the database is 255 characters. If your site is configured to use multi-byte character sets like Unicode, UTF-8 or non-ISO-8599-x make the maximum smaller using this forumula:<br/><tt>round_down(255/(maximum character set byte size per character))</tt><br/> Example for UTF-8, for which the max. character bite syze per character is 4 bytes: 255/4=63.');
DEFINE('_LATEST_THREADFORUM','Topic/Forum');
DEFINE('_LATEST_NUMBER','New posts');
DEFINE('_COM_A_SHOWNEW','Show New posts');
DEFINE('_COM_A_SHOWNEW_DESC','If set to &quot;Yes&quot; Joomlaboard will show the user an indicator for forums that contain new posts and which posts are new since his/her last visit.');
DEFINE('_COM_A_NEWCHAR','&quot;New&quot; indicator');
DEFINE('_COM_A_NEWCHAR_DESC','Define here what should be used to indicate new posts (like an &quot;!&quot; or &quot;New!&quot;)');
DEFINE('_LATEST_AUTHOR','Latest post author');
DEFINE('_GEN_FORUM_NEWPOST','Indicates there are new posts in this forum since your last visit');
DEFINE('_GEN_FORUM_NOTNEW','No new posts since your last visit');
DEFINE('_GEN_UNREAD','Indicates that there are new, unread replies in this topic since your last visit');
DEFINE('_GEN_NOUNREAD','No new, unread replies in this topic since your last visit');
DEFINE('_GEN_MARK_ALL_FORUMS_READ','Mark all forums read');
DEFINE('_GEN_MARK_THIS_FORUM_READ','Mark this forum read');
DEFINE('_GEN_FORUM_MARKED','All posts in this forum have been marked as read');
DEFINE('_GEN_ALL_MARKED','All posts have been marked as read');
DEFINE('_IMAGE_UPLOAD','Image Upload');
DEFINE('_IMAGE_DIMENSIONS','Your image file can be maximum (width x height - size)');
DEFINE('_IMAGE_ERROR_TYPE','Please use only jpeg, gif or png images');
DEFINE('_IMAGE_ERROR_EMPTY','Please select a file before uploading');
DEFINE('_IMAGE_ERROR_SIZE','The image file size exceeds the maximum set by the Administrator.');
DEFINE('_IMAGE_ERROR_WIDTH','The image file width exceeds the maximum set by the Administrator.');
DEFINE('_IMAGE_ERROR_HEIGHT','The image file height exceeds the maximum set by the Administrator.');
DEFINE('_IMAGE_UPLOADED','Your Image has been uploaded.');
DEFINE('_COM_A_IMAGE','Images');
DEFINE('_COM_A_IMGHEIGHT','Max. Image Height');
DEFINE('_COM_A_IMGWIDTH','Max. Image Width');
DEFINE('_COM_A_IMGSIZE','Max. Image Filesize<br/><em>in Kilobytes</em>');
DEFINE('_COM_A_IMAGEUPLOAD','Allow Public Upload for Images');
DEFINE('_COM_A_IMAGEUPLOAD_DESC','Set to &quot;Yes&quot; if you want everybody (public) to be able to upload an image.');
DEFINE('_COM_A_IMAGEREGUPLOAD','Allow Registered Upload for Images');
DEFINE('_COM_A_IMAGEREGUPLOAD_DESC','Set to &quot;Yes&quot; if you want registered and logged in users to be able to upload an image.<br/> Note: (Super)administrators and moderators are always able to upload images.');
  //New since preRC4-II:
DEFINE('_COM_A_UPLOADS','Uploads');
DEFINE('_FILE_TYPES','Your file can be of type - max. size');
DEFINE('_FILE_ERROR_TYPE','You are only allowed to upload files of type:\n');
DEFINE('_FILE_ERROR_EMPTY','Please select a file before uploading');
DEFINE('_FILE_ERROR_SIZE','The file size exceeds the maximum set by the Administrator.');
DEFINE('_COM_A_FILE','Files');
DEFINE('_COM_A_FILEALLOWEDTYPES','File types allowed');
DEFINE('_COM_A_FILEALLOWEDTYPES_DESC','Specify here which file types are allowed for upload. Use comma separated <strong>lowercase</strong> lists without spaces.<br />Example: zip,txt,exe,htm,html');
DEFINE('_COM_A_FILESIZE','Max. File size<br/><em>in Kilobytes</em>');
DEFINE('_COM_A_FILEUPLOAD','Allow File Upload for Public');
DEFINE('_COM_A_FILEUPLOAD_DESC','Set to &quot;Yes&quot; if you want everybody (public) to be able to upload a file.');
DEFINE('_COM_A_FILEREGUPLOAD','Allow File Upload for Registered');
DEFINE('_COM_A_FILEREGUPLOAD_DESC','Set to &quot;Yes&quot; if you want registered and logged in users to be able to upload a file.<br/> Note: (Super)administrators and moderators are always able to upload files.');
DEFINE('_SUBMIT_CANCEL','Your post submission has been cancelled');
DEFINE('_HELP_SUBMIT','Click here to submit your message');
DEFINE('_HELP_PREVIEW','Click here to see what your message will look like when submitted');
DEFINE('_HELP_CANCEL','Click here to cancel your message');
DEFINE('_POST_DELETE_ATT','If this box is checked, all image and file attachments of posts you are going to delete will be deleted as well (recommended).');
   //new since preRC4-III
DEFINE('_COM_A_USER_MARKUP','Show Edited Mark Up');
DEFINE('_COM_A_USER_MARKUP_DESC','Set to &quot;Yes&quot; if you want an edited post be marked up with text showing that the post is edited by a user and when it was edited.');
DEFINE('_EDIT_BY','Post edited by:');
DEFINE('_EDIT_AT','at:');
DEFINE('_UPLOAD_ERROR_GENERAL','An error occured when uploading your Avatar. Please try again or notify your system administrator');
DEFINE('_COM_A_IMGB_IMG_BROWSE','Uploaded Images Browser');
DEFINE('_COM_A_IMGB_FILE_BROWSE','Uploaded Files Browser');
DEFINE('_COM_A_IMGB_TOTAL_IMG','Number of uploaded images');
DEFINE('_COM_A_IMGB_TOTAL_FILES','Number of uploaded files');
DEFINE('_COM_A_IMGB_ENLARGE','Click the image to see its full size');
DEFINE('_COM_A_IMGB_DOWNLOAD','Click the file image to download it');
DEFINE('_COM_A_IMGB_DUMMY_DESC','The option &quot;Replace with dummy&quot; will replace the selected image with a dummy image.<br /> This allows you to remove the actual file without breaking the post.<br /><small><em>Please note that sometimes an explicit browser refresh is needed to see the dummy replacement.</em></small>');
DEFINE('_COM_A_IMGB_DUMMY','Current dummy image');
DEFINE('_COM_A_IMGB_REPLACE','Replace with dummy');
DEFINE('_COM_A_IMGB_REMOVE','Remove entirely');
DEFINE('_COM_A_IMGB_NAME','Name');
DEFINE('_COM_A_IMGB_SIZE','Size');
DEFINE('_COM_A_IMGB_DIMS','Dimensions');
DEFINE('_COM_A_IMGB_CONFIRM','Are you absolutely sure you want to delete this file? \n Deleting a file, will give a crippled referencing post...');
DEFINE('_COM_A_IMGB_VIEW','Open post (to edit)');
DEFINE('_COM_A_IMGB_NO_POST','No referencing post!');
DEFINE('_USER_CHANGE_VIEW','Changes in these settings will become effective the next time you visit the forums.<br /> If you want to change the view type &quot;Mid-Flight&quot; you can use the options from the forum menu bar.');
DEFINE('_MOSBOT_DISCUSS_A','Discuss this article on the forums. (');
DEFINE('_MOSBOT_DISCUSS_B',' posts)');
DEFINE('_POST_DISCUSS','This thread discusses the Content article');
DEFINE('_COM_A_RSS','Enable RSS feed');
DEFINE('_COM_A_RSS_DESC','The RSS feed enables users to download the latest posts to their desktop/RSS Reader aplication (see <a href="http://www.rssreader.com" target="_blank">rssreader.com</a> for an example.');
DEFINE('_LISTCAT_RSS','get the latest posts directly to your desktop');
DEFINE('_SEARCH_REDIRECT','Joomlaboard needs to (re)establish your access privileges before it can perform your search request.\nDo not worry, this is quite normal after more than 30 minutes of inactivity.\nPlease submit your search request again.');

//====================
//admin.forum.html.php
DEFINE('_COM_A_CONFIG','Configuration');
DEFINE('_COM_A_VERSION','Your version is ');
DEFINE('_COM_A_DISPLAY','Display #');
DEFINE('_COM_A_CURRENT_SETTINGS','Current Setting');
DEFINE('_COM_A_EXPLANATION','Explanation');
DEFINE('_COM_A_BOARD_TITLE','Board Title');
DEFINE('_COM_A_BOARD_TITLE_DESC','The name of your board');
DEFINE('_COM_A_VIEW_TYPE','Default View type');
DEFINE('_COM_A_VIEW_TYPE_DESC','Choose between a threaded or flat view as default');
DEFINE('_COM_A_THREADS','Threads Per Page');
DEFINE('_COM_A_THREADS_DESC','Number of threads per page to show');
DEFINE('_COM_A_REGISTERED_ONLY','Registered Users Only');
DEFINE('_COM_A_REG_ONLY_DESC','Set to &quot;Yes&quot; to allow only registered users to use the Forum (view & post), Set to &quot;No&quot; to allow any visitor to use the Forum');
DEFINE('_COM_A_PUBWRITE','Public Read/Write');
DEFINE('_COM_A_PUBWRITE_DESC','Set to &quot;Yes&quot; to allow for public write privileges, Set to &quot;No&quot; to allow any visitor to see posts, but only registered users to write posts');
DEFINE('_COM_A_USER_EDIT','User Edits');
DEFINE('_COM_A_USER_EDIT_DESC','Set to &quot;Yes&quot; to allow registered Users to edit their own posts.');
DEFINE('_COM_A_MESSAGE','In order to save changes of the values above, press the &quot;Save&quot; button at the top.');
DEFINE('_COM_A_HISTORY','Show History');
DEFINE('_COM_A_HISTORY_DESC','Set to &quot;Yes&quot; if you want the topic history shown when a reply/quote is made');
DEFINE('_COM_A_SUBSCRIPTIONS','Allow Subscriptions');
DEFINE('_COM_A_SUBSCRIPTIONS_DESC','Set to &quot;Yes&quot; if you want to allow registered users to subscribe to a topic and recieve email notifications on new posts');
DEFINE('_COM_A_HISTLIM','History Limit');
DEFINE('_COM_A_HISTLIM_DESC','Number of posts to show in the history');
DEFINE('_COM_A_FLOOD','Flood Protection');
DEFINE('_COM_A_FLOOD_DESC','The amount of seconds a user has to wait between two consecutive post. Set to 0 (zero) to turn Flood Protection off. NOTE: Flood Protection <em>can</em> cause degradation of performance..');
DEFINE('_COM_A_MODERATION','Email Moderators');
DEFINE('_COM_A_MODERATION_DESC','Set to &quot;Yes&quot; if you want email notifications on new posts sent to the forum moderator(s). Note: although every (super)administrator has automatically all Moderator privileges assign them explicitly as moderators on
 the forum to recieve emails too!');
DEFINE('_COM_A_SHOWMAIL','Show Email');
DEFINE('_COM_A_SHOWMAIL_DESC','Set to &quot;No&quot; if you never want to display the users email address; not even to registered users.');
DEFINE('_COM_A_AVATAR','Allow Avatars');
DEFINE('_COM_A_AVATAR_DESC','Set to &quot;Yes&quot; if you want registered users to have an avatar (manageable trough their profile)');
DEFINE('_COM_A_AVHEIGHT','Max. Avatar Height');
DEFINE('_COM_A_AVWIDTH','Max. Avatar Width');
DEFINE('_COM_A_AVSIZE','Max. Avatar Filesize<br/><em>in Kilobytes</em>');
DEFINE('_COM_A_USERSTATS','Show User Stats');
DEFINE('_COM_A_USERSTATS_DESC','Set to &quot;Yes&quot; to show User Statistics like number of posts user made, User type (Admin, Moderator, User, etc.).');
DEFINE('_COM_A_AVATARUPLOAD','Allow Avatar Upload');
DEFINE('_COM_A_AVATARUPLOAD_DESC','Set to &quot;Yes&quot; if you want registered users to be able to upload an avatar.');
DEFINE('_COM_A_AVATARGALLERY','Use Avatars Gallery');
DEFINE('_COM_A_AVATARGALLERY_DESC','Set to &quot;Yes&quot; if you want registered users to be able to choose an avatar from a Gallery you provide (components/com_joomlaboard/avatars/gallery).');
DEFINE('_COM_A_RANKING_DESC','Set to &quot;Yes&quot; if you want to show the rank registered users have based on the number of posts they made.<br/><strong>Note that you must enable User Stats in the Advanced tab too to show it.</strong>');
DEFINE('_COM_A_RANKINGIMAGES','Use Rank Images');
DEFINE('_COM_A_RANKINGIMAGES_DESC','Set to &quot;Yes&quot; if you want to show the rank registered users have with an image (from components/com_joomlaboard/ranks). Turning this of will show the text for that rank. Check the documentation on www.tsmf.net for more information on ranking images');
DEFINE('_COM_A_RANK1','Rank 1');
DEFINE('_COM_A_RANK1TXT','Rank 1 text');
DEFINE('_COM_A_RANK2','Rank 2');
DEFINE('_COM_A_RANK2TXT','Rank 2 text');
DEFINE('_COM_A_RANK3','Rank 3');
DEFINE('_COM_A_RANK3TXT','Rank 3 text');
DEFINE('_COM_A_RANK4','Rank 4');
DEFINE('_COM_A_RANK4TXT','Rank 4 text');
DEFINE('_COM_A_RANK5','Rank 5');
DEFINE('_COM_A_RANK5TXT','Rank 5 text');
DEFINE('_COM_A_RANK6','Rank 6');
DEFINE('_COM_A_RANK6TXT','Rank 6 text');
DEFINE('_COM_A_RANK','Rank');
DEFINE('_COM_A_RANK_NAME','Rankname');
DEFINE('_COM_A_RANK_LIMIT','Ranklimit');
//email and stuff
$_COM_A_NOTIFICATION ="New post notification from ";
$_COM_A_NOTIFICATION1="A new post has been made to a topic to which you have subscribed on the ";
$_COM_A_NOTIFICATION2="You can administer your subscriptions by following the 'my profile' link on the forum home page after you have logged in on the site. From your profile you can also unsubscribe from the topic.";
$_COM_A_NOTIFICATION3="Do not answer to this email notification as it is a generated email.";
$_COM_A_NOT_MOD1="A new post has been made to a forum to which you have assigned as moderator on the ";
$_COM_A_NOT_MOD2="Please have a look at it after you have logged in on the site.";

DEFINE('_COM_A_NO','No');
DEFINE('_COM_A_YES','Yes');
DEFINE('_COM_A_FLAT','Flat');
DEFINE('_COM_A_THREADED','Threaded');
DEFINE('_COM_A_MESSAGES','Messages per page');
DEFINE('_COM_A_MESSAGES_DESC','Number of messages per page to show');
   //admin; changes from 0.9 to 0.9.1
DEFINE('_COM_A_USERNAME','Username');
DEFINE('_COM_A_USERNAME_DESC','Set to &quot;Yes&quot; if you want the username (as in login) to be used instead of the users real name');
DEFINE('_COM_A_CHANGENAME','Allow Name Change');
DEFINE('_COM_A_CHANGENAME_DESC','Set to &quot;Yes&quot; if you want registered users to be able to change their name when posting. If set to &quot;No&quot; then registered users will not be able to edit his/her name');
   //admin; changes 0.9.1 to 0.9.2
DEFINE('_COM_A_BOARD_OFFLINE','Forum Offline');
DEFINE('_COM_A_BOARD_OFFLINE_DESC','Set to &quot;Yes&quot; if you want to take the Forum section offline. The forum will remain browsable by site (super)admins.');
DEFINE('_COM_A_BOARD_OFFLINE_MES','Forum Offline Message');
DEFINE('_COM_A_PRUNE','Prune Forums');
DEFINE('_COM_A_PRUNE_NAME','Forum to prune:');
DEFINE('_COM_A_PRUNE_DESC','The Prune Forums function allows you to prune threads to which there have not been any new posts for the specified number of days. This does not remove topics with the sticky bit set or which are explicitly locked; these must be removed manually. Threads in locked forums can not be pruned.');
DEFINE('_COM_A_PRUNE_NOPOSTS','Prune threads with no posts for the past ');
DEFINE('_COM_A_PRUNE_DAYS','days');
DEFINE('_COM_A_PRUNE_USERS','Prune Users');
DEFINE('_COM_A_PRUNE_USERS_DESC','This function allows you to prune your Joomlaboard user list against the Joomla! Site user list. It will delete all profiles for Joomlaboard Users that have been deleted from your Joomla! Framework.<br/>When you are sure you want to continue, click &quot;Start Pruning&quot; in the menu bar above.');


//general
DEFINE('_GEN_ACTION','Action');
DEFINE('_GEN_AUTHOR','Author');
DEFINE('_GEN_BY','by');
DEFINE('_GEN_CANCEL','cancel');
DEFINE('_GEN_CONTINUE','submit');
DEFINE('_GEN_DATE','Date');
DEFINE('_GEN_DELETE','delete');
DEFINE('_GEN_EDIT','edit');
DEFINE('_GEN_EMAIL','email');
DEFINE('_GEN_EMOTICONS','emoticons');
DEFINE('_GEN_FLAT','Flat');
DEFINE('_GEN_FLAT_VIEW','flat view');
DEFINE('_GEN_FORUMLIST','Forum List');
DEFINE('_GEN_FORUM','Forum');
DEFINE('_GEN_HELP','help');
DEFINE('_GEN_HITS','Views');
DEFINE('_GEN_LAST_POST','Last Post');
DEFINE('_GEN_LATEST_POSTS','show latest posts');
DEFINE('_GEN_LOCK','lock');
DEFINE('_GEN_UNLOCK','unlock');
DEFINE('_GEN_LOCKED_FORUM','means this forum is locked; no new posts possible.');
DEFINE('_GEN_LOCKED_TOPIC','means this topic is locked; no new posts possible.');
DEFINE('_GEN_MESSAGE','Message');
DEFINE('_GEN_MODERATED','means this forum is moderated; new post are reviewed prior to publishing.');
DEFINE('_GEN_MODERATORS','Moderators');
DEFINE('_GEN_MOVE','move');
DEFINE('_GEN_NAME','Name');
DEFINE('_GEN_POST_NEW_TOPIC','::post new topic::');
DEFINE('_GEN_POST_REPLY','post reply');
DEFINE('_GEN_MYPROFILE','my profile');
DEFINE('_GEN_QUOTE','quote');
DEFINE('_GEN_REPLY','reply');
DEFINE('_GEN_REPLIES','Replies');
DEFINE('_GEN_THREADED','Threaded');
DEFINE('_GEN_THREADED_VIEW','threaded view');
DEFINE('_GEN_SIGNATURE','Signature');
DEFINE('_GEN_ISSTICKY','means this topic is sticky.');
DEFINE('_GEN_STICKY','sticky');
DEFINE('_GEN_UNSTICKY','unsticky');
DEFINE('_GEN_SUBJECT','Subject');
DEFINE('_GEN_SUBMIT','Submit');
DEFINE('_GEN_TOPIC','Topic');
DEFINE('_GEN_TOPICS','Topics');
DEFINE('_GEN_TOPIC_ICON','topic icon');
DEFINE('_GEN_SEARCH_BOX','search forum');
$_GEN_THREADED_VIEW="threaded view";
$_GEN_FLAT_VIEW    ="flat view";

//avatar_upload.php
DEFINE('_UPLOAD_UPLOAD','Upload');
DEFINE('_UPLOAD_DIMENSIONS','Your image file can be maximum (width x height - size)');
DEFINE('_UPLOAD_SUBMIT','Submit a new Avatar for Upload');
DEFINE('_UPLOAD_SELECT_FILE','Select file');
DEFINE('_UPLOAD_ERROR_TYPE','Please use only jpeg, gif or png images');
DEFINE('_UPLOAD_ERROR_EMPTY','Please select a file before uploading');
DEFINE('_UPLOAD_ERROR_NAME','The image file must contain only alphanumeric characters and no spaces please.');
DEFINE('_UPLOAD_ERROR_SIZE','The image file size exceeds the maximum set by the Administrator.');
DEFINE('_UPLOAD_ERROR_WIDTH','The image file width exceeds the maximum set by the Administrator.');
DEFINE('_UPLOAD_ERROR_HEIGHT','The image file height exceeds the maximum set by the Administrator.');
DEFINE('_UPLOAD_ERROR_CHOOSE',"You didn't choose an Avatar from the gallery...");
DEFINE('_UPLOAD_UPLOADED','Your avatar has been uploaded.');
DEFINE('_UPLOAD_GALLERY','Choose one from the Avatar Gallery:');
DEFINE('_UPLOAD_CHOOSE','Confirm Choice.');

// listcat.php
DEFINE('_LISTCAT_ADMIN','An administrator should create them first from the ');
DEFINE('_LISTCAT_DO','They will know what to do ');
DEFINE('_LISTCAT_INFORM','Inform them and tell them to hurry up!');
DEFINE('_LISTCAT_NO_CATS','There are no categories in the forum defined yet.');
DEFINE('_LISTCAT_PANEL','Administration Panel of the Joomla! OS CMS.');
DEFINE('_LISTCAT_PENDING','pending message(s)');

// moderation.php
DEFINE('_MODERATION_MESSAGES','There are no pending messages in this forum.');

// post.php
DEFINE('_POST_ABOUT_TO_DELETE','You are about to delete the message');
DEFINE('_POST_ABOUT_DELETE','<strong>NOTES:</strong><br/>
-if you delete a Forum Topic (the first post in a thread) all children will be deleted as well!
..Consider blanking the post and posters name if only the contents should be removed..
<br/>
- All children of a deleted normal post will be moved up 1 rank in the thread hierarchy.');
DEFINE('_POST_CLICK','click here');
DEFINE('_POST_ERROR','Could not find username/email. Severe database error not listed');
DEFINE('_POST_ERROR_MESSAGE','An unknown SQL Error occured and your message was not posted.  If the problem persists, please contact the administrator.');
DEFINE('_POST_ERROR_MESSAGE_OCCURED','An error has occured and the message was not updated.  Please try again.  If this error persists please contact the administrator.');
DEFINE('_POST_ERROR_TOPIC','An error occured during the delete(s). Please check the error below:');
DEFINE('_POST_FORGOT_NAME','You forgot to include your name.  Click your browser&#146s back button to go back and try again.');
DEFINE('_POST_FORGOT_SUBJECT','You forgot to include a subject.  Click your browser&#146s back button to go back and try again.');
DEFINE('_POST_FORGOT_MESSAGE','You forgot to include a message.  Click your browser&#146s back button to go back and try again.');
DEFINE('_POST_INVALID','An invalid post id was requested.');
DEFINE('_POST_LOCK_SET','The topic has been locked.');
DEFINE('_POST_LOCK_NOT_SET','The topic could not be locked.');
DEFINE('_POST_LOCK_UNSET','The topic has been unlocked.');
DEFINE('_POST_LOCK_NOT_UNSET','The topic could not be unlocked.');
DEFINE('_POST_MESSAGE','Post a new message in ');
DEFINE('_POST_MOVE_TOPIC','Move this Topic to forum ');
DEFINE('_POST_NEW','Post a new message in: ');
DEFINE('_POST_NO_SUBSCRIBED_TOPIC','Your subscription to this topic could not be processed.');
DEFINE('_POST_NOTIFIED','Check this box to have yourself notified about replies to this topic.');
DEFINE('_POST_STICKY_SET','The sticky bit has been set for this topic.');
DEFINE('_POST_STICKY_NOT_SET','The sticky bit could not be set for this topic.');
DEFINE('_POST_STICKY_UNSET','The sticky bit has been unset for this topic.');
DEFINE('_POST_STICKY_NOT_UNSET','The sticky bit could not be unset for this topic.');
DEFINE('_POST_SUBSCRIBE','subscribe');
DEFINE('_POST_SUBSCRIBED_TOPIC','You have been subscribed to this topic.');
DEFINE('_POST_SUCCESS','Your message has been successfully');
DEFINE('_POST_SUCCES_REVIEW','Your message has been successfully posted.  It will be reviewed by a Moderator before it will be published on the forum.');
DEFINE('_POST_SUCCESS_REQUEST','Your request has been processed.  If you are not taken back to the topic in a few moments,');
DEFINE('_POST_TOPIC_HISTORY','Topic History of');
DEFINE('_POST_TOPIC_HISTORY_MAX','Max. showing the last');
DEFINE('_POST_TOPIC_HISTORY_LAST','posts  -  <i>(Last post first)</i>');
DEFINE('_POST_TOPIC_NOT_MOVED','Your topic could not be moved. To get back to the topic:');
DEFINE('_POST_TOPIC_FLOOD1','The administrator of this forum has enabled Flood Protection and has decided that you must wait ');
DEFINE('_POST_TOPIC_FLOOD2',' seconds before you can make another post.');
DEFINE('_POST_TOPIC_FLOOD3','Please click your browser&#146s back button to get back to the forum.');
DEFINE('_POST_EMAIL_NEVER','your email address will never be displayed on the site.');
DEFINE('_POST_EMAIL_REGISTERED','your email address will only be available to registered users.');
DEFINE('_POST_LOCKED','locked by the administrator.');
DEFINE('_POST_NO_NEW','New replies are not allowed.');
DEFINE('_POST_NO_PUBACCESS1','The administrator has disabled public write access.');
DEFINE('_POST_NO_PUBACCESS2','Only logged in / registered users<br /> are allowed to contribute to the forum.');

// showcat.php
DEFINE('_SHOWCAT_NO_TOPICS','>> There are no topics in this forum yet <<');
DEFINE('_SHOWCAT_PENDING','pending message(s)');

// userprofile.php
DEFINE('_USER_DELETE',' check this box to delete your signature');
DEFINE('_USER_ERROR_A','You came to this page in error. Please inform the administrator on which links ');
DEFINE('_USER_ERROR_B','you clicked that got you here. She or he can then file a bug report.');
DEFINE('_USER_ERROR_C','Thank you!');
DEFINE('_USER_ERROR_D','Error number to include in your report: ');
DEFINE('_USER_GENERAL','General Profile Options');
DEFINE('_USER_MODERATOR','You are assigned as a Moderator to forums');
DEFINE('_USER_MODERATOR_NONE','No forums found assigned to you');
DEFINE('_USER_MODERATOR_ADMIN','Admins are moderator on all forums.');
DEFINE('_USER_NOSUBSCRIPTIONS','No subscriptions found for you');
DEFINE('_USER_PREFERED','Prefered Viewtype');
DEFINE('_USER_PROFILE','Profile for ');
DEFINE('_USER_PROFILE_NOT_A','Your profile could ');
DEFINE('_USER_PROFILE_NOT_B','not');
DEFINE('_USER_PROFILE_NOT_C',' be updated.');
DEFINE('_USER_PROFILE_UPDATED','Your profile is updated.');
DEFINE('_USER_RETURN_A','If you are not taken back to your profile in a few moments ');
DEFINE('_USER_RETURN_B','click here');
DEFINE('_USER_SUBSCRIPTIONS','Your Subscriptions');
DEFINE('_USER_UNSUBSCRIBE',':: unsubscribe :: ');
DEFINE('_USER_UNSUBSCRIBE_A','You could ');
DEFINE('_USER_UNSUBSCRIBE_B','not');
DEFINE('_USER_UNSUBSCRIBE_C',' be unsubscribed from the topic.');
DEFINE('_USER_UNSUBSCRIBE_YES','You have been unsubscribed from the topic.');
DEFINE('_USER_DELETEAV',' check this box to delete your Avatar');
//New 0.9 to 1.0
DEFINE('_USER_ORDER','Preferred Message Ordering');
DEFINE('_USER_ORDER_DESC','Last post first');
DEFINE('_USER_ORDER_ASC','First post first');

// view.php
DEFINE('_VIEW_DISABLED','The administrator has disabled public write access.');
DEFINE('_VIEW_POSTED','Posted by');
DEFINE('_VIEW_SUBSCRIBE',':: Subscribe to this topic ::');
DEFINE('_MODERATION_INVALID_ID','An invalid post id was requested.');
DEFINE('_VIEW_NO_POSTS','There are no posts in this forum.');
DEFINE('_VIEW_VISITOR','Visitor');
DEFINE('_VIEW_ADMIN','Admin');
DEFINE('_VIEW_USER','User');
DEFINE('_VIEW_MODERATOR','Moderator');
DEFINE('_VIEW_REPLY','Reply to this message');
DEFINE('_VIEW_EDIT','Edit this message');
DEFINE('_VIEW_QUOTE','Quote this message in a new post');
DEFINE('_VIEW_DELETE','Delete this message');
DEFINE('_VIEW_STICKY','Set this topic sticky');
DEFINE('_VIEW_UNSTICKY','Unset this topic sticky');
DEFINE('_VIEW_LOCK','Lock this topic');
DEFINE('_VIEW_UNLOCK','Unlock this topic');
DEFINE('_VIEW_MOVE','Move this topic to another forum');
DEFINE('_VIEW_SUBSCRIBETXT','Subscribe to this topic and get notified by mail about new posts');


//NEW-STRINGS-FOR-TRANSLATING-READY-FOR-SIMPLEBOARD 9.2


DEFINE('_HOME','home');
DEFINE('_POSTS','Posts:');
DEFINE('_TOPIC_NOT_ALLOWED','Post');
DEFINE('_FORUM_NOT_ALLOWED','Forum');
DEFINE('_FORUM_IS_OFFLINE','Forum is OFFLINE!');
DEFINE('_PAGE','Page: ');
DEFINE('_NO_POSTS','No Posts');
DEFINE('_CHARS','characters max.');
DEFINE('_HTML_YES','HTML is disabled');
DEFINE('_YOUR_AVATAR','<b>Your Avatar</b>');
DEFINE('_NON_SELECTED','Not yet selected <br>');
DEFINE('_SET_NEW_AVATAR','Select new Avatar');
DEFINE('_THREAD_UNSUBSCRIBE',':: unsubscribe ::');
DEFINE('_SHOW_LAST_POSTS','Active topics in last');
DEFINE('_SHOW_HOURS','hours');
DEFINE('_SHOW_POSTS','Total: ');
DEFINE('_DESCRIPTION_POSTS','The newest posts for the active topics are shown');
DEFINE('_SHOW_4_HOURS','4 Hours');
DEFINE('_SHOW_8_HOURS','8 Hours');
DEFINE('_SHOW_12_HOURS','12 Hours');
DEFINE('_SHOW_24_HOURS','24 Hours');
DEFINE('_SHOW_48_HOURS','48 Hours');
DEFINE('_SHOW_WEEK','Week');
DEFINE('_POSTED_AT','Posted at');
DEFINE('_DATETIME','Y/m/d H:i');
DEFINE('_NO_TIMEFRAME_POSTS','There are no new posts in the timeframe you selected.');
DEFINE('_MESSAGE','Message');
DEFINE('_NO_SMILIE','no');
DEFINE('_FORUM_UNAUTHORIZIED','This forum is open only to registered and logged in users.');
DEFINE('_FORUM_UNAUTHORIZIED2','If you are already registered, please log in first.');
DEFINE('_MESSAGE_ADMINISTRATION','Moderation');
DEFINE('_MOD_APPROVE','Approve');
DEFINE('_MOD_DELETE','Delete');

//NEW in RC1
DEFINE('_SHOW_LAST','Show most recent message');
DEFINE('_POST_WROTE','wrote');
DEFINE('_COM_A_EMAIL','Board Email Address');
DEFINE('_COM_A_EMAIL_DESC','This is the Boards email address. Make this a valid email address');
DEFINE('_COM_A_WRAP','Wrap Words Longer Than');
DEFINE('_COM_A_WRAP_DESC','Enter the maximum number of characters a single word may have. This feature allows you to tune the output of Joomlaboard Posts to your template.<br/> 70 characters is probably the maximum for fixed width templates but you might need to experiment a bit.<br/>URLs, no matter how long, are not affected by the wordwrap');
DEFINE('_COM_A_SIGNATURE','Max. Signature Length');
DEFINE('_COM_A_SIGNATURE_DESC','Maximum number of characters allowed for the user signature.');
DEFINE('_SHOWCAT_NOPENDING','No pending message(s)');
DEFINE('_COM_A_BOARD_OFSET','Board Time Offset');
DEFINE('_COM_A_BOARD_OFSET_DESC','Some boards are located on servers in a different timezone than the users are. Set the Time Offset Joomlaboard must use in the post time in hours. Positive and negative numbers can be used');

//New in RC2
DEFINE('_COM_A_BASICS','Basics');
DEFINE('_COM_A_FRONTEND','Frontend');
DEFINE('_COM_A_SECURITY','Security');
DEFINE('_COM_A_AVATARS','Avatars');
DEFINE('_COM_A_INTEGRATION','Integration');
DEFINE('_COM_A_PMS','Enable private messaging');
DEFINE('_COM_A_PMS_DESC','Select the appropriate private messaging component if you have installed any. Selecting Clexus PMS will also enable Clexus PMS user profile related options (like ICQ, AIM, Yahoo, MSN and profile links if supported by the Joomlaboard template used');
DEFINE('_VIEW_PMS','Click here to send a Private Message to this user');

//new in RC3
DEFINE('_POST_RE','Re:');
DEFINE('_BBCODE_BOLD','Bold text: [b]text[/b] ');
DEFINE('_BBCODE_ITALIC','Italic text: [i]text[/i]');
DEFINE('_BBCODE_UNDERL','Underline text: [u]text[/u]');
DEFINE('_BBCODE_QUOTE','Quote text: [quote]text[/quote]');
DEFINE('_BBCODE_CODE','Code display: [code]code[/code]');
DEFINE('_BBCODE_ULIST','Unordered List: [ul] [li]text[/li] [/ul] - Hint: a list must contain List Items');
DEFINE('_BBCODE_OLIST','Ordered List: [ol] [li]text[/li] [/ol] - Hint: a list must contain List Items');
DEFINE('_BBCODE_IMAGE','Image: [img size=(01-499)]http://www.google.com/images/web_logo_left.gif[/img]');
DEFINE('_BBCODE_LINK','Link: [url=http://www.zzz.com/]This is a link[/url]');
DEFINE('_BBCODE_CLOSA','Close all tags');
DEFINE('_BBCODE_CLOSE','Close all open bbCode tags');
DEFINE('_BBCODE_COLOR','Color: [color=#FF6600]text[/color]');
DEFINE('_BBCODE_SIZE','Size: [size=1]text size[/size] - Hint: sizes range from 1 to 5');
DEFINE('_BBCODE_LITEM','List Item: [li] list item [/li]');
DEFINE('_BBCODE_HINT','bbCode Help - Hint: bbCode can be used on selected text!');
DEFINE('_COM_A_TAWIDTH','Textarea Width');
DEFINE('_COM_A_TAWIDTH_DESC','Adjust the width of the reply/post text entry area to match your template. <br/>The Topic Emoticon Toolbar will be wrapped accross two lines if width <= 420 pixels');
DEFINE('_COM_A_TAHEIGHT','Textarea Height');
DEFINE('_COM_A_TAHEIGHT_DESC','Adjust the height of the reply/post text entry area to match your template');
DEFINE('_COM_A_ASK_EMAIL','Require Email');
DEFINE('_COM_A_ASK_EMAIL_DESC','Require an email address when users or visitors make a post. Set to &quot;No&quot; if you want this feature to be skipped on the frontend. Posters will not be asked for their email address.');

?>
