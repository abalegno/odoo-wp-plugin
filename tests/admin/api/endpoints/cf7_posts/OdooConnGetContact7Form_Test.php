<?php

namespace odoo_conn\tests\admin\api\endpoints\cf7_posts\OdooConnGetContact7Form;

require_once(__DIR__ . "/../common.php");
require_once("admin/api/schema.php");
require_once("admin/api/endpoints/c7f_posts.php");

use \PHPUnit\Framework\TestCase;
use odoo_conn\admin\api\endpoints\OdooConnGetContact7Form;

class OdooConnGetContact7Form_Test extends TestCase {

	use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	public function test_ok () {
		$wpdb = \Mockery::mock("WPDB");
		$wpdb->shouldReceive("prepare")->with("SELECT ID, post_title FROM wp_posts WHERE post_type='wpcf7_contact_form'", [])
			->once()->andReturn("SELECT ID, post_title FROM wp_posts WHERE post_type='wpcf7_contact_form'");
		$wpdb->shouldReceive("get_results")->with("SELECT ID, post_title FROM wp_posts WHERE post_type='wpcf7_contact_form'")
			->once()->andReturn(array(array("ID"=>4, "post_title"=>"Title")));
		$GLOBALS["wpdb"] = $wpdb;
		$GLOBALS["table_prefix"] = "wp_";

		$odooConnGetContact7Form = new OdooConnGetContact7Form();
		$results = $odooConnGetContact7Form->request(array());
		
		$this->assertEquals(array(array("ID"=>4, "post_title"=>"Title")), $results);
	}
}

?>