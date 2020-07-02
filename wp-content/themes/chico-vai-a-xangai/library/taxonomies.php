<?php
$tax_featured = new Taxonomy('is_featured', ['post'], new Label('Destaque','Destaques'));

$tax_register = new Taxonomies();
$tax_register->add($tax_featured)->hook();