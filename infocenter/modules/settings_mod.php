<?php

	class SettingsMod
	{

		//Script Info
		const SCRIPT_NAME = "Pardus Infocenter"; //please don't change that if you don't really need it
		const SCRIPT_VERSION = "1.6.4"; //please don't change that if you don't really need it

		//DB settings
		const DB_SERVER_ADDRESS = "localhost"; //Best left this unless otherwise specified
		const DB_ACCOUNT = "login"; //Your SQL Database Login
		const DB_PASSWORD = "pardus"; //Your SQL Database Password
		const DB_NAME = "infocenter"; //Your SQL database name

		//Userscript Settings
		const EASY_INSTALL = true;
		const EASY_NAME = "PardusInfocenter"; //the name you want to be displayed in the combo box
		const EASY_URL = "http://mysite/infocenter"; //the exact url to your Infocenter, no trailing slashes

		//Session Settings
		const SESSION_NAME = "pardus_infocenter";

		//Page Settings
		const PAGE_TITLE = "Pardus Infocenter"; //change this to what you want to appear in the title of your pages
		const PAGE_FAVICON = "favicon.ico"; // Upload a new favicon  to the main directory
		const PAGE_RECORDS_PER_PAGE = 50;
		const PAGE_STARTING_PAGE = "main"; //possible values: "combats","hacks","missions","main" (case sensitive)

		//Image Settings
		const STATIC_IMAGES = "http://static.pardus.at/img/stdhq"; //Modify this to any online image pack
		const IMAGE_LOGIN_IMAGE = "http://static.pardus.at/images/flight_school.png"; //Modify this to display a custom logo at the login page

		//Feature settings
		const ENABLE_COMBAT_SHARE = true; // set to "false" to disable
		const ENABLE_HACK_SHARE = true; // set to "false" to disable
		const ENABLE_MISSION_SHARE = true; // set to "false" to disable
		const ENABLE_PAYMENT_SHARE = true; // set to "false" to disable

		const ENABLE_COMMENTS = true; // set to "false" to disable
		const ENABLE_PUBLIC = true; // set to "false" to disable
		const PUBLIC_UNIVERSE = 'Orion'; // set to 'Orion', 'Artemis', or 'Pegasus'

		const ENABLE_MAIN_PAGE = true; // set to "false" to disable
		const MAIN_PAGE_TITLE = "Pardus Infocenter - Main Page";  //Modify this so you can change the main page title
		const MAIN_PAGE_IMAGE = "http://static.pardus.at/images/dock.jpg"; //Modify this so you can change the main page image
		const MAIN_PAGE_DESCRIPTION = "Just another Pardus Infocenter.";  //Modify this so you can change the main page title

		//Legacy Support
		const USE_ENCRYPTED_PASSWORDS = true;	//change this to "false" *ONLY* if you want to upgrade an existing 1.5b2 installation
												//without resetting password(s); passwords must be stored in plain text
												//and not in md5 hash if you set this option to "false"
		const DB_TABLE_PREFIX = ""; //leave null on first installation and if you want to use on an existint 1.5b2;
									//if you set something here remember you *MUST* rename the tables in your db;
									//for example if you set DB_TABLE_PREFIX = "infocenter_" you *MUST* rename the tables
									//into "infocenter_account", "infocenter_combat", "infocenter_hack", "infocenter_mission"

		static $MISSION_CLEAR_TIMES = array(
			'1 day' => 1,
			'3 days' => 3,
			'1 week' => 7,
			'2 weeks' => 14,
			'1 month' => 30
		);

	}

?>
