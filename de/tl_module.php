<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Tim Gatzky 2011-2012 
 * @author     Tim Gatzky <info@tim-gatzky.de>
 * @package    newslistcomments 
 * @license    LGPL 
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['addNewslistComments']						= array('Kommentare hinzufügen', 'Fügt der Nachrichtenliste eine Kommentarfunktion für jeden Eintrag hinzu. <p style="color:gray">Das Template news_latest_comments muss gewählt sein.</p>');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_limit'] 				= array('Limit', 'Legt die Anzahl an Kommentaren fest, die direkt angezeigt werden. 0 für alle');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_maxLimit'] 				= array('Maximale Anzahl', 'Die Gesamtanzahl an Kommentaren, die angezeigt werden. 0 für alle');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_annonymus'] 			= array('Name Unbekannt', 'Dieser Name wird öffentlichen Usern gegeben.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_aliveTime'] 			= array('Löschen Timeout', 'Eingabe in Minuten. Zeitspanne in der das Löschen des Kommentars erlaubt ist.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_alwaysShowDelete'] 		= array('Löschen immer anzeigen', 'Die Lösch-Funktion für den Kommentar immer anzeigen.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_allowAll'] 				= array('Öffentliche Kommentare erlauben', 'Der User muss nicht angemeldet sein um Kommentare abzugeben.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_messagebox'] 			= array('Nachrichten-Box einfügen', 'Fügt eine Box zum Nachrichten erstellen oberhalb der Nachrichtenliste hinzu.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_dateFormat'] 			= array('Datums- und Zeitformat', 'Legen Sie das Format für die Zeitausgabe fest. Siehe php manual date()');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_timeFormat'] 			= array('Zeitformat', 'Zeitformat-String. Dient der Anzeige wie lange ein Kommentar bereits existiert. Siehe php manual date()');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_messagebox_template'] 	= array('Nachrichten-Box-Template', 'Wählen Sie das Template für die Nachrichten-Box');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_sortBy'] 				= array('Sortierung', 'Bitte wählen Sie die Art der Sortierung.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_sortBy']['DESC'] 		= array('Neuste oben','');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_sortBy']['ASC'] 		= array('Älteste oben','');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_module']['newslistcomments_legend'] 	= 'Kommentar-Einstellungen';


?>