<?php
// rafik application step workflow
AfwDatabase::db_query("ALTER TABLE c0adm.application_model_field add   duration_expiry smallint DEFAULT NULL  AFTER api_endpoint_id;");