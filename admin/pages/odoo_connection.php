<?php

require_once(__DIR__ . "/../api/endpoints/odoo_connections.php");

use odoo_conn\admin\api\endpoints\OdooConnGetOdooConnection;

class OdooConnOdooConnectionListTable extends OdooConnCustomTableDisplay
{

    function get_columns()
    {
        return array(
            "cb" => '<input type="checkbox" />',
            "name" => "Name",
            "username" => "Username",
            "url" => "URL",
            "database_name" => "Database Name"
        );
    }

}

function odoo_conn_odoo_connection_page()
{
    wp_register_script(
        "odoo-connection", plugins_url("odoo_connection.js", __FILE__), array("jquery"), "1.0.0", true
    );
    wp_localize_script("odoo-connection", "wpApiSettings", array(
        "root" => esc_url_raw(rest_url()), "nonce" => wp_create_nonce("wp_rest")
    ));
    wp_enqueue_script("odoo-connection");

    ?>
    <div class="wrap">
        <h1>Odoo Connections</h1>
        <a href="#" id="create-data" class="create-database-record button-primary" value="Create a new Connection">Create
            a new Connection</a>
        <form method="POST" onsubmit="return submitConnection();" id="form-data" class="submit-database"
              style="display: none;">
            <input type="text" name="name" id="name" placeholder="Name"/><br/>
            <input type="text" name="username" id="username" placeholder="Username"/><br/>
            <input type="text" name="api_key" id="api_key" placeholder="API Key"/><br/>
            <input type="text" name="url" id="url" placeholder="URL"/><br/>
            <input type="text" name="database_name" id="database_name" placeholder="Database Name"/><br/>
            <input type="Submit" name="submit" class="button-primary"/>
        </form>
    </div>
    <?php

    echo "<div class='wrap'>";
    $odoo_connection = new OdooConnGetOdooConnection(ARRAY_A);
    $table_display = new OdooConnOdooConnectionListTable($odoo_connection);

    echo "<form method='post'>";
    $table_display->prepare_items();
    $table_display->display();
    echo "</div>";
}

?>