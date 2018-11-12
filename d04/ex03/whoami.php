<?php
if (!session_start())
    return;
if ($_SESSION && $_SESSION['loggued_on_user'] && $_SESSION['loggued_on_user'] != "")
	echo $_SESSION['loggued_on_user']."\n";
else
	echo "ERROR\n";
