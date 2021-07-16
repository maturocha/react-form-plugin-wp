<?php

$strings = array(
  'fields' => array(
    'firstname'											=> 	__('Prénom', 'frouzebox-forms'),
    'lastname'											=> 	__('Nom', 'frouzebox-forms'),
    'telephone'											=> 	__('Téléphone', 'frouzebox-forms'),
    'email'											    => 	__('Email', 'frouzebox-forms'),
    'password'											=> 	__('Mot de passe', 'frouzebox-forms'),
    'password_confirmation'					=> 	__('Confirmer le mot de passe', 'frouzebox-forms'),
    'company'											  => 	__('Société (facultatif)', 'frouzebox-forms'),
    'address'											  => 	__('Adresse', 'frouzebox-forms'),
    'postal_code'										=> 	__('NPA', 'frouzebox-forms'),
    'city'											  => 	__('Ville', 'frouzebox-forms'),

  ),
  'messages' => array(
    'required' => __('Obligatoire', 'frouzebox-forms'),
    'password_validation' => __('Le mot de passe doit comporter au moins 8 caractères', 'frouzebox-forms'),
    'password_match' => __('Les mots de passe doivent correspondre', 'frouzebox-forms'),
    'email_exists' => __('Cet e-mail est déjà enregistré', 'frouzebox-forms'),
    'invalid_npa' => __('Code postal invalide', 'frouzebox-forms'),
    'free_month' => __('Gratuit pendant 1 mois', 'frouzebox-forms'),
    'price_month' => __('%price% € par %period%', 'frouzebox-forms'),
    'without_charges' => __('Sans engagement!', 'frouzebox-forms'),
    'accept' => __("J'accepte les Conditions Générales de Vente", 'frouzebox-forms'),
    'required_accept' => __("Obligatoire d'accepter les conditions.", 'frouzebox-forms'),
    'welcome' => __("Merci de patienter un instant... vous allez être redirigé automatiquement", 'frouzebox-forms'),
  ),
  'title' => array(
    'my_account' => __('Mes informations', 'frouzebox-forms'),
    'address_facturation' => __('Adresse de Facturation', 'frouzebox-forms'),
    'my_subscription' => __('Mon Abonnement', 'frouzebox-forms'),
  ),
  'button' => array(
    'next' => __('Suivant', 'frouzebox-forms'),
    'back' =>  __("Revenir à l'étape précédente", 'frouzebox-forms'),
    'finish' =>  __("S’abonner", 'frouzebox-forms'),
  ),
  
);