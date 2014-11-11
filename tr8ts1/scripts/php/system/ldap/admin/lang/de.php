<?php

/*
 * �bersetzung von Marius Rieder <marius.rieder@bluewin.ch>
 *                 Uwe Ebel
 * Modifikationen von Dieter Kluenter <hdk@dkluenter.de>
 *
 * 
 * $Header: /cvsroot/phpldapadmin/phpldapadmin/lang/de.php,v 1.22 2004/04/26 19:49:36 i18phpldapadmin Exp $
 * 
 * Verwendete CVS-Version von en.php 1.65
 */

// Search form
$lang['simple_search_form_str'] = 'Einfache Suche';//'Simple Search Form';
$lang['advanced_search_form_str'] = 'Experten Suche';//'Advanced Search Form';
$lang['server'] = 'Server';//'Server';
$lang['search_for_entries_whose'] = 'Suche nach Eintr�gen die';//'Search for entries whose';
$lang['base_dn'] = 'Base DN';//'Base DN';
$lang['search_scope'] = 'Suchbereich';//'Search Scope';
//$lang['search_ filter'] = 'Suchfilter';//'Search Filter';
$lang['show_attributes'] = 'Zeige Attribute';//'Show Attributtes';
$lang['Search'] = 'Suchen';//'Search';
$lang['equals'] = 'gleich';//'equals';
//$lang['starts_with'] = 'beginnt mit';//'starts with';
$lang['contains'] = 'enth�lt';//'contains';
//$lang['ends_with'] = 'endet mit';//'ends with';
//$lang['sounds_like'] = '�hnlich wie';//'sounds like';
$lang['predefined_search_str'] = 'oder ein von dieser Liste ausw�hlen';//'or select a predefined search';
$lang['predefined_searches'] = 'Vordefinierte Suche';//'Predefined Searches';
$lang['no_predefined_queries'] = 'Keine Abfragen sind in der config.php definiert';// 'No queries have been defined in config.php.';


// Tree browser
$lang['request_new_feature'] = 'Anfragen von neuen M�glichkeiten';//'Request a new feature';
//$lang['see_open_requests'] = 'Siehe offene Anfragen';//'see open requests';
$lang['report_bug'] = 'Einen Fehler berichten';//'Report a bug';
//$lang['see_open_bugs'] = 'Siehe offene Fehler';//'see open bugs';
$lang['schema'] = 'Schema';//'schema';
$lang['search'] = 'suche';//'search';
$lang['refresh'] = 'aktualisieren';//'refresh';
$lang['create'] = 'Erstellen';//'create';
$lang['info'] = 'Info';//'info';
$lang['import'] = 'Import';//'import';
$lang['logout'] = 'abmelden';//'logout';
$lang['create_new'] = 'Neuen Eintrag erzeugen';//'Create New';
$lang['new'] = 'Neu';//'new';
$lang['view_schema_for'] = 'Zeige Schema f�r';//'View schema for';
$lang['refresh_expanded_containers'] = 'Aktualisiere alle ge�ffneten Container von';//'Refresh all expanded containers for';
$lang['create_new_entry_on'] = 'Erzeuge einen neuen Eintrag auf';//'Create a new entry on';
$lang['view_server_info'] = 'Zeige Server Informationen';//'View server-supplied information';
$lang['import_from_ldif'] = 'Importiere Eintr�ge von einer LDIF-Datei';//'Import entries from an LDIF file';
$lang['logout_of_this_server'] = 'Von diesem Server abmelden';//'Logout of this server';
$lang['logged_in_as'] = 'Angemeldet als: ';//'Logged in as: ';
$lang['read_only'] = 'nur lesen';//'read only';
$lang['read_only_tooltip'] = 'Diese Attribut wurde vom phpLDAPadmin-Adminstrator als nur lesend markiert.';//This attribute has been flagged as read only by the phpLDAPadmin administrator';
$lang['could_not_determine_root'] = 'Konnte die Basis ihres LDAP Verzeichnises nicht ermitteln';//'Could not determin the root of your LDAP tree.';
$lang['ldap_refuses_to_give_root'] = 'Es scheint das ihr LDAP Server nicht dazu konfiguriert wurde seine Basis bekanntzugeben';//'It appears that the LDAP server has been configured to not reveal its root.';
$lang['please_specify_in_config'] = 'Bitte in config.php angeben';//'Please specify it in config.php';
$lang['create_new_entry_in'] = 'Neuen Eintrag erzeugen auf';//'Create a new entry in';
$lang['login_link'] = 'Anmelden...';//'Login...';
$lang['login'] = 'Anmelden';//'login';

// Entry display
$lang['delete_this_entry'] = 'Diesen Eintrag l�schen';//'Delete this entry';
$lang['delete_this_entry_tooltip'] = 'F�r diese Entscheidung wird nochmals nachgefragt.';//'You will be prompted to confirm this decision';
$lang['copy_this_entry'] = 'Diesen Eintrag kopieren';//'Copy this entry';
$lang['copy_this_entry_tooltip'] = 'Kopiere diese Object an eine anderen Ort: ein neuer DN oder einen anderen Server.';//'Copy this object to another location, a new DN, or another server';
$lang['export'] = 'Exportieren';//'Export to LDIF';
$lang['export_tooltip'] = 'Speichere einen Abzug diese Objektes';//'Save an LDIF dump of this object';
$lang['export_subtree_tooltip'] = 'Speicher eine Abzug ab diesem Objekt und alle seine Untereintr�ge';//'Save an LDIF dump of this object and all of its children';
$lang['export_subtree'] = 'Export Unterbaum nach LDIF';//'Export subtree to LDIF';
//$lang['export_mac'] = 'Zeilenende f�r Macintosh';//'Macintosh style line ends';
//$lang['export_win'] = 'Zeilenende f�r Windows';//'Windows style line ends';
//$lang['export_unix'] = 'Zeilenende f�r Unix';//'Unix style line ends';
$lang['create_a_child_entry'] = 'Erzeuge einen Untereintrag';//'Create a child entry';
//$lang['add_a_jpeg_photo'] = 'Ein JPEG-Foto hinzuf�gen';//'Add a jpegPhoto';
$lang['rename_entry'] = 'Eintrag umbenennen';//'Rename Entry';
$lang['rename'] = 'Umbenennen';//'Rename';
$lang['add'] = 'Hinzuf�gen';//'Add';
$lang['view'] = 'Ansehen';//'View';
$lang['view_one_child'] = 'Zeige einen Untereintrag';//'View 1 child';
$lang['view_children'] = 'Zeige %s Untereintr�ge';//'View %s children';
$lang['add_new_attribute'] = 'Neues Attribut hinzuf�gen';//'Add New Attribute';
// DELETED $lang['add_new_attribute_tooltip'] = 'F�ge ein neues Attribut/Wert zu diesem Eintrag hinzu';// 'Add a new attribute/value to this entry';
$lang['add_new_objectclass'] = 'Neue ObjectClass hinzuf�gen';//'Add new ObjectClass';
//$lang['internal_attributes'] = 'Interne Attribute';//'Internal Attributes';
$lang['hide_internal_attrs'] = 'Verdecke interne Attribute';//'Hide internal attributes';
$lang['show_internal_attrs'] = 'Zeige interne Attribute';//'Show internal attributes';
//$lang['internal_attrs_tooltip'] = 'Attribute werden automatisch vom System erzeugt.';//'Attributes set automatically by the system';
//$lang['entry_attributes'] = 'Attribute des Eintrages';//'Entry Attributes';
$lang['attr_name_tooltip'] = 'Klicken sie um die Schemadefinition f�r den Attributtyp "%s" anzuzeigen.';//'Click to view the schema defintion for attribute type \'%s\'';
//$lang['click_to_display'] = 'Klicken zum Ansehen';//'click to display';
//$lang['hidden'] = 'verdeckt';//'hidden'; 
$lang['none'] = 'Keine';//'none';
$lang['no_internal_attributes'] = 'Keine internen Attribute.';//'No internal attributes';
$lang['no_attributes'] = 'Dieser Eintrag hat keine Attribute.';//'This entry has no attributes';
$lang['save_changes'] = '�nderungen speichern';//'Save Changes';
$lang['add_value'] = 'Wert hinzuf�gen';//'add value';
$lang['add_value_tooltip'] = 'F�ge einen weiteren Wert dem Attribut hinzu';//'Add an additional value to this attribute';
$lang['refresh_entry'] = 'Auffrischen';// 'Refresh';
$lang['refresh_this_entry'] = 'Aktualisiere den Entrag';//'Refresh this entry';
$lang['delete_hint'] = 'Hinweis: Um ein Attribut zu l�schen, leeren Sie den Inhalt des Wertes.';//'Hint: <b>To delete an attribute</b>, empty the text field and click save.';
$lang['attr_schema_hint'] = 'Tipp:Um das Schema f�r ein Attribut anzusehen, gen�gt ein klick auf den Attributnamen';//'Hint: <b>To view the schema for an attribute</b>, click the attribute name.';
$lang['attrs_modified'] = 'Einige Attribute (%s) wurden ver�ndert und sind hervorgehoben.';//'Some attributes (%s) were modified and are highlighted below.';
$lang['attr_modified'] = 'Ein Attribut (%s) wurde ver�ndert und ist hervorgehoben.';//'An attribute (%s) was modified and is highlighted below.';
$lang['viewing_read_only'] = 'Zeige Eintrag im Nurlesemodus';//'Viewing entry in read-only mode.';
//$lang['change_entry_rdn'] = '�ndere den RDN des Eintrages';//'Change this entry\'s RDN';
$lang['no_new_attrs_available'] = 'Keine weiteren Attribute verf�gbar f�r diesen Eintrag';//'no new attributes available for this entry';
$lang['no_new_binary_attrs_available'] = 'Keine weiteren Bin�ren Attribute verf�gbar f�r diesen Eintrag.';//'no new binary attributes available for this entry';
$lang['binary_value'] = 'Bin�rwert';//'Binary value';
$lang['add_new_binary_attr'] = 'Neuen Bin�rwert hinzuf�gen';//'Add New Binary Attribute';
// DELETE $lang['add_new_binary_attr_tooltip'] = 'F�ge einen neuen Bin�wert (Attribut/Wert) aus einer Datei hinzu.';//'Add a new binary attribute/value from a file';
$lang['alias_for'] = 'Alias f�r';//'Alias for';
$lang['download_value'] = 'Wert herunterladen';//'download value';
$lang['delete_attribute'] = 'L�sche Attribut';//'delete attribute';
$lang['true'] = 'Wahr';//'true';
$lang['false'] = 'Falsch';//'false';
$lang['none_remove_value'] = 'nichts, entferne den Wert';//?? //'none, remove value';
$lang['really_delete_attribute'] = 'L�sche das Attribut wirklich';//'Really delete attribute';
$lang['add_new_value'] = 'Neuen Wert hinzuf�gen';//'Add New Value';

// Schema browser
$lang['the_following_objectclasses'] = 'Die folgenden Objektklassen werden vom LDAP-Server unterst�tzt.';//'The following <b>objectClasses</b> are supported by this LDAP server.';
$lang['the_following_attributes'] = 'Die folgenden Attribute werden vom LDAP-Server unterst�tzt.';//'The following <b>attributeTypes</b> are supported by this LDAP server.';
$lang['the_following_matching'] = 'Die folgenden Suchregeln werden vom LDAP-Server unterst�tzt.';//'The following <b>matching rules</b> are supported by this LDAP server.';
$lang['the_following_syntaxes'] = 'Die folgenden Syntaxe werden vom LDAP-Server unterst�tzt.';//'The following <b>syntaxes</b> are supported by this LDAP server.';
$lang['schema_retrieve_error_1']='Der Server unterst�tzt nicht vollst�ndig das LDAP-Protokoll.';//'The server does not fully support the LDAP protocol.';
$lang['schema_retrieve_error_2']='Die verwendete PHP-Version setzte keine korrekte LDAP-Abfrage ab.';//'Your version of PHP does not correctly perform the query.';
$lang['schema_retrieve_error_3']='Oder phpLDAPadmin konnte nicht das Schema f�r den Server abfragen.';//'Or lastly, phpLDAPadmin doesn\'t know how to fetch the schema for your server.';
$lang['jump_to_objectclass'] = 'Gehe zur objectClass';//'Jump to an objectClass';
$lang['jump_to_attr'] = 'Gehe zum Attribut';//'Jump to an attribute';
$lang['jump_to_matching_rule'] = 'Gehe zur Treffer Regel';
$lang['schema_for_server'] = 'Schema f�r Server';//'Schema for server';
$lang['required_attrs'] = 'Notwendige Attribute';//'Required Attributes';
$lang['optional_attrs'] = 'Optionale Attribute';//'Optional Attributes';
$lang['optional_binary_attrs'] = 'Optinales Bin�rattribut';//'Optional Binary Attributes';
$lang['OID'] = 'OID';//'OID';
$lang['aliases']='Pseudonym(e)';//'Aliases';
$lang['desc'] = 'Beschreibung';//'Description';
$lang['no_description']='Keine Beschreibung';//'no description';
$lang['name'] = 'Name';//'Name';
$lang['equality']='Gleichheit';
$lang['is_obsolete'] = 'Diese objectClass ist veraltet';//'This objectClass is <b>obsolete</b>';
$lang['inherits'] = 'Abgeleitet von';//'Inherits';
$lang['inherited_from']='abgeleteitet von';//inherited from';
$lang['parent_to'] = 'Knoten von';//'Parent to';
$lang['jump_to_this_oclass'] = 'Gehe zur objectClass Definition';//'Jump to this objectClass definition';
$lang['matching_rule_oid'] = 'Treffer-Regel OID';//'Matching Rule OID';
$lang['syntax_oid'] = 'Syntax OID';//'Syntax OID';
$lang['not_applicable'] = 'nicht anwendbar';//'not applicable';
$lang['not_specified'] = 'nicht spezifiziert';//not specified';
$lang['character']='Zeichen';//'character'; 
$lang['characters']='Zeichen';//'characters';
$lang['used_by_objectclasses']='Verwendet von den Objektklassen';//'Used by objectClasses';
$lang['used_by_attributes']='Verwendet in den Attributen';//'Used by Attributes';
$lang['oid']='OID';
$lang['obsolete']='Veraltet';//'Obsolete';
$lang['ordering']='Ordnung';//'Ordering';
$lang['substring_rule']='Teilstring Regel';//'Substring Rule';
$lang['single_valued']='Einzelner Wert';//'Single Valued';
$lang['collective']='Sammlung';//'Collective';
$lang['user_modification']='Benutzer �nderung';//'User Modification';
$lang['usage']='Verwendung';//'Usage';
$lang['maximum_length']='Maximale Gr�sse';//'Maximum Length';
$lang['attributes']='Attribut Typen';//'Attributes Types';
$lang['syntaxes']='Syntaxe';//'Syntaxes';
$lang['objectclasses']='Objekt Klassen';//'objectClasses';
$lang['matchingrules']='Treffer Regeln';//'Matching Rules';
$lang['could_not_retrieve_schema_from']='Das Schema konnte nicht abgefragt werden. Betrifft die Einstellung des Servers:';//'Could not retrieve schema from';
$lang['type']='Typ';// 'Type';

// Deleting entries
$lang['entry_deleted_successfully'] = 'Der Eintrag \'%s\' wurde erfolgreich gel�scht.';//'Entry \'%s\' deleted successfully.';
$lang['you_must_specify_a_dn'] = 'Ein DN muss angegeben werden.';//'You must specify a DN';
$lang['could_not_delete_entry'] = 'Konnte den Eintrag nicht l�schen: %s';//'Could not delete the entry: %s';
$lang['no_such_entry'] = 'Keinen solchen Eintrag: %s';//'No such entry: %s';
$lang['delete_dn'] = 'L�schen von %s';//'Delete %s';
//$lang['permanently_delete_children'] = 'Ebenso dauerhaftes L�schen aller Untereintr�ge?';//'Permanently delete all children also?';
$lang['entry_is_root_sub_tree'] = 'Dies ist ein Root-Eintrag und beinhaltet einen Unterbaum mit %s Eintr�gen.';//'This entry is the root of a sub-tree containing %s entries.';
$lang['view_entries'] = 'Zeige Eintr�ge';//'view entries';
$lang['confirm_recursive_delete'] = 'phpLDAPadmin kann diesen Eintrag und die %s Untereintr�ge rekursiv l�schen. Unten ist eine Liste der Eintr�ge angegeben die von diesem L�schen betroffen w�ren. Sollen alle Eintr�ge gel�scht werden?';//'phpLDAPadmin can recursively delete this entry and all %s of its children. See below for a list of all the entries that this action will delete. Do you want to do this?';
$lang['confirm_recursive_delete_note'] = 'Hinweis: Dies ist sehr gef�hrlich und erfolgt auf eines Risiko. Die Ausf�hrung kann nicht r�ckg�ngig gemacht werden. Dies betrifft ebenso Aliase, Referenzen und andere Dinge die zu Problemen f�hren k�nnen.';//'Note: this is potentially very dangerous and you do this at your own risk. This operation cannot be undone. Take into consideration aliases, referrals, and other things that may cause problems.';
$lang['delete_all_x_objects'] = 'L�schen aller "%s" Objekte';//'Delete all %s objects';
$lang['recursive_delete_progress'] = 'Rekursives L�schen in Arbeit';//'Recursive delete progress';
$lang['entry_and_sub_tree_deleted_successfully'] = 'Erfolgreiches L�schen des  Eintrages "%s" und dessen Unterbaums.';// 'Entry %s and sub-tree deleted successfully.';
$lang['failed_to_delete_entry'] = 'Fehler beim L�schen des Eintrages %s.';//'Failed to delete entry %s';

// Deleting attributes
$lang['attr_is_read_only'] = 'Das Attribut "%s" ist in der phpLDAPadmin Konfiguration als nur lesend deklariert.';//'The attribute "%s" is flagged as read-only in the phpLDAPadmin configuration.';
$lang['no_attr_specified'] = 'Kein Attributname angegeben.';//'No attribute name specified.';
$lang['no_dn_specified'] = 'Kein DN angegeben.';//'No DN specified';

// Adding attributes
$lang['left_attr_blank'] = 'Der Wert des Attributes wurde leergelassen. Bitte zur�ck gehen und erneut versuchen.';//'You left the attribute value blank. Please go back and try again.';
$lang['failed_to_add_attr'] = 'Fehler beim Hinzuf�gen des Attributes';//'Failed to add the attribute.';
$lang['file_empty'] = 'Die ausgew�hlte Datei ist entweder nicht vorhanden oder leer. Bitte zur�ckgehen und nochmals versuchen.';//'The file you chose is either empty or does not exist. Please go back and try again.';
$lang['invalid_file'] = 'Sicherheitsfehler: Die hochgeladene Datei kann b�sartig sein.';//'Security error: The file being uploaded may be malicious.';
$lang['warning_file_uploads_disabled'] = 'Die PHP-Konfiguration (php.ini) gestattet es nicht Dateien hochzuladen. Bitte die php.ini hierzu �berpr�fen.';//'Your PHP configuration has disabled file uploads. Please check php.ini before proceeding.';
$lang['uploaded_file_too_big'] = 'Die hochgeladene Datei ist gr��er als die maximal erlaubte Datei aus der "php.ini". Bitte in der php.ini den Eintrag "upload_max_size" �berpr�fen.';//'The file you uploaded is too large. Please check php.ini, upload_max_size setting';
$lang['uploaded_file_partial'] = 'Die ausw�hlte Datei wurde nur unvollst�ndig hochgeladen.';//'The file you selected was only partially uploaded, likley due to a network error.';
$lang['max_file_size'] = 'Maximal Dateigr��e ist: %s';//'Maximum file size: %s';

// Updating values
$lang['modification_successful'] = '�nderung war erfolgreich!';//'Modification successful!';
$lang['change_password_new_login'] = 'Da das Passwort ge�ndert wurde m�ssen Sie sich erneut einloggen.'; //'Since you changed your password, you must now login again with your new password.';


// Adding objectClass form
$lang['new_required_attrs'] = 'Neue ben�tigte Attribute';//'New Required Attributes';
$lang['requires_to_add'] = 'Diese Aktion zwingt sie folgendes hinzuzuf�gen';//'This action requires you to add';
$lang['new_attributes'] = 'neue Attribute';//'new attributes';
$lang['new_required_attrs_instructions'] = 'Anleitung: Um diese objectClass hinzuzuf�gen m�ssen sie ';//'Instructions: In order to add this objectClass to this entry, you must specify';
$lang['that_this_oclass_requires'] = 'die von dieser objectClass ben�tigt werden. Sie k�nnen dies in diesem Formular machen.';//'that this objectClass requires. You can do so in this form.';
$lang['add_oclass_and_attrs'] = 'ObjectClass und Attribute hinzuf�gen';//'Add ObjectClass and Attributes';

// General
$lang['chooser_link_tooltip'] = 'Klicken um einen Eintrag (DN) grafisch auszuw�hlen.';//"Click to popup a dialog to select an entry (DN) graphically';
$lang['no_updates_in_read_only_mode'] = 'Sie k�nnen keine Aktualisierungen durchf�hren w�hrend der Server sich im \'nur lese\'-modus befindet';//'You cannot perform updates while server is in read-only mode';
$lang['bad_server_id'] = 'Ung�ltige Server ID';//'Bad server id';
$lang['not_enough_login_info'] = 'Nicht gen�gend Angaben zur Anmeldung am Server. Bitte �berpr�fen sie ihre Konfiguration';//'Not enough information to login to server. Please check your configuration.';
$lang['could_not_connect'] = 'Konnte keine Verbindung zum LDAP Server herstellen.';//'Could not connect to LDAP server.';
$lang['could_not_connect_to_host_on_port'] = 'Konnte keine Verbindung zum Server "%s" am Port "%s" erstellen.';//'Could not connect to "%s" on port "%s"';
$lang['could_not_perform_ldap_mod_add'] = 'Kann keine \'ldap_mod_add\' Operationen durchf�hren.';//'Could not perform ldap_mod_add operation.';
$lang['bad_server_id_underline'] = 'Ung�ltige Server ID:';//"Bad server_id: ';
$lang['success'] = 'Erfolgreich';//"Success';
$lang['server_colon_pare'] = 'Server';//"Server: ';
$lang['look_in'] = 'Sehe nach in:';//"Looking in: ';
$lang['missing_server_id_in_query_string'] = 'Keine Server ID in der Anfrage angegeben';//'No server ID specified in query string!';
$lang['missing_dn_in_query_string'] = 'Kein DN in der Anfrage angegeben';//'No DN specified in query string!';
$lang['back_up_p'] = 'Eine Ebene h�her...';//"Back Up...';
$lang['no_entries'] = 'Keine Eintr�ge';//"no entries';
$lang['not_logged_in'] = 'Nicht eingeloggt';//"Not logged in';
$lang['could_not_det_base_dn'] = 'Konnten Basis-DN nicht ermitteln.';//"Could not determine base DN';
$lang['reasons_for_error']='Dies kann mehrere Gr�nde haben. Die h�ufigsten sind:';//'This could happen for several reasons, the most probable of which are:';
$lang['please_report_this_as_a_bug']='Bitte senden Sie dies als einen Fehlerbericht.';//'Please report this as a bug.';
$lang['yes']='Ja';//'Yes'
$lang['no']='Nein';//'No'
$lang['go']='Weiter';//'go'
$lang['delete']='L�schen';//'Delete';
$lang['back']='Zur�ck';//'Back';
$lang['object']='Objekt';//'object';
//$lang['objects']='Objekte';//'objects';
$lang['delete_all']='L�sche alle';//'Delete all';
$lang['url_bug_report']=''+$lang['url_bug_report'];//'https://sourceforge.net/tracker/?func=add&group_id=61828&atid=498546';
$lang['hint'] = 'Hinweis';//'hint';
$lang['bug'] = 'Programmfehler';//'bug';
$lang['warning'] = 'Warnung';//'warning';
$lang['light'] = 'light'; // the word 'light' from 'light bulb'
$lang['proceed_gt'] = 'Weiter';//'Proceed &gt;&gt;';


// Add value form
$lang['add_new'] = 'Neu hinzuf�gen';//'Add new';
$lang['value_to'] = 'Wert auf';//'value to';
//also used in copy_form.php
$lang['distinguished_name'] = 'Distinguished Name (eindeutiger Name)';// 'Distinguished Name';
$lang['current_list_of'] = 'Aktuelle Liste von';//'Current list of';
$lang['values_for_attribute'] = 'Werte des Attributes';//'values for attribute';
$lang['inappropriate_matching_note'] = 'Info: Sie werden einen "inappropriate matching" Fehler erhalten, falls sie nicht'; //'Note: You will get an "inappropriate matching" error if you have not<br />' .
			' eine "EQUALITY" Regel f�r dieses Attribut auf ihren LDAP Server eingerichtet haben.';//'setup an <tt>EQUALITY</tt> rule on your LDAP server for this attribute.';
$lang['enter_value_to_add'] = 'Geben sie den Wert ein den sie hinzuf�gen m�chten:';//'Enter the value you would like to add:';
$lang['new_required_attrs_note'] = 'Info: Sie werden gegebenenfalles gezwungen sein neue Attribute hinzuzuf�gen.';//'Note: you may be required to enter new attributes<br />that this objectClass requires.';
$lang['syntax'] = 'Syntax';//'Syntax';

//Copy.php
$lang['copy_server_read_only'] = 'Sie k�nnen keine Aktualisierungen durchf�hren w�hrend der Server sich im \'nur lese\'-modus befindet';//"You cannot perform updates while server is in read-only mode';
$lang['copy_dest_dn_blank'] = 'Sie haben kein Ziel DN angegeben';//"You left the destination DN blank.';
$lang['copy_dest_already_exists'] = 'Der Zieleintrag (%s) existiert bereits.';//"The destination entry (%s) already exists.';
$lang['copy_dest_container_does_not_exist'] = 'Der Zielcontainer (%s) existiert nicht.';//'The destination container (%s) does not exist.';
$lang['copy_source_dest_dn_same'] = 'Ursprung DN und Ziel DN sind identisch';//"The source and destination DN are the same.';
$lang['copy_copying'] = 'Kopieren';//"Copying ';
$lang['copy_recursive_copy_progress'] = 'Rekursives Kopieren im Gange';//"Recursive copy progress';
$lang['copy_building_snapshot'] = 'Erzeuge Speicherauszug des zu kopierenden Verzeichnisses';//"Building snapshot of tree to copy... ';
$lang['copy_successful_like_to'] = 'Kopieren erfolgreich! Wollen sie den';//"Copy successful! Would you like to ';
$lang['copy_view_new_entry'] = 'neuen Eintrag ansehen';//"view the new entry';
$lang['copy_failed'] = 'Kopieren des DN fehlgeschlagen: ';//'Failed to copy DN: ';


//edit.php
$lang['missing_template_file'] = 'Warnung: Template Datei nicht gefunden';//'Warning: missing template file, ';
$lang['using_default'] = 'Standardeinstellung verwenden';//'Using default.';
$lang['template'] = 'Vorlage';//'Template';
$lang['must_choose_template'] = 'Eine Vorlage muss ausgew�hlt sein';//'You must choose a template';
$lang['invalid_template'] = 'Die Vorlage "%s" ist ung�ltig';// '%s is an invalid template';
$lang['using_template'] = 'Verwende Vorlage';//'using template';
$lang['go_to_dn'] = 'Gehe zu %s';//'Go to %s';

//copy_form.php
$lang['copyf_title_copy'] = 'Kopiere';//"Copy ';
$lang['copyf_to_new_object'] = 'in ein neues Objekt';//"to a new object';
$lang['copyf_dest_dn'] = 'Ziel DN';//"Destination DN';
$lang['copyf_dest_dn_tooltip'] = 'Der komplette DN des Eintrages der beim Kopieren erzeugt wird.';//'The full DN of the new entry to be created when copying the source entry';
$lang['copyf_dest_server'] = 'Zielserver';//"Destination Server';
$lang['copyf_note'] = 'Info: Kopieren zwischen unterschiedlichen Servern funktioniert nur wenn keine Unvereinbarkeiten im Schema auftreten';//"Note: Copying between different servers only works if there are no schema violations';
$lang['copyf_recursive_copy'] = 'Rekursiv kopiert auch alle Unterobjekte';//"Recursively copy all children of this object as well.';
$lang['recursive_copy'] = 'Rekursives kopieren';//'Recursive copy';
$lang['filter'] = 'Filter';//'Filter';
$lang['filter_tooltip'] = 'Bei der Ausf�rung des rekursiven Kopierens werden nur die Eintr�ge verwendet, die mit dem Filter �bereinstimmen';// 'When performing a recursive copy, only copy those entries which match this filter';


//create.php
$lang['create_required_attribute'] = 'Fehler, sie haben einen Wert f�r ein ben�tigtes Attribut frei gelassen.';//"Error, you left the value blank for required attribute ';
$lang['redirecting'] = 'Weiterleitung';//"Redirecting'; moved from create_redirection -> redirection
$lang['here'] = 'hier';//"here'; renamed vom create_here -> here
$lang['create_could_not_add'] = 'Konnte das Objekt dem LDAP-Server nicht hinzuf�gen.';//"Could not add the object to the LDAP server.';

//create_form.php
$lang['createf_create_object'] = 'Erzeuge einen neuen Eintag';//"Create Object';
$lang['createf_choose_temp'] = 'Vorlage w�hlen';//"Choose a template';
$lang['createf_select_temp'] = 'W�hlen sie eine Vorlage f�r das Objekt';//"Select a template for the creation process';
$lang['createf_proceed'] = 'Weiter';//"Proceed &gt;&gt;';
$lang['rdn_field_blank'] = 'Das RDN Feld wurde leer gelassen.';//'You left the RDN field blank.';
$lang['container_does_not_exist'] = 'Der angegenben Eintrag (%s) ist nicht vorhanden. Bitte erneut versuchen.';// 'The container you specified (%s) does not exist. Please try again.';
$lang['no_objectclasses_selected'] = 'Es wurde kein ObjectClasses f�r diesen Eintrag ausgew�hlt. Bitte zur�ckgehen und korrigieren';//'You did not select any ObjectClasses for this object. Please go back and do so.';
$lang['hint_structural_oclass'] = 'Hinweis: Es muss mindestens ein Strukturelle ObjectClass ausgew�hlt sein.';//'Hint: You must choose at least one structural objectClass';

//creation_template.php
$lang['ctemplate_on_server'] = 'Auf dem Server';//"On server';
$lang['ctemplate_no_template'] = 'Keine Vorlage angegeben in den POST Variabeln';//"No template specified in POST variables.';
$lang['ctemplate_config_handler'] = 'Ihre Konfiguration spezifiziert f�r diese Vorlage die Routine';//"Your config specifies a handler of';
$lang['ctemplate_handler_does_not_exist'] = '. Diese Routine existiert nicht im \'templates/creation\' Verzeichnis';//"for this template. But, this handler does not exist in the 'templates/creation' directory.';
$lang['create_step1'] = 'Schritt 1 von 2: Name und Objektklasse(n)';//'Step 1 of 2: Name and ObjectClass(es)';
$lang['create_step2'] = 'Schritt 2 von 2: Bestimmen der Attribute und Werte';//'Step 2 of 2: Specify attributes and values';
$lang['relative_distinguished_name'] = 'Relativer Distingushed Name';//'Relative Distinguished Name';
$lang['rdn'] = 'RDN';//'RDN';
$lang['rdn_example'] = '(Beispiel: cn=MeineNeuePerson)';//'(example: cn=MyNewPerson)';
$lang['container'] = 'Beh�lter';//'Container';


// search.php
$lang['you_have_not_logged_into_server'] = 'Sie haben sich am ausgew�hlten Server nicht angemeldet. Sie k�nnen keine Suche durchf�hren.';//'You have not logged into the selected server yet, so you cannot perform searches on it.';
$lang['click_to_go_to_login_form'] = 'Klicken sie hier um zur Anmeldeseite zu gelangen';//'Click here to go to the login form';
$lang['unrecognized_criteria_option'] = 'Unbekannte Option';// 'Unrecognized criteria option: ';
$lang['if_you_want_to_add_criteria'] = 'Falls eigene Auswahlkriterien hinzugef�gt werden sollen, muss \'search.php\' editiert werden';//'If you want to add your own criteria to the list. Be sure to edit search.php to handle them. Quitting.';
$lang['entries_found'] = 'Gefundene Eintr�ge: ';//'Entries found: ';
$lang['filter_performed'] = 'Angewanter Filter: ';//'Filter performed: ';
$lang['search_duration'] = 'Suche durch phpLDAPadmin ausgef�hrt in';//'Search performed by phpLDAPadmin in';
$lang['seconds'] = 'Sekunden';//'seconds';

// search_form_advanced.php
$lang['scope_in_which_to_search'] = 'Bereich der durchsucht wird.';//'The scope in which to search';
$lang['scope_sub'] = 'Sub (Suchbasis und alle Unterverzeichnisebenen)';//'Sub (entire subtree)';
$lang['scope_one'] = 'One (Suchbasis und eine Unterverzeichnisebene)';//'One (one level beneath base)';
$lang['scope_base'] = 'Base (Nur Suchbasis)';//'Base (base dn only)';
$lang['standard_ldap_search_filter'] = 'Standard LDAP Suchfilter. Bsp.: (&(sn=Smith)(givenname=David))';//'Standard LDAP search filter. Example: (&(sn=Smith)(givenname=David))';
$lang['search_filter'] = 'Suchfilter';//'Search Filter';
$lang['list_of_attrs_to_display_in_results'] = 'Kommaseparierte Liste der anzuzeigenden Attribute.';//'A list of attributes to display in the results (comma-separated)';

// search_form_simple.php
$lang['starts with'] = 'beginnt mit';//'starts with';
$lang['ends with'] = 'endet auf';//'ends with';
$lang['sounds like'] = 'klingt wie';//'sounds like';


// server_info.php
$lang['could_not_fetch_server_info'] = 'Konnte keine LDAP Informationen vom Server empfangen';//'Could not retrieve LDAP information from the server';
$lang['server_info_for'] = 'Serverinformationen f�r: ';//'Server info for: ';
$lang['server_reports_following'] = 'Der Server meldete die folgenden Informationen �ber sich';//'Server reports the following information about itself';
$lang['nothing_to_report'] = 'Der Server hat keine Informationen gemeldet';//'This server has nothing to report.';

//update.php
$lang['update_array_malformed'] = 'Das "update_array" wird falsch dargestellt. Dies k�nnte ein phpLDAPadmin Fehler sein. Bitte Berichten sie uns davon.';//'update_array is malformed. This might be a phpLDAPadmin bug. Please report it.';
$lang['could_not_perform_ldap_modify'] = 'Konnte die \'ldap_modify\' Operation nicht ausf�hren.';//'Could not perform ldap_modify operation.';

// update_confirm.php
$lang['do_you_want_to_make_these_changes'] = 'Wollen sie diese �nderungen �bernehmen?';//'Do you want to make these changes?';
$lang['attribute'] = 'Attribute';//'Attribute';
$lang['old_value'] = 'Alter Wert';//'Old Value';
$lang['new_value'] = 'Neuer Wert';//'New Value';
$lang['attr_deleted'] = '[Wert gel�scht]';//'[attribute deleted]';
$lang['commit'] = 'Anwenden';//'Commit';
$lang['cancel'] = 'Abbruch';//'Cancel';
$lang['you_made_no_changes'] = 'Sie haben keine �nderungen vorgenommen.';//'You made no changes';
$lang['go_back'] = 'Zur�ck';//'Go back';

// welcome.php
$lang['welcome_note'] = 'Benutzen sie das Menu auf der linken Seite zur Navigation.';//'Use the menu to the left to navigate';
$lang['credits'] = 'Vorspann';//'Credits';
$lang['changelog'] = '�nderungsdatei';//'ChangeLog';
//$lang['documentation'] = 'Dokumentation';// 'Documentation';
$lang['donate'] = 'Spende';//'Donate';

// view_jpeg_photo.php
$lang['unsafe_file_name'] = 'Unsicherer Dateiname:';//'Unsafe file name: ';
$lang['no_such_file'] = 'Keine Datei unter diesem Namen';//'No such file: ';

//function.php
$lang['auto_update_not_setup'] = '"auto_uid_numbers" wurde in der Konfiguration (%s) aktiviert, aber der Mechanismus (auto_uid_number_mechanism) nicht. Bitte diese Problem korrigieren.';//"You have enabled auto_uid_numbers for <b>%s</b> in your configuration, but you have not specified the auto_uid_number_mechanism. Please correct this problem.';
$lang['uidpool_not_set'] = 'Der Mechanismus "auto_uid_number_mechanism" ist als "uidpool" f�r den Server (%s) festgelegt, jedoch wurde nicht der "auto_uid_number_uid_pool_dn" festgelegt. Bitte korrigieren und dann weiter verfahren.';//"You specified the <tt>auto_uid_number_mechanism</tt> as <tt>uidpool</tt> in your configuration for server <b>%s</b>, but you did not specify the audo_uid_number_uid_pool_dn. Please specify it before proceeding.';

$lang['uidpool_not_exist'] = 'Es scheint so, dass der "uidPool" - der in der Konfiguration festgelegt ist - nicht vorhanden ist.';//"It appears that the uidPool you specified in your configuration (<tt>%s</tt>) does not exist.';

$lang['specified_uidpool'] = 'Der "auto_uid_number_mechanism" wurde auf "search" in der Konfiguration des Servers (%s) festgelegt, aber es wurde der Wert f� "auto_uid_number_search_base" nicht gesetzt. Bitte korrigieren und dann weiter verfahren.';//"You specified the <tt>auto_uid_number_mechanism</tt> as <tt>search</tt> in your configuration for server <b>%s</b>, but you did not specify the <tt>auto_uid_number_search_base</tt>. Please specify it before proceeding.';
$lang['bad_auto_uid_search_base'] = 'Die phpLDAPadmin Konfiguration f�r den Server "%s" gibt eine ung�ltige Suchbasis f�r "auto_uid_search_base" an.';//'Your phpLDAPadmin configuration specifies an invalid auto_uid_search_base for server %s';
$lang['auto_uid_invalid_credential'] = 'Konnte nicht mit "%s" verbinden';// 'Unable to bind to <b>%s</b> with your with auto_uid credentials. Please check your configuration file.'; 
$lang['auto_uid_invalid_value'] = 'Es wurde ein ung�ltiger Wert f�r "auto_uid_number_mechanism" (%s) festgelegt. G�ltig sind nur die Werte "uidpool" und "search". Bitte den Fehler korrigieren. ';//"You specified an invalid value for auto_uid_number_mechanism (<tt>%s</tt>) in your configration. Only <tt>uidpool</tt> and <tt>search</tt> are valid. Please correct this problem.';

$lang['error_auth_type_config'] = 'Fehler: Ein Fehler ist in der Konfiguration (config.php) aufgetreten. Die einzigen beiden erlaubten Werte im Konfigurationsteil "auth_type" zu einem LDAP-Server ist "config" oder "form". Eingetragen ist aber "%s", was nicht erlaubt ist.';//"Error: You have an error in your config file. The only two allowed values for 'auth_type' in the $servers section are 'config' and 'form'. You entered '%s', which is not allowed. ';

$lang['php_install_not_supports_tls'] = 'Die verwendete PHP-Version unterst�tzt kein TLS (verschl�sselte Verbindung).';//"Your PHP install does not support TLS';
$lang['could_not_start_tls'] = 'TLS konnte nicht gestartet werden. Bitte die LDAP-Server-Konfiguration �berpr�fen.';//"Could not start TLS.<br />Please check your LDAP server configuration.';
$lang['could_not_bind_anon'] = 'Konnte keine Anonymous Anmeldung zum Server herstellen.';//'Could not bind anonymously to server.';
$lang['could_not_bind'] = 'Konnte keine Verbindung zum LDAP-Server herstellen';//'Could not bind to the LDAP server.';
//$lang['anon_required_for_login_attr'] = 'Bei der Verwendung des Anmeldeprozedur "login_attr" muss der Server Anonymous Anmelden zulassen.';//'When using the login_attr feature, the LDAP server must support anonymous binds.';
$lang['anonymous_bind'] = 'Anonymous anmelden';//'Anonymous Bind';
//$lang['auth_type_not_valid'] = 'Die Konfigurationsdatei enth�lt einen Fehler. Der Eintrag f�r \'auth_type\' mit \'%s\' ist nicht g�ltig';// 'You have an error in your config file. auth_type of %s is not valid.';
$lang['bad_user_name_or_password'] = 'Falscher Benutzername oder Passwort. Bitte erneut versuchen.';//'Bad username or password. Please try again.';
$lang['redirecting_click_if_nothing_happens'] = 'Automatische Umleitung. Falls dies nicht automatisch erfolgt dann hier klicken.';//'Redirecting... Click here if nothing happens.';
$lang['successfully_logged_in_to_server'] = 'Erfolgreich am Server %s angemeldet';//'Successfully logged into server <b>%s</b>';
$lang['could_not_set_cookie'] = 'Konnte kein \'Cookie\' setzten.';//'Could not set cookie.';
$lang['ldap_said'] = 'LDAP meldet: %s';//"<b>LDAP said</b>: %s<br /><br />';
$lang['ferror_error'] = 'Fehler';//"Error';
$lang['fbrowse'] = '�berfliegen';//"browse';
$lang['delete_photo'] = 'L�sche Foto';//"Delete Photo';
$lang['install_not_support_blowfish'] = 'Die verwendete PHP-Version unterst�tzt keine Blowfish Verschl�sselung.';//"Your PHP install does not support blowfish encryption.';
$lang['install_not_support_md5crypt'] = 'Die eingesetzte PHP-Version unterst�tzt keine MD5-Verschl�sselung.';//'Your PHP install does not support md5crypt encryption.';
$lang['install_no_mash'] = 'Die verwendete PHP-Version unterst�tzt nicht die Funktion mhash(), daher kann kein SHA Hash verwendet werden.';// "Your PHP install does not have the mhash() function. Cannot do SHA hashes.';
$lang['jpeg_contains_errors'] = 'Die Bilddatei enth�lt Fehler';//"jpegPhoto contains errors<br />';
$lang['ferror_number'] = 'Fehlernummer: %s (%s)';//"<b>Error number</b>: %s <small>(%s)</small><br /><br />';
$lang['ferror_discription'] ='Beschreibung: %s';// "<b>Description</b>: %s <br /><br />';
$lang['ferror_number_short'] = 'Fehlernummer: %s';//"<b>Error number</b>: %s<br /><br />';
$lang['ferror_discription_short'] = 'Beschreibung: (keine Beschreibung verf�gbar)';//"<b>Description</b>: (no description available)<br />';
$lang['ferror_submit_bug'] = 'Ist das ein phpLDAPadmin Fehler? Wenn dies so ist, dann bitte <a href=\'%s\'>dar�ber berichten</a>';//"Is this a phpLDAPadmin bug? If so, please <a href=\'%s\'>report it</a>.';
$lang['ferror_unrecognized_num'] = 'Unbekannte Fehlernummer:';//"Unrecognized error number: ';

$lang['ferror_nonfatil_bug'] = '<center><table class=\'notice\'><tr><td colspan=\'2\'><center><img src=\'images/warning.png\' height=\'12\' width=\'13\' /><b>Ein nicht fataler Fehler in phpLDAPadmin gefunden!</b></td></tr><tr><td>Fehler:</td><td><b>%s</b> (<b>%s</b>)</td></tr><tr><td>Datei:</td><td><b>%s</b>Zeile:<b>%s</b>, aufgerufen von <b>%s</b></td></tr><tr><td>Version:</td><td>PLA: <b>%s</b>, PHP: <b>%s</b>, SAPI: <b>%s</b></td></tr><tr><td>Web server:</td><td><b>%s</b></td></tr><tr><td colspan=\'2\'><center><a target=\'new\' href=\'%s\'>Bitte diesen Fehler melden (durch anklicken).</a>.</center></td></tr></table></center><br />';//"<center><table class=\'notice\'><tr><td colspan=\'2\'><center><img src=\'images/warning.png\' height=\'12\' width=\'13\' /><b>You found a non-fatal phpLDAPadmin bug!</b></td></tr><tr><td>Error:</td><td><b>%s</b> (<b>%s</b>)</td></tr><tr><td>File:</td><td><b>%s</b> line <b>%s</b>, caller <b>%s</b></td></tr><tr><td>Versions:</td><td>PLA: <b>%s</b>, PHP: <b>%s</b>, SAPI: <b>%s</b></td></tr><tr><td>Web server:</td><td><b>%s</b></td></tr><tr><td colspan=\'2\'><center><a target=\'new\' href=\'%s\'>Please report this bug by clicking here</a>.</center></td></tr></table></center><br />';

$lang['ferror_congrats_found_bug'] = '<center><table class=\'notice\'><tr><td colspan=\'2\'><center><img src=\'images/warning.png\' height=\'12\' width=\'13\' /><b>Gratulation, einen Fehler in phpLDAPadmin gefunden!</b></td></tr><tr><td>Fehler:</td><td><b>%s</b> (<b>%s</b>)</td></tr><tr><td>Datei:</td><td><b>%s</b>Zeile:<b>%s</b>, aufgerufen von <b>%s</b></td></tr><tr><td>Version:</td><td>PLA: <b>%s</b>, PHP: <b>%s</b>, SAPI: <b>%s</b></td></tr><tr><td>Web server:</td><td><b>%s</b></td></tr><tr><td colspan=\'2\'><center><a target=\'new\' href=\'%s\'>Bitte diesen Fehler melden (durch anklicken).</a>.</center></td></tr></table></center><br />';//"Congratulations! You found a bug in phpLDAPadmin.<br /><br /><table class=\'bug\'><tr><td>Error:</td><td><b>%s</b></td></tr><tr><td>Level:</td><td><b>%s</b></td></tr><tr><td>File:</td><td><b>%s</b></td></tr><tr><td>Line:</td><td><b>%s</b></td></tr><tr><td>Caller:</td><td><b>%s</b></td></tr><tr><td>PLA Version:</td><td><b>%s</b></td></tr><tr><td>PHP Version:</td><td><b>%s</b></td></tr><tr><td>PHP SAPI:</td><td><b>%s</b></td></tr><tr><td>Web server:</td><td><b>%s</b></td></tr></table><br /> Please report this bug by clicking below!';

//ldif_import_form
$lang['import_ldif_file_title'] = 'Importiere LDIF Datei';//'Import LDIF File';
$lang['select_ldif_file'] = 'LDIF Datei ausw�hlen';//'Select an LDIF file:';
$lang['select_ldif_file_proceed'] = 'Ausf�hren';//'Proceed &gt;&gt;';
$lang['dont_stop_on_errors'] = 'Bei einem Fehler nicht unterbrechen sondern weitermachen.';//'Don\'t stop on errors';

//ldif_import
$lang['add_action'] = 'Hinzuf�gen...';//'Adding...';
$lang['delete_action'] = 'Entfernen...';//'Deleting...';
$lang['rename_action'] = 'Umbenennen...';//'Renaming...';
$lang['modify_action'] = 'Ab�ndern...';//'Modifying...';
$lang['warning_no_ldif_version_found'] = 'Keine Version gefunden. Gehe von der Version 1 aus.';//'No version found. Assuming 1.';
$lang['valid_dn_line_required'] = 'Eine g�ltige DN Zeile wird ben�tigt.';//'A valid dn line is required.';
$lang['missing_uploaded_file'] = 'Hochgeladene Datei fehlt.';//'Missing uploaded file.';
$lang['no_ldif_file_specified.'] = 'Kein LDIF-Datei angegeben. Bitte erneut versuchen.';//'No LDIF file specified. Please try again.';
$lang['ldif_file_empty'] = 'Die hochgeladene LDIF-Datei ist leer.';// 'Uploaded LDIF file is empty.';
$lang['empty'] = 'leer';//'empty';
$lang['file'] = 'Datei';//'File';
$lang['number_bytes'] = '%s Bytes';//'%s bytes';

$lang['failed'] = 'fehlgeschlagen';//'failed';
$lang['ldif_parse_error'] = 'LDIF Pars Fehler';//'LDIF Parse Error';
$lang['ldif_could_not_add_object'] = 'Konnte das Objekt nicht hinzuf�gen:';//'Could not add object:';
$lang['ldif_could_not_rename_object'] = 'Konnte das Objekt nicht umbenennen:';//'Could not rename object:';
$lang['ldif_could_not_delete_object'] = 'Konnte das Objekt nicht entfernen:';//'Could not delete object:';
$lang['ldif_could_not_modify_object'] = 'Konnte das Objekt nicht ab�ndern:';//'Could not modify object:';
$lang['ldif_line_number'] = 'Anzahl Zeilen:';//'Line Number:';
$lang['ldif_line'] = 'Zeile:';//'Line:';

//delete_form
$lang['sure_permanent_delete_object']='Sind Sie sicher das Sie dauerhaft den Eintrag l�schen wollen?';//'Are you sure you want to permanently delete this object?';
$lang['permanently_delete_children']='L�sche alles und auch die Untereintr�ge?';//'Permanently delete all children also?';
//$lang['info_delete_recursive_1']='Dieser Objekt-Eintrag hat weitere Untereintr�ge';//'This object is the root of a sub-tree containing objects.'; 
//$lang['info_delete_recursive_2']='phpLDAPadmin kann rekursiv diesen Objekt-Eintrag mit all seinen Untereintr�gen l�schen.';//'phpLDAPadmin can recursively delete this object and all of its children.';
//$lang['info_delete_recursive_3']='Unten ist eine Liste mit allen Eintr�gen (DN) aufgef�hrt die gel�scht werden. Soll dies wirklich durchgef�hrt werden?';//'See below for a list of DNs that this will delete. Do you want to do this?';
//$lang['note_delete_noundo']='Hinweis: Dies ist sehr gef�hrlich. Die Aktion kann nicht r�ckg�ngig gemacht werden. Synomyme (alias) und �hnliche Eintr�ge  k�nnen zu Problemen f�hren.'; // 'Note: This is potentially very dangerous and you do this at your own risk. This operation cannot be undone. Take into consideration aliases and other such things that may cause problems.';
//$lang['list_of_dn_delete']='Liste aller DN(s) die mit dieser Aktion mitgel�scht werden.';//'A list of all the DN(s) that this action will delete:';
//$lang['cannot_delete_base_dn']='Der Basis DN kann nicht gel�scht werden';//'You cannot delete the base DN entry of the LDAP server.';

$lang['list_of_entries_to_be_deleted'] = 'List der Eintr�ge die gel�scht werden:';//'List of entries to be deleted:';
$lang['dn'] = 'DN'; //'DN';

// Exports
$lang['export_format'] = 'Export Format';// 'Export format';
$lang['line_ends'] = 'Zeilenende'; //'Line ends';
$lang['must_choose_export_format'] = 'Bitte ein Exportformat ausw�hlen';//'You must choose an export format.';
$lang['invalid_export_format'] = 'Ungl�ltiges Export-Format';//'Invalid export format';
$lang['no_exporter_found'] = 'Keinen g�ltigen Exporter gefunden.';//'No available exporter found.';
$lang['error_performing_search'] = 'Ein Fehler trat w�hrend des Suchvorgangs auf';//'Encountered an error while performing search.';
$lang['showing_results_x_through_y'] = 'Zeige die Ergebnisse von %s bis %s.';//'Showing results %s through %s.';
$lang['searching'] = 'Suche...';//'Searching...';
$lang['size_limit_exceeded'] = 'Hinweis, das Limit der Suchtreffer wurde �berschritten.';//'Notice, search size limit exceeded.';
$lang['entry'] = 'Eintrag';//'Entry';
$lang['ldif_export_for_dn'] = 'LDIF Export von: %s'; //'LDIF Export for: %s';
$lang['generated_on_date'] = 'Erstellt von phpLDAPadmin am %s';//'Generated by phpLDAPadmin on %s';
$lang['total_entries'] = 'Anzahl der Eintraege';//'Total Entries';
$lang['dsml_export_for_dn'] = 'DSLM Export von:';//'DSLM Export for: %s';

// logins
$lang['could_not_find_user'] = 'Konnte den Benutzer %s nicht finden.';//'Could not find a user "%s"';
$lang['password_blank'] = 'Das Passwort wurde leer gelassen';//'You left the password blank.';
$lang['login_cancelled'] = 'Anmeldung abgebrochen';//'Login cancelled.';
$lang['no_one_logged_in'] = 'Niemand ist an diesem Server angemeldet';//'No one is logged in to that server.';
$lang['could_not_logout'] = 'Konnte nicht abgemeldet werden';//'Could not logout.';
//$lang['browser_close_for_http_auth_type'] = 'You must close your browser to logout whie in \'http\' authentication mode';
$lang['unknown_auth_type'] = 'Unbekannter Authentifizierungsart: %s';//'Unknown auth_type: %s';
$lang['logged_out_successfully'] = 'Erfolgreich vom Server %s abgemeldet.';//'Logged out successfully from server <b>%s</b>';
$lang['authenticate_to_server'] = 'Authentifizierung mit Server %s';//'Authenticate to server %s';
$lang['warning_this_web_connection_is_unencrypted'] = 'Achtung: Diese Webverbindung ist unverschl�sselt.';//'Warning: This web connection is unencrypted.';
$lang['not_using_https'] = 'Es wird keine verschl�sselte Verbindung (\'https\') verwendet. Der Webbrowser �bermittelt die Anmeldeinformationen im Klartext.';// 'You are not use \'https\'. Web browser will transmit login information in clear text.';
$lang['login_dn'] = 'Anmelde DN';//'Login DN';
$lang['user_name'] = 'Benutzername';//'User name';
$lang['password'] = 'Passwort';//'Password';
$lang['authenticate'] = 'Authentifizierung';//'Authenticate';

// Entry browser
$lang['entry_chooser_title'] = 'Eintr�ge ausw�hlen';//'Entry Chooser';

// Index page
$lang['need_to_configure'] = 'phpLDAPadmin muss konfiguriert werden. Bitte die Datei "config.php" erstellen. Ein Beispiel einer "config.php" liegt als Datei "config.php.example" bei.';// ';//'You need to configure phpLDAPadmin. Edit the file \'config.php\' to do so. An example config file is provided in \'config.php.example\'';

// Mass deletes
$lang['no_deletes_in_read_only'] = 'L�schen ist im Nur-Lese-Modus nicht erlaubt.';//'Deletes not allowed in read only mode.';
$lang['error_calling_mass_delete'] = 'Fehler im Aufruf von "mass_delete.php". "mass_delete" ist in den POST-Variablen nicht vorhanden.';//'Error calling mass_delete.php. Missing mass_delete in POST vars.';
$lang['mass_delete_not_array'] = 'Die POST-Variable "mass_delete" ist kein Array.';//'mass_delete POST var is not an array.';
$lang['mass_delete_not_enabled'] = '"Viel-L�schen" ist nicht aktiviert. Bitte in der der "config.php" aktivieren vor dem Weitermachen.';//'Mass deletion is not enabled. Please enable it in config.php before proceeding.';
$lang['mass_deleting'] = 'Viel-L�schen';//'Mass Deleting';
$lang['mass_delete_progress'] = 'L�schprozess auf Server "%s"';//'Deletion progress on server "%s"';
$lang['malformed_mass_delete_array'] = 'Das Array "mass_delete" ist falsch dargestellt.';//'Malformed mass_delete array.';
$lang['no_entries_to_delete'] = 'Es wurde kein zu l�schender Eintrag ausgew�hlt.';//'You did not select any entries to delete.';
$lang['deleting_dn'] = 'L�sche "%s"';//'Deleting %s';
$lang['total_entries_failed'] = '%s von %s Eintr�gen konnten nicht gel�scht werden.';//'%s of %s entries failed to be deleted.';
$lang['all_entries_successful'] = 'Alle Eintr�ge wurden erfolgreich gel�scht.';//'All entries deleted successfully.';
$lang['confirm_mass_delete'] = 'Bitte das L�schen von %s Eintr�gen auf dem Server %s best�tigen';//'Confirm mass delete of %s entries on server %s';
$lang['yes_delete'] = 'Ja, L�schen!';//'Yes, delete!';


// Renaming entries
$lang['non_leaf_nodes_cannot_be_renamed'] = 'Das Umbenennen von einem Eintrag mit Untereintr�gen ist nicht M�glich. Es ist nur auf den Untersten Eintr�gen gestattet.';// 'You cannot rename an entry which has children entries (eg, the rename operation is not allowed on non-leaf entries)';
$lang['no_rdn_change'] = 'Der RDN wurde nicht ver�ndert';//'You did not change the RDN';
$lang['invalid_rdn'] = 'Ung�ltiger RDN Wert';//'Invalid RDN value';
$lang['could_not_rename'] = 'Der Eintrag konnte nicht umbenannt werden';//'Could not rename the entry';


?>
