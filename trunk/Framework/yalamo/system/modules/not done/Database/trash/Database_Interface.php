<?php
Interface IDatabase{
	Public function Request();
	Public function Select();
	Public function SelectToJson();
	Public function SelectToXml();
	Public function SelectToCvs();
}
?>