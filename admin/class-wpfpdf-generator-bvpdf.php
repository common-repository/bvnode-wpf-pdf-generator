<?php

class bvnode_wpf_pdf_Generator_BVPDF {
    public $pdf;

    public $entry_id;

    public $entry;

    public $form_data;

    public $fields;

    public $settings;

    public $template_id;

    public $template;

    public $content;

    public $header;

    public $footer;

    public $css;

    public function __construct( $entry_id = 0, $form_data = null, $fields = null ) {
        global $bvnode_wpf_pdf_ProccessSmartTags;
        require_once bvnode_wpf_pdf_PATH . 'dompdf/autoload.inc.php';
        $this->pdf = new Dompdf\Dompdf();
        $this->entry_id = $entry_id;
        $this->entry = false;
        $this->form_data = $form_data;
        $this->fields = $fields;
        $this->settings = null;
        $this->template_id = null;
        $this->template = null;
        $this->content = null;
        $this->header = null;
        $this->footer = null;
        $this->css = null;
        if ( $this->entry_id ) {
            $this->entry = wpforms()->entry->get( $this->entry_id );
        }
        if ( !$this->fields && $this->entry ) {
            $this->fields = json_decode( $this->entry->fields, true );
        }
        if ( !$this->form_data && $this->entry ) {
            $form = wpforms()->form->get( $this->entry->form_id );
            $this->form_data = wpforms_decode( $form->post_content );
        }
        if ( isset( $this->form_data['be_template_fields'] ) ) {
            $be_template_fields = $this->form_data['be_template_fields'];
            $bvnode_wpf_pdf_ProccessSmartTags = false;
            foreach ( $be_template_fields as $index => $value ) {
                if ( $this->entry_id ) {
                    $be_template_fields[$index] = wpforms_process_smart_tags(
                        $value,
                        $this->form_data,
                        $this->fields,
                        $this->entry_id
                    );
                } else {
                    $be_template_fields[$index] = wpforms_process_smart_tags( $value, $this->form_data, $this->fields );
                }
            }
            $bvnode_wpf_pdf_ProccessSmartTags = true;
        }
        // TODO: Seperate source logic to other fn
        $options = get_option( 'bvnode_wpf_pdf_generator_template_data' );
        $this->template = $options['bvnode_wpf_pdf_generator_template_template'] ?? '';
        $this->settings = json_decode( $options['bvnode_wpf_pdf_generator_template_settings'] ?? '', 1 );
        $this->header = $options['bvnode_wpf_pdf_generator_template_header'] ?? '';
        $this->footer = $options['bvnode_wpf_pdf_generator_template_footer'] ?? '';
        $this->css = $options['bvnode_wpf_pdf_generator_template_css'] ?? '';
        // TODO: End
        $this->content = $this->template;
        if ( isset( $be_template_fields ) ) {
            foreach ( $be_template_fields as $index => $value ) {
                if ( !empty( $value ) && trim( $value ) != ',' && trim( $value ) != '-' ) {
                    $this->content = str_replace( '{{' . $index . '}}', $value, $this->content );
                } else {
                    $this->content = str_replace( '{{' . $index . '}}', '---', $this->content );
                }
            }
        }
        $bvnode_wpf_pdf_ProccessSmartTags = false;
        if ( $this->entry_id ) {
            $this->content = wpforms_process_smart_tags(
                $this->content,
                $this->form_data,
                $this->fields,
                $this->entry_id
            );
        } else {
            $this->content = wpforms_process_smart_tags( $this->content, $this->form_data, $this->fields );
        }
        $bvnode_wpf_pdf_ProccessSmartTags = true;
        $this->content = $this->wpf_process_smarttag_all_fields( $this->content, $this->form_data, $this->fields );
    }

    public function get_css() {
        return $this->css ?? '';
    }

    public function get_font() {
        return $this->settings['font'] ?? 'Helvetica';
    }

    public function get_orientation() {
        return $this->settings['orientation'] ?? 'portrait';
    }

    public function get_paper_size() {
        return $this->settings['paper_size'] ?? 'a4';
    }

    public function get_margin( $location = 'top' ) {
        return $this->settings['margins'][$location] ?? 0;
    }

    public function buildCSS() {
        return '<style>
        body {
            counter-reset: page;
            font-family: ' . $this->get_font() . ';
            
        }
        img {
            max-width: 100%;
            height: auto;
        }
        @page {
            positition: relative;
            counter-increment: page;
            margin-top: ' . $this->get_margin( 'top' ) . ';
            margin-bottom: ' . $this->get_margin( 'bottom' ) . ';
            margin-left: ' . $this->get_margin( 'left' ) . ';
            margin-right: ' . $this->get_margin( 'right' ) . ';
        }
        header{
            position: fixed;
            left: 0px;
            right: 0px;
            height: ' . $this->get_margin( 'top' ) / 3 * 1 . ';
            
            margin-top: -' . $this->get_margin( 'top' ) . ';
            border-bottom: 1px solid #000;
            padding-top: ' . $this->get_margin( 'top' ) / 3 * 1 . '; 
            padding-bottom: ' . $this->get_margin( 'top' ) / 3 * 1 . '; 
        }
        .page-no::after {
            content: counter(page);
        }
        footer {
            position: fixed;
            left: 0px;
            right: 0px;
            
            height: ' . $this->get_margin( 'bottom' ) / 3 * 2 . ';
            padding-top: ' . $this->get_margin( 'bottom' ) / 3 * 1 . ';
            bottom: 0px;
            margin-bottom: -' . $this->get_margin( 'bottom' ) . ';
            border-top: 1px solid #000;
        }
        .page-break { page-break-before: always; }
        ' . $this->get_css() . '
    </style>';
    }

    public function buildHeader() {
    }

    public function buildFooter() {
    }

    public function buildMain() {
    }

    public function buildAllFieldsTable( $first = false ) {
        $templ = '<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top:1px solid #dddddd;border-collapse: collapse;max-width:100%;width:100%;"><tbody>
        <tr><td style="color:#333333;padding-top: 20px;padding-bottom: 3px;"><strong>{field_name}</strong></td></tr>
        <tr><td style="color:#555555;padding-top: 3px;padding-bottom: 20px;">{field_value}</td></tr>
        </tbody></table>';
        if ( $first ) {
            $templ = str_replace( 'border-top:1px solid #dddddd;', '', $templ );
        }
        return $templ;
    }

    public function buildHTML() {
        $html = '<!DOCTYPE html><html lang="en"><head>' . $this->buildCSS() . '</head><body>';
        if ( $this->settings['page_header'] ) {
            $html .= '<header>' . $this->header . '</header>';
        }
        if ( $this->settings['page_footer'] ) {
            $html .= '<footer>' . $this->footer . '</footer>';
        }
        $html .= '<main>' . str_replace( '{page-break}', '<div class="page-break"></div>', $this->content ) . '</main>';
        $html .= '</body></html>';
        return str_replace( '{page-no}', '<span class="page-no"></span>', $html );
    }

    public function display_pdf() {
        $this->pdf->loadHtml( $this->buildHTML() );
        $options = new Dompdf\Options();
        $options->set( "isPhpEnabled", true );
        $options->set( 'isRemoteEnabled', true );
        $this->pdf->setOptions( $options );
        $this->pdf->setPaper( $this->get_paper_size(), $this->get_orientation() );
        $this->pdf->render();
        return $this->pdf;
    }

    public function get_filename() {
        global $bvnode_wpf_pdf_ProccessSmartTags;
        if ( $this->entry_id ) {
            $entry = wpforms()->entry->get( $this->entry_id );
        }
        $this->fields = json_decode( $entry->fields, true );
        $file_name = $this->form_data['settings']['bvnode_wpf_pdf_file_name'];
        if ( isset( $file_name ) && !empty( $file_name ) ) {
            $real_file_name = $file_name;
            $bvnode_wpf_pdf_ProccessSmartTags = false;
            if ( $this->entry_id ) {
                $real_file_name = wpforms_process_smart_tags( $real_file_name, $this->form_data, $this->fields );
            } else {
                $real_file_name = wpforms_process_smart_tags( $real_file_name, $this->form_data, $this->fields );
            }
            $bvnode_wpf_pdf_ProccessSmartTags = true;
        } else {
            $real_file_name = $this->form_data['settings']['bvnode_wpf_pdf_template'] . "_" . $this->entry_id;
        }
        return $real_file_name;
    }

    public static function get_conditions( $content ) {
        $data = [];
        preg_match_all( '/{%[\\s]?if.*%}((.|\\n)*){%[\\s]?endif.*?%}/iuU', $content, $match1 );
        if ( isset( $match1[0] ) ) {
            foreach ( $match1[0] as $matches ) {
                preg_match_all( '/%\\s?(?<statement>.*?\\s)((?<field>.*?)[\\s]?(?<operator>==|<>|<=|>=|>|<|!=))?(?<condition>.+?)?%}(?<value>(.|\\n)*?){/iu', $matches, $match2 );
                if ( isset( $match2['statement'] ) ) {
                    for ($i = 0; $i < count( $match2['statement'] ); $i++) {
                        $data[] = array(
                            'statement' => trim( $match2['statement'][$i] ),
                            'operator'  => trim( $match2['operator'][$i] ),
                            'field'     => trim( $match2['field'][$i] ),
                            'condition' => trim( str_replace( ['"', "'"], '', $match2['condition'][$i] ) ),
                            'value'     => trim( $match2['value'][$i] ),
                            'match'     => $matches,
                        );
                    }
                }
            }
        }
        return $data;
    }

    function condition_help(
        $stat,
        $field,
        $data,
        $val,
        $oper = '=='
    ) {
        if ( isset( $field ) && !empty( $field ) ) {
            switch ( $oper ) {
                case '==':
                    return ( $field == $data ? $val : false );
                case '!=':
                    return ( $field != $data ? $val : false );
                case '>':
                    return ( $field > $data ? $val : false );
                case '<':
                    return ( $field < $data ? $val : false );
                case '<=':
                    return ( $field <= $data ? $val : false );
                case '>=':
                    return ( $field >= $data ? $val : false );
                case '<>':
                    return ( $field != $data ? $val : false );
            }
        }
        return ( $stat == 'else' ? $val : false );
    }

    public function wpf_process_smarttag_all_fields( $content, $form_data, $fields ) {
        // phpcs:ignore
        if ( empty( $fields ) ) {
            return '';
        }
        $message = '';
        // Check to see if user has added support for field type.
        //$other_fields = apply_filters( 'wpforms_email_display_other_fields', [], $this );
        $x = 1;
        foreach ( $fields as $field_id => $field ) {
            $field_name = '';
            $field_val = '';
            // If the field exists in the form_data but not in the final
            // field data, then it's a non-input based field, "other fields".
            if ( empty( $fields[$field_id] ) ) {
                // if ( empty( $other_fields ) || ! in_array( $field['type'], $other_fields, true ) ) {
                // 	continue;
                // }
                if ( $field['type'] === 'divider' ) {
                    $field_name = ( !empty( $field['label'] ) ? str_repeat( '&mdash;', 3 ) . ' ' . $field['label'] . ' ' . str_repeat( '&mdash;', 3 ) : null );
                    $field_val = ( !empty( $field['description'] ) ? $field['description'] : '' );
                } elseif ( $field['type'] === 'pagebreak' ) {
                    if ( !empty( $field['position'] ) && $field['position'] === 'bottom' ) {
                        continue;
                    }
                    $title = ( !empty( $field['title'] ) ? $field['title'] : esc_html__( 'Page Break', 'bvnode-wpf-pdf-generator' ) );
                    $field_name = str_repeat( '&mdash;', 6 ) . ' ' . $title . ' ' . str_repeat( '&mdash;', 6 );
                } elseif ( $field['type'] === 'html' ) {
                    $field_name = ( !empty( $field['name'] ) ? $field['name'] : esc_html__( 'HTML / Code Block', 'bvnode-wpf-pdf-generator' ) );
                    $field_val = $field['code'];
                } elseif ( $field['type'] === 'content' ) {
                    $field_name = esc_html__( 'Content', 'bvnode-wpf-pdf-generator' );
                    $field_val = $field['content'];
                }
            } else {
                if ( !isset( $fields[$field_id]['value'] ) || (string) $fields[$field_id]['value'] === '' ) {
                    continue;
                }
                $field_name = ( isset( $fields[$field_id]['name'] ) ? $fields[$field_id]['name'] : '' );
                $field_val = ( empty( $fields[$field_id]['value'] ) && !is_numeric( $fields[$field_id]['value'] ) ? '<em>' . esc_html__( '(empty)', 'bvnode-wpf-pdf-generator' ) . '</em>' : $fields[$field_id]['value'] );
            }
            if ( empty( $field_name ) && null !== $field_name ) {
                $field_name = sprintf( 
                    /* translators: %d - field ID. */
                    esc_html__( 'Field ID #%d', 'bvnode-wpf-pdf-generator' ),
                    absint( $field['id'] )
                 );
            }
            $field_item = $this->buildAllFieldsTable( 1 === $x );
            $field_item = str_replace( '{field_name}', $field_name, $field_item );
            $field_item = str_replace( '{field_value}', apply_filters(
                'wpforms_html_field_value',
                $field_val,
                ( isset( $fields[$field_id] ) ? $fields[$field_id] : $field ),
                $form_data,
                'email-html'
            ), $field_item );
            $message .= wpautop( $field_item );
            $x++;
        }
        if ( empty( $message ) ) {
            $empty_message = esc_html__( 'An empty form was submitted.', 'bvnode-wpf-pdf-generator' );
            $message = wpautop( $empty_message );
        }
        return str_replace( '{all_fields_table}', '' . $message . '', $content );
    }

}
