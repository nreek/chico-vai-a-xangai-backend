<?php

$cpt_newsletter = new CPT('newsletter', new Label('Lead de Newsletter','Leads de Newsletter'));
$cpt_newsletter->supports([ 'title' ]);

$cpt_suggestion = new CPT('suggestion', new Label('Sugestão','Sugestões'));
$cpt_suggestion->supports([ 'title', 'editor' ]);

$cpt_film = new CPT('film', new Label('Filme','Filmes'));
$cpt_film->supports([ 'title', 'editor' ]);


$cpt_colunistas = new CPT('colunistas', new Label('Colunista','Colunistas'));

$cpt_register = new CPTs();
$cpt_register->add($cpt_newsletter, $cpt_colunistas, $cpt_suggestion, $cpt_film)->hook();
