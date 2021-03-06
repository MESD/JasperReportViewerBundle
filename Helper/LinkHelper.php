<?php

namespace Mesd\Jasper\ReportViewerBundle\Helper;

use Symfony\Component\Routing\Router;

class LinkHelper
{
    ///////////////
    // VARIABLES //
    ///////////////

    /**
     * Reference to the symfony application's router
     * @var Router
     */
    private $router;

    //////////////////
    // BASE METHODS //
    //////////////////


    /**
     * Constructor (Primarily for use by the dependency injection container)
     *
     * @param Router $router The Symfony Applications routing component
     */
    public function __construct(Router $router) {
        //Set stuff
        $this->router = $router;
    }


    ///////////////////
    // CLASS METHODS //
    ///////////////////


    /**
     * Generates the links for the buttons on the toolbar (barring history which stays the same throughout the page view)
     *
     * @param  string $requestId  The current request id of the report being viewed
     * @param  int    $page       The current page number
     * @param  int    $totalPages The total number of pages
     *
     * @return array              The array of links
     */
    public function generateToolBarLinks($requestId, $page, $totalPages) {
        //Setup the return array
        $links = array();

        //Generate the export links
        $links['pdf'] = $this->router->generate('MesdJasperReportBundle_export_cached_report', array(
                'requestId' => $requestId,
                'format'    => 'pdf'
            ));
        $links['xls'] = $this->router->generate('MesdJasperReportBundle_export_cached_report', array(
                'requestId' => $requestId,
                'format'    => 'xls'
            ));

        //Generate the print link (which for now is just the pdf link)
        $links['print'] = $links['pdf'];

        //Generate the page links
        if ($page != 1) {
            $links['first'] = $this->router->generate('MesdJasperReportViewerBundle_display_page', array(
                    'requestId' => $requestId,
                    'page' => 1
                ));
        } else {
            $links['first'] = '#';
        }

        if (0 < $page - 10) {
            $links['back10'] = $this->router->generate('MesdJasperReportViewerBundle_display_page', array(
                    'requestId' => $requestId,
                    'page' => $page - 10
                ));
        } else {
            $links['back10'] = '#';
        }

        if (0 < $page - 1) {
            $links['back'] = $this->router->generate('MesdJasperReportViewerBundle_display_page', array(
                    'requestId' => $requestId,
                    'page' => $page - 1
                ));
        } else {
            $links['back'] = '#';
        }

        if ($page + 1 <= $totalPages) {
            $links['forward'] = $this->router->generate('MesdJasperReportViewerBundle_display_page', array(
                    'requestId' => $requestId,
                    'page' => $page + 1
                ));
        } else {
            $links['forward'] = '#';
        }

        if ($page + 10 <= $totalPages) {
            $links['forward10'] = $this->router->generate('MesdJasperReportViewerBundle_display_page', array(
                    'requestId' => $requestId,
                    'page' => $page + 10
                ));
        } else {
            $links['forward10'] = '#';
        }

        if ($page != $totalPages) {
            $links['last']  = $this->router->generate('MesdJasperReportViewerBundle_display_page', array(
                    'requestId' => $requestId,
                    'page' => $totalPages
                ));
        } else {
            $links['last'] = '#';
        }

        //return the finished links array
        return $links;
    }
}