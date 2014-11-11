<?php
// $Header: /cvsroot/phpldapadmin/phpldapadmin/lang/sv.php,v 1.2 2004/03/19 20:13:09 i18phpldapadmin Exp $

/*
 * Translated by Gunnar Nystrom <gunnar (dot) a (dot) nystrom (at) telia (dot)  com>
 * based on 0.9.3 Version
 
*/

// Search form
$lang['simple_search_form_str'] = 'Enkel s�kning';//'Simple Search Form';
$lang['advanced_search_form_str'] = 'Experts�kning';//'Advanced Search Form';
$lang['server'] = 'Server';//'Server';
$lang['search_for_entries_whose'] = 'S�k efter rader som';//'Search for entries whose';
$lang['base_dn'] = 'Base DN';//'Base DN';
$lang['search_scope'] = 'S�komf�ng';//Search Scope';
$lang['search_ filter'] = 'S�kfilter';//'Search Filter';
$lang['show_attributes'] = 'Visa attribut';//'Show Attributtes';
$lang['Search'] = 'S�k';// 'Search';
$lang['equals'] = 'lika med';//'equals';
$lang['starts_with'] = 'B�rjar med';//'starts with';
$lang['contains'] = 'inneh�ller';//'contains';
$lang['ends_with'] = 'slutar med';//'ends with';
$lang['sounds_like'] = 'l�ter som';//'sounds like';

// Tree browser
$lang['request_new_feature'] = 'Beg�r en ny funktion';//'Request a new feature';
$lang['see_open_requests'] = 'Se �ppna f�rfr�gningar';//'see open requests';
$lang['report_bug'] = 'Rapportera ett fel';//'Report a bug';
$lang['see_open_bugs'] = 'Se �ppna felrapporter';//'see open bugs';
$lang['schema'] = 'schema';//'schema';
$lang['search'] = 's�kning';//'search';
$lang['create'] = 'skapa';//'create';
$lang['info'] = 'information';//'info';
$lang['import'] = 'importera';//'import';
$lang['refresh'] = 'uppdatera';//'refresh';
$lang['logout'] = 'logga ut';//'logout';
$lang['create_new'] = 'Skapa ny';//'Create New';
$lang['view_schema_for'] = 'Titta p� schema f�r';//'View schema for';
$lang['refresh_expanded_containers'] = 'Uppdatera alla �pnna beh�llare f�r';//'Refresh all expanded containers for';
$lang['create_new_entry_on'] = 'Skapa en ny post f�r';//'Create a new entry on';
$lang['view_server_info'] = 'Titta p� information som servern tillhandah�llit';//'View server-supplied information';
$lang['import_from_ldif'] = 'Importera rader fr�n LDIF file';//'Import entries from an LDIF file';
$lang['logout_of_this_server'] = 'Logga ut fr�n den h�r servern';//'Logout of this server';
$lang['logged_in_as'] = '/Inloggad som';//'Logged in as: ';
$lang['read_only'] = 'Enbart l�sning';//'read only';
$lang['could_not_determine_root'] = 'Kan inte best�mma roten f�r ditt LDAP tr�d';//'Could not determine the root of your LDAP tree.';
$lang['ldap_refuses_to_give_root'] = 'Det ser ut som om LDAP-servern har konfigurerats att inte avsl�ja sin rot.';//'It appears that the LDAP server has been configured to not reveal its root.';
$lang['please_specify_in_config'] = 'Var sn�ll och specificera i config.php';//'Please specify it in config.php';
$lang['create_new_entry_in'] = 'Skapa en ny post i';//'Create a new entry in';
$lang['login_link'] = 'Logga in...';//'Login...';

// Entry display
$lang['delete_this_entry'] = 'Ta bort den h�r posten';//'Delete this entry';
$lang['delete_this_entry_tooltip'] = 'Du kommer att bli tillfr�gad f�r att konfirmera det h�r beslutet';//'You will be prompted to confirm this decision';
$lang['copy_this_entry'] = 'Kopiera den h�r posten';//'Copy this entry';
$lang['copy_this_entry_tooltip'] = 'Kopiera det h�r objektet till en annan plats, ett nytt DN, eller en annan server';//'Copy this object to another location, a new DN, or another server';
$lang['export_to_ldif'] = 'Exportera till LDIF';//'Export to LDIF';
$lang['export_to_ldif_tooltip'] = 'Spara en LDIF kopia av detta objekt';//'Save an LDIF dump of this object';
$lang['export_subtree_to_ldif_tooltip'] = 'Spara en LDIF kopia av detta objekt och alla dess underobjekt';//'Save an LDIF dump of this object and all of its children';
$lang['export_subtree_to_ldif'] = 'Exportera subtr�det till LDIF';//'Export subtree to LDIF';
$lang['export_to_ldif_mac'] = 'Radslut enligt Macintosh-standard';// 'Macintosh style line ends';
$lang['export_to_ldif_win'] = 'Radslut enligt Windows-standard';//'Windows style line ends';
$lang['export_to_ldif_unix'] = 'Radslut enligt Unix-standard';//'Unix style line ends';
$lang['create_a_child_entry'] = 'Skapa en subpost';//'Create a child entry';
$lang['add_a_jpeg_photo'] = 'L�gg till ett JPEG-foto';//'Add a jpegPhoto';
$lang['rename_entry'] = 'D�p om posten';//'Rename Entry';
$lang['rename'] = 'D�p om ';//'Rename';
$lang['add'] = 'L�gg till';//'Add';
$lang['view'] = 'Titta';//'View';
$lang['add_new_attribute'] = 'L�gg till ett nytt attribut';//'Add New Attribute';
$lang['add_new_attribute_tooltip'] = 'L�gg till ett nytt attribut/v�rde till denna post';//'Add a new attribute/value to this entry';
$lang['internal_attributes'] = 'Interna attribut';//'Internal Attributes';
$lang['hide_internal_attrs'] = 'G�m interna attribut';//'Hide internal attributes';
$lang['show_internal_attrs'] ='Visa interna attribut';// 'Show internal attributes';
$lang['internal_attrs_tooltip'] = 'Attribut som s�tts automatiskt av systemet';//'Attributes set automatically by the system';
$lang['entry_attributes'] = 'Ing�ngsattribut';//'Entry Attributes';
$lang['attr_name_tooltip'] = 'Klicka f�r att titta p� schemadefinitionen f�r attributtyp \'%s\'';//'Click to view the schema defintion for attribute type \'%s\'';
$lang['click_to_display'] = 'klicka\'+\' f�r att visa';// 'click \'+\' to display';
$lang['hidden'] = 'g�mda';//'hidden';
$lang['none'] = 'inget';//'none';
$lang['save_changes'] = 'Spara �ndringar';//'Save Changes';
$lang['add_value'] = 'l�gg till v�rde';//'add value';
$lang['add_value_tooltip'] = 'L�gg till ett ytterligare v�rde till attribut \'%s\''; // 'Add an additional value to attribute \'%s\'';
$lang['refresh_entry'] = 'Uppdatera';//'Refresh';
$lang['refresh_this_entry'] = 'Uppdatera denna post';//'Refresh this entry';
$lang['delete_hint'] = 'Tips: <b>F�r att ta bort ett attribut</b>, ta bort all text i textf�ltet och klicka \'Spara �ndringar\'.'; 'Hint: <b>To delete an attribute</b>, empty the text field and click save.';
$lang['attr_schema_hint'] = 'Tips: <b>F�r att titta p� ett attributs schema</b>, klicka p� attributnamnet';//'Hint: <b>To view the schema for an attribute</b>, click the attribute name.';
$lang['attrs_modified'] = 'N�gra attribut var �ndrade och �r markerade nedan.';//'Some attributes (%s) were modified and are highlighted below.';
$lang['attr_modified'] = 'Ett attribut var �ndrat och �r markerat nedan.';//An attribute (%s) was modified and is highlighted below.';
$lang['viewing_read_only'] = 'Titta p� en post med enbart l�stiilst�nd';//'Viewing entry in read-only mode.';
$lang['change_entry_rdn'] = '�ndra denna posts RDN';//'Change this entry\'s RDN';
$lang['no_new_attrs_available'] = 'inga nya attribut tillg�ngliga f�r denna post';//'no new attributes available for this entry';
$lang['binary_value'] = 'Bin�rt v�rde';//'Binary value';
$lang['add_new_binary_attr'] = 'L�gg till nytt bin�rt attribut';//'Add New Binary Attribute';
$lang['add_new_binary_attr_tooltip'] = 'L�gg till nytt bin�rt attribut/v�rde fr�n en fil';//'Add a new binary attribute/value from a file';
$lang['alias_for'] = 'Observera: \'%s\' �r ett alias for \'%s\'';//'Note: \'%s\' is an alias for \'%s\'';
$lang['download_value'] = 'ladda ner v�rde';//'download value';
$lang['delete_attribute'] = 'ta bort attribut';//'delete attribute';
$lang['true'] = 'Sant';//'true';
$lang['false'] = 'Falskt';//'false';
$lang['none_remove_value'] = 'inget, ta bort v�rdet';//'none, remove value';
$lang['really_delete_attribute'] = 'Ta definitivt bort v�rdet';//'Really delete attribute';

// Schema browser
$lang['the_following_objectclasses'] = 'F�ljande <b>objektklasser</b> st�ds av denna LDAP server.';//'The following <b>objectClasses</b> are supported by this LDAP server.';
$lang['the_following_attributes'] = 'F�ljande <b>attributtyper</b> st�ds av denna LDAP server.';//'The following <b>attributeTypes</b> are supported by this LDAP server.';
$lang['the_following_matching'] = 'F�ljande <b>matchningsregler</b> st�ds av denna LDAP server.';//'The following <b>matching rules</b> are supported by this LDAP server.';
$lang['the_following_syntaxes'] = 'F�ljande <b>syntax</b> st�ds av denna LDAP server.';//'The following <b>syntaxes</b> are supported by this LDAP server.';
$lang['jump_to_objectclass'] = 'V�lj en objectClass';//'Jump to an objectClass';
$lang['jump_to_attr'] = 'V�lj en attributtyp';//'Jump to an attribute type';
$lang['schema_for_server'] = 'Schema f�r servern';//'Schema for server';
$lang['required_attrs'] = 'N�dv�ndiga attribut';//'Required Attributes';
$lang['optional_attrs'] = 'Valfria attribut';//'Optional Attributes';
$lang['OID'] = 'OID';//'OID';
$lang['desc'] = 'Beskrivning';//'Description';
$lang['name'] = 'Namn';//'Name';
$lang['is_obsolete'] = 'Denna objectClass �r <b>f�r�ldrad</b>';//'This objectClass is <b>obsolete</b>';
$lang['inherits'] = '�rver';//'Inherits';
$lang['jump_to_this_oclass'] = 'G� till definitionen av denna objectClass';//'Jump to this objectClass definition';
$lang['matching_rule_oid'] = 'Matchande regel-OID';//'Matching Rule OID';
$lang['syntax_oid'] = 'Syntax-OID';//'Syntax OID';
$lang['not_applicable'] = 'inte till�mplig';//'not applicable';
$lang['not_specified'] = 'inte specificerad';//'not specified';

// Deleting entries
$lang['entry_deleted_successfully'] = 'Borttagning av posten  \'%s\' lyckades';//'Entry \'%s\' deleted successfully.';
$lang['you_must_specify_a_dn'] = 'Du m�ste specificera ett DN';//'You must specify a DN';
$lang['could_not_delete_entry'] = 'Det gick inte att ta bort posten';//'Could not delete the entry: %s';

// Adding objectClass form
$lang['new_required_attrs'] = 'Nya n�dv�ndiga attribut';//'New Required Attributes';
$lang['requires_to_add'] = 'Den h�r �tg�rden kr�ver att du l�gger till';//'This action requires you to add';
$lang['new_attributes'] = 'nya attribut';//'new attributes';
$lang['new_required_attrs_instructions'] = 'Instruktioner: F�r att kunna l�gga till objektklassen till denna post, m�ste du specificera';//'Instructions: In order to add this objectClass to this entry, you must specify';
$lang['that_this_oclass_requires'] = 'att objektklassen kr�ver. Det kan g�ras i detta formul�r.';//'that this objectClass requires. You can do so in this form.';
$lang['add_oclass_and_attrs'] = 'L�gg till objektklass och attribut';//'Add ObjectClass and Attributes';

// General
$lang['chooser_link_tooltip'] = 'Klicka f�r att �ppna ett f�nster f�r att v�lja ett <DN> grafiskt.';//'Click to popup a dialog to select an entry (DN) graphically';
$lang['no_updates_in_read_only_mode'] = 'Du kan inte g�ra uppdateringar medan servern �r i l�stillst�nd';//'You cannot perform updates while server is in read-only mode';
$lang['bad_server_id'] = 'Felaktigt server-id';//'Bad server id';
$lang['not_enough_login_info'] = 'Det saknas information f�r att logga in p� servern. Var v�nlig och kontrollera din konfiguration.';//'Not enough information to login to server. Please check your configuration.';
$lang['could_not_connect'] = 'Det gick inte att ansluta till LDAP-servern.';//'Could not connect to LDAP server.';
$lang['could_not_perform_ldap_mod_add'] = 'Det gick inte att utf�ra ldap_mod_add operationen.';//''Could not perform ldap_mod_add operation.';
$lang['bad_server_id_underline'] = 'Felaktigt server_id';//'Bad server_id: ';
$lang['success'] = 'Det lyckades';//'Success';
$lang['server_colon_pare'] = 'Server';//'Server: ';
$lang['look_in'] = 'Tittar in';//'Looking in: ';
$lang['missing_server_id_in_query_string'] = 'Inget server-ID specificerat i fr�gestr�gen!';//'No server ID specified in query string!';
$lang['missing_dn_in_query_string'] = 'Inget DN specificerat i fr�gestr�gen!';//'No DN specified in query string!';
$lang['back_up_p'] = 'Tillbaka';//'Back Up...';
$lang['no_entries'] = 'inga poster';//'no entries';
$lang['not_logged_in'] = 'Inte inloggad';//'Not logged in';
$lang['could_not_det_base_dn'] = 'Det gick inte att best�mma \'base DN\'';//'Could not determine base DN';

// Add value form
$lang['add_new'] = 'L�gg till nytt';//'Add new';
$lang['value_to'] = 'v�rde till';//'value to';
$lang['distinguished_name'] =  'Distinguished Name';//'Distinguished Name';
$lang['current_list_of'] = 'Aktuell lista av';//'Current list of';
$lang['values_for_attribute'] = 'attributv�rden';//'values for attribute';
$lang['inappropriate_matching_note'] = 'Observera: Du kommer att f� ett \'inappropriate matching\'-fel om du inte har<br />' .
                        'satt upp en <tt>EQUALITY</tt>-regel p� din LDAP-server f�r detta attribut.';//  'Note: You will get an "inappropriate matching" error if you have not<br />' .
			'setup an <tt>EQUALITY</tt> rule on your LDAP server for this attribute.';
$lang['enter_value_to_add'] = 'Skriv in v�rdet du vill l�gga till';//'Enter the value you would like to add:';
$lang['new_required_attrs_note'] = 'Observera: Du kan bli tvungen att skriva in de nya attribut som denna objectClass beh�ver';//'Note: you may be required to enter new attributes that this objectClass requires';
$lang['syntax'] = 'Syntax';//'Syntax';

//copy.php
$lang['copy_server_read_only'] = 'Du kan inte g�ra uppdateringar medan servern �r i l�stillst�nd';//'You cannot perform updates while server is in read-only mode';
$lang['copy_dest_dn_blank'] = 'Du l�mnade destinations-DN tomt';//'You left the destination DN blank.';
$lang['copy_dest_already_exists'] = 'Destinationen finns redan';//'The destination entry (%s) already exists.';
$lang['copy_dest_container_does_not_exist'] = 'Destinations-beh�llaren (%s) finns inte';// 'The destination container (%s) does not exist.';
$lang['copy_source_dest_dn_same'] = 'K�ll- och destinations-DN �r samma.';//'The source and destination DN are the same.';
$lang['copy_copying'] = 'Kopierar';//'Copying ';
$lang['copy_recursive_copy_progress'] = 'Rekursiv kopiering p�g�r';//'Recursive copy progress';
$lang['copy_building_snapshot'] = 'Bygger en �gonblicksbild av det tr�d som ska kopieras';//'Building snapshot of tree to copy... ';
$lang['copy_successful_like_to'] = 'Kopieringen lyckades! Vill du';//'Copy successful! Would you like to ';
$lang['copy_view_new_entry'] = 'titta p� den nya posten';//'view the new entry';
$lang['copy_failed'] = 'Kopiering av DN misslyckades';//'Failed to copy DN: ';

//edit.php
$lang['missing_template_file'] = 'Varning! mall-filen saknas,';//'Warning: missing template file, ';
$lang['using_default'] = 'anv�nder default.'; //'Using default.';

//copy_form.php
$lang['copyf_title_copy'] = 'Kopiera';//'Copy ';
$lang['copyf_to_new_object'] = 'till ett nytt objekt';//'to a new object';
$lang['copyf_dest_dn'] =  'Destinations-DN';//'Destination DN';
$lang['copyf_dest_dn_tooltip'] = 'Den nya postens fullst�ndiga DN skapas n�r k�llposten kopieras';//'The full DN of the new entry to be created when copying the source entry';
$lang['copyf_dest_server'] = 'Destinations-server';//'Destination Server';
$lang['copyf_note'] = 'Tips: Kopiering mellan olika servrar fungerar bara om det inte finns n�gra brott mot schemorna.';// 'Hint: Copying between different servers only works if there are no schema violations';
$lang['copyf_recursive_copy'] = 'Kopiera �ven rekursivt alla underobjekt till detta objekt.';//'Recursively copy all children of this object as well.';

//create.php
$lang['create_required_attribute'] = 'Du l�mnade ett v�rde tomt f�r ett n�dv�ndigt attribut <b>%s</b>.';//'You left the value blank for required attribute <b>%s</b>.';
$lang['create_redirecting'] = 'Omstyrning';//'Redirecting';
$lang['create_here'] = 'h�r';//'here';
$lang['create_could_not_add'] = 'Det gick inte att l�gga till objektet till LDAP-servern.';//'Could not add the object to the LDAP server.';

//create_form.php
$lang['createf_create_object'] = 'Skapa objekt';//'Create Object';
$lang['createf_choose_temp'] = 'V�lj en mall';//'Choose a template';
$lang['createf_select_temp'] = 'V�lj en mall f�r att skapa objekt';//'Select a template for the creation process';
$lang['createf_proceed'] = 'Forts�tt';//'Proceed';

//creation_template.php
$lang['ctemplate_on_server'] = 'P� servern';//'On server';
$lang['ctemplate_no_template'] = 'Ingen mall specificerad i POST variablerna.';//'No template specified in POST variables.';
$lang['ctemplate_config_handler'] = 'Din konfiguration specificerar en hanterare';//'Your config specifies a handler of';
$lang['ctemplate_handler_does_not_exist'] = 'f�r denna mall, men hanteraren finns inte i templates/creation-katalogen';//'for this template. But, this handler does not exist in the templates/creation directory.';

// search.php
$lang['you_have_not_logged_into_server'] = 'Du har inte loggat in till den valda servern �nnu, s� du kan inte g�ra s�kningar p� den.';//'You have not logged into the selected server yet, so you cannot perform searches on it.';
$lang['click_to_go_to_login_form'] = 'Klicka h�r f�r att komma till login-formul�ret';//'Click here to go to the login form';
$lang['unrecognized_criteria_option'] = 'K�nner inte till detta urvals-kriterium';//'Unrecognized criteria option: ';
$lang['if_you_want_to_add_criteria'] = 'Om du vill l�gga till ditt eget kriterium till listan, kom ih�g att �ndra search.php f�r att hantera det. Avslutar.';//'If you want to add your own criteria to the list. Be sure to edit search.php to handle them. Quitting.';
$lang['entries_found'] = 'Poster funna:';//'Entries found: ';
$lang['filter_performed'] = 'Filtrering utf�rd: ';//'Filter performed: ';
$lang['search_duration'] = 'S�kning utf�rd av phpLDAPadmin p�';//'Search performed by phpLDAPadmin in';
$lang['seconds'] = 'sekunder';//'seconds';

// search_form_advanced.php
$lang['scope_in_which_to_search'] = 'S�komfattning';//'The scope in which to search';
$lang['scope_sub'] = 'Sub (Base DN och hela tr�det under)';//'Sub (entire subtree)';
$lang['scope_one'] = 'One (en niv� under Base DN)';//One (one level beneath base)';
$lang['scope_base'] = 'Base (endast Base DN)';//'Base (base dn only)';
$lang['standard_ldap_search_filter'] = 'Standard LDAP s�kfilter. Exempel: (&(sn=Smith)(givenname=David))';//'Standard LDAP search filter. Example: (&(sn=Smith)(givenname=David))';
$lang['search_filter'] = 'S�kfilter';//'Search Filter';
$lang['list_of_attrs_to_display_in_results'] = 'En lista med attribut att visa i resultatet (komma-separerad)';// 'A list of attributes to display in the results (comma-separated)';
$lang['show_attributes'] = 'Visa attribut';//'Show Attributes';

// search_form_simple.php
$lang['search_for_entries_whose'] = 'S�k efter poster som:';//'Search for entries whose:';
$lang['equals'] = '�r lika med';//'equals';
$lang['starts with'] = 'b�rjar med';//'starts with';
$lang['contains'] = 'inneh�ller';//'contains';
$lang['ends with'] = 'slutar med';//'ends with';
$lang['sounds like'] = 'l�ter som';//'sounds like';

// server_info.php
$lang['could_not_fetch_server_info'] = 'Det gick inte att h�mta LDAP information fr�n servern.';//'Could not retrieve LDAP information from the server';
$lang['server_info_for'] = 'Serverinformation f�r';//'Server info for: ';
$lang['server_reports_following'] = 'Servern rapporterar f�ljande information om sig sj�lv';//'Server reports the following information about itself';
$lang['nothing_to_report'] = 'Servern har inget att rapportera';//'This server has nothing to report.';

//update.php
$lang['update_array_malformed'] = 'update_array �r felaktig. Detta kan vara ett phpLDAPadmin-fel. Var v�nlig och rapportera det.';// 'update_array is malformed. This might be a phpLDAPadmin bug. Please report it.';
$lang['could_not_perform_ldap_modify'] = 'Det gick inte att utf�ra operationen ldap_modify.';//'Could not perform ldap_modify operation.';

// update_confirm.php
$lang['do_you_want_to_make_these_changes'] = 'Vill du g�ra dessa �ndringar?';//'Do you want to make these changes?';
$lang['attribute'] = 'Attribut';//'Attribute';
$lang['old_value'] = 'F�reg�ende v�rde';//'Old Value';
$lang['new_value'] = 'Nytt v�rde';//'New Value';
$lang['attr_deleted'] = '[attributet borttaget]';//'[attribute deleted]';
$lang['commit'] = 'Bekr�fta';//'Commit';
$lang['cancel'] = '�ngra';//'Cancel';
$lang['you_made_no_changes'] = 'Du gjorde inga �ndringar';//'You made no changes';
$lang['go_back'] = 'G� tillbaka';//'Go back';

// welcome.php
$lang['welcome_note'] = 'Navigera med hj�lp av menyn till v�nster';//'Use the menu to the left to navigate';
$lang['credits'] = 'Tack till';//'Credits';
$lang['changelog'] = '�ndringslogg';//'ChangeLog';
$lang['documentation'] = 'Dokumentation';//'Documentation';

// view_jpeg_photo.php
$lang['unsafe_file_name'] = 'Os�kert filnamn';//'Unsafe file name: ';
$lang['no_such_file'] = 'Filen finns inte';//'No such file: ';

//function.php
$lang['auto_update_not_setup'] = 'Du har slagit p� auto_uid_numbers f�r <b>%s</b> i din konfiguration, 
                                  men du har inte specificerat auto_uid_number_mechanism. Var v�nlig och r�tta till 
                                  detta problem.'; 
                                  //'You have enabled auto_uid_numbers for <b>%s</b> in your configuration,
                                  //but you have not specified the auto_uid_number_mechanism. Please correct
                                  //this problem.';
$lang['uidpool_not_set'] = 'Du har specificerat <tt>auto_uid_number_mechanism</tt> som <tt>uidpool</tt> 
                            i din konfiguration f�r server<b>%s</b>, men du specificerade inte 
                            audo_uid_number_uid_pool_dn. Var v�nlig och specificera den innan du forts�tter.';
                            //'You specified the <tt>auto_uid_number_mechanism</tt> as <tt>uidpool</tt>
                            //in your configuration for server <b>%s</b>, but you did not specify the
                            //audo_uid_number_uid_pool_dn. Please specify it before proceeding.';
$lang['uidpool_not_exist'] = 'Det ser ut som om den uidPool du specificerade i din konfiguration (<tt>%s</tt>) 
                             inte existerar.';
                             // 'It appears that the uidPool you specified in your configuration (<tt>%s</tt>)
                             // does not exist.';
$lang['specified_uidpool'] = 'Du specificerade <tt>auto_uid_number_mechanism</tt> som <tt>search</tt> i din 
                             konfiguration f�r server<b>%s</b>, men du specificerade inte 
                             <tt>auto_uid_number_search_base</tt>. Var v�nlig och specificera den innan du forts�tter.';
                             // 'You specified the <tt>auto_uid_number_mechanism</tt> as <tt>search</tt> in your
                             //configuration for server <b>%s</b>, but you did not specify the
                             //<tt>auto_uid_number_search_base</tt>. Please specify it before proceeding.';
$lang['auto_uid_invalid_value'] = 'Du specificerade ett ogiltigt v�rde f�r auto_uid_number_mechanism (<tt>%s</tt>) 
                                   i din konfiguration. Endast <tt>uidpool</tt> och <tt>search</tt> are giltiga. 
                                   Var v�nlig och r�tta till detta problem.';
                                   //'You specified an invalid value for auto_uid_number_mechanism (<tt>%s</tt>)
                                   //in your configration. Only <tt>uidpool</tt> and <tt>search</tt> are valid.
                                   //Please correct this problem.';
$lang['error_auth_type_config'] = 'Fel: Du har ett fel i din konfigurationsfil. De enda till�tna v�rdena 
                                   f�r auth_type i $servers-sektionen �r \'config\' and \'form\'. Du skrev in \'%s\', 
                                   vilket inte �r till�tet. ';
                                   //'Error: You have an error in your config file. The only two allowed values
                                   //for auth_type in the $servers section are \'config\' and \'form\'. You entered \'%s\',
                                   //which is not allowed. ';
$lang['php_install_not_supports_tls'] = 'Din PHP-installation st�djer inte TLS';//'Your PHP install does not support TLS';
$lang['could_not_start_tls'] = 'Det gick inte att starta TLS.<br />Var v�nlig och kontrollera din LDAP-serverkonfiguration.';//'Could not start TLS.<br />Please check your LDAP server configuration.';
$lang['auth_type_not_valid'] = 'Du har ett fel i din konfigurationsfil. auth_type %s �r inte till�ten.';//'You have an error in your config file. auth_type of %s is not valid.';
$lang['ldap_said'] = '<b>LDAP sa</b>: %s<br /><br />';//'<b>LDAP said</b>: %s<br /><br />';
$lang['ferror_error'] = 'Fel';'Error';
$lang['fbrowse'] = 'titta';//'browse';
$lang['delete_photo'] = 'Ta bort foto';//'Delete Photo';
$lang['install_not_support_blowfish'] = 'Din PHP-installation st�djer inte blowfish-kryptering.';// 'Your PHP install does not support blowfish encryption.';
$lang['install_no_mash'] = 'Din PHP-installation har inte funktionen mash(). Det g�r inte att g�ra SHA hashes.';//'Your PHP install does not have the mhash() function. Cannot do SHA hashes.';
$lang['jpeg_contains_errors'] = 'JPEG-fotot inneh�ller fel<br />';//'jpegPhoto contains errors<br />';
$lang['ferror_number'] = '<b>Felnummer</b>: %s <small>(%s)</small><br /><br />';//'<b>Error number</b>: %s <small>(%s)</small><br /><br />';
$lang['ferror_discription'] ='<b>Beskrivning</b>: %s <br /><br />';//'<b>Description</b>: %s <br /><br />';
$lang['ferror_number_short'] = '<b>Felnummer</b>: %s<br /><br />';//'<b>Error number</b>: %s<br /><br />';
$lang['ferror_discription_short'] = '<b>Beskrivning</b>: (ingen beskrivning tillg�nglig)<br />';//'<b>Description</b>: (no description available)<br />';
$lang['ferror_submit_bug'] = '�r det h�r ett phpLDAPadmin-fel? Om s� �r fallet, var v�nlig och <a href=\'%s\'>rapportera det</a>.';
//'Is this a phpLDAPadmin bug? If so, please <a href=\'%s\'>report it</a>.';
$lang['ferror_unrecognized_num'] = 'Ok�nt felnummer';//'Unrecognized error number: ';
$lang['ferror_nonfatil_bug'] = '<center><table class=\'notice\'><tr><td colspan=\'2\'><center><img src=\'images/warning.png\' height=\'12\' width=\'13\' />
             <b>Du har hittat en icke-kritisk phpLDAPadmin bug!</b></td></tr><tr><td>Fel:</td><td><b>%s</b> (<b>%s</b>)</td></tr><tr><td>Fil:</td>
             <td><b>%s</b> rad <b>%s</b>, anropande <b>%s</b></td></tr><tr><td>Versioner:</td><td>PLA: <b>%s</b>, PHP: <b>%s</b>, SAPI: <b>%s</b>
             </td></tr><tr><td>Web server:</td><td><b>%s</b></td></tr><tr><td colspan=\'2\'><center><a target=\'new\' href=\'%s\'>
             Var v�nlig och rapportera felet genom att klicka h�r</a>.</center></td></tr></table></center><br />';

             //'<center><table class=\'notice\'><tr><td colspan=\'2\'><center><img src=\'images/warning.png\' height=\'12\' width=\'13\' />
             //<b>You found a non-fatal phpLDAPadmin bug!</b></td></tr><tr><td>Error:</td><td><b>%s</b> (<b>%s</b>)</td></tr><tr><td>File:</td>
             //<td><b>%s</b> line <b>%s</b>, caller <b>%s</b></td></tr><tr><td>Versions:</td><td>PLA: <b>%s</b>, PHP: <b>%s</b>, SAPI: <b>%s</b>
             //</td></tr><tr><td>Web server:</td><td><b>%s</b></td></tr><tr><td colspan=\'2\'><center><a target=\'new\' href=\'%s\'>
             //Please report this bug by clicking here</a>.</center></td></tr></table></center><br />';

$lang['ferror_congrats_found_bug'] = 'Gratulerar! Du har hittat en bug i phpLDAPadmin.<br /><br />
	     <table class=\'bug\'>
	     <tr><td>Fel:</td><td><b>%s</b></td></tr>
	     <tr><td>Niv�:</td><td><b>%s</b></td></tr>
	     <tr><td>Fil:</td><td><b>%s</b></td></tr>
	     <tr><td>Rad:</td><td><b>%s</b></td></tr>
		 <tr><td>Anropare:</td><td><b>%s</b></td></tr>
	     <tr><td>PLA Version:</td><td><b>%s</b></td></tr>
	     <tr><td>PHP Version:</td><td><b>%s</b></td></tr>
	     <tr><td>PHP SAPI:</td><td><b>%s</b></td></tr>
	     <tr><td>Web server:</td><td><b>%s</b></td></tr>
	     </table>
	     <br />
	     Var v�nlig och rapportera den h�r buggen genom att klicak h�r nedan!';

//'Congratulations! You found a bug in phpLDAPadmin.<br /><br />
//<table class=\'bug\'>
//<tr><td>Error:</td><td><b>%s</b></td></tr>
//<tr><td>Level:</td><td><b>%s</b></td></tr>
//<tr><td>File:</td><td><b>%s</b></td></tr>
//<tr><td>Line:</td><td><b>%s</b></td></tr>
//<tr><td>Caller:</td><td><b>%s</b></td></tr>
//<tr><td>PLA Version:</td><td><b>%s</b></td></tr>
//<tr><td>PHP Version:</td><td><b>%s</b></td></tr>
//<tr><td>PHP SAPI:</td><td><b>%s</b></td></tr>
//<tr><td>Web server:</td><td><b>%s</b></td></tr>
//</table>
//<br />
//Please report this bug by clicking below!';


//ldif_import_form
$lang['import_ldif_file_title'] = 'Importera LDIF-fil';//'Import LDIF File';
$lang['select_ldif_file'] = 'V�lj en LDIF-fil:';//'Select an LDIF file:';
$lang['select_ldif_file_proceed'] = 'Forts�tt &gt;&gt;';//'Proceed &gt;&gt;';

//ldif_import
$lang['add_action'] = 'L�gger till...';//'Adding...';
$lang['delete_action'] = 'Tar bort...';//'Deleting...';
$lang['rename_action'] = 'D�per om...';//''Renaming...';
$lang['modify_action'] = '�ndrar...';//'Modifying...';

$lang['failed'] = 'misslyckades';//'failed';
$lang['ldif_parse_error'] = 'LDIF parsningsfel';//'LDIF Parse Error';
$lang['ldif_could_not_add_object'] = 'Det gick inte att l�gga till objekt';//'Could not add object:';
$lang['ldif_could_not_rename_object'] = 'Det gick inte att l�gga d�pa om objekt';//'Could not rename object:';
$lang['ldif_could_not_delete_object'] = 'Det gick inte att ta bort objekt';//'Could not delete object:';
$lang['ldif_could_not_modify_object'] = 'Det gick inte att �ndra objekt';//'Could not modify object:';
$lang['ldif_line_number'] = 'Radnummer';//'Line Number:';
$lang['ldif_line'] = 'Rad:';//'Line:';
?>
