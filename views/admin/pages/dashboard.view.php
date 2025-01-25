<?php
$layoutFile = 'admin.layouts.main';

// extra styles section
ob_start(); ?>
<?php $stylesBlock = ob_get_clean();

// extra scripts section
ob_start(); ?>
<?php $scriptsBlock = ob_get_clean();
?>

