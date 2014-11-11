<?php
// encoding: ISO-8859-1,fr.php,�������
/*        ---   INSTRUCTIONS FOR TRANSLATORS   ---
 *
 * If you want to write a new language file for your language,
 * please submit the file on SourceForge:
 *
 * https://sourceforge.net/tracker/?func=add&group_id=61828&atid=498548
 *
 * Use the option "Check to Upload and Attach a File" at the bottom
 *
 * Thank you!
 *
 * $Header: /cvsroot/phpldapadmin/phpldapadmin/lang/fr.php,v 1.24 2004/03/07 17:37:41 xrenard Exp $
 */

/*
 * The $lang array contains all the strings that phpLDAPadmin uses.
 * Each language file simply defines this aray with strings in its
 * language.
 */

//  Search form
$lang['simple_search_form_str'] = 'Recherche Simple';
$lang['advanced_search_form_str'] = 'Recherche avanc�e';
$lang['server'] = 'Serveur';
$lang['search_for_entries_whose'] = 'Chercher les entr�es dont';
$lang['base_dn'] = 'Base DN';
$lang['search_scope'] = 'Port�e de la recherche';
$lang['show_attributes'] = 'Montrer les attributs';
$lang['Search'] = 'Chercher';
$lang['equals'] = 'est �gal �';
$lang['contains'] = 'contient';
$lang['predefined_search_str'] = 'Selectionner une recherche pr�d�finie';
$lang['predefined_searches'] = 'Recherches pr�d�finies';
$lang['no_predefined_queries'] = 'Aucune requ�te n\' a �t� d�finie dans config.php.';

// Tree browser
$lang['request_new_feature'] = 'Demander une nouvelle fonctionnalit�';
$lang['report_bug'] = 'Signaler un bogue';
$lang['schema'] = 'schema';
$lang['search'] = 'chercher';
$lang['refresh'] = 'rafra�chir';
$lang['create'] = 'cr�er';
$lang['info'] = 'info';
$lang['import'] = 'importer';
$lang['logout'] = 'se d�connecter';
$lang['create_new'] = 'Cr�er';
$lang['view_schema_for'] = 'Voir les schemas pour';
$lang['refresh_expanded_containers'] = 'Rafra�chir tous les containeurs �tendus';
$lang['create_new_entry_on'] = 'Cr�er une nouvelle entr�e sur';
$lang['new'] = 'nouveau';
$lang['view_server_info'] = 'Voir les informations sur le serveur';
$lang['import_from_ldif'] = 'Importer des entr�es � partir d\'un fichier LDIF';
$lang['logout_of_this_server'] = 'Se d�connecter de ce serveur';
$lang['logged_in_as'] = 'Connect� en tant que: ';
$lang['read_only'] = 'Lecture seule';
$lang['could_not_determine_root'] = 'La racine de l\'arborescence Ldap n\'a pu �tre d�termin�e.';
$lang['ldap_refuses_to_give_root'] = 'Il semble que le serveur LDAP a �t� configur� de telle sorte que la racine ne soit pas r�vel�e.';
$lang['please_specify_in_config'] = 'Veuillez le sp�cifier dans le fichier config.php';
$lang['create_new_entry_in'] = 'Cr�er une nouvelle entr�e dans';
$lang['login_link'] = 'Login...';
$lang['login'] = 'login';

// Entry display
$lang['delete_this_entry'] = 'Supprimer cette entr�e';
$lang['delete_this_entry_tooltip'] = 'Il vous sera demand� confirmation';
$lang['copy_this_entry'] = 'Copier cette entr�e';
$lang['copy_this_entry_tooltip'] = 'Copier cet objet vers un autre endroit, un nouveau DN ou un autre serveur';
$lang['export'] = 'Exporter';
$lang['export_tooltip'] = 'Sauvegarder cet objet';
$lang['export_subtree_tooltip'] = 'Sauvegarder cet objet ainsi que tous les sous-objets';
$lang['export_subtree'] = 'Exporter l\'arborescence';
$lang['create_a_child_entry'] = 'Cr�er une sous-entr�e'; 
$lang['rename_entry'] = 'Renommer l\'entr�e';
$lang['rename'] = 'Renommer';
$lang['add'] = 'Ajouter';
$lang['view'] = 'Voir';
$lang['view_one_child'] = 'Voir 1 sous-entr�e';
$lang['view_children'] = 'Voir les %s sous-entr�es';
$lang['add_new_attribute'] = 'Ajouter un nouvel attribut';
$lang['add_new_objectclass'] = 'Ajouter une nouvelle classe d\'objet';
$lang['hide_internal_attrs'] = 'Cacher les attributs internes';
$lang['show_internal_attrs'] = 'Montrer les attributs internes';
$lang['attr_name_tooltip'] = 'Cliquer pour voir la d�finition de sch�ma pour l\'attribut de type \'%s\'';
$lang['none'] = 'aucun'; 
$lang['save_changes'] = 'Sauver les modifications';
$lang['add_value'] = 'ajouter une valeur';
$lang['add_value_tooltip'] = 'Ajouter une valeur suppl�mentaire �  cet attribut';
$lang['refresh_entry'] = 'Rafraichir';
$lang['refresh_this_entry'] = 'Rafra�chir cette entr�e';
$lang['delete_hint'] = 'Note: Pour effacer un attribut, laissez le champs vide et cliquez pour sauvegarder.';
$lang['attr_schema_hint'] = 'Note: Pour voir le sch�ma pour un attribut, cliquer sur le nom de l\'attribut.';
$lang['attrs_modified'] = 'Certains attributs (%s) ont �t� modifi�s et sont mis en �vidence ci-dessous.';
$lang['attr_modified'] = 'Un attribut (%s) a �t� modifi� et est mis en �vidence ci-dessous.';
$lang['viewing_read_only'] = 'Voir une entr�e en lecture seule.';
$lang['no_new_attrs_available'] = 'plus d\'attributs disponibles pour cette entr�e';
$lang['no_new_binary_attrs_available'] = 'plus d\' attributs binaires disponibles pour cette entr��';
$lang['binary_value'] = 'Valeur de type binaire';
$lang['add_new_binary_attr'] = 'Ajouter un nouvel attribut de type binaire';
$lang['alias_for'] = 'Alias pour';
$lang['download_value'] = 'T�l�charger le contenu';
$lang['delete_attribute'] = 'Supprimer l\'attribut';
$lang['true'] = 'vrai';
$lang['false'] = 'faux';
$lang['none_remove_value'] = 'aucun, suppression de la valeur';
$lang['really_delete_attribute'] = 'Voulez-vous vraiment supprimer l\'attribut';
$lang['add_new_value'] = 'Ajouter une nouvelle valeur';

// Schema browser
$lang['the_following_objectclasses'] = 'Les classes d\'objets (objectClasses) suivantes sont support�s par ce serveur LDAP.';
$lang['the_following_attributes'] = 'Les types d\'attributs (attributesTypes) suivants sont support�s par ce serveur LDAP.';
$lang['the_following_matching'] = 'Les op�rateurs (matching rules) suivants sont support�s par ce serveur LDAP.';
$lang['the_following_syntaxes'] = 'Les syntaxes suivantes sont support�s par ce serveur LDAP.';
$lang['schema_retrieve_error_1']='Le serveur ne supporte pas enti�rement le protocol LDAP.';
$lang['schema_retrieve_error_2']='Votre version de PHP ne permet pas d\'ex�cute correctement la requ�te.';
$lang['schema_retrieve_error_3']='Ou tout du moins, phpLDAPadmin ne sait pas comment r�cup�rer le sch�ma pour votre serveur.';
$lang['jump_to_objectclass'] = 'Aller � une classe d\'objet';
$lang['jump_to_attr'] = 'Aller � un attribut';
$lang['jump_to_matching_rule'] = 'Aller � une r�gle d\'�galit�';
$lang['schema_for_server'] = 'Schema pour le serveur';
$lang['required_attrs'] = 'Attributs obligatoires';
$lang['optional_attrs'] = 'Attributs optionnels';
$lang['optional_binary_attrs'] = 'Attributs binaires optionnels';
$lang['OID'] = 'OID';
$lang['aliases']='Alias';
$lang['desc'] = 'Description';
$lang['no_description']='aucune description';
$lang['name'] = 'Nom';
$lang['equality']='Egalit�';
$lang['is_obsolete'] = 'Cette classe d\'objet est obsolete';
$lang['inherits'] = 'h�rite';
$lang['inherited_from']='h�rite de';
$lang['jump_to_this_oclass'] = 'Aller � la d�finition de cette classe d\'objet';
$lang['matching_rule_oid'] = 'OID de l\'op�rateur';
$lang['syntax_oid'] = 'OID de la syntaxe';
$lang['not_applicable'] = 'not applicable';
$lang['not_specified'] = 'non sp�cifi�';
$lang['character']='caract�re'; 
$lang['characters']='caract�res';
$lang['used_by_objectclasses']='Utilis� par les objectClasses';
$lang['used_by_attributes']='Utilis� par les attributes';
$lang['maximum_length']='Maximum Length';
$lang['attributes']='Types d\'attribut';
$lang['syntaxes']='Syntaxes';
$lang['objectclasses']='objectClasses';
$lang['matchingrules']='R�gles d\'�galit�';
$lang['oid']='OID';
$lang['obsolete']='Obsol�te';
$lang['ordering']='Ordonn�';
$lang['substring_rule']='Substring Rule';
$lang['single_valued']='Valeur Unique';
$lang['collective']='Collective';
$lang['user_modification']='Modification Utilisateur';
$lang['usage']='Usage';
$lang['maximum_length']='Longueur maximale';
$lang['could_not_retrieve_schema_from']='Impossible de r�cup�rer le sch�ma de';
$lang['type']='Type';

// Deleting entries
$lang['entry_deleted_successfully'] = 'Suppression de l\'entr�e \'%s\' r�ussie.';
$lang['you_must_specify_a_dn'] = 'Un DN doit �tre sp�cifi�';
$lang['could_not_delete_entry'] = 'Impossible de supprimer l\'entr�e: %s';
$lang['no_such_entry'] = 'Aucune entr�e de ce type: %s';
$lang['delete_dn'] = 'Delete %s';
$lang['permanently_delete_children'] = 'Effacer �galement les sous-entr�es?';
$lang['entry_is_root_sub_tree'] = 'Cette entr�e est la racine d\'une arborescence contenant %s entr�es.';
$lang['view_entries'] = 'voir les entr�es';
$lang['confirm_recursive_delete'] = 'phpLDAPadmin peut supprimer cette entr�es ainsi que les %s noeuds enfants de fa�on r�cursive. Voir ci-dessous pour une liste des entr�es que cette action suprimera. Voulez-vous continuer?';
$lang['confirm_recursive_delete_note'] = 'Note: ceci est potentiellement tr�s dangereux and vous fa�tes cela � vos propres risques. Cette op�ration ne peut �tre annul�e. Prenez en consid�ration les alias ainsi que d\'autres choses qui pourraient causer des probl�mes.';
$lang['delete_all_x_objects'] = 'Suppressions des  %s objets';
$lang['recursive_delete_progress'] = 'Progression de la suppression r�cursive';
$lang['entry_and_sub_tree_deleted_successfully'] = 'L\'entr�e %s ainsi que la sous-arborescence de ce noeud ont �t� supprim�s avec succ�s.';
$lang['failed_to_delete_entry'] = 'Echec lors de la suppression de l\'entr�e %s';
$lang['list_of_entries_to_be_deleted'] = 'Liste des entr�es � supprimer:';
$lang['sure_permanent_delete_object']='Etes-vous certain de vouloir supprimer d�finitivement cet objet?';
$lang['dn'] = 'DN';

// Deleting attributes
$lang['attr_is_read_only'] = 'L\'attribut "%s" est marqu� comme �tant en lecture seule dans la configuration de phpLDAPadmin.';
$lang['no_attr_specified'] = 'Aucun nom d\'attributs sp�cifi�.';
$lang['no_dn_specified'] = 'Aucun DN specifi�';

// Adding attributes
$lang['left_attr_blank'] = 'Vous avez laisser la valeur de l\'attribut vide. Veuillez s\'il vous pla�t retourner � la page pr�c�dente et recommencer.';
$lang['failed_to_add_attr'] = 'Echec lors de l\'ajout de l\'attribut.';

// Updating values
$lang['modification_successful'] = 'Modification r�ussie!';
$lang['change_password_new_login'] = 'Votre mot de passe ayant �t� chang�, vous devez maintenant vous logger avec votre nouveau mot de passe.';

// Adding objectClass form
$lang['new_required_attrs'] = 'Nouveaux Attributs Obligatoires';
$lang['requires_to_add'] = 'Cette action n�cessite d\'ajouter';
$lang['new_attributes'] = 'nouveaux attributs';
$lang['new_required_attrs_instructions'] = 'Instructions: Afin d\'ajouter cette classe d\'objet, vous devez sp�cifier';
$lang['that_this_oclass_requires'] = 'dont cette classe d\'objet a besoin. Vous pouvez le faire avec ce formulaire.';
$lang['add_oclass_and_attrs'] = 'Ajout d\' ObjectClass et d\'attributs';

// General
$lang['chooser_link_tooltip'] = 'Cliquer pour choisir un entr�(DN)';
$lang['no_updates_in_read_only_mode'] = 'Vous ne pouvez effectuer des mises � jour si le serveur est en lecture seule';
$lang['bad_server_id'] = 'Id de serveur invalide';
$lang['not_enough_login_info'] = 'Informations insuffisantes pour se logguer au serveur. Veuillez, s\'il vous pla�, v�rifier votre configuration.';
$lang['could_not_connect'] = 'Impossible de se connecter au serveur LDAP.';
$lang['could_not_connect_to_host_on_port'] = 'Impossible de se connecter � "%s" sur le port "%s"';
$lang['could_not_perform_ldap_mod_add'] = 'Echec lors de l\'op�ration ldap_mod_add.';
$lang['bad_server_id_underline'] = 'serveur_id invalide: ';
$lang['success'] = 'Succ�s';
$lang['server_colon_pare'] = 'Serveur: ';
$lang['look_in'] = 'Recherche dans: ';
$lang['missing_server_id_in_query_string'] = 'Aucun serveur ID sp�cifi� dans la ligne de requ�te !';
$lang['missing_dn_in_query_string'] = 'Aucun DN sp�cifi� dans la ligne de requ�te !';
$lang['back_up_p'] = 'Retour...';
$lang['no_entries'] = 'aucune entr�e';
$lang['not_logged_in'] = 'Vous n\'�tes pas loggu�';
$lang['could_not_det_base_dn'] = 'Impossible de d�terminer le DN de base';
$lang['please_report_this_as_a_bug']='Veuillez s\'il-vous-pla�t rapporter ceci comme un bogue.';
$lang['reasons_for_error']='Ceci peut arriver pour plusieurs raisons, les plus probables sont:';
$lang['yes']='Oui';
$lang['no']='Non';
$lang['go']='Go';
$lang['delete']='Suppression';
$lang['back']='Back';
$lang['object']='object';
$lang['delete_all']='Tous les supprimer';
$lang['url_bug_report']='https://sourceforge.net/tracker/?func=add&group_id=61828&atid=498546';
$lang['hint'] = 'Astuce';
$lang['bug'] = 'bogue';
$lang['warning'] = 'Avertissement';
$lang['light'] = 'lumi�re'; // the word 'light' from 'light bulb'
$lang['proceed_gt'] = 'Continuer &gt;&gt;';


// Add value form
$lang['add_new'] = 'Ajout d\'une nouvelle valeur ';
$lang['value_to'] = 'pour';
$lang['distinguished_name'] = 'Distinguished Name';
$lang['current_list_of'] = 'Liste actuelle de';
$lang['values_for_attribute'] = 'valeur(s) pour l\' attribut';
$lang['inappropriate_matching_note'] = 'Note: Vous obtiendrez une erreur de type "inappropriate matching" si vous n\'avez pas<br />' .
			'd�fini une r�gle "EQUALITY" pour cet attribut aupr�s du serveur LDAP.';
$lang['enter_value_to_add'] = 'Entrez la valeur que vous voulez ajouter:';
$lang['new_required_attrs_note'] = 'Note: vous aurez peut-�re besoin d\'introduire de nouveaux attributs requis pour cette classe d\'objet';
$lang['syntax'] = 'Syntaxe';

//Copy.php
$lang['copy_server_read_only'] = 'Des mises � jours ne peuvent pas  �tre effectu�es si le serveur est en lecture seule';
$lang['copy_dest_dn_blank'] = 'Vous avez laiss� le DN de destination vide.';
$lang['copy_dest_already_exists'] = 'L\'entr�e de destination (%s) existe d�j�.';
$lang['copy_dest_container_does_not_exist'] = 'Le conteneur de destination (%s) n\'existe pas.';
$lang['copy_source_dest_dn_same'] = 'Le DN d\'origine et le DN de destination sont identiques.';
$lang['copy_copying'] = 'Copie ';
$lang['copy_recursive_copy_progress'] = 'Progression de la copie r�cursive';
$lang['copy_building_snapshot'] = 'Construction de l\'image de l\'arborscence � copier... ';
$lang['copy_successful_like_to'] = 'Copie r�ussite!  Voulez-vous ';
$lang['copy_view_new_entry'] = '�diter cette nouvelle entr�e';
$lang['copy_failed'] = 'Echec lors de la copie de: ';

//edit.php
$lang['missing_template_file'] = 'Avertissement: le fichier mod�le est manquant, ';
$lang['using_default'] = 'Utilisation du mod�le par d�faut.';
$lang['template'] = 'Mod�le';
$lang['must_choose_template'] = 'Vous devez choisir un mod�le';
$lang['invalid_template'] = '%s est un mod�le non valide';
$lang['using_template'] = 'Utilisation du mod�le';
$lang['go_to_dn'] = 'Aller � %s';




//copy_form.php
$lang['copyf_title_copy'] = 'Copie de ';
$lang['copyf_to_new_object'] = 'vers un nouvel objet';
$lang['copyf_dest_dn'] = 'DN de destination';
$lang['copyf_dest_dn_tooltip'] = 'Le DN de la nouvelle entr�e � cr�er lors de la copie de l\'entr�e source';
$lang['copyf_dest_server'] = 'Destination Serveur';
$lang['copyf_note'] = 'Note: La copie entre diff�rents serveurs fonctionne seulement si il n\'y a pas de violation de sch�ma';
$lang['copyf_recursive_copy'] = 'Copier r�cursivement les sous-entr�es de cet object.';
$lang['recursive_copy'] = 'Copie r�cursive';
$lang['filter'] = 'Filtre';
$lang['filter_tooltip'] = 'Lors d\'une copie r�cursive, seuls les entr�es correspondant � ce filtre seront copi�s';

//create.php
$lang['create_required_attribute'] = 'Une valeur n\'a pas �t� sp�cifi�e pour l\'attribut requis %s.';
$lang['redirecting'] = 'Redirection';
$lang['here'] = 'ici';
$lang['create_could_not_add'] = 'L\'ajout de l\'objet au serveur LDAP n\'a pu �tre effectu�e.';
$lang['rdn_field_blank'] = 'Vous avez laisser le champ du RDN vide.';
$lang['container_does_not_exist'] = 'Le containeur que vous avez sp�cifi� (%s) n\'existe pas. Veuillez, s\'il vous pla�t recommencer.';
$lang['no_objectclasses_selected'] = 'Vous n\'avez s�lectionner aucun ObjectClasses pour cet objet. Veuillez s\'il vous pla�t retourner � la page pr�c�dente et le faire.';
$lang['hint_structural_oclass'] = 'Note: Vous devez choisir au moins une classe d\'objet de type structural';

//create_form.php
$lang['createf_create_object'] = 'Creation d\'un objet';
$lang['createf_choose_temp'] = 'Choix d\'un mod�le';
$lang['createf_select_temp'] = 'Selectionner un mod�le pour la proc�dure de cr�ation';
$lang['createf_proceed'] = 'Continuer';
$lang['relative_distinguished_name'] = 'Relative Distinguished Name';
$lang['rdn'] = 'RDN';
$lang['rdn_example'] = '(exemple: cn=MyNewPerson)';
$lang['container'] = 'Containeur';
$lang['alias_for'] = 'Alias pour %s';


//creation_template.php
$lang['ctemplate_on_server'] = 'Sur le serveur';
$lang['ctemplate_no_template'] = 'Aucun mod�le sp�cifi� dans les variables POST.';
$lang['ctemplate_config_handler'] = 'Votre configuration sc�cifie un gestionnaire de';
$lang['ctemplate_handler_does_not_exist'] = 'pour ce mod�le. Cependant, ce gestionnaire n\'existe pas dans le r�pertoire \'templates/creation\'.';
$lang['create_step1'] = 'Etape 1 de 2: Nom et classes d\'objet';
$lang['create_step2'] = 'Etape 2 de 2: D�finition des attributs et de leurs valeurs';
//search.php
$lang['you_have_not_logged_into_server'] = 'Vous ne vous �tes pas encore logg� aupr�s du serveur s�lectionn�. Vous ne pouvez y effectuer des recherches.';
$lang['click_to_go_to_login_form'] = 'Cliquer ici pour vous rendre au formulaire de login';
$lang['unrecognized_criteria_option'] = 'Crit�re non reconnu: ';
$lang['if_you_want_to_add_criteria'] = 'Si vous voulez ajouter vos propres crit�re � la liste, soyez cetain d\'�diter search.php afin de pouvoir les g�rer.';
$lang['entries_found'] = 'Entr�es trouv�es: ';
$lang['filter_performed'] = 'Filtre utilis�: ';
$lang['search_duration'] = 'Recherche effectu�e par phpLDAPadmin en';
$lang['seconds'] = 'secondes';

// search_form_advanced.php
$lang['scope_in_which_to_search'] = 'Port�e de la recherche';
$lang['scope_sub'] = 'Sub (le sous-arbre)';
$lang['scope_one'] = 'One (un niveau sous la base)';
$lang['scope_base'] = 'Base (le dn de base)';
$lang['standard_ldap_search_filter'] = 'Un filtre standard de recherche LDAP. Exemple: (&(sn=Smith)(givenname=David))';
$lang['search_filter'] = 'Filtre pour la recherche';
$lang['list_of_attrs_to_display_in_results'] = 'Une liste des attributs � afficher dans les r�sultats(s�par�s par des virgules)';
$lang['show_attributes'] = 'Attributs � afficher';

// search_form_simple.php
$lang['search_for_entries_whose'] = 'Chercher les entr�es dont:';
$lang['equals'] = 'est egal �;';
$lang['starts with'] = 'commence par';
$lang['contains'] = 'contient';
$lang['ends with'] = 'se termine par';
$lang['sounds like'] = 'ressemble �';

// server_info.php
$lang['could_not_fetch_server_info'] = 'Impossible de r�cup�rer les informations concernant le serveur Ldap';
$lang['server_info_for'] = 'Informations pour le serveur: ';
$lang['server_reports_following'] = 'Le serveur a rapport� les informations suivantes';
$lang['nothing_to_report'] = 'Ce serveur n\'a aucunes informations a rapporter.';

//update.php
$lang['update_array_malformed'] = 'update_array n\'est pas bien form�. Ceci est peut-�tre un bogue de phpLDAPadmin. Pourriez-vous effectuer un rapport de bogue, s\'il vous pla�t.';
$lang['could_not_perform_ldap_modify'] = 'L\'op�ration ldap_modify n\'a pu �tre effectu�e.';

// update_confirm.php
$lang['do_you_want_to_make_these_changes'] = 'Voulez-vous effectuer ces changements?';
$lang['attribute'] = 'Attribut';
$lang['old_value'] = 'Ancienne Valeur';
$lang['new_value'] = 'Nouvelle Valeur';
$lang['attr_deleted'] = '[attribut supprim�]';
$lang['commit'] = 'Valider';
$lang['cancel'] = 'Annuler';
$lang['you_made_no_changes'] = 'Aucun changement n\'a �t� effectu�';
$lang['go_back'] = 'Retour';

// welcome.php
$lang['welcome_note'] = 'Utilisez le menu de gauche pour la navigation';
$lang['credits'] = 'Cr�dits';
$lang['changelog'] = 'ChangeLog';
$lang['donate'] = 'Donation';

// view_jpeg_photo.php
$lang['unsafe_file_name'] = 'Nom de fichier non s�r: ';
$lang['no_such_file'] = 'Aucun fichier trouv�: ';

//function.php
$lang['auto_update_not_setup'] = '"auto_uid_numbers" a �t� activ� pour <b>%s</b> dans votre configuration,
                                  mais vous n\'avez pas sp�cifi� le m�canisme "auto_uid_number_mechanism". Veuiller corriger
                                  ce probl�me.';
$lang['uidpool_not_set'] = 'Vous avez sp�cifi� l<tt>auto_uid_number_mechanism</tt> comme uidpool
                            dans la configuration du serveur <b>%s</b>, mais vous n\'avez pas sp�cifi� de valeur pour
                            auto_uid_number_uid_pool_dn. Veuillez le sp�cifier avant de continuer.';
$lang['uidpool_not_exist'] = 'Le uidPool que vous avez sp�cifi� dans votre configuration (%s)
                              n\'existe pas.';
$lang['specified_uidpool'] = 'Le m�chanisme "auto_uid_number_mechanism" a �t� d�fini � search dans votre
                              configuration pour le serveur %s, mais la directive "auto_uid_number_search_base" n\'est pad d�finie. Veuillez le sp�cifier avant de continuer.';
$lang['auto_uid_invalid_credential'] = 'Impossible d\'effectuer un "bind" � %s avec vos droits pour "auto_uid". Veuillez S\'il vous pla�t v�rifier votre fichier de configuration.'; 
$lang['bad_auto_uid_search_base'] = 'Votre fichier de configuration sp�cifie un invalide auto_uid_search_base pour le serveur %s';
$lang['auto_uid_invalid_value'] = 'Une valeur non valide a �t� sp�cifi�e pour le m�chaninsme "auto_uid_number_mechanism" (%s)
                                   dans votre configuration. Seul <tt>uidpool</tt> et <tt>search</tt> sont valides.
                                   Veuillez corriger ce probl�me.';
$lang['error_auth_type_config'] = 'Erreur: Vous avez une erreur dans votre fichier de configuration.Les valeurs 
                                   support�es pour \'auth_type\' sont \'config\' et \'form\' dans la section $servers.
                                   Vous avez mis \'%s\', ce qui n\'est pas autoris�.';
$lang['php_install_not_supports_tls'] = 'Votre installation PHP ne supporte pas TLS.';
$lang['could_not_start_tls'] = 'Impossible de d�marrer TLS.<br />Veuillez,s\'il vous pla�t, v�rifier la configuration de votre serveur LDAP.';                                
$lang['could_not_bind_anon'] = 'Impossible d\'effectuer un "bind" anonyme.';
$lang['anonymous_bind'] = 'Bind Anonyme';
$lang['bad_user_name_or_password'] = 'Mauvais nom d\'utilisateur ou mot de passe. Veuillez recommencer s\'il vous pla�t.';
$lang['redirecting_click_if_nothing_happens'] = 'Redirection... Cliquez ici si rien ne se passe.';
$lang['successfully_logged_in_to_server'] = 'Login r�ussi sur le serveur %s';
$lang['could_not_set_cookie'] = 'Impossible d\'activer les cookies.';
$lang['ldap_said'] = '<b>LDAP said</b>: %s<br /><br />';
$lang['ferror_error'] = 'Erreur';
$lang['fbrowse'] = 'naviguer';
$lang['delete_photo'] = 'Supprimer la photo';
$lang['install_not_support_blowfish'] = 'Votre installation PHP ne support pas l\'encryption blowfish.';
$lang['install_no_mash'] = 'Votre installation PHP ne supporte pas la fonction mhash(). Impossible de cr�er un hash SHA.';
$lang['jpeg_contains_errors'] = 'jpegPhoto contient des erreurs<br />';
$lang['ferror_number'] = '<b>Num�ro de l\'erreur</b>: %s <small>(%s)</small><br /><br />';
$lang['ferror_discription'] = '<b>Description</b>: %s <br /><br />';
$lang['ferror_number_short'] = '<b>Num� de l\'erreur</b>: %s<br /><br />';
$lang['ferror_discription_short'] = '<b>Description</b>: (pas de description disponible)<br />';
$lang['ferror_submit_bug'] = 'Est-ce un bogue de phpLDAPadmin? Si c\'est le cas,veuillez s\'il vous pla�t <a href=\'%s\'>le rapporter</a>.';
$lang['ferror_unrecognized_num'] = 'Num�ro de l\'erreur non reconnu: ';
$lang['ferror_nonfatil_bug'] = '<center><table class=\'notice\'><tr><td colspan=\'2\'><center><img src=\'images/warning.png\' height=\'12\' width=\'13\' />
             <b>Vous avez trouv� un bogue non fatal dans phpLDAPAdmin!</b></td></tr><tr><td>Erreur:</td><td><b>%s</b> (<b>%s</b>)</td></tr><tr><td>Fichier:</td>
             <td><b>%s</b> ligne <b>%s</b>, origine de l\'appel <b>%s</b></td></tr><tr><td>Versions:</td><td>PLA: <b>%s</b>, PHP: <b>%s</b>, SAPI: <b>%s</b>
             </td></tr><tr><td>Serveur Web:</td><td><b>%s</b></td></tr><tr><td colspan=\'2\'><center><a target=\'new\' href=\'%s\'>
             S\'il vous pla�t, veuillez rapporter ce bogue en cliquant ici</a>.</center></td></tr></table></center><br />';
$lang['ferror_congrats_found_bug'] = 'F�licitations! Vous avez trouv� un bogue dans phpLDAPadmin.<br /><br />
	     <table class=\'bug\'>
	     <tr><td>Erreur:</td><td><b>%s</b></td></tr>
	     <tr><td>Niveau:</td><td><b>%s</b></td></tr>
	     <tr><td>Fichier:</td><td><b>%s</b></td></tr>
	     <tr><td>Ligne:</td><td><b>%s</b></td></tr>
        	 <tr><td>Origine de l\'appel:</td><td><b>%s</b></td></tr>
	     <tr><td>PLA Version:</td><td><b>%s</b></td></tr>
	     <tr><td>PHP Version:</td><td><b>%s</b></td></tr>
	     <tr><td>PHP SAPI:</td><td><b>%s</b></td></tr>
	     <tr><td>Serveur Webr:</td><td><b>%s</b></td></tr>
	     </table>
	     <br />
             S\'il vous pla�t, veuillez rapporter ce bogue en cliquant ici!';

//ldif_import_form
$lang['import_ldif_file_title'] = 'Import de fichier LDIF';
$lang['select_ldif_file'] = 'S�lectionner un fichier LDIF:';
$lang['select_ldif_file_proceed'] = 'Continuer &gt;&gt;';

//lldif_import
$lang['add_action'] = 'Ajout de...';
$lang['delete_action'] = 'Supression de...';
$lang['rename_action'] = 'Renommage de...';
$lang['modify_action'] = 'Modification de...';
$lang['warning_no_ldif_version_found'] = 'Aucun num�ro de version trouv�. Version 1 suppos�.';
$lang['valid_dn_line_required'] = 'Une ligne avec un dn valide est requis.';
$lang['valid_dn_line_required'] = 'A valid dn line is required.';
$lang['missing_uploaded_file'] = 'Le fichier est manquant.';
$lang['no_ldif_file_specified.'] = 'Aucun fichier LDIFsp�cifi�. Veuillez r�essayer, s\'il vous pla�t.';
$lang['ldif_file_empty'] = 'Le fichier LDIF est vide.';
$lang['file'] = 'Fichier';
$lang['number_bytes'] = '%s bytes';

$lang['failed'] = '�chec';
$lang['ldif_parse_error'] = 'Erreur lors de l\'analyse du fichier LDIF';
$lang['ldif_could_not_add_object'] = 'Impossible d\'ajouter l\'objet:';
$lang['ldif_could_not_rename_object'] = 'Impossible de renommer l\'objet:';
$lang['ldif_could_not_delete_object'] = 'Impossible de supprimer l\'objet:';
$lang['ldif_could_not_modify_object'] = 'Impossible de modifier l\'objet:';
$lang['ldif_line_number'] = 'Num�ro de ligne';
$lang['ldif_line'] = 'Ligne';

//delete_form
$lang['sure_permanent_delete_object']='Etes-vous certain de vouloir supprimer d�finitivement cet objet?';
$lang['list_of_entries_to_be_deleted'] = 'Liste des entr�es � supprimer:';
$lang['dn'] = 'DN';

// Exports
$lang['export_format'] = 'Format';
$lang['line_ends'] = 'Fin de ligne';
$lang['must_choose_export_format'] = 'Vous devez s�lectionner un format pour l\'exportation.';
$lang['invalid_export_format'] = 'Format d\'exportation invalide';
$lang['no_exporter_found'] = 'Aucun exporteur trouv�.';
$lang['error_performing_search'] = 'Une erreur a eu lieu lors de la recherche.';
$lang['showing_results_x_through_y'] = 'Affichage  de %s � %s des r�sultats.';
$lang['searching'] = 'Recherche...';
$lang['size_limit_exceeded'] = 'Notice, la limite de taille pour la recherche est atteinte.';
$lang['entry'] = 'Entr�e';
$lang['ldif_export_for_dn'] = 'Export LDIF pour: %s';
$lang['generated_on_date'] = 'Gener� par phpLDAPadmin le %s';
$lang['total_entries'] = 'Nombre d\'entr�es';
$lang['dsml_export_for_dn'] = 'Export DSML pour: %s';


// logins
$lang['could_not_find_user'] = 'Impossible de trouver l\'utilisateur "%s"';
$lang['password_blank'] = 'Le champ pour le mot de passe est vide.';
$lang['login_cancelled'] = 'Login interrompu.';
$lang['no_one_logged_in'] = 'Personne n\'est logg� � ce serveur.';
$lang['could_not_logout'] = 'Impossible de se d�connecter.';
$lang['unknown_auth_type'] = 'auth_type inconnu: %s';
$lang['logged_out_successfully'] = 'D�connection r�ussie du serveur %s';
$lang['authenticate_to_server'] = 'Authentification au serveur %s';
$lang['warning_this_web_connection_is_unencrypted'] = 'Attention: Cette connection web n\'est pas crypt�e.';
$lang['not_using_https'] = 'Vous n\'utilisez pas \'https\'. Le navigateur web transmettra les informations de login en clair.';
$lang['login_dn'] = 'Login DN';
$lang['user_name'] = 'Nom de l\'utilisateur';
$lang['password'] = 'Mot de passe';
$lang['authenticate'] = 'Authentification';

// Entry browser
$lang['entry_chooser_title'] = 'S�lection de l\'entr�e';

// Index page
$lang['need_to_configure'] = 'phpLDAPadmin a besoin d\'�tre configur�.Pour cela, �diter le fichier \'config.php\' . Un exemple de fichier de configuration est fourni dans \'config.php.example\'';

// Mass deletes
$lang['no_deletes_in_read_only'] = 'Les suppressions ne sont pas permises en mode lecure seule.';
$lang['error_calling_mass_delete'] = 'Erreur lors de l\'appel �  mass_delete.php.  mass_delete est manquant dans les variables POST.';
$lang['mass_delete_not_array'] = 'La variable POST mass_delete \'est pas un tableau.';
$lang['mass_delete_not_enabled'] = 'La suppression de masse n\'est pas disponible. Veuillez l\'activer dans config.php avant de continuer.';
$lang['mass_deleting'] = 'Suppression en masse';
$lang['mass_delete_progress'] = 'Progr�s de la suppression sur le serveur "%s"';
$lang['malformed_mass_delete_array'] = 'Le tableau mass_delete n\'est pas bien form�.';
$lang['no_entries_to_delete'] = 'Vous n\'avez s�lectionn� aucune entr�es � effacer.';
$lang['deleting_dn'] = 'Deleting %s';
$lang['total_entries_failed'] = '%s des %s entr�es n\'ont pu �tre supprim�es.';
$lang['all_entries_successful'] = 'Toutes les entr�es ont �t� supprim�es avec succ�s.';
$lang['confirm_mass_delete'] = 'Confirmation de la suppression en masse de %s entr�es sur le serveur %s';
$lang['yes_delete'] = 'Oui, supprimer!';

// Renaming entries
$lang['non_leaf_nodes_cannot_be_renamed'] = 'Vous ne pouvez pas renommer une entr�e qui a des sous-entr�es';
$lang['no_rdn_change'] = 'Le RDN n\'a pas �t� modifi�';
$lang['invalid_rdn'] = 'Valeur invalide du RDN';
$lang['could_not_rename'] = 'Impossible de renommer l\'entr�e';


?>
