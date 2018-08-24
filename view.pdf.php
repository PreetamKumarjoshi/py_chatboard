<?php

/**
 * @package    PwgAds
 * @subpackage Frontend
 * @author     www.boeschung.de
 */
defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
require_once(JPATH_SITE.'/components'.'/com_pwgads'.'/helpers'.'/dompdf'.'/dompdf_config.inc.php');

/**
 * Erweiterung der Basisklasse HtmlView
 */

class PwgAdsViewReporting extends HtmlView {

	function display($tpl = null) {

		$app = JFactory::getApplication();

		$this->reporting_data = $this->get('ReportingData');
		$this->customer_data = $this->get('CustomerData');

		// Fehler abfangen, die beim Aufbau der View aufgetreten sind
		if (count($errors = $this->get('Errors'))) {
			JError::raise(500, implode('/n', $errors));
		}




		$html = $this->loadTemplate();
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream('PWG_Anzeigenreport_vom_'.date('dmY').'.pdf');

		parent::display($tpl);
	}

}
