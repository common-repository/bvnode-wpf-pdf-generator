<?php

class bvnode_wpf_pdf_Generator_PDF {
    private $template;

    public function __construct( $template ) {
        $this->template = $template;
    }

    public function build_css() {
        return '<style>
        body {
            counter-reset: page;
            font-family: ' . $this->template->get_font() . ';
            
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        @page {
            positition: relative;
            counter-increment: page;
            margin-top: ' . $this->template->get_margin( 'top' ) . ';
            margin-bottom: ' . $this->template->get_margin( 'bottom' ) . ';
            margin-left: ' . $this->template->get_margin( 'left' ) . ';
            margin-right: ' . $this->template->get_margin( 'right' ) . ';
        }
        header{
            position: fixed;
            left: 0px;
            right: 0px;
            height: ' . $this->template->get_margin( 'top' ) / 3 * 1 . ';
            
            margin-top: -' . $this->template->get_margin( 'top' ) . ';
            border-bottom: 1px solid #000;
            padding-top: ' . $this->template->get_margin( 'top' ) / 3 * 1 . '; 
            padding-bottom: ' . $this->template->get_margin( 'top' ) / 3 * 1 . '; 
        }
        .page-no::after {
            content: counter(page);
        }
        .all-fields-table {
            border-top:1px solid #dddddd;
            border-collapse: collapse;
            max-width:100%;
            width:100%;
            table-layout:fixed;
        }
        .all-fields-table-row-name {
            color:#333333;padding-top: 20px;padding-bottom: 3px;
        }
        .all-fields-table-row-value {
            color:#555555;padding-top: 3px;padding-bottom: 20px;
        }
        footer {
            position: fixed;
            left: 0px;
            right: 0px;
            
            height: ' . $this->template->get_margin( 'bottom' ) / 3 * 2 . ';
            padding-top: ' . $this->template->get_margin( 'bottom' ) / 3 * 1 . ';
            bottom: 0px;
            margin-bottom: -' . $this->template->get_margin( 'bottom' ) . ';
            border-top: 1px solid #000;
        }
        .page-break { page-break-before: always; }
        ' . $this->template->get_css() . '
    </style>';
    }

    public function build_html() {
        $html = '<!DOCTYPE html><html lang="en"><head>' . $this->build_css() . '</head><body>';
        $html .= $this->template->output();
        $html .= '</body></html>';
        return $html;
    }

    public function pdf() {
        require_once bvnode_wpf_pdf_PATH . 'dompdf/autoload.inc.php';
        $pdf = new Dompdf\Dompdf();
        $options = new Dompdf\Options();
        $options->set( "isPhpEnabled", true );
        $options->set( 'isRemoteEnabled', true );
        $pdf->setOptions( $options );
        $pdf->setPaper( $this->template->get_paper_size(), $this->template->get_orientation() );
        $pdf->loadHtml( $this->build_html() );
        $pdf->render();
        return $pdf;
    }

}
