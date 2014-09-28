<?php

$events = new Event;

$events->find_by_date_and_user_id( $current_user->id() );

?>