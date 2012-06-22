<?php
/**
 * roboProjekt is a plugin that allows you to easily create Projectpages specified to your
 * needs
 * 
 * Copyright (C) 2012  Marcel Neidinger (github.com/sQu4rks)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
class SpecialroboProjekt extends SpecialPage{
	function __construct(){
		parent::__construct('roboProjekt');
	}
	
	/**
	 * Function will be called on execution
	 */
	function execute($par){
		global $wgOut;
		global $wgUser;
		
		//Set title and Stuff
		$this->setHeaders();
		$wgOut->setPageTitle('roboProjekt');
		//Formdescriptor to describe our Interface
		$formDescriptor = array(
			'projektname' => array(
					'label' => 'Projektname: ',
					'class' => 'HTMLTextField',
					'info' => 'Achte bitte darauf, das dein Projektname keinem anderen Projekt ähnelt',
					'required' => true
			),
			'projektbeschreibung' => array(
					'label' => 'Projektbeschreibung: ',
					'type' => 'textarea',
					'info' => 'Bitte beschreibe dein Projekt kurz (IYPT Text reicht bspw.)',
					'rows' => 5,
					'cols' => 25,
					'required' => true
			),
			'projektleiter' => array(
					'label' => 'Projektleiter: ',
					'class' => 'HTMLTextField',
					'info' => 'Dieser Leiter sollte mit dem von JuFo übereinstimmen ',
					'default' => $wgUser->getRealName(),
					'required' => true
			),
			'projektkategorie' => array(
					'label' => 'Projektkategorie',
					'type' => 'select',
					'options' => array(
						'ICYS' => 'ICYS',
						'IYPT' => 'IYPT',
						'Jugend Forscht' => 'Jugend_Forscht',
						'Seminararbeit' => 'Seminararbeit'
					),
					'required' => true
			),
			'hint' => array(
					'label' => 'So gehts weiter ',
					'type' => 'info',
					'default' => 'Nach dem <strong>Erstellen</strong> gelangst du auf die Seite <br /> Bitte pfleg als erstes die Fehlenden Informationen deiner Teammitglieder ein <br />Klick dann auf <strong>Beobachten</strong>, damit die Wiki dich über Änderungen informiert',
					'raw' => true,#Keine html-escapierung
					'required' => true
			)
		);
		//Initialise HTML Form itself
		$htmlForm = new HTMLForm($formDescriptor,'myform');
		$htmlForm->setSubmitText('Projekt erstellen');
		$htmlForm->setTitle($this->getTitle());
		
		$htmlForm->setSubmitCallback(array('SpecialroboProjekt','processInput')); //Callback
		$htmlForm->show();	
	}

	/**
	 * Funktion zur verarbeitung der Daten
	 * @author Marcel Neidinger 
	 */
	static function processInput( $formData ) {
		global $wgOut;
		global $wgUser;
		
		//Variablen deklarieren
		$projektTitle = $formData['projektname'];
		$projektbeschreibung = $formData['projektbeschreibung'];
		$projektleiter = $formData['projektleiter'];
		$projektkategorie = $formData['projektkategorie'];
		
		//Titel festlegen und checken ob dieser nicht funktioniert PFADEN !!!
		$title = Title::newFromText($projektTitle);
		
		if($title->exists()){
			$wgOut->addHTML('<div style="border-style: solid; border-color: red; border-width: 1px; color: red; font-weight: bold; text-align: center;">Dieses Projekt exsistiert schon </div>');
		}else{
			$page = new WikiPage($title);
			//Content zusammenschreiben
			$Usersektion = '<h2>Gruppenmitglieder</h2> <table style="width: 100%; border-width: 1px; border-color: black; border-style: solid;"> <tr style="background-color: #EDC31A;"><th>Name</th> <th>E-Mailadresse </th> <th>Telefon</th> <tr> <td>'.$projektleiter.'</td><td> </td><td> </td></tr><tr><td> </td><td> </td> <td> </td></tr><tr> <td> </td><td> </td> <td> </td></tr></table>';
			$content = '<h2>Beschreibung</h2>'.$projektbeschreibung;
			$page->doEdit($content.$Usersektion."[[Kategorie:".$projektkategorie."]]","Summary",0,false,$wgUser);
			$wgOut->addHTML('<div style="border-style: solid; border-color: green; border-width: 1px; color: green; font-weight: bold; text-align: center;">Das Projekt wurde erstellt</div>');
			//Auf die Seite redirekten
			$wgOut->redirect($page->getTitle()->getLocalUrl());
		} 
	}
}
