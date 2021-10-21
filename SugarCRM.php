<?php
class SugarCRMPlugin extends MantisPlugin {
    function config()
    {
        return array(
            'db_hostname' => 'mysql.home.arpa',
            'db_username' => 'sugarcrm',
            'db_password' => 'strong_password',
            'db_dbname' => 'sugarcrm',
        );
    }

    function register() {
        $this->name = plugin_lang_get( 'title' );
        $this->description = plugin_lang_get( 'description' );
        $this->page = 'config';
        $this->version = '0.1';
        $this->requires = array(
            'MantisCore' => '1.3, 2.0',
        );

        $this->author = 'Murray Crane';
        $this->contact = 'murray.crane@ggpsystems.co.uk';
        $this->url = 'https://wmantisbt.org';
    }
}