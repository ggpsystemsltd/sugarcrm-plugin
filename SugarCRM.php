<?php

/***
 * SugarCRM integration plugin
 */
class SugarCRMPlugin extends MantisPlugin {
    /***
     * A method that populates the plugin information and minimum requirements.
     * @return void
     */
    function register() {
        $this->name = plugin_lang_get( 'title' );
        $this->description = plugin_lang_get( 'description' );
        $this->page = 'config';
        $this->version = '1.3.0';
        $this->requires = array(
            'MantisCore' => '1.3.0',
        );

        $this->author = 'Murray Crane';
        $this->contact = 'murray.crane@ggpsystems.co.uk';
        $this->url = 'https://www.mantisbt.org';
    }

    /***
     * Default plugin configuration.
     * @return array
     */
    function config()
    {
        return array(
            'db_hostname' => 'mysql.example.com',
            'db_username' => 'sugarcrm',
            'db_password' => 'strong_password',
            'db_database' => 'sugarcrm',
            'case_url'    => 'https://sugarcrm.example.com/#Cases/'
        );
    }

    /**
     * Register events for plugin.
     */
    function events() {
        return array(
            'EVENT_SUGARCRM_CASE_URL' => EVENT_TYPE_OUTPUT,
            'EVENT_SUGARCRM_CASE_UPDATE' => EVENT_TYPE_EXECUTE,
        );
    }

    /**
     * Register event hooks for plugin.
     */
    function hooks() {
        return array(
            'EVENT_SUGARCRM_CASE_URL' => 'getCaseUrl',
            'EVENT_SUGARCRM_CASE_UPDATE' => 'updateCase',
        );
    }

    /***
     * Get SugarCRM Case UUID using Case Number
     *
     * @param int @p_event Whatever
     * @param int $p_chained_param SugarCRM Case Number
     *
     * @return string URL to the SugarCRM Case number
     */
    function getCaseUrl( $p_event, $p_chained_param ) {
        if( $p_chained_param != null ) {
            return '<a href="' . plugin_config_get( 'case_url' ) . self::getCaseUuid( $p_chained_param ) . '">';
        }
    }

    /***
     * Get SugarCRM Case UUID using Case Number
     *
     * @param int $p_casenumber SugarCRM Case number to retrieve UUID for
     *
     * @return string UUID that equates to the SugarCRM Case number
     */
    function getCaseUuid( $p_casenumber = null ) {
        if( $p_casenumber != null ) {
            $t_uuid = null;

            $t_errlevel = error_reporting( 0 );
            $t_mysqli = new mysqli( plugin_config_get( 'db_hostname' ), plugin_config_get( 'db_username' ), plugin_config_get( 'db_password' ), plugin_config_get( 'db_database' ));
            error_reporting( $t_errlevel );

            if( $t_mysqli->connect_error ) {
                die( 'Connect Error (' . $t_mysqli->connect_errno . ') ' . $t_mysqli->connect_error );
            }

            if($t_stmt = $t_mysqli->prepare( "SELECT id FROM cases WHERE case_number=?" )) {
                $t_stmt->bind_param( "s", $p_casenumber );
                $t_stmt->execute();
                $t_stmt->bind_result( $t_uuid );
                $t_stmt->fetch();
                $t_stmt->close();
            }

            $t_mysqli->close();
            return $t_uuid;
        }

        return null;
    }

    /***
     * Update SugarCRM Case field/value
     *
     * @param array $p_params Case number, field to be updated and value to apply
     *
     * @return bool  Success/Failure
     */
    public function updateCase($p_event, $p_params ) {
        $t_rtrn = false;
        $t_casenumber = $p_params[0];
        $t_field = $p_params[1];
        $t_value = $p_params[2];

        if( $t_casenumber != null ) {
            $t_errlevel = error_reporting( 0 );
            $t_mysqli = new mysqli( plugin_config_get( 'db_hostname' ), plugin_config_get( 'db_username' ), plugin_config_get( 'db_password' ), plugin_config_get( 'db_database' ));
            error_reporting( $t_errlevel );

            if( $t_mysqli->connect_errno ) {
                die( 'Connect error (' . $t_mysqli->connect_errno . ') ' . $t_mysqli->connect_error );
            }

            $t_query = "UPDATE cases SET $t_field=? WHERE case_number=?";
            $t_stmt = $t_mysqli->stmt_init();
            $t_stmt->prepare( $t_query );
            $t_stmt->bind_param( "si", $t_value, $t_casenumber );
            $t_rtrn = $t_stmt->execute();
            $t_stmt->close();
            $t_mysqli->close();
        }

        return $t_rtrn;
    }
}