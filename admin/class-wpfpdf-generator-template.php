<?php

class bvnode_wpf_pdf_Generator_Template {
    private $type;

    private $template_id;

    private $template_name;

    private $form_data;

    private $fields;

    private $options;

    private $settings;

    private $header;

    private $main;

    private $footer;

    private $css;

    private $template_fields;

    private $file_name;

    private $encrypt;

    private $encrypt_password;

    private $html;

    public function __construct(
        $type = 'options',
        $template_id = null,
        $form_data = null,
        $fields = null
    ) {
        $this->type = $type;
        if ( $type == 'template' && $template_id ) {
            $this->template_id = $template_id;
            $this->template_name = get_the_title( $template_id );
            $this->settings = json_decode( get_post_meta( $template_id, '_generatepdf_template_settings', true ) ?? '{}', 1 );
            $this->header = get_post_meta( $template_id, '_generatepdf_template_header', true ) ?? '';
            $this->main = get_post_meta( $template_id, '_generatepdf_template', true ) ?? '';
            $this->footer = get_post_meta( $template_id, '_generatepdf_template_footer', true ) ?? '';
            $this->css = get_post_meta( $template_id, '_generatepdf_template_css', true ) ?? '';
        }
        if ( $type == 'options' ) {
            $options = get_option( 'bvnode_wpf_pdf_generator_template_data' );
            $this->template_name = 'PDF Template';
            $this->settings = json_decode( $options['bvnode_wpf_pdf_generator_template_settings'] ?? '', 1 );
            $this->header = $options['bvnode_wpf_pdf_generator_template_header'] ?? '';
            $this->main = $options['bvnode_wpf_pdf_generator_template_template'] ?? '';
            $this->footer = $options['bvnode_wpf_pdf_generator_template_footer'] ?? '';
            $this->css = $options['bvnode_wpf_pdf_generator_template_css'] ?? '';
        }
        if ( $form_data ) {
            $this->form_data = $form_data;
            $this->template_fields = $form_data['be_template_fields'] ?? [];
            $this->file_name = $form_data['settings']['bvnode_wpf_pdf_file_name'];
            $this->encrypt = $form_data['settings']['bvnode_wpf_pdf_encrypt'] ?? false;
            $this->encrypt_password = $form_data['settings']['bvnode_wpf_pdf_encrypt_password'] ?? false;
        } else {
            $this->template_fields = false;
            $this->file_name = false;
            $this->encrypt = false;
            $this->encrypt_password = false;
        }
        if ( $fields ) {
            $this->fields = $fields;
        } else {
            $this->fields = [];
        }
    }

    public function has_encrypt() {
        return $this->encrypt;
    }

    public function get_encrypt_password() {
        return $this->process_smart_tags( $this->encrypt_password );
    }

    public function get_font() {
        return $this->settings['font'] ?? 'Helvetica';
    }

    public function get_margin( $location = 'top' ) {
        return $this->settings['margins'][$location] ?? 0;
    }

    public function get_orientation() {
        return $this->settings['orientation'] ?? 'portrait';
    }

    public function get_paper_size() {
        return $this->settings['paper_size'] ?? 'a4';
    }

    public function get_css() {
        return $this->css ?? '';
    }

    public function buildAllFieldsTable( $first = false ) {
        $templ = '<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" class="all-fields-table"><tbody>
        <tr><td class="all-fields-table-row-name"><strong>{field_name}</strong></td></tr>
        <tr><td class="all-fields-table-row-value">{field_value}</td></tr>
        </tbody></table>';
        if ( $first ) {
            $templ = str_replace( 'border-top:1px solid #dddddd;', '', $templ );
        }
        return $templ;
    }

    public function build_fields_table() {
        if ( empty( $this->fields ) ) {
            return '';
        }
        $fields = $this->fields;
        $message = '';
        $types = explode( ',', apply_filters( "bvnode_wpf_pdf_smart_tags_field_types", [] )['fields'] );
        // Check to see if user has added support for field type.
        //$other_fields = apply_filters( 'wpforms_email_display_other_fields', [], $this );
        $x = 1;
        foreach ( $fields as $field_id => $field ) {
            $field_name = '';
            $field_val = '';
            if ( !in_array( $field['type'], $types ) ) {
                continue;
            }
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
            $field_item = str_replace( '{field_value}', $this->fix_value( apply_filters(
                'wpforms_html_field_value',
                $field_val,
                ( isset( $fields[$field_id] ) ? $fields[$field_id] : $field ),
                $this->form_data,
                'email-html'
            ) ), $field_item );
            $message .= wpautop( $field_item );
            $x++;
        }
        if ( empty( $message ) ) {
            $empty_message = esc_html__( 'An empty form was submitted.', 'bvnode-wpf-pdf-generator' );
            $message = wpautop( $empty_message );
        }
        return $message;
    }

    function fix_value( $val ) {
        return str_replace( '⭐', '<span style="font-family:DejaVu Sans; sans-serif">&#9733;</span>', $val );
    }

    public function get_html() {
        $html = '';
        if ( isset( $this->settings ) ) {
            if ( $this->settings['page_header'] ) {
                $html .= '<header>' . $this->header . '</header>';
            }
            if ( $this->settings['page_footer'] ) {
                $html .= '<footer>' . $this->footer . '</footer>';
            }
        }
        $html .= '<main>' . $this->main . '</main>';
        $html = str_replace( '{page-no}', '<div class="page-no"></div>', $html );
        $html = str_replace( '{page-break}', '<div class="page-break"></div>', $html );
        if ( strpos( $html, '{all_fields_table}' ) && $this->fields ) {
            $html = str_replace( '{all_fields_table}', $this->build_fields_table(), $html );
        }
        return $html;
    }

    public function get_placeholders() {
        preg_match_all( '/{{(.*?)}}/', $this->get_html(), $placeholders );
        return array_unique( $placeholders[1] );
    }

    public function replace_placeholders( $placeholders = [] ) {
        $html = $this->get_html();
        foreach ( $placeholders as $placeholder => $value ) {
            if ( !empty( $value ) && trim( $value ) != ',' && trim( $value ) != '-' ) {
                $html = str_replace( '{{' . $placeholder . '}}', $value, $html );
            } else {
                $html = str_replace( '{{' . $placeholder . '}}', '---', $html );
            }
        }
        return $html;
    }

    public function process_smart_tags( $value ) {
        global $bvnode_wpf_pdf_ProccessSmartTags;
        if ( !$this->form_data || !$this->fields ) {
            return $value;
        }
        $bvnode_wpf_pdf_ProccessSmartTags = false;
        $value = preg_replace( '/{entry_date.*?}/mui', date( 'm/d/Y', strtotime( $this->form_data['entry_date'] ) ), $value );
        $value = wpforms_process_smart_tags( $value, $this->form_data, $this->fields );
        $bvnode_wpf_pdf_ProccessSmartTags = true;
        return $value;
    }

    public function process_template_fields() {
        $template_fields = $this->template_fields;
        foreach ( $template_fields as $index => $value ) {
            $template_fields[$index] = $this->process_smart_tags( $value );
        }
        return $template_fields;
    }

    public function output() {
        if ( $this->template_fields ) {
            $output = $this->replace_placeholders( $this->process_template_fields() );
        } else {
            $output = $this->get_html();
        }
        return $output;
    }

    public function get_filename() {
        return str_replace( '.pdf.pdf', '.pdf', $this->process_smart_tags( $this->file_name ?? $this->template_name ) . '.pdf' );
    }

    public function get_conditions() {
        $data = [];
        preg_match_all( '/{%[\\s]?if(.|\\n)*endif[\\s]?%}/iuU', $this->get_html(), $match1 );
        if ( isset( $match1[0] ) ) {
            foreach ( $match1[0] as $j => $matches ) {
                $data[$j]['match'] = $matches;
                preg_match_all( '/%\\s?(?<statement>.*?\\s)(?<fields>.*?)?%}(?<value>(.|\\n)*?){/iu', $matches, $match2 );
                if ( isset( $match2['statement'] ) ) {
                    for ($i = 0; $i < count( $match2['statement'] ); $i++) {
                        preg_match_all( '/(?<field>.*?)[\\s]?(?<operator>==|<>|<=|>=|>|<|!=)(?<condition>.+?)\\s(?<logic>\\s|AND|OR|and|or|%)?/iu', $match2['fields'][$i], $fields );
                        $f = [];
                        for ($k = 0; $k < count( $fields['field'] ); $k++) {
                            $f[] = [
                                'field'     => trim( $fields['field'][$k] ),
                                'operator'  => trim( $fields['operator'][$k] ),
                                'condition' => trim( $fields['condition'][$k] ),
                                'logic'     => strtoupper( trim( $fields['logic'][$k] ) ),
                            ];
                        }
                        $data[$j]['data'][] = array(
                            'statement' => trim( $match2['statement'][$i] ),
                            'fields'    => $f,
                            'value'     => $this->process_smart_tags( trim( $match2['value'][$i] ) ),
                            'match'     => $matches,
                        );
                    }
                } else {
                    $data[$j]['data'][] = array(
                        'statement' => 'else',
                        'fields'    => [],
                        'value'     => '',
                        'match'     => $matches,
                    );
                }
            }
        }
        return $data;
    }

    function condition_helper(
        $stat,
        $fields,
        $val,
        $data_fields
    ) {
        $con = ( $stat == 'else' ? $val : false );
        $log = '';
        // print_r($data_fields);
        // echo '<br>';
        foreach ( $fields as $fi ) {
            $field = $data_fields[$fi['field']] ?? $fi['field'];
            $data = $data_fields[$fi['condition']] ?? $fi['condition'];
            $oper = $fi['operator'] ?? '==';
            //   echo $field.$oper.$data;
            //For AND first failed
            if ( !empty( $log ) && $log == 'AND' && !$con ) {
                return false;
            }
            //for OR - first one was true
            if ( !empty( $log ) && $log == 'OR' && $con ) {
                return $val;
            }
            if ( !(strpos( $field, "'" ) === false && strpos( $field, '"' ) === false) ) {
                $field = str_replace( ["'", '"'], '', $field );
            }
            if ( !(strpos( $data, "'" ) === false && strpos( $data, '"' ) === false) ) {
                $data = str_replace( ["'", '"'], '', $data );
            }
            if ( isset( $field ) && !empty( $field ) ) {
                switch ( $oper ) {
                    case '==':
                        $con = ( $field == $data ? $val : false );
                        break;
                    case '!=':
                        $con = ( $field != $data ? $val : false );
                        break;
                    case '>':
                        $con = ( $field > $data ? $val : false );
                        break;
                    case '<':
                        $con = ( $field < $data ? $val : false );
                        break;
                    case '<=':
                        $con = ( $field <= $data ? $val : false );
                        break;
                    case '>=':
                        $con = ( $field >= $data ? $val : false );
                        break;
                    case '<>':
                        $con = ( $field != $data ? $val : false );
                        break;
                }
            }
            $log = $fi['logic'];
            //   echo ' : '.$con;
            //   echo '<br>';
            //   print_r($fi);
            //   echo '<br>';
            //   echo '<br>';
        }
        return $con;
    }

    function condition_help(
        $stat,
        $field,
        $data,
        $val,
        $oper = '=='
    ) {
        if ( !(strpos( $field, "'" ) === false && strpos( $field, '"' ) === false) ) {
            $field = str_replace( ["'", '"'], '', $field );
        }
        if ( !(strpos( $data, "'" ) === false && strpos( $data, '"' ) === false) ) {
            $data = str_replace( ["'", '"'], '', $data );
        }
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

}
