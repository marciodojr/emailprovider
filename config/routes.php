<?php

return array_merge_recursive(
    require_once 'config/api-routes.php', // for data response
    require_once 'config/template-routes.php' // for html templates
);
